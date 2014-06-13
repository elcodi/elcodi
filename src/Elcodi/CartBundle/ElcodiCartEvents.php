<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle;

/**
 * Core Events related with all core entities
 */
class ElcodiCartEvents
{
    /**
     * Cart events
     */

    /**
     * Cart events
     */

    /**
     * This event is dispatched before the Cart is loaded
     *
     * event.name : cart.preload
     * event.class : CartPreLoadEvent
     */
    const CART_PRELOAD = 'cart.preload';

    /**
     * This event is dispatched when the Cart is loaded
     *
     * event.name : cart.onload
     * event.class : CartOnLoadEvent
     */
    const CART_ONLOAD = 'cart.onload';

    /**
     * This event is dispatched when the Cart emptied
     *
     * event.name : cart.onempty
     * event.class : CartOnEmptyEvent
     */
    const CART_ONEMPTY = 'cart.onempty';

    /**
     * This event is dispatched when an inconsistente is found in a cart
     *
     * event.name : cart.inconsistent
     * event.class : CartInconsistentEvent
     */
    const CART_INCONSISTENT = 'cart.inconsistent';

    /**
     * CartLine events
     */

    /**
     * This event is dispatched when a CartLine is being added into a Cart
     *
     * event.name : cart_line.onadd
     * event.class : CartLineOnAdd
     */
    const CARTLINE_ONADD = 'cart_line.onadd';

    /**
     * This event is dispatched when a CartLine edited
     *
     * event.name : cart_line.onedit
     * event.class : CartLineOnEdit
     */
    const CARTLINE_ONEDIT = 'cart_line.onedit';

    /**
     * This event is dispatched when a CartLine is removed from a Cart
     *
     * event.name : cart_line.onremove
     * event.class : CartLineOnRemove
     */
    const CARTLINE_ONREMOVE = 'cart_line.onremove';

    /**
     * Order events
     */

    /**
     * Order created events
     */

    /**
     * This event is dispatched before an order is created
     *
     * event.name : order.precreated
     * event.class : OrderPreCreatedEvent
     */
    const ORDER_PRECREATED = 'order.precreated';

    /**
     * This event is dispatched when an order is created
     *
     * event.name : order.oncreated
     * event.class : OrderOnCreatedEvent
     */
    const ORDER_ONCREATED = 'order.oncreated';

    /**
     * Orderline created events
     */

    /**
     * This event is dispatched when an orderline is created
     *
     * event.name : orderline.oncreated
     * event.class : OrderLineOnCreatedEvent
     */
    const ORDERLINE_ONCREATED = 'order_line.oncreated';

    /**
     * Order State change events
     */

    /**
     * This event is dispatched each time a new order state is added
     *
     * This event has, as first parameter an OrderChangedStatusEvent object
     * having current Order object, last and current OrderHistoryObject
     *
     * event.name : orderstate.change
     * event.class : OrderStatePreChangeEvent
     *
     */
    const ORDER_STATE_PRECHANGE = 'order_state.prechange';

    /**
     * This event is dispatched each time a new order state is added
     *
     * This event has, as first parameter an OrderChangedStatusEvent object
     * having current Order object, last and current OrderHistoryObject
     *
     * event.name : orderstate.onchange
     * event.class : OrderStateOnChangeEvent
     *
     */
    const ORDER_STATE_ONCHANGE = 'order_state.onchange';

    /**
     * OrderLine State change events
     */

    /**
     * This event is dispatched before a new orderline state is added
     *
     * This event has, as first parameter an OrderLinePreChangedStatusEvent
     * object having current OrderLine object, last and current
     * OrderLineHistoryObject and last and current stats
     *
     * event.name : orderlinestate.prechange
     * event.class : OrderLineStatePreChangeEvent
     *
     */
    const ORDERLINE_STATE_PRECHANGE = 'order_line_state.prechange';

    /**
     * This event is dispatched before a new orderline state is added
     *
     * This event has, as first parameter an OrderLinePreChangedStatusEvent
     * object having current OrderLine object, last and current
     * OrderLineHistoryObject and last and current stats
     *
     * event.name : orderlinestate.onchange
     * event.class : OrderLineStateOnChangeEvent
     *
     */
    const ORDERLINE_STATE_ONCHANGE = 'order_line_state.onchange';
}
