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

namespace Elcodi\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration.
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'abstract_user',
                            'Elcodi\Component\User\Entity\Abstracts\AbstractUser',
                            '@ElcodiUserBundle/Resources/config/doctrine/AbstractUser.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'admin_user',
                            'Elcodi\Component\User\Entity\AdminUser',
                            '@ElcodiUserBundle/Resources/config/doctrine/AdminUser.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'customer',
                            'Elcodi\Component\User\Entity\Customer',
                            '@ElcodiUserBundle/Resources/config/doctrine/Customer.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}
