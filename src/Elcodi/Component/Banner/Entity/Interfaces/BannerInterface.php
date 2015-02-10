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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Banner\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * BannerInterface
 */
interface BannerInterface
    extends
    IdentifiableInterface,
    EnabledInterface,
    DateTimeInterface
{
    /**
     * Set banner name
     *
     * @param string $name Name of the banner
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get banner name
     *
     * @return string
     */
    public function getName();

    /**
     * Set banner description
     *
     * @param string $description Description of the banner
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Get banner description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set banner url
     *
     * @param string $url Url of the banner
     *
     * @return $this Self object
     */
    public function setUrl($url);

    /**
     * Get banner url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set banner zones to banner
     *
     * @param Collection $bannerZones Banner zones
     *
     * @return $this Self object
     */
    public function setBannerZones(Collection $bannerZones);

    /**
     * Get banner zones from banner
     *
     * @return Collection banner zones
     */
    public function getBannerZones();

    /**
     * Add banner zone to banner
     *
     * @param BannerZoneInterface $bannerZone Banner Zone
     *
     * @return $this Self object
     */
    public function addBannerZone(BannerZoneInterface $bannerZone);

    /**
     * Remove banner zone from banner
     *
     * @param BannerZoneInterface $bannerZone Banner Zone
     *
     * @return $this Self object
     */
    public function removeBannerZone(BannerZoneInterface $bannerZone);
}
