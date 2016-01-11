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

namespace Elcodi\Component\Comment\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

/**
 * Class Comment.
 */
class Comment implements CommentInterface
{
    use IdentifiableTrait, DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Source
     */
    protected $source;

    /**
     * @var string
     *
     * Context
     */
    protected $context;

    /**
     * @var CommentInterface|null
     *
     * parent
     */
    protected $parent;

    /**
     * @var Collection
     *
     * children
     */
    protected $children;

    /**
     * @var string
     *
     * Author token
     */
    protected $authorToken;

    /**
     * @var string
     *
     * Author name
     */
    protected $authorName;

    /**
     * @var string
     *
     * Author email
     */
    protected $authorEmail;

    /**
     * @var string
     *
     * content
     */
    protected $content;

    /**
     * Sets Content.
     *
     * @param string $content Content
     *
     * @return $this Self object
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get Content.
     *
     * @return string Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets Parent.
     *
     * @param CommentInterface|null $parent Parent
     *
     * @return $this Self object
     */
    public function setParent(CommentInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get Parent.
     *
     * @return CommentInterface|null Parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets Source.
     *
     * @param string $source Source
     *
     * @return $this Self object
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get Source.
     *
     * @return string Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set Children.
     *
     * @param Collection $children Children
     *
     * @return $this Self object
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get Children.
     *
     * @return Collection Children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get Context.
     *
     * @return string Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets Context.
     *
     * @param string $context Context
     *
     * @return $this Self object
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get AuthorEmail.
     *
     * @return string AuthorEmail
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Sets AuthorEmail.
     *
     * @param string $authorEmail AuthorEmail
     *
     * @return $this Self object
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * Get AuthorName.
     *
     * @return string AuthorName
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Sets AuthorName.
     *
     * @param string $authorName AuthorName
     *
     * @return $this Self object
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get AuthorToken.
     *
     * @return string AuthorToken
     */
    public function getAuthorToken()
    {
        return $this->authorToken;
    }

    /**
     * Sets AuthorToken.
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
