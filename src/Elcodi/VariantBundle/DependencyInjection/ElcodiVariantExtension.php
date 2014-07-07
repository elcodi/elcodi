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

namespace Elcodi\VariantBundle\DependencyInjection;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiVariantExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
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
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'services',
            'factories',
            'repositories',
            'objectManagers',
        ];
    }

    /**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\VariantBundle\Entity\Interfaces\VariantInterface' => 'elcodi.core.variant.entity.variant.class',
            'Elcodi\ProductBundle\Entity\Interfaces\ProductInterface' => 'elcodi.core.variant.entity.product.class',
        ];
    }
}
