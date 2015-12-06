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

namespace Elcodi\Component\Configuration\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;

/**
 * Interface ConfigurationInterface.
 */
interface ConfigurationInterface extends DateTimeInterface
{
    /**
     * Get Key.
     *
     * @return string Key
     */
    public function getKey();

    /**
     * Sets Key.
     *
     * @param string $key Key
     *
     * @return $this Self object
     */
    public function setKey($key);

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Namespace.
     *
     * @return string Namespace
     */
    public function getNamespace();

    /**
     * Sets Namespace.
     *
     * @param string $namespace Namespace
     *
     * @return $this Self object
     */
    public function setNamespace($namespace);

    /**
     * Get Type.
     *
     * @return string Type
     */
    public function getType();

    /**
     * Sets Type.
     *
     * @param string $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get Value.
     *
     * @return mixed Value
     */
    public function getValue();

    /**
     * Sets Value.
     *
     * @param mixed $value Value
     *
     * @return $this Self object
     */
    public function setValue($value);
}
