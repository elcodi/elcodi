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

namespace Elcodi\Bundle\RuleBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Elcodi\Bundle\CoreBundle\Interfaces\DependentBundleInterface;
use Elcodi\Bundle\RuleBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\RuleBundle\DependencyInjection\ElcodiRuleExtension;
use Elcodi\Component\Rule\CompilerPass\ContextCompilerPass;
use Elcodi\Component\Rule\CompilerPass\ExpressionLanguageCompilerPass;

/**
 * Class ElcodiRuleBundle
 */
class ElcodiRuleBundle extends Bundle implements DependentBundleInterface
{
    /**
     * Builds bundle
     *
     * @param ContainerBuilder $container Container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /**
         * Adds compiler pass
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
     * Create instance of current bundle, and return dependent bundle namespaces
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies()
    {
        return [
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
        return;
    }
}
