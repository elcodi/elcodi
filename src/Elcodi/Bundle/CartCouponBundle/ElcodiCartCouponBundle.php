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

namespace Elcodi\Bundle\CartCouponBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CartCouponBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\CartCouponBundle\DependencyInjection\ElcodiCartCouponExtension;
use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface;

/**
 * Class ElcodiCartCouponBundle
 */
class ElcodiCartCouponBundle extends AbstractElcodiBundle implements DependentBundleInterface
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
        return new ElcodiCartCouponExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Elcodi\Bundle\CartBundle\ElcodiCartBundle',
            'Elcodi\Bundle\CouponBundle\ElcodiCouponBundle',
            'Elcodi\Bundle\RuleBundle\ElcodiRuleBundle',
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
        ];
    }
}
