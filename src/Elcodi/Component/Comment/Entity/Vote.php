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

namespace Elcodi\Component\Comment\Entity;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;

/**
 * Class Vote
 */
class Vote implements VoteInterface
{
    use DateTimeTrait;

    /**
     * @var boolean
     *
     * Vote up
     */
    const UP = true;

    /**
     * @var boolean
     *
     * Vote down
     */
    const DOWN = false;

    /**
     * @var integer
     *
     * id
     */
    protected $id;

    /**
     * @var boolean
     *
     * Type
     */
    protected $type;

    /**
     * @var string
     *
     * Author token
     */
    protected $authorToken;

    /**
     * @var CommentInterface
     *
     * Comment
     */
    protected $comment;

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Get Comment
     *
     * @return CommentInterface Comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets Comment
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get Type
     *
     * @return boolean Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Type
     *
     * @param boolean $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get AuthorToken
     *
     * @return string AuthorToken
     */
    public function getAuthorToken()
    {
        return $this->authorToken;
    }

    /**
     * Sets AuthorToken
     *
     * @param string $authorToken AuthorToken
     *
     * @return $this Self object
     */
    public function setAuthorToken($authorToken)
    {
        $this->authorToken = $authorToken;

        return $this;
    }
}
