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

namespace Elcodi\Bundle\ReferralProgramBundle\CompilerPass;

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
                'elcodi.core.referral_program.entity.referral_hash.manager',
                'elcodi.core.referral_program.entity.referral_hash.class',
                'elcodi.core.referral_program.entity.referral_hash.mapping_file',
                'elcodi.core.referral_program.entity.referral_hash.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.referral_program.entity.referral_line.manager',
                'elcodi.core.referral_program.entity.referral_line.class',
                'elcodi.core.referral_program.entity.referral_line.mapping_file',
                'elcodi.core.referral_program.entity.referral_line.enabled'
            )
            ->addEntityMapping(
                $container,
                'elcodi.core.referral_program.entity.referral_rule.manager',
                'elcodi.core.referral_program.entity.referral_rule.class',
                'elcodi.core.referral_program.entity.referral_rule.mapping_file',
                'elcodi.core.referral_program.entity.referral_rule.enabled'
            );
    }
}
