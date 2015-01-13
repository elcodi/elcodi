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
 */

namespace Elcodi\Component\Rule\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Rule\Configuration\Interfaces\ContextConfigurationInterface;
use Elcodi\Component\Rule\Services\Interfaces\ContextAwareInterface;

/**
 * Class ContextConfiguration
 */
class ContextConfiguration implements ContextConfigurationInterface
{
    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $objectManager;

    /**
     * Construct method
     *
     * @param ObjectManager $objectManager Object manager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Configures context
     *
     * @param ContextAwareInterface $contextAware
     *
     * @return $this Self object
     */
    public function configureContext(ContextAwareInterface $contextAware)
    {
        $contextAware->addContextElement(['manager', $this->objectManager]);

        return $this;
    }
}
