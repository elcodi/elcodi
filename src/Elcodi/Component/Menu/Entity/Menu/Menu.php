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

namespace Elcodi\Component\Menu\Entity\Menu;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Entity\Menu\Traits\SubnodesTrait;

/**
 * Class Menu
 */
class Menu extends AbstractEntity implements MenuInterface
{
    use SubnodesTrait, DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * name
     */
    protected $code;

    /**
     * @var string
     *
     * description
     */
    protected $description;

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return Menu Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return Menu Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
