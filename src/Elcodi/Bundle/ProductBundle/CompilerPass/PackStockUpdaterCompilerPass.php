<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\ProductBundle\CompilerPass;

use Elcodi\Bundle\CoreBundle\CompilerPass\Abstracts\AbstractTagCompilerPass;

/**
 * Class PackStockUpdaterCompilerPass.
 */
class PackStockUpdaterCompilerPass extends AbstractTagCompilerPass
{
    /**
     * Get collector service name.
     *
     * @return string Collector service name
     */
    public function getCollectorServiceName()
    {
        return 'elcodi.stock_updater.product_pack';
    }

    /**
     * Get collector method name.
     *
     * @return string Collector method name
     */
    public function getCollectorMethodName()
    {
        return 'addPurchasableStockUpdater';
    }

    /**
     * Get tag name.
     *
     * @return string Tag name
     */
    public function getTagName()
    {
        return 'elcodi.simple_purchasable_stock_updater';
    }
}
