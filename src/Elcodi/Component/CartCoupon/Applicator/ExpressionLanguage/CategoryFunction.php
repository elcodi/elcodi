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

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryFunction.
 */
class CategoryFunction implements ExpressionLanguageFunctionInterface
{
    /**
     * Register function.
     *
     * @param ExpressionLanguage $expressionLanguage Expression language
     */
    public function registerFunction(ExpressionLanguage $expressionLanguage)
    {
        $expressionLanguage->register('c', function ($ids) {
            return sprintf('(c(%1$s))', $ids);
        }, function ($arguments, $ids) {
            $ids = explode(',', $ids);
            $purchasable = $arguments['purchasable'];

            $categoryIds = $purchasable
                ->getCategories()
                ->map(function (CategoryInterface $category) {
                    return $category->getId();
                })
                ->toArray();

            $intersection = array_intersect(
                $categoryIds,
                $ids
            );

            return !empty($intersection);
        });
    }
}
