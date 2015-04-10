<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Sitemap\Element;

use Elcodi\Component\Sitemap\Element\Interfaces\SitemapElementGeneratorInterface;
use Elcodi\Component\Sitemap\Factory\SitemapElementFactory;
use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Class EntitySitemapElementGenerator
 */
class EntitySitemapElementGenerator implements SitemapElementGeneratorInterface
{
    /**
     * @var SitemapElementFactory
     *
     * SitemapElement factory
     */
    protected $sitemapElementFactory;

    /**
     * @var SitemapTransformerInterface
     *
     * Sitemap transformer
     */
    protected $transformer;

    /**
     * @var EntitySitemapElementProvider
     *
     * EntitySitemapElement provider
     */
    protected $entitySitemapElementProvider;

    /**
     * @var string
     *
     * Change frequency
     */
    protected $changeFrequency;

    /**
     * @var string
     *
     * Priority
     */
    protected $priority;

    /**
     * Construct method
     *
     * @param SitemapElementFactory        $sitemapElementFactory        SitemapElement Factory
     * @param SitemapTransformerInterface  $transformer                  Transformer
     * @param EntitySitemapElementProvider $entitySitemapElementProvider EntitySitemapElement provider
     * @param string|null                  $changeFrequency              Change frequency
     * @param string|null                  $priority                     Priority
     */
    public function __construct(
        SitemapElementFactory $sitemapElementFactory,
        SitemapTransformerInterface $transformer,
        EntitySitemapElementProvider $entitySitemapElementProvider,
        $changeFrequency = null,
        $priority = null
    ) {
        $this->sitemapElementFactory = $sitemapElementFactory;
        $this->transformer = $transformer;
        $this->entitySitemapElementProvider = $entitySitemapElementProvider;
        $this->changeFrequency = $changeFrequency;
        $this->priority = $priority;
    }

    /**
     * Generate desired elements
     *
     * @param string|null $language Language
     *
     * @return array Elements generated
     */
    public function generateElements($language = null)
    {
        $sitemapElements = [];
        $transformer = $this->transformer;

        $entities = $this
            ->entitySitemapElementProvider
            ->getEntities();

        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $sitemapElements[] = $this
                    ->sitemapElementFactory
                    ->create(
                        $transformer->getLoc($entity, $language),
                        $transformer->getLastMod($entity, $language),
                        $this->changeFrequency,
                        $this->priority
                    );
            }
        }

        return $sitemapElements;
    }
}
