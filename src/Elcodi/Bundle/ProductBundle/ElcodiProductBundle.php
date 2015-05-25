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

namespace Elcodi\Bundle\ProductBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface;
use Elcodi\Bundle\ProductBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\ProductBundle\DependencyInjection\ElcodiProductExtension;

/**
 * ElcodiProductBundle Bundle
 */
class ElcodiProductBundle extends Bundle implements DependentBundleInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingCompilerPass());
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiProductExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies()
    {
        return [
            'Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle',
            'Elcodi\Bundle\LanguageBundle\ElcodiLanguageBundle',
            'Elcodi\Bundle\MediaBundle\ElcodiMediaBundle',
            'Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle',
            'Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle',
            'Elcodi\Bundle\ConfigurationBundle\ElcodiConfigurationBundle',
            'Elcodi\Bundle\StoreBundle\ElcodiStoreBundle',
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
        ];
    }

    /**
     * Register Commands.
     *
     * Disabled as commands are registered as services.
     *
     * @param Application $application An Application instance
     */
    public function registerCommands(Application $application)
    {
        return null;
    }
}
