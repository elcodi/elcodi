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

namespace Elcodi\Component\Core\Factory\Traits;

/**
 * Trait FactoryTrait.
 */
trait FactoryTrait
{
    /**
     * @var \Elcodi\Component\Core\Factory\Abstracts\AbstractFactory
     *
     * Factory
     */
    private $factory;

    /**
     * Get Factory.
     *
     * @return \Elcodi\Component\Core\Factory\Abstracts\AbstractFactory Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Sets Factory.
     *
     * @param \Elcodi\Component\Core\Factory\Abstracts\AbstractFactory $factory Factory
     *
     * @return $this Self object
     */
    public function setFactory(\Elcodi\Component\Core\Factory\Abstracts\AbstractFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }
}
