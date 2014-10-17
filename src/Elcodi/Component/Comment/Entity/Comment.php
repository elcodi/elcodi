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

namespace Elcodi\Component\Comment\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Class Comment
 */
class Comment implements CommentInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var integer
     *
     * id
     */
    protected $id;

    /**
     * @var string
     *
     * Source
     */
    protected $source;

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
     * @var
     *
     * author
     */
    protected $author;

    /**
     * @var string
     *
     * content
     */
    protected $content;

    /**
     * @var string
     *
     * content
     */
    protected $parsedContent;

    /**
     * @var integer
     *
     * content
     */
    protected $parsingType;

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
     * Sets Author
     *
     * @param AbstractUserInterface $author Author
     *
     * @return $this Self object
     */
    public function setAuthor(AbstractUserInterface $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get Author
     *
     * @return AbstractUserInterface Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets Content
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
     * Get Content
     *
     * @return string Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets Parent
     *
     * @param CommentInterface|null $parent Parent
     *
     * @return $this Self object
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get Parent
     *
     * @return CommentInterface|null Parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets ParsedContent
     *
     * @param string $parsedContent ParsedContent
     *
     * @return $this Self object
     */
    public function setParsedContent($parsedContent)
    {
        $this->parsedContent = $parsedContent;

        return $this;
    }

    /**
     * Get ParsedContent
     *
     * @return string ParsedContent
     */
    public function getParsedContent()
    {
        return $this->parsedContent;
    }

    /**
     * Sets ParsingType
     *
     * @param int $parsingType ParsingType
     *
     * @return $this Self object
     */
    public function setParsingType($parsingType)
    {
        $this->parsingType = $parsingType;

        return $this;
    }

    /**
     * Get ParsingType
     *
     * @return int ParsingType
     */
    public function getParsingType()
    {
        return $this->parsingType;
    }

    /**
     * Sets Source
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
     * Get Source
     *
     * @return string Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set Children
     *
     * @param Collection $children Children
     *
     * @return $this self Object
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get Children
     *
     * @return Collection Children
     */
    public function getChildren()
    {
        return $this->children;
    }
}
