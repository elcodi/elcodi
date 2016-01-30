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

namespace Elcodi\Bundle\RuleBundle;

use Mmoreram\SymfonyBundleDependencies\DependentBundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Bundle\RuleBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\RuleBundle\DependencyInjection\ElcodiRuleExtension;
use Elcodi\Component\Rule\CompilerPass\ContextCompilerPass;
use Elcodi\Component\Rule\CompilerPass\ExpressionLanguageCompilerPass;

/**
 * Class ElcodiRuleBundle.
 */
class ElcodiRuleBundle extends AbstractElcodiBundle implements DependentBundleInterface
{
    /**
     * Builds bundle.
     *
     * @param ContainerBuilder $container Container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /**
         * Adds compiler pass.
         */
        $container
            ->addCompilerPass(new MappingCompilerPass())
            ->addCompilerPass(new ContextCompilerPass())
            ->addCompilerPass(new ExpressionLanguageCompilerPass());
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiRuleExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces.
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
        ];
    }
}
