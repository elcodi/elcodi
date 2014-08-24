<?php

/**
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

namespace Elcodi\Component\Media\Entity\Interfaces;

/**
 * Class FileInterface
 */
interface FileInterface extends MediaInterface
{
    /**
     * Set path
     *
     * @param string $path Path to file
     *
     * @return FileInterface self Object
     */
    public function setPath($path);

    /**
     * Get path
     *
     * @return string Path
     */
    public function getPath();

    /**
     * Set id
     *
     * @param int $id Entity Id
     *
     * @return FileInterface self Object
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return int Entity identifier
     */
    public function getId();

    /**
     * Set the mime type of this media element
     *
     * @param string $contentType Content type
     *
     * @return FileInterface self Object
     */
    public function setContentType($contentType);

    /**
     * Get the mime type of this media element
     *
     * @return string
     */
    public function getContentType();

    /**
     * Set the extension of the file
     *
     * @param string $extension Extension
     *
     * @return FileInterface self Object
     */
    public function setExtension($extension);

    /**
     * Get the extension of the file
     *
     * @return string
     */
    public function getExtension();

    /**
     * Set the file size in bytes
     *
     * @param string $size Size
     *
     * @return FileInterface self Object
     */
    public function setSize($size);

    /**
     * Get the file size in bytes
     *
     * @return integer Size
     */
    public function getSize();

    /**
     * Set the content
     *
     * @param string $content Content
     *
     * @return FileInterface self Object
     */
    public function setContent($content);

    /**
     * Get the content
     *
     * @return string Content
     */
    public function getContent();
}
