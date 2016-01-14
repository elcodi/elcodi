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

namespace Elcodi\Component\Menu\Services\Abstracts;

/**
 * Class AbstractMenuModifier.
 */
abstract class AbstractMenuModifier
{
    /**
     * @var array
     *
     * All elements
     */
    private $allElements = [];

    /**
     * @var array
     *
     * Elements stored by menu code
     */
    private $elementsStoredByMenuCode = [];

    /**
     * @var array
     *
     * Element stored by stage
     */
    private $elementsStoredByStage = [];

    /**
     * @var array
     *
     * Priorities
     */
    private $priorities = [];

    /**
     * Add element.
     *
     * @param mixed        $element  Element
     * @param array|string $menus    Menu codes
     * @param string       $stage    Stage
     * @param int          $priority Priority
     *
     * @return $this Self object
     */
    public function addElement(
        $element,
        $menus,
        $stage,
        $priority = 0
    ) {
        $priority = (int) $priority;
        $elementId = spl_object_hash($element);
        $menus = is_array($menus)
            ? $menus
            : [$menus];

        if (empty($menus)) {
            $this->allElements[$elementId] = $element;
        } else {
            foreach ($menus as $menu) {
                $this->addElementByMenuCode(
                    $element,
                    $menu
                );
            }
        }

        $this->addElementByStage(
            $element,
            $stage
        );

        $this->priorities[$elementId] = $priority;

        return $this;
    }

    /**
     * Get elements given a stage and the code of the menu.
     *
     * @param string $menuCode Menu code
     * @param string $stage    Stage
     *
     * @return array Elements
     */
    public function getElementsByMenuCodeAndStage(
        $menuCode,
        $stage
    ) {
        $elementsByMenuCode = isset($this->elementsStoredByMenuCode[$menuCode])
            ? $this->elementsStoredByMenuCode[$menuCode]
            : [];

        $elementsByStage = isset($this->elementsStoredByStage[$stage])
            ? $this->elementsStoredByStage[$stage]
            : [];

        $elements = array_values(
            array_intersect_key(
                array_merge(
                    $this->allElements,
                    $elementsByMenuCode
                ),
                $elementsByStage
            )
        );

        usort($elements, function ($element1, $element2) {
            $element1Id = spl_object_hash($element1);
            $element2Id = spl_object_hash($element2);

            return $this->priorities[$element1Id] <= $this->priorities[$element2Id];
        });

        return $elements;
    }

    /**
     * Add element by menu code.
     *
     * @param mixed  $element  Element
     * @param string $menuCode Menu code
     *
     * @return $this Self object
     */
    private function addElementByMenuCode(
        $element,
        $menuCode
    ) {
        if (!isset($this->elementsStoredByMenuCode[$menuCode])) {
            $this->elementsStoredByMenuCode[$menuCode] = [];
        }

        $elementId = spl_object_hash($element);
        $this->elementsStoredByMenuCode[$menuCode][$elementId] = $element;

        return $this;
    }

    /**
     * Add element by stage.
     *
     * @param mixed  $element Element
     * @param string $stage   Stage
     *
     * @return $this Self object
     */
    private function addElementByStage(
        $element,
        $stage
    ) {
        if (!isset($this->elementsStoredByStage[$stage])) {
            $this->elementsStoredByStage[$stage] = [];
        }

        $elementId = spl_object_hash($element);
        $this->elementsStoredByStage[$stage][$elementId] = $element;

        return $this;
    }
}
