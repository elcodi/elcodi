<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Plugin\StoreSetupWizardBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class ElcodiStoreSetupWizardExtension
 */
class ElcodiStoreSetupWizardExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_store_setup_wizard';

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
     * @param array $config Config array
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'services',
            'templating',
            'eventListeners',
        ];
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
