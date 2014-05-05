<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */
 
namespace Elcodi\MediaBundle\Entity;

use Elcodi\MediaBundle\Entity\Abstracts\Media;
use Elcodi\MediaBundle\Entity\Interfaces\FileInterface;

/**
 * Class File
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
     * @var integer
     *
     * Size
     */
    protected $size;

    /**
     * Set path
     *
     * @param string $path Path to file
     *
     * @return File self Object
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the mime type of this media element
     *
     * @param string $contentType Content type
     *
     * @return File self Object
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get the mime type of this media element
     *
     * @return string Content type
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the extension of the file
     *
     * @param string $extension Extension
     *
     * @return File self Object
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the extension of the file
     *
     * @return string Extension
     */
    public function getExtension()
    {
        return $this;
    }

    /**
     * Set the file size in bytes
     *
     * @param integer $size Size
     *
     * @return File self Object
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the file size in bytes
     *
     * @return integer Size
     */
    public function getSize()
    {
        return $this->size;
    }
}
 