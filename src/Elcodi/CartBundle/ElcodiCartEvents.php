<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
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
     * Cart check events
     */

    /**
     * This event is dispatched before the Cart is checked by the bundle
     *
     * event.name : cart.precheck
     * event.class : CartPreCheckEvent
     */
    const CART_PRECHECK = 'cart.precheck';

    /**
     * This event is dispatched when the Cart is checked by the bundle
     *
     * event.name : cart.oncheck
     * event.class : CartOnCheckEvent
     */
    const CART_ONCHECK = 'cart.oncheck';

    /**
     * This event is dispatched after the Cart is checked by the bundle
     *
     * event.name : cart.postcheck
     * event.class : CartPostCheckEvent
     */
    const CART_POSTCHECK = 'cart.postcheck';

    /**
     * Cart load events
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
     * This event is dispatched after the Cart is loaded
     *
     * event.name : cart.postload
     * event.class : CartPostLoadEvent
     */
    const CART_POSTLOAD = 'cart.postload';

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
     * This event is dispatched after an order is created
     *
     * event.name : order.postcreated
     * event.class : OrderPostCreatedEvent
     */
    const ORDER_POSTCREATED = 'order.postcreated';

    /**
     * Orderline created events
     */

    /**
     * This event is dispatched before an orderline is created
     *
     * event.name : orderline.precreated
     * event.class : OrderLinePreCreatedEvent
     */
    const ORDERLINE_PRECREATED = 'orderline.precreated';

    /**
     * This event is dispatched when an orderline is created
     *
     * event.name : orderline.oncreated
     * event.class : OrderLineOnCreatedEvent
     */
    const ORDERLINE_ONCREATED = 'orderline.oncreated';

    /**
     * This event is dispatched after an orderline is created
     *
     * event.name : orderline.postcreated
     * event.class : OrderLinePostCreatedEvent
     */
    const ORDERLINE_POSTCREATED = 'orderline.postcreated';

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
    const ORDER_STATE_PRECHANGE = 'orderstate.prechange';

    /**
     * This event is dispatched each time a new order state is added
     *
     * This event has, as first parameter an OrderChangedStatusEvent object
     * having current Order object, last and current OrderHistoryObject
     *
     * event.name : orderstate.onchange
     * event.class : OrderStatePostChangeEvent
     *
     */
    const ORDER_STATE_POSTCHANGE = 'orderstate.postchange';

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
    const ORDERLINE_STATE_PRECHANGE = 'orderlinestate.prechange';

    /**
     * This event is dispatched before a new orderline state is added
     *
     * This event has, as first parameter an OrderLinePreChangedStatusEvent
     * object having current OrderLine object, last and current
     * OrderLineHistoryObject and last and current stats
     *
     * event.name : orderlinestate.postchange
     * event.class : OrderLineStatePostChangeEvent
     *
     */
    const ORDERLINE_STATE_POSTCHANGE = 'orderlinestate.postchange';
}
