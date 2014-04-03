<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Handler;

use Elcodi\CoreBundle\EventListener\ParametrizedSluggableListener;
use Elcodi\ProductBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Gedmo\Sluggable\Handler\SlugHandlerInterface;
use Gedmo\Sluggable\Mapping\Event\SluggableAdapter;
use Gedmo\Sluggable\SluggableListener;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * Sluggable handler which slugs all parent nodes
 * recursively based on Gedmo\Sluggable\Handler\TreeSLugHandler.
 *
 * It also searches for translatable objects and generates the
 * correct slug hierarchy using translatable/translated entities.
 *
 * The translation model is from Knp\DoctrineBehaviors\Model\Translatable,
 * KnpLabs/DoctrineBehaviours
 *
 * This is a simple and specific implementation for the
 * ElcodiProductBundle:Category entity
 *
 */
class CategoryTranslationTreeSlugHandler implements SlugHandlerInterface
{

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var ParametrizedSluggableListener
     */
    protected $sluggable;

    /**
     * {@inheritDoc}
     */
    public function __construct(SluggableListener $sluggable)
    {
        $this->sluggable = $sluggable;
    }

    /**
     * {@inheritDoc}
     */
    public static function validate(array $options, ClassMetadata $meta)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function onChangeDecision(SluggableAdapter $ea, array &$config, $object, &$slug, &$needToChangeSlug)
    {
        $this->om = $ea->getObjectManager();
    }

    /**
     * {@inheritDoc}
     */
    public function postSlugBuild(SluggableAdapter $ea, array &$config, $object, &$slug)
    {
        $slugHandlerOptions = [];
        foreach ($config['handlers'][get_called_class()] as $key => $slugHandlerOption) {
            $slugHandlerOptions[$key] = $this->expandParameterFromOption(trim($slugHandlerOption));
        }

        $traverseHierarchy = isset($slugHandlerOptions['traverseHierarchy']) ? $slugHandlerOptions['traverseHierarchy'] : false;
        $separator = isset($slugHandlerOptions['separator']) ? $slugHandlerOptions['separator'] : false;

        // Ugly, but Doctrine Sluggable extension works this way: to further process the
        // slugged text we must work on the string reference that SlugHandlerInterface
        // gives us in onChangeDecision() and onSlugCompletion()
        if ($traverseHierarchy) {
            $slug = $this->transliterate($separator, $object);
        }

    }

    /**
     * Checks if a SlugHandlerOption is in the form of a service container parameter:
     *
     * %my.parameter.example%
     *
     * If so, lookup the parameter value in the container parameter collection and
     * return it
     *
     * Otherwise just return the option value as is it, since it does not need to
     * be expanded
     *
     * The parameter collection is injected into the ParametrizedSluggableListener
     * service through a compiler pass class, since the SluggableListener base service
     * can not be configured or extended
     *
     * @see Elcodi\CoreBundle\DependencyInjection\Compiler\InjectParameterToSluggableListenerCompilerPass
     *
     * @param $option
     * @return mixed
     */
    protected function expandParameterFromOption($option)
    {
        $containerParameters = $this->sluggable->getContainerParameters();

        $normalizedOption = preg_replace("/^%([\w\.]+)%$/", "\\1", $option);

        if (isset($containerParameters[$normalizedOption])) {

            // this option is in the %parameter% form, return its
            // value from the parameter collection, if defined
            return $containerParameters[$normalizedOption];

        } else {

            // just return it as it is, this option holds a value
            return $option;
        }

    }
    /**
     * {@inheritDoc}
     */
    public function onSlugCompletion(SluggableAdapter $ea, array &$config, $object, &$slug)
    {

    }

    /**
     * Returns a concatenated string containing parent
     * categories names, separated by $separator character
     *
     * This temporary slug is then transliterated by the standard
     * Gedmo\Sluggable\Util\Urlizer service
     *
     * @param string $separator
     * @param object $object
     *
     * @return string
     */
    public function transliterate($separator, $object)
    {

        /** @var Translation $object */
        $locale = $object->getLocale();

        /** @var Category $category */
        $category = $object->getTranslatable();

        $acc = [];

        while ($category instanceof Category && $category->isEnabled() && !$category->isDeleted()) {
            $acc[] = $category;
            $category = $category->getParent();
        }

        $text = implode($separator, array_reverse(
            array_map(function ($v) use ($locale) {
                /** @var Category $v */

                return $v->translate($locale)->getName();
            }, $acc)
        ));

        return $text;
    }

    /**
     * {@inheritDoc}
     */
    public function handlesUrlization()
    {
        return false;
    }

}
