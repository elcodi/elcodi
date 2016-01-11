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

namespace Elcodi\Component\Configuration\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class ConfigurationExpressionLanguageProvider.
 */
class ConfigurationExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * Get functions defined by this Expression Language element.
     *
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            new ExpressionFunction('elcodi_config', function ($name, $defaultValue = null) {

                return ($defaultValue)
                    ? sprintf(
                        '$this->get(\'elcodi.manager.configuration\')->get(%s,%s)',
                        $name,
                        $defaultValue
                    )
                    : sprintf(
                        '$this->get(\'elcodi.manager.configuration\')->get(%s)',
                        $name
                    );

            }, function (array $variables, $name, $defaultValue = null) {
                return $variables['container']
                    ->get('elcodi.manager.configuration')
                    ->get($name, $defaultValue);
            }),
        ];
    }
}
