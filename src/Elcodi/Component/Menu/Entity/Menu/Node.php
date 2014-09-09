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

namespace Elcodi\Component\Menu\Entity\Menu;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Traits\SubnodesTrait;

/**
 * Class Node
 */
class Node extends AbstractEntity implements NodeInterface
{
    use SubnodesTrait, DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Node name
     */
    protected $name;

    /**
     * @var string
     *
     * Node code or short name
     */
    protected $code;

    /**
     * @var string
     *
     * url
     */
    protected $url;

    /**
     * Sets Node name
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
     * Gets Node name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Node URL
     *
     * Can be a plain URL or a route name
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
     * Gets Node url
     *
     * @return string Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Gets Node code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Node code
     *
     * @param string $code
     *
     * @return $this self Object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}
