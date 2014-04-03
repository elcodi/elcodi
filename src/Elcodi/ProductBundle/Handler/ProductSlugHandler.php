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

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Sluggable\Handler\SlugHandlerInterface;
use Gedmo\Sluggable\Mapping\Event\SluggableAdapter;
use Gedmo\Sluggable\SluggableListener;
use Gedmo\Tool\Wrapper\AbstractWrapper;

/**
 * Sluggable handler for Product translatable class.
 * Based on Gedmo RelativeSlugHandler class
 * */
class ProductSlugHandler implements SlugHandlerInterface
{

    /**
     * @var Separator
     * @todo Set this variable to parameter
     *
     * Separator
     */
    const SEPARATOR = '-';

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var SluggableListener
     */
    protected $sluggable;

    /**
     * Used options
     *
     * @var array
     */
    protected $usedOptions;

    /**
     * Callable of original transliterator
     * which is used by sluggable
     *
     * @var callable
     */
    protected $originalTransliterator;

    /**
     * $options = array(
     *     'separator' => '/',
     *     'relationField' => 'something',
     *     'relationSlugField' => 'slug'
     * )
     * {@inheritDoc}
     */
    public function __construct(SluggableListener $sluggable)
    {
        $this->sluggable = $sluggable;
    }

    /**
     * {@inheritDoc}
     */
    public function onChangeDecision(SluggableAdapter $ea, array &$config, $object, &$slug, &$needToChangeSlug)
    {
        $this->om = $ea->getObjectManager();
        $isInsert = $this->om->getUnitOfWork()->isScheduledForInsert($object);
        $this->usedOptions = $config['handlers'][get_called_class()];

        if (!isset($this->usedOptions['separator'])) {
            $this->usedOptions['separator'] = self::SEPARATOR;
        }

        if (!$isInsert && !$needToChangeSlug) {
            $changeSet = $ea->getObjectChangeSet($this->om->getUnitOfWork(), $object);

            if (isset($changeSet[$this->usedOptions['relationField']])) {
                $needToChangeSlug = true;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function postSlugBuild(SluggableAdapter $ea, array &$config, $object, &$slug)
    {
        $this->originalTransliterator = $this->sluggable->getTransliterator();
        $this->sluggable->setTransliterator(array($this, 'transliterate'));
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
    public function onSlugCompletion(SluggableAdapter $ea, array &$config, $object, &$slug)
    {
    }

    /**
     * Transliterates the slug in ProductTranslation by looking
     * at Product::family property. If it is set, just compute the
     * slug as Product::family + ProductTranslation::name
     * otherwise compute the slug as
     * Product::shop::name + ProductTranslation::name (in this
     * case "type" will hold the whole product name, translated in
     * current locale)
     *
     * @param  string $text      current Product translatable name
     * @param  string $separator character separator in resulting slug
     * @param  object $object
     * @return string
     */
    public function transliterate($text, $separator, $object)
    {
        $result = call_user_func_array(
            $this->originalTransliterator,
            array($text, $separator, $object)
        );

        $wrapped = AbstractWrapper::wrap($object, $this->om);

        $relation = $wrapped->getPropertyValue("translatable");

        if ($relation) {
            $product = AbstractWrapper::wrap($relation, $this->om);

            $productFamily = $product->getPropertyValue("family");

            $shop = AbstractWrapper::wrap($product->getPropertyValue("shop"), $this->om);
            $shopName = $shop->getPropertyValue("name");

            $compoundSlug = $productFamily ? $productFamily : $shopName;

            $resultParent = call_user_func_array(
                $this->originalTransliterator,
                array($compoundSlug, $separator, $object)
            );

            $result = $resultParent . $this->usedOptions['separator'] . $result;
        }

        $this->sluggable->setTransliterator($this->originalTransliterator);

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function handlesUrlization()
    {
        return true;
    }
}
