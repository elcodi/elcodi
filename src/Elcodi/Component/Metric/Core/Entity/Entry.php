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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Metric\Core\Entity;

use DateTime;

use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;

/**
 * Class Entry
 */
class Entry implements EntryInterface
{
    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

    /**
     * @var string
     *
     * Token
     */
    protected $token;

    /**
     * @var string
     *
     * Event
     */
    protected $event;

    /**
     * @var string
     *
     * Value
     */
    protected $value;

    /**
     * @var integer
     *
     * Type
     */
    protected $type;

    /**
     * @var DateTime
     *
     * Created at
     */
    protected $createdAt;

    /**
     * Construct
     *
     * @param string   $token     Token
     * @param string   $event     Event
     * @param string   $value     Value
     * @param integer  $type      Type
     * @param DateTime $createdAt Created At
     */
    public function __construct(
        $token,
        $event,
        $value,
        $type,
        $createdAt
    ) {
        $this->token = $token;
        $this->event = $event;
        $this->value = $value;
        $this->type = $type;
        $this->createdAt = $createdAt;
    }

    /**
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Token
     *
     * @return string Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get Event
     *
     * @return string Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Get Value
     *
     * @return string Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get Type
     *
     * @return int Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get CreatedAt
     *
     * @return mixed CreatedAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
