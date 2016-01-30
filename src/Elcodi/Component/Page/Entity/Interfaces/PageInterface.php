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

namespace Elcodi\Component\Page\Entity\Interfaces;

use DateTime;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface PageInterface.
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 * @author Berny Cantos <be@rny.cc>
 */
interface PageInterface
    extends
    IdentifiableInterface,
    MetaDataInterface,
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Set the path.
     *
     * @param string $path The path
     *
     * @return $this Self object
     */
    public function setPath($path);

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set the title.
     *
     * @param string $title The title
     *
     * @return $this Self object
     */
    public function setTitle($title);

    /**
     * Get the content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set the content.
     *
     * @param string $content The content
     *
     * @return $this Self object
     */
    public function setContent($content);

    /**
     * Get Type.
     *
     * @return int Type
     */
    public function getType();

    /**
     * Sets Type.
     *
     * @param int $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get PublicationDate.
     *
     * @return DateTime PublicationDate
     */
    public function getPublicationDate();

    /**
     * Sets PublicationDate.
     *
     * @param DateTime $publicationDate PublicationDate
     *
     * @return $this Self object
     */
    public function setPublicationDate(DateTime $publicationDate);

    /**
     * Sets the persistence property.
     *
     * @param bool $persistent If the page can't be removed
     *
     * @return $this Self object
     */
    public function setPersistent($persistent);

    /**
     * Gets the page persistence.
     *
     * @return bool If the page is persistent
     */
    public function isPersistent();
}
