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

namespace Elcodi\Component\Banner\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Banner\Entity\Interfaces\BannerInterface;
use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * BannerZone
 */
class BannerZone extends AbstractEntity implements BannerZoneInterface
{
    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var Collection
     *
     * Language
     */
    protected $language;

    /**
     * @var Collection
     *
     * Banners
     */
    protected $banners;

    /**
     * @var float
     *
     * Height of item in cm
     */
    protected $height;

    /**
     * @var float
     *
     * Width of item in cm
     */
    protected $width;

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
     * Set code
     *
     * @param string $code
     *
     * @return $this self Object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Language
     *
     * @param LanguageInterface $language Language to set
     *
     * @return $this self Object
     */
    public function setLanguage(LanguageInterface $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get shops
     *
     * @return LanguageInterface Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add banner into banner zone
     *
     * @param BannerInterface $banner Banner
     *
     * @return $this self Object
     */
    public function addBanner(BannerInterface $banner)
    {
        $this->banners->add($banner);

        return $this;
    }

    /**
     * Remove banner from banner zone
     *
     * @param BannerInterface $banner Banner
     *
     * @return $this self Object
     */
    public function removeBanner(BannerInterface $banner)
    {
        $this->banners->removeElement($banner);

        return $this;
    }

    /**
     * Set banners into banner zone
     *
     * @param Collection $banners Banners
     *
     * @return $this self Object
     */
    public function setBanners(Collection $banners)
    {
        $this->banners = $banners;

        return $this;
    }

    /**
     * Get banners
     *
     * @return Collection Banners
     */
    public function getBanners()
    {
        $this->banners;
    }

    /**
     * Set the BannerZoneInterface height in pixels
     *
     * @param float $height Height
     *
     * @return $this self Object
     */
    public function setHeight($height)
    {
        $this->height = (float) $height;

        return $this;
    }

    /**
     * Get the BannerZoneInterface height in pixels
     *
     * @return float Height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the BannerZoneInterface width in pixels
     *
     * @param float $width Width
     *
     * @return $this self Object
     */
    public function setWidth($width)
    {
        $this->width = (float) $width;

        return $this;
    }

    /**
     * Get the BannerZoneInterface width in pixels
     *
     * @return float Width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * To string method
     *
     * @return string BannerZoneInterface to string
     */
    public function __toString()
    {
        $isoLang = 'all languages';

        if ($this->getLanguage() instanceof LanguageInterface) {

            $isoLang = $this->getLanguage()->getIso();
        }

        return $this->getName() . ' - ' . $isoLang;
    }
}
