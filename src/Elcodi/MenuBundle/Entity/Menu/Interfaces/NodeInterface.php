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

namespace Elcodi\MenuBundle\Entity\Menu\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * Interface NodeInterface
 */
interface NodeInterface extends DateTimeInterface, EnabledInterface, SubnodesAwareInterface
{
    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return NodeInterface Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Url
     *
     * @param string $url Url
     *
     * @return NodeInterface Self object
     */
    public function setUrl($url);

    /**
     * Get Url
     *
     * @return string Url
     */
    public function getUrl();
}
