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

namespace Elcodi\Component\Sitemap\Element;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Class EntitySitemapElementProvider.
 */
class EntitySitemapElementProvider
{
    /**
     * @var ObjectRepository
     *
     * Repository
     */
    private $repository;

    /**
     * @var string
     *
     * Method
     */
    private $method;

    /**
     * @var array
     *
     * Arguments
     */
    private $arguments;

    /**
     * Construct method.
     *
     * @param ObjectRepository $repository Repository
     * @param string           $method     Method
     * @param array            $arguments  Arguments
     */
    public function __construct(
        ObjectRepository $repository,
        $method,
        array $arguments
    ) {
        $this->repository = $repository;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Get entities from provider.
     *
     * @return array Entities
     */
    public function getEntities()
    {
        $method = $this->method;

        return $this
            ->repository
            ->$method($this->arguments);
    }
}
