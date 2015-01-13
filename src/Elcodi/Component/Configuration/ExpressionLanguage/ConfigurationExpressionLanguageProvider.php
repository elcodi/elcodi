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

namespace Elcodi\Component\Configuration\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class ConfigurationExpressionLanguageProvider
 */
class ConfigurationExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return array(
            new ExpressionFunction('elcodi_config', function ($name) {
                return sprintf(
                    '$this->get(\'elcodi.configuration_manager\')->get(%s)',
                    $name
                );
            }, function (array $variables, $name) {
                return $variables['container']
                    ->get('elcodi.configuration_manager')
                    ->get($name);
            }),
        );
    }
}
