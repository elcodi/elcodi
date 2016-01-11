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

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CommentInterface.
 */
interface CommentInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Get AuthorEmail.
     *
     * @return string AuthorEmail
     */
    public function getAuthorEmail();

    /**
     * Sets AuthorEmail.
     *
     * @param string $authorEmail AuthorEmail
     *
     * @return $this Self object
     */
    public function setAuthorEmail($authorEmail);

    /**
     * Get AuthorName.
     *
     * @return string AuthorName
     */
    public function getAuthorName();

    /**
     * Sets AuthorName.
     *
     * @param string $authorName AuthorName
     *
     * @return $this Self object
     */
    public function setAuthorName($authorName);

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

    /**
     * Sets Content.
     *
     * @param string $content Content
     *
     * @return $this Self object
     */
    public function setContent($content);

    /**
     * Get Content.
     *
     * @return string Content
     */
    public function getContent();

    /**
     * Sets Parent.
     *
     * @param CommentInterface|null $parent Parent
     *
     * @return $this Self object
     */
    public function setParent(CommentInterface $parent = null);

    /**
     * Get Parent.
     *
     * @return CommentInterface|null Parent
     */
    public function getParent();

    /**
     * Sets Source.
     *
     * @param string $source Source
     *
     * @return $this Self object
     */
    public function setSource($source);

    /**
     * Get Source.
     *
     * @return string Source
     */
    public function getSource();

    /**
     * Set Children.
     *
     * @param Collection $children Children
     *
     * @return $this Self object
     */
    public function setChildren(Collection $children);

    /**
     * Get Children.
     *
     * @return Collection Children
     */
    public function getChildren();

    /**
     * Get Context.
     *
     * @return string Context
     */
    public function getContext();

    /**
     * Sets Context.
     *
     * @param string $context Context
     *
     * @return $this Self object
     */
    public function setContext($context);
}
