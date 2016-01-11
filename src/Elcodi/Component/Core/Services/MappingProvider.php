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

namespace Elcodi\Component\Core\Services;

/**
 * Class MappingProvider.
 */
class MappingProvider
{
    /**
     * @var array
     *
     * Mapping implementations
     *
     * interface => implementation
     */
    private $implementations;

    /**
     * @var array
     *
     * Mapping interfaces
     *
     * implementation => interface
     */
    private $interfaces;

    /**
     * Construct.
     *
     * @param array $implementations Implementations
     */
    public function __construct(array $implementations)
    {
        $this->implementations = $implementations;
        $this->interfaces = array_flip($implementations);
    }

    /**
     * Get interface given implementation.
     *
     * @param string $implementation Implementation
     *
     * @return string|bool Interface
     */
    public function getInterface($implementation)
    {
        return isset($this->interfaces[$implementation])
            ? $this->interfaces[$implementation]
            : false;
    }

    /**
     * Get implementation given interface.
     *
     * @param string $interface Interface
     *
     * @return string|bool Implementation
     */
    public function getImplementation($interface)
    {
        return isset($this->implementations[$interface])
            ? $this->implementations[$interface]
            : false;
    }
}
