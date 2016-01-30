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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface ManufacturerInterface.
 */
interface ManufacturerInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface,
    MetaDataInterface,
    ImagesContainerWithPrincipalImageInterface
{
    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Set description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug);

    /**
     * Get slug.
     *
     * @return string Slug
     */
    public function getSlug();
}
