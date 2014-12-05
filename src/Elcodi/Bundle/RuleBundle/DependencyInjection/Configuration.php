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

namespace Elcodi\Bundle\RuleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritDoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'abstract_rule',
                            'Elcodi\Component\Rule\Entity\Abstracts\AbstractRule',
                            '@ElcodiRuleBundle/Resources/config/doctrine/AbstractRule.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'expression',
                            'Elcodi\Component\Rule\Entity\Expression',
                            '@ElcodiRuleBundle/Resources/config/doctrine/Expression.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'rule',
                            'Elcodi\Component\Rule\Entity\Rule',
                            '@ElcodiRuleBundle/Resources/config/doctrine/Rule.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'rule_group',
                            'Elcodi\Component\Rule\Entity\RuleGroup',
                            '@ElcodiRuleBundle/Resources/config/doctrine/RuleGroup.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}
