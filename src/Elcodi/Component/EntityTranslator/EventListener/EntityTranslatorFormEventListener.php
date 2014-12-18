<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\EntityTranslator\EventListener;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Elcodi\Component\EntityTranslator\Form\Type\TranslatableFieldType;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class EntityTranslatorFormEventListener
 */
class EntityTranslatorFormEventListener implements EventSubscriberInterface
{
    /**
     * @var EntityTranslationProviderInterface
     *
     * Entity Translation provider
     */
    protected $entityTranslationProvider;

    /**
     * @var array
     *
     * Translation configuration
     */
    protected $translationConfiguration;

    /**
     * @var Collection
     *
     * Locales
     */
    protected $locales;

    /**
     * @var array
     *
     * Submitted data in plain mode
     */
    protected $submittedDataPlain;

    /**
     * Construct method
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Entity Translation provider
     * @param array                              $translationConfiguration  Entity Translation configuration
     * @param Collection                         $locales                   Locales
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        array $translationConfiguration,
        Collection $locales
    )
    {
        $this->entityTranslationProvider = $entityTranslationProvider;
        $this->translationConfiguration = $translationConfiguration;
        $this->locales = $locales;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT   => 'preSubmit',
            FormEvents::POST_SUBMIT  => 'postSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    /**
     * Pre set data
     *
     * @param FormEvent $event Event
     */
    public function preSetData(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        $classStack = $this->getNamespacesFromClass(get_class($entity));

        foreach ($classStack as $classNamespace) {

            if (!array_key_exists($classNamespace, $this->translationConfiguration)) {
                continue;
            }

            $entityConfiguration = $this->translationConfiguration[$classNamespace];
            $entityFields = $entityConfiguration['fields'];

            foreach ($entityFields as $fieldName => $fieldConfiguration) {

                $formConfig = $form
                    ->get($fieldName)
                    ->getConfig();

                $form
                    ->remove($fieldName)
                    ->add($fieldName, new TranslatableFieldType(
                        $this->entityTranslationProvider,
                        $formConfig,
                        $entity,
                        $fieldName,
                        $entityConfiguration,
                        $fieldConfiguration,
                        $this->locales
                    ), array(
                        'mapped' => false,
                    ));
            }
        }
    }

    /**
     * Pre submit
     *
     * @param FormEvent $event Event
     */
    public function preSubmit(FormEvent $event)
    {
        $this->submittedDataPlain = $event->getData();
    }

    /**
     * Post submit
     *
     * @param FormEvent $event Event
     */
    public function postSubmit(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        $entityNamespace = $form
            ->getConfig()
            ->getDataClass();

        $classStack = $this->getNamespacesFromClass($entityNamespace);

        foreach ($classStack as $classNamespace) {

            if (!array_key_exists($classNamespace, $this->translationConfiguration)) {
                continue;
            }

            $entityConfiguration = $this->translationConfiguration[$classNamespace];
            $entityFields = $entityConfiguration['fields'];
            $entityIdGetter = $entityConfiguration['idGetter'];

            foreach ($this->locales as $locale) {

                foreach ($entityFields as $fieldName => $fieldConfiguration) {

                    $this
                        ->entityTranslationProvider
                        ->setTranslation(
                            $entityConfiguration['alias'],
                            $entity->$entityIdGetter(),
                            $fieldName,
                            $this->submittedDataPlain[$fieldName][$locale . '_' . $fieldName],
                            $locale
                        );
                }
            }
        }

        $this
            ->entityTranslationProvider
            ->flushTranslations();
    }

    /**
     * Get all possible classes given an object
     *
     * @param string $namespace Namespace
     *
     * @return string[] Set of classes and interfaces
     */
    protected function getNamespacesFromClass($namespace)
    {
        $classStack = [$namespace];
        $classStack = array_merge($classStack, class_parents($namespace));
        $classStack = array_merge($classStack, class_implements($namespace));

        return $classStack;
    }
}
