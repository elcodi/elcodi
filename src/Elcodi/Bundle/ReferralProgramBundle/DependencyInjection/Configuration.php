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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ReferralProgramBundle\DependencyInjection;

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
                            'referral_hash',
                            'Elcodi\Component\ReferralProgram\Entity\ReferralHash',
                            '@ElcodiReferralProgramBundle/Resources/config/doctrine/ReferralHash.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'referral_line',
                            'Elcodi\Component\ReferralProgram\Entity\ReferralLine',
                            '@ElcodiReferralProgramBundle/Resources/config/doctrine/ReferralLine.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'referral_rule',
                            'Elcodi\Component\ReferralProgram\Entity\ReferralRule',
                            '@ElcodiReferralProgramBundle/Resources/config/doctrine/ReferralRule.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->scalarNode('controller_route_name')
                    ->defaultValue('elcodi_referralprogram_track')
                ->end()
                ->scalarNode('controller_route')
                    ->defaultValue('/referralprogram/track/{hash}')
                ->end()
                ->scalarNode('controller_redirect_route_name')
                    ->defaultValue('')
                ->end()
                ->booleanNode('purge_disabled_lines')
                    ->defaultFalse()
                ->end()
                ->booleanNode('auto_referral_assignment')
                    ->defaultTrue()
                ->end()
            ->end();
    }
}
