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

namespace Elcodi\CoreBundle\DataFixtures\ORM\Abstracts;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\AbstractFixture as DoctrineAbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Id\IdentityGenerator;
use Doctrine\ORM\Id\AssignedGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
abstract class AbstractFixture extends DoctrineAbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
     * @return AbstractFixture self Object
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Modifies $entity doctrine metadata so that its identity generator
     * is overridden with a manual one (AssignedGenerator)
     *
     * @param ObjectManager $manager Entity manager
     * @param string        $entity  Entity namespace
     *
     * @return AbstractFixture self Object
     */
    protected function disableIdAutogeneration(ObjectManager $manager, $entity)
    {
        /**
         * @var ClassMetadataInfo $metadata
         */
        $metadata = $manager->getClassMetaData($entity);
        $metadata->setIdGenerator(new AssignedGenerator());

        return $this;
    }

    /**
     * Reenable autogeneration of id
     *
     * @param ObjectManager $manager Entity manager
     * @param string        $entity  Entity namespace
     *
     * @return AbstractFixture self Object
     */
    protected function enableIdAutogeneration(ObjectManager $manager, $entity)
    {
        /**
         * @var ClassMetadataInfo $metadata
         */
        $metadata = $manager->getClassMetaData($entity);
        $metadata->setIdGenerator(new IdentityGenerator());

        return $this;
    }
}
