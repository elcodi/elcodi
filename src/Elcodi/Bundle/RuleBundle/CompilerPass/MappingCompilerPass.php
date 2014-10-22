<?php

/*
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

namespace Elcodi\Bundle\RuleBundle\CompilerPass;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MappingCompilerPass
 */
class MappingCompilerPass extends AbstractMappingCompilerPass
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this
            ->addEntityMapping(
                $container,
                'elcodi.core.rule.entity.abstract_rule.manager',
                'elcodi.core.rule.entity.abstract_rule.class',
                'elcodi.core.rule.entity.abstract_rule.mapping_file',
                'elcodi.core.rule.entity.abstract_rule.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.rule.entity.expression.manager',
                'elcodi.core.rule.entity.expression.class',
                'elcodi.core.rule.entity.expression.mapping_file',
                'elcodi.core.rule.entity.expression.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.rule.entity.rule.manager',
                'elcodi.core.rule.entity.rule.class',
                'elcodi.core.rule.entity.rule.mapping_file',
                'elcodi.core.rule.entity.rule.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.rule.entity.rule_group.manager',
                'elcodi.core.rule.entity.rule_group.class',
                'elcodi.core.rule.entity.rule_group.mapping_file',
                'elcodi.core.rule.entity.rule_group.enabled'
            );
    }
}
