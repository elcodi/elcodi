<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\EntityTranslator\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Component\EntityTranslator\Form\Type\TranslatableFieldType;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class EntityTranslatorFormEventListener.
 */
class EntityTranslatorFormEventListener implements EventSubscriberInterface
{
    /**
     * @var EntityTranslationProviderInterface
     *
     * Entity Translation provider
     */
    private $entityTranslationProvider;

    /**
     * @var array
     *
     * Translation configuration
     */
    private $translationConfiguration;

    /**
     * @var array
     *
     * Locales
     */
    private $locales;

    /**
     * @var string
     *
     * Master locale
     */
    private $masterLocale;

    /**
     * @var bool
     *
     * Fallback is enabled.
     *
     * If a field is required and the fallback flag is enabled, all translations
     * will not be required anymore, but just the translation with same language
     * than master
     */
    private $fallback;

    /**
     * @var array
     *
     * Submitted data in plain mode
     */
    private $submittedDataPlain = [];

    /**
     * @var array
     *
     * Local and temporary backup of translations
     */
    private $translationsBackup = [];

    /**
     * Construct method.
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Entity Translation provider
     * @param array                              $translationConfiguration  Entity Translation configuration
     * @param array                              $locales                   Locales
     * @param string                             $masterLocale              Master locale
     * @param bool                               $fallback                  Fallback
     */
    public function __construct(
        EntityTranslationProviderInterface $entityTranslationProvider,
        array $translationConfiguration,
        array $locales,
        $masterLocale,
        $fallback
    ) {
        $this->entityTranslationProvider = $entityTranslationProvider;
        $this->translationConfiguration = $translationConfiguration;
        $this->locales = $locales;
        $this->masterLocale = $masterLocale;
        $this->fallback = $fallback;
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
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
            FormEvents::POST_SUBMIT => 'postSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    /**
     * Pre set data.
     *
     * @param FormEvent $event Event
     */
    public function preSetData(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        $entityConfiguration = $this->getTranslatableEntityConfiguration($entity);

        if (is_null($entityConfiguration)) {
            return null;
        }

        $entityFields = $entityConfiguration['fields'];

        foreach ($entityFields as $fieldName => $fieldConfiguration) {
            if (!$form->has($fieldName)) {
                continue;
            }

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
                    $this->locales,
                    $this->masterLocale,
                    $this->fallback
                ), [
                    'mapped' => false,
                ]);
        }
    }

    /**
     * Pre submit.
     *
     * @param FormEvent $event Event
     */
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $formHash = $this->getFormHash($form);
        $this->submittedDataPlain[$formHash] = $event->getData();
    }

    /**
     * Post submit.
     *
     * @param FormEvent $event Event
     */
    public function postSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        if (!$form->isValid()) {
            return;
        }

        $entity = $event->getData();
        $formHash = $this->getFormHash($form);
        $entityConfiguration = $this->getTranslatableEntityConfiguration($entity);

        if (is_null($entityConfiguration)) {
            return null;
        }

        $this->translationsBackup[$formHash] = [];

        $entityData = [
            'object' => $entity,
            'idGetter' => $entityConfiguration['idGetter'],
            'alias' => $entityConfiguration['alias'],
            'fields' => [],
        ];

        $entityFields = $entityConfiguration['fields'];

        foreach ($entityFields as $fieldName => $fieldConfiguration) {
            if (!isset($this->submittedDataPlain[$formHash][$fieldName])) {
                continue;
            }

            $field = $this->submittedDataPlain[$formHash][$fieldName];

            foreach ($this->locales as $locale) {
                $entityData['fields'][$fieldName][$locale] = $field[$locale . '_' . $fieldName];
            }

            if ($this->masterLocale && isset($field[$this->masterLocale . '_' . $fieldName])) {
                $masterLocaleData = $field[$this->masterLocale . '_' . $fieldName];
                $setter = $fieldConfiguration['setter'];
                $entity->$setter($masterLocaleData);
            }
        }

        $this->translationsBackup[$formHash][] = $entityData;
    }

    /**
     * Method executed at the end of the response. Save all entity translations
     * previously generated and waiting for being flushed into database and
     * cache layer.
     */
    public function saveEntityTranslations()
    {
        if (empty($this->translationsBackup)) {
            return null;
        }

        foreach ($this->translationsBackup as $formHash => $entities) {
            foreach ($entities as $entityData) {
                $entity = $entityData['object'];
                $entityIdGetter = $entityData['idGetter'];
                $entityAlias = $entityData['alias'];
                $fields = $entityData['fields'];

                foreach ($fields as $fieldName => $locales) {
                    foreach ($locales as $locale => $translation) {
                        $this
                            ->entityTranslationProvider
                            ->setTranslation(
                                $entityAlias,
                                $entity->$entityIdGetter(),
                                $fieldName,
                                $translation,
                                $locale
                            );
                    }
                }
            }
        }

        $this
            ->entityTranslationProvider
            ->flushTranslations();
    }

    /**
     * Get form unique hash.
     *
     * @param FormInterface $form Form
     *
     * @return string Form hash
     */
    public function getFormHash(FormInterface $form)
    {
        return spl_object_hash($form);
    }

    /**
     * Get configuration for a translatable entity, or null if the entity is not
     * translatable.
     *
     * @param object $entity Entity
     *
     * @return array|null Configuration
     */
    private function getTranslatableEntityConfiguration($entity)
    {
        $entityNamespace = get_class($entity);
        $classStack = $this->getNamespacesFromClass($entityNamespace);

        foreach ($classStack as $classNamespace) {
            if (array_key_exists($classNamespace, $this->translationConfiguration)) {
                return $this->translationConfiguration[$classNamespace];
            }
        }

        return null;
    }

    /**
     * Get all possible classes given an object.
     *
     * @param string $namespace Namespace
     *
     * @return string[] Set of classes and interfaces
     */
    private function getNamespacesFromClass($namespace)
    {
        $classStack = [$namespace];
        $classStack = array_merge($classStack, class_parents($namespace));
        $classStack = array_merge($classStack, class_implements($namespace));

        return $classStack;
    }
}
