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

namespace Elcodi\Component\Media\Entity;

use Elcodi\Component\Media\Entity\Abstracts\Media;
use Elcodi\Component\Media\Entity\Interfaces\FileInterface;

/**
 * Class File.
 */
class File extends Media implements FileInterface
{
    /**
     * @var string
     *
     * Path
     */
    protected $path;

    /**
     * @var string
     *
     * Content Type
     */
    protected $contentType;

    /**
     * @var string
     *
     * Extension
     */
    protected $extension;

    /**
     * @var int
     *
     * Size
     */
    protected $size;

    /**
     * @var string
     *
     * Content
     */
    protected $content;

    /**
     * Set path.
     *
     * @param string $path Path to file
     *
     * @return $this Self object
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the mime type of this media element.
     *
     * @param string $contentType Content type
     *
     * @return $this Self object
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get the mime type of this media element.
     *
     * @return string Content type
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the extension of the file.
     *
     * @param string $extension Extension
     *
     * @return $this Self object
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the extension of the file.
     *
     * @return string Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the file size in bytes.
     *
     * @param int $size Size
     *
     * @return $this Self object
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the file size in bytes.
     *
     * @return int Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the content.
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
     * Get the content.
     *
     * @return string Content
     */
    public function getContent()
    {
        return $this->content;
    }
}
