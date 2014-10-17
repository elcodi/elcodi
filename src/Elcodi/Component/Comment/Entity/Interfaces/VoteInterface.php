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

namespace Elcodi\Component\Comment\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Interface VoteInterface
 */
interface VoteInterface extends DateTimeInterface
{
    /**
     * Get Comment
     *
     * @return CommentInterface Comment
     */
    public function getComment();

    /**
     * Sets Comment
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function setComment($comment);

    /**
     * Get Type
     *
     * @return boolean Type
     */
    public function getType();

    /**
     * Sets Type
     *
     * @param boolean $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get User
     *
     * @return AbstractUserInterface User
     */
    public function getUser();

    /**
     * Sets User
     *
     * @param AbstractUserInterface $user User
     *
     * @return $this Self object
     */
    public function setUser($user);
}
