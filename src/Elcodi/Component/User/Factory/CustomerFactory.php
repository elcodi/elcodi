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

namespace Elcodi\Component\User\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\User\ElcodiUserProperties;
use Elcodi\Component\User\Entity\Customer;

/**
 * Class CustomerFactory.
 */
class CustomerFactory extends AbstractFactory
{
    /**
     * @var GeneratorInterface
     *
     * Generator
     */
    private $generator;

    /**
     * Token generator.
     *
     * @param GeneratorInterface $generator Token generator
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return Customer Empty entity
     */
    public function create()
    {
        /**
         * @var Customer $customer
         */
        $classNamespace = $this->getEntityNamespace();
        $customer = new $classNamespace();
        $customer
            ->setGender(ElcodiUserProperties::GENDER_UNKNOWN)
            ->setGuest(false)
            ->setNewsletter(false)
            ->setAddresses(new ArrayCollection())
            ->setCarts(new ArrayCollection())
            ->setOrders(new ArrayCollection())
            ->setToken($this->generator->generate(2))
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $customer;
    }
}
