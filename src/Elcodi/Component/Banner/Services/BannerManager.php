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

namespace Elcodi\Component\Banner\Services;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Banner\Repository\BannerRepository;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * BannerManager.
 */
class BannerManager
{
    /**
     * @var BannerRepository
     *
     * Banner Repository
     */
    private $bannerRepository;

    /**
     * Construct method.
     *
     * @param BannerRepository $bannerRepository Banner repository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Get banners from a bannerZone code, given a language.
     *
     * @param string            $bannerZoneCode Banner zone code
     * @param LanguageInterface $language       Language
     *
     * @return Collection banners
     */
    public function getBannersFromBannerZoneCode($bannerZoneCode, LanguageInterface $language = null)
    {
        return $this
            ->bannerRepository
            ->getBannerByZone($bannerZoneCode, $language);
    }

    /**
     * Get banners from a bannerZone, given a language.
     *
     * @param BannerZoneInterface $bannerZone Banner zone
     * @param LanguageInterface   $language   Language
     *
     * @return Collection banners
     */
    public function getBannersFromBannerZone(BannerZoneInterface $bannerZone, LanguageInterface $language = null)
    {
        return $this->getBannersFromBannerZoneCode(
            $bannerZone->getCode(),
            $language
        );
    }
}
