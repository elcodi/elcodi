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

namespace Elcodi\RuleBundle\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\RuleBundle\Configuration\Interfaces\ContextConfigurationInterface;
use Elcodi\RuleBundle\Services\Interfaces\ContextAwareInterface;

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
     * @param ContextAwareInterface $contextAware
     */
    public function configureContext(ContextAwareInterface $contextAware)
    {
        $contextAware->addContextElement(['manager', $this->objectManager]);
    }
}
