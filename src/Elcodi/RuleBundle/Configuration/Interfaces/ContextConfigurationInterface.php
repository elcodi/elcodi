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

namespace Elcodi\RuleBundle\Configuration\Interfaces;

use Elcodi\RuleBundle\Services\Interfaces\ContextAwareInterface;

/**
 * Class ContextConfigurationInterface
 */
interface ContextConfigurationInterface
{
    /**
     * Configures a context aware object
     *
     * @param ContextAwareInterface $contextAware Context aware object
     */
    public function configureContext(ContextAwareInterface $contextAware);
}
