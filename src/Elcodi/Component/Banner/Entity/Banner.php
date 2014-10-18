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

namespace Elcodi\Component\Banner\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Banner\Entity\Interfaces\BannerInterface;
use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;

/**
 * Banner
 */
class Banner extends AbstractEntity implements BannerInterface
{
    use DateTimeTrait, EnabledTrait, PrincipalImageTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var string
     *
     * Url
     */
    protected $url;

    /**
     * @var integer
     *
     * Position
     */
    protected $position;

    /**
     * @var ImageInterface
     *
     * Banner image
     */
    protected $image;

    /**
     * @var Collection
     *
     * Banner zones
     */
    protected $bannerZones;

    /**
     * Set banner name
     *
     * @param string $name Name of the banner
     *
     * @return $this self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get banner name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set banner description
     *
     * @param string $description Description of the banner
     *
     * @return $this self Object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get banner description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set banner url
     *
     * @param string $url Url of the banner
     *
     * @return $this self Object
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get banner url
     *
     * @return string Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set banner zones to banner
     *
     * @param Collection $bannerZones Banner zones
     *
     * @return $this self Object
     */
    public function setBannerZones(Collection $bannerZones)
    {
        $this->bannerZones = $bannerZones;

        return $this;
    }

    /**
     * Get banner zones from banner
     *
     * @return Collection banner zones
     */
    public function getBannerZones()
    {
        return $this->bannerZones;
    }

    /**
     * Add banner zone to banner
     *
     * @param BannerZoneInterface $bannerZone Banner Zone
     *
     * @return $this self Object
     */
    public function addBannerZone(BannerZoneInterface $bannerZone)
    {
        $this->bannerZones->add($bannerZone);

        return $this;
    }

    /**
     * Remove banner zone from banner
     *
     * @param BannerZoneInterface $bannerZone Banner Zone
     *
     * @return $this self Object
     */
    public function removeBannerZone(BannerZoneInterface $bannerZone)
    {
        $this->bannerZones->removeElement($bannerZone);

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getName();
    }
}
