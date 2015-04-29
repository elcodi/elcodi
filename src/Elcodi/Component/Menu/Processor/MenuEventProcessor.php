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

namespace Elcodi\Component\Menu\Processor;

use RuntimeException;

use Elcodi\Component\Menu\Event\Abstracts\AbstractMenuEvent;
use Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface;

/**
 * Class MenuEventProcessor
 */
class MenuEventProcessor
{
    /**
     * @var MenuSerializerInterface
     *
     * Menu serializer
     */
    protected $menuSerializer;

    /**
     * Menu serializer
     *
     * @param MenuSerializerInterface $menuSerializer Menu Serializer
     */
    public function __construct(MenuSerializerInterface $menuSerializer)
    {
        $this->menuSerializer = $menuSerializer;
    }

    /**
     * Visit each node in the menu with the filters and return the result.
     *
     * @return array
     */
    public function getProcessedMenu(AbstractMenuEvent $event)
    {
        $filters = $event->getFilters();
        $nodes = $event->getNodes();

        if (count($filters) === 0) {
            return $nodes;
        }

        return $this
            ->applyFiltersToNodes(
                $filters,
                $nodes
            );
    }

    /**
     * Apply all filters to all nodes
     *
     * @param array $filters Filters
     * @param array $nodes   Nodes
     *
     * @return array Filtered nodes
     */
    protected function applyFiltersToNodes(
        array $filters,
        array $nodes
    ) {
        $subnodes = [];
        foreach ($nodes as $nodeName => $childNode) {
            foreach ($filters as $filter) {
                $childNode = $filter($childNode);
                if ($childNode === false) {
                    continue 2;
                }

                if (!is_array($childNode)) {
                    throw new RuntimeException(sprintf(
                        'Menu filters should return an array, but "%s" was found.',
                        gettype($childNode)
                    ));
                }
            }

            if (count($childNode['subnodes']) > 0) {
                $childNode['subnodes'] = $this
                    ->applyFiltersToNodes(
                        $filters,
                        $childNode['subnodes']
                    );
            }

            $subnodes[$nodeName] = $childNode;
        }

        return $subnodes;
    }
}
