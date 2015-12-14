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

namespace Elcodi\Component\Plugin\Exception;

use RuntimeException;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * NotFoundHttpException.
 */
class PluginNotFoundException extends RuntimeException
{
    /**
     * @return PluginNotFoundException
     */
    public static function createPluginRouteNotFound(Plugin $plugin)
    {
        $message = sprintf('Elcodi cannot find plugin %s. Make sure it exists as a vendor by checking your composer, or load elcodi:install command in order to update the plugin database', $plugin->getNamespace());

        return new static($message);
    }
}
