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

namespace Elcodi\Component\Settings\Factory;

use DateTime;

use Elcodi\Component\Settings\ElcodiSettingsTypes;
use Elcodi\Component\Settings\Entity\Interfaces\SettingsInterface;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class SettingsFactory
 */
class SettingsFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return SettingsInterface Empty entity
     */
    public function create()
    {
        /**
         * @var SettingsInterface $settings
         */
        $classNamespace = $this->getEntityNamespace();
        $settings = new $classNamespace();

        $settings
            ->setNamespace('')
            ->setType(ElcodiSettingsTypes::TYPE_STRING)
            ->setCreatedAt(new DateTime());

        return $settings;
    }
}
