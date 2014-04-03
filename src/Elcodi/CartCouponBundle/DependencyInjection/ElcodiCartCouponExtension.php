<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartCouponBundle\DependencyInjection;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class ElcodiCartCouponExtension
 */
class ElcodiCartCouponExtension extends AbstractExtension
{

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Config files to load
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'eventListeners',
            'factories',
        ];
    }
}
