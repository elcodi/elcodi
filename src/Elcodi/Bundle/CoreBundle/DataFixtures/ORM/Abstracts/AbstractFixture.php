<?php

/**
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

namespace Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts;

use Doctrine\Common\DataFixtures\AbstractFixture as DoctrineAbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
abstract class AbstractFixture extends DoctrineAbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected $container;

    /**
     * Set container
     *
     * @param ContainerInterface $container Container
     *
     * @return $this self Object
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get service from container
     *
     * @param string $serviceName Service name
     *
     * @return Object service instance
     *
     * @throws InvalidArgumentException          if the service is not defined
     * @throws ServiceCircularReferenceException When a circular reference is detected
     * @throws ServiceNotFoundException          When the service is not defined
     */
    protected function get($serviceName)
    {
        return $this
            ->container
            ->get($serviceName);
    }
}
