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

namespace Elcodi\Component\Menu\Services\Abstracts;

/**
 * Class AbstractMenuModifier
 */
abstract class AbstractMenuModifier
{
    /**
     * @var array
     *
     * All elements
     */
    private $allElements;

    /**
     * @var array
     *
     * Elements stored by menu code
     */
    private $elementsStoredByMenuCode;

    /**
     * @var array
     *
     * Element stored by stage
     */
    private $elementsStoredByStage;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->elementsStoredByMenuCode = [];
        $this->elementsStoredByStage = [];
        $this->allElements = [];
    }

    /**
     * Add element
     *
     * @param mixed  $element Element
     * @param array  $menus   Menu codes
     * @param string $stage   Stage
     *
     * @return $this Self object
     */
    public function addElement(
        $element,
        $menus,
        $stage
    ) {
        $menus = is_array($menus)
            ? $menus
            : [$menus];

        if (empty($menus)) {
            $elementId = spl_object_hash($element);
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

        return $this;
    }

    /**
     * Add element by menu code
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
     * Add element by stage
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

    /**
     * Get elements given a stage and the code of the menu
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

        return array_values(
            array_intersect_key(
                array_merge(
                    $this->allElements,
                    $elementsByMenuCode
                ),
                $elementsByStage
            )
        );
    }
}
