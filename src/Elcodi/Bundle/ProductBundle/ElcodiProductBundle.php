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

namespace Elcodi\Bundle\ProductBundle;

use Mmoreram\SymfonyBundleDependencies\DependentBundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Bundle\ProductBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\ProductBundle\CompilerPass\PurchasableImageResolverCompilerPass;
use Elcodi\Bundle\ProductBundle\CompilerPass\PurchasableNameResolverCompilerPass;
use Elcodi\Bundle\ProductBundle\CompilerPass\PurchasableStockUpdaterCompilerPass;
use Elcodi\Bundle\ProductBundle\CompilerPass\PurchasableStockValidatorCompilerPass;
use Elcodi\Bundle\ProductBundle\DependencyInjection\ElcodiProductExtension;

/**
 * ElcodiProductBundle Bundle.
 */
class ElcodiProductBundle extends AbstractElcodiBundle implements DependentBundleInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingCompilerPass());
        $container->addCompilerPass(new PurchasableNameResolverCompilerPass());
        $container->addCompilerPass(new PurchasableStockValidatorCompilerPass());
        $container->addCompilerPass(new PurchasableStockUpdaterCompilerPass());
        $container->addCompilerPass(new PurchasableImageResolverCompilerPass());
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
     * Create instance of current bundle, and return dependent bundle namespaces.
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle',
            'Elcodi\Bundle\LanguageBundle\ElcodiLanguageBundle',
            'Elcodi\Bundle\MediaBundle\ElcodiMediaBundle',
            'Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle',
            'Elcodi\Bundle\AttributeBundle\ElcodiAttributeBundle',
            'Elcodi\Bundle\StoreBundle\ElcodiStoreBundle',
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
        ];
    }
}
