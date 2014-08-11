<?php

/**
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
 */

namespace Elcodi\CartBundle\Services;

/**
 * Class OrderStateManager
 *
 * Manages all states
 *
 * Api Methods:
 *
 * * isOrderStateChangePermitted($lastState, $newState) : boolean
 */
class OrderStateManager
{
    /**
     * @var array
     *
     * Available changeset for order history lines
     */
    protected $orderHistoryChangesAvailable;

    /**
     * Construct method
     *
     * @param array $orderHistoryChangesAvailable Order History changes Available
     */
    public function __construct(
        array $orderHistoryChangesAvailable
    )
    {
        $this->orderHistoryChangesAvailable = $orderHistoryChangesAvailable;
    }

    /**
     * Checks if current change is permitted
     *
     * @param string $lastState Current line state
     * @param string $newState  New state to reach
     *
     * @return boolean New state is reachable from given state
     */
    public function isOrderStateChangePermitted(
        $lastState,
        $newState
    )
    {
        /**
         * $lastState - Current line state
         * $newState - New Stat to reach
         */

        if (!is_string($lastState) || !is_string($newState)) {

            /**
             * Both states should be string values.
             * If are not, will return false
             */

            return false;
        }

        if ($lastState === $newState) {

            /**
             * nothing to do. If it's in the array this means we want to record
             * repeated states.
             *
             * Return false because any effect will cause.
             */

            return true;
        }

        $availableStats = array_key_exists($lastState, $this->orderHistoryChangesAvailable)
            ? $this->orderHistoryChangesAvailable[$lastState]
            : array();

        /**
         * Exception if new state is not available nor is accessible from
         * current state
         */

        return in_array($newState, $availableStats, true);
    }

}
