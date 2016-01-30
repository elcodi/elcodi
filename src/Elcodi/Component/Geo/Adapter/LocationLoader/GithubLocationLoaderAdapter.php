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

namespace Elcodi\Component\Geo\Adapter\LocationLoader;

use Elcodi\Component\Geo\Adapter\LocationLoader\Interfaces\LocationLoaderAdapterInterface;

/**
 * Class GithubLocationLoaderAdapter.
 */
class GithubLocationLoaderAdapter implements LocationLoaderAdapterInterface
{
    /**
     * Given a country name, return the sql to be loaded.
     *
     * @param string $countryName Country name
     *
     * @return string Sql to be loaded
     */
    public function getSqlForCountry($countryName)
    {
        $url = 'https://raw.githubusercontent.com/elcodi/LocationDumps/master/' . $countryName . '.sql';

        return file_get_contents($url);
    }
}
