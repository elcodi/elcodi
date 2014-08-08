<?php

/**
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

namespace Elcodi\RuleBundle\DependencyInjection;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiRuleExtension
 */
class ElcodiRuleExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
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
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'services',
            'factories',
            'configurations',
            'repositories',
            'objectManagers',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\RuleBundle\Entity\Interfaces\RuleInterface' => 'elcodi.core.rule.entity.rule.class',
            'Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface' => 'elcodi.core.rule.entity.rule_group.class',
            'Elcodi\RuleBundle\Entity\Interfaces\ExpressionInterface' => 'elcodi.core.rule.entity.expression.class',
        ];
    }
}
