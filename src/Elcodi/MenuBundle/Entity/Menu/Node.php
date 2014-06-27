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

namespace Elcodi\MenuBundle\Entity\Menu;

use Elcodi\MenuBundle\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\MenuBundle\Entity\Menu\Traits\SubnodesTrait;

/**
 * Class Node
 */
class Node extends AbstractEntity implements NodeInterface
{
    use SubnodesTrait, DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * name
     */
    protected $name;

    /**
     * @var string
     *
     * url
     */
    protected $url;

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return Node Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Url
     *
     * @param string $url Url
     *
     * @return Node Self object
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get Url
     *
     * @return string Url
     */
    public function getUrl()
    {
        return $this->url;
    }
}
