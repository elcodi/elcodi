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

namespace Elcodi\Component\Plugin\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\PluginTypes;

/**
 * Class PluginRepository
 */
class PluginRepository extends EntityRepository
{
    /**
     * Find certain type plugins
     *
     * @param string $category Plugin category
     *
     * @return Plugin[] All installed plugins from certain type
     */
    public function getPluginsByCategory($category)
    {
        return $this->findBy([
            'type' => PluginTypes::TYPE_PLUGIN,
            'category' => $category,
            'enabled'  => true,
        ]);
    }

    /**
     * Find all templates given a category
     *
     * @param string $category Plugin category
     *
     * @return Plugin[] All installed templates from certain type
     */
    public function getTemplatesByCategory($category)
    {
        return $this->findBy([
            'type' => PluginTypes::TYPE_TEMPLATE,
            'category' => $category,
            'enabled'  => true,
        ]);
    }
}
