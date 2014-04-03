<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * Language
 */
class Language extends AbstractEntity implements LanguageInterface
{
    use EnabledTrait;

    /**
     * @var float
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
     * @return Language self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get shop name
     *
     * @return string
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
     * @return Language self Object
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string
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
