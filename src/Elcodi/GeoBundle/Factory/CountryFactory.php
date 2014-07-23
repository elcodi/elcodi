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

namespace Elcodi\GeoBundle\Factory;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\GeoBundle\Entity\Interfaces\CountryInterface;
use Elcodi\LanguageBundle\Entity\Interfaces\LanguageInterface;

/**
 * Class CountryFactory
 */
class CountryFactory extends AbstractFactory
{
    /**
     * Creates an instance of a simple country.
     *
     * This method must return always an empty instance for related entity
     *
     * @return LanguageInterface Empty entity
     */
    public function create()
    {
        /**
         * @var CountryInterface $country
         */
        $classNamespace = $this->getEntityNamespace();
        $country = new $classNamespace();

        return $country;
    }
}
