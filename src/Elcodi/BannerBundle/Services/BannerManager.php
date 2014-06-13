<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\BannerBundle\Services;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\BannerBundle\Entity\Interfaces\BannerZoneInterface;
use Elcodi\BannerBundle\Repository\BannerRepository;

/**
 * BannerManager
 */
class BannerManager
{
    /**
     * @var BannerRepository
     *
     * Banner Repository
     */
    protected $bannerRepository;

    /**
     * Construct method
     *
     * @param BannerRepository $bannerRepository Banner zone repository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Get banners from a bannerZone code, given a language
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
     * Get banners from a bannerZone, given a language
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
