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

namespace Elcodi\Component\Configuration\Factory;

use Elcodi\Component\Configuration\ElcodiConfigurationTypes;
use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ConfigurationFactory.
 */
class ConfigurationFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return ConfigurationInterface Empty entity
     */
    public function create()
    {
        /**
         * @var ConfigurationInterface $configuration
         */
        $classNamespace = $this->getEntityNamespace();
        $configuration = new $classNamespace();

        $configuration
            ->setNamespace('')
            ->setType(ElcodiConfigurationTypes::TYPE_STRING)
            ->setCreatedAt($this->now());

        return $configuration;
    }
}
