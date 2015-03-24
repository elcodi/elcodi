<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace Elcodi\Component\EntityTranslator\Services;

/**
 * Class EntityTranslationChangesBag
 */
class EntityTranslationChangesBag
{
    /**
     * @var array
     *
     * Entity Translation changes
     */
    protected $changes;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->changes = [];
    }

    /**
     * Add change
     *
     * @param array $change Change
     *
     * @return $this Self object
     */
    public function addChange(array $change)
    {
        $this->changes[] = $change;

        return $this;
    }

    /**
     * Get changes
     *
     * @return array Entity Translation changes
     */
    public function getChanges()
    {
        return $this->changes;
    }
}
