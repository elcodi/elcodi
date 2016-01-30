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

namespace Elcodi\Component\CartCoupon\Applicator\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;

/**
 * Class ManufacturerFunction.
 */
class ManufacturerFunction implements ExpressionLanguageFunctionInterface
{
    /**
     * Register function.
     *
     * @param ExpressionLanguage $expressionLanguage Expression language
     */
    public function registerFunction(ExpressionLanguage $expressionLanguage)
    {
        $expressionLanguage->register('m', function ($ids) {
            return sprintf('(purchasable.manufacturer.id in [%1$s])', $ids);
        }, function ($arguments, $ids) {
            $ids = explode(',', $ids);
            $purchasable = $arguments['purchasable'];
            $manufacturer = $purchasable->getManufacturer();

            if (!$manufacturer instanceof ManufacturerInterface) {
                return false;
            }

            return in_array(
                $manufacturer->getId(),
                $ids
            );
        });
    }
}
