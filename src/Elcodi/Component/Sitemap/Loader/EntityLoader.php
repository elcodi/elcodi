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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Sitemap\Loader;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use Elcodi\Component\Sitemap\Loader\Interfaces\EntityLoaderInterface;
use Elcodi\Component\Sitemap\Transformer\Interfaces\SitemapTransformerInterface;

/**
 * Class EntityLoader
 */
class EntityLoader implements EntityLoaderInterface
{
    /**
     * @var SitemapTransformerInterface
     *
     * Sitemap transformer
     */
    protected $transformer;

    /**
     * @var ObjectRepository
     *
     * Repository
     */
    protected $repository;

    /**
     * @var string
     *
     * Method
     */
    protected $method;

    /**
     * @var array
     *
     * Arguments
     */
    protected $arguments;

    /**
     * Construct method
     *
     * @param SitemapTransformerInterface $transformer Transformer
     * @param ObjectRepository            $repository  Repository
     * @param string                      $method      Method
     * @param array                       $arguments   Arguments
     */
    public function __construct(
        SitemapTransformerInterface $transformer,
        ObjectRepository $repository,
        $method,
        array $arguments
    ) {
        $this->transformer = $transformer;
        $this->repository = $repository;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Load all the entities
     *
     * @return ArrayCollection Entities
     */
    public function load()
    {
        $method = $this->method;
        $entities = $this
            ->repository
            ->$method($this->arguments);

        return new ArrayCollection($entities);
    }

    /**
     * Get Transformer
     *
     * @return SitemapTransformerInterface Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}
