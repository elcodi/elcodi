<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Banner\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * BannerRepository.
 */
class BannerRepository extends EntityRepository
{
    /**
     * Get activated banners by specific banner zone (and optional zone code).
     *
     * Return an ArrayCollection object
     *
     * @param string            $bannerZoneCode BannerZone code
     * @param LanguageInterface $language       Language
     *
     * @return ArrayCollection
     */
    public function getBannerByZone($bannerZoneCode, LanguageInterface $language = null)
    {
        $parameters = [
            'code' => $bannerZoneCode,
        ];

        if (!is_null($language)) {
            $parameters['language'] = $language;
        }

        $banners = $this
            ->createQueryBuilder('b')
            ->leftJoin('b.bannerZones', 'bz')
            ->where(
                is_null($language)
                    ? 'bz.language is NULL'
                    : 'bz.language = :language'
            )
            ->andWhere('bz.code = :code')
            ->orderBy('b.position', 'ASC')
            ->setParameters($parameters)
            ->getQuery()
            ->getResult();

        return new ArrayCollection($banners);
    }
}
