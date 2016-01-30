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

namespace Elcodi\Component\Media\Entity\Interfaces;

/**
 * Interface FileInterface.
 */
interface FileInterface extends MediaInterface
{
    /**
     * Set path.
     *
     * @param string $path Path to file
     *
     * @return $this Self object
     */
    public function setPath($path);

    /**
     * Get path.
     *
     * @return string Path
     */
    public function getPath();

    /**
     * Set the mime type of this media element.
     *
     * @param string $contentType Content type
     *
     * @return $this Self object
     */
    public function setContentType($contentType);

    /**
     * Get the mime type of this media element.
     *
     * @return string
     */
    public function getContentType();

    /**
     * Set the extension of the file.
     *
     * @param string $extension Extension
     *
     * @return $this Self object
     */
    public function setExtension($extension);

    /**
     * Get the extension of the file.
     *
     * @return string
     */
    public function getExtension();

    /**
     * Set the file size in bytes.
     *
     * @param string $size Size
     *
     * @return $this Self object
     */
    public function setSize($size);

    /**
     * Get the file size in bytes.
     *
     * @return int Size
     */
    public function getSize();

    /**
     * Set the content.
     *
     * @param string $content Content
     *
     * @return $this Self object
     */
    public function setContent($content);

    /**
     * Get the content.
     *
     * @return string Content
     */
    public function getContent();
}
