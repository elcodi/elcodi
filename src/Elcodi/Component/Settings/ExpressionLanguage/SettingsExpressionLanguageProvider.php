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

namespace Elcodi\Component\Settings\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class SettingsExpressionLanguageProvider
 */
class SettingsExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            new ExpressionFunction('elcodi_settings', function ($name, $defaultValue = null) {

                return ($defaultValue)
                    ? sprintf(
                        '$this->get(\'elcodi.manager.settings\')->get(%s,%s)',
                        $name,
                        $defaultValue
                    )
                    : sprintf(
                        '$this->get(\'elcodi.manager.settings\')->get(%s)',
                        $name
                    );

            }, function (array $variables, $name, $defaultValue = null) {
                return $variables['container']
                    ->get('elcodi.manager.settings')
                    ->get($name, $defaultValue);
            }),
        ];
    }
}
