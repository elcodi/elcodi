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
     * Context
     */
    protected $context;

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
     * @param string   $context   Context
     * @param DateTime $createdAt Created At
     */
    public function __construct(
        $token,
        $event,
        $context,
        $createdAt
    )
    {
        $this->context = $context;
        $this->createdAt = $createdAt;
        $this->event = $event;
        $this->token = $token;
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
     * Get Context
     *
     * @return string Context
     */
    public function getContext()
    {
        return $this->context;
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
     * Get Token
     *
     * @return string Token
     */
    public function getToken()
    {
        return $this->token;
    }
}
