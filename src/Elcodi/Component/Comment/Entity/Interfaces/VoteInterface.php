<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Comment\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface VoteInterface.
 */
interface VoteInterface
    extends
    IdentifiableInterface,
    DateTimeInterface
{
    /**
     * Get Comment.
     *
     * @return CommentInterface Comment
     */
    public function getComment();

    /**
     * Sets Comment.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function setComment(CommentInterface $comment);

    /**
     * Get Type.
     *
     * @return bool Type
     */
    public function getType();

    /**
     * Sets Type.
     *
     * @param bool $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get AuthorToken.
     *
     * @return string AuthorToken
     */
    public function getAuthorToken();

    /**
     * Sets AuthorToken.
     *
     * @param string $authorToken AuthorToken
     *
     * @return $this Self object
     */
    public function setAuthorToken($authorToken);
}
