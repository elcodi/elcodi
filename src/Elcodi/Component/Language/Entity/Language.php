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

namespace Elcodi\Component\Language\Entity;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Language
 */
class Language extends AbstractEntity implements LanguageInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Language name
     */
    protected $name;

    /**
     * @var string
     *
     * Language iso
     */
    protected $iso;

    /**
     * Set language name
     *
     * @param string $name Name of the shop
     *
     * @return $this self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get shop name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set iso
     *
     * @param string $iso Iso
     *
     * @return $this self Object
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string Iso
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * To string
     *
     * @return String
     */
    public function __toString()
    {
        return $this->getIso();
    }
}
