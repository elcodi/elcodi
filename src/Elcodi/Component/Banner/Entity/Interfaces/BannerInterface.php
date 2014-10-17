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

namespace Elcodi\Component\Banner\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * BannerInterface
 */
interface BannerInterface extends EnabledInterface, DateTimeInterface
{
    /**
     * Set banner name
     *
     * @param string $name Name of the banner
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addBannerZone(BannerZoneInterface $bannerZone);

    /**
     * Remove banner zone from banner
     *
     * @param BannerZoneInterface $bannerZone Banner Zone
     *
     * @return $this self Object
     */
    public function removeBannerZone(BannerZoneInterface $bannerZone);
}
