<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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
 * Class MappingProvider
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
     * Construct
     *
     * @param array $implementations Implementations
     */
    public function __construct(array $implementations)
    {
        $this->implementations = $implementations;
        $this->interfaces = array_flip($implementations);
    }

    /**
     * Get interface given implementation
     *
     * @param string $implementation Implementation
     *
     * @return string|boolean Interface
     */
    public function getInterface($implementation)
    {
        return isset($this->interfaces[(string) $implementation])
            ? $this->interfaces[(string) $implementation]
            : false;
    }

    /**
     * Get implementation given interface
     *
     * @param string $interface Interface
     *
     * @return string|boolean Implementation
     */
    public function getImplementation($interface)
    {
        return isset($this->implementations[(string) $interface])
            ? $this->implementations[(string) $interface]
            : false;
    }
}
