Elcodi CartCoupon component for Symfony2
========================================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [CartCoupon](#cartcoupon)
  * [OrderCoupon](#ordercoupon)
1. [Service layer](#service-layer)
  * [Services/CartCouponManager.php](#servicescartcouponmanagerphp)
  * [Services/CartCouponRuleManager.php](#servicescartcouponrulemanagerphp)
  * [Services/OrderCouponManager.php](#servicesordercouponmanagerphp)
1. [Event layer](#event-layer)
  * [CartCouponOnCheckEvent](#cartcoupononcheckevent)
  * [CartCouponOnApplyEvent](#cartcoupononapplyevent)
  * [CartCouponOnRemoveEvent](#cartcoupononremoveevent)
  * [CartCouponOnRejectedEvent](#cartcoupononrejectedevent)
  * [OrderCouponOnApplyEvent](#ordercoupononapplyevent)
1. [Event listeners](#event-listeners)
  * [AutomaticCouponApplicatorListener](#automaticcouponapplicatorlistener)
  * [AvoidDuplicatesListener](#avoidduplicateslistener)
  * [CartCouponManagerListener](#cartcouponmanagerlistener)
  * [CheckCartCouponListener](#checkcartcouponlistener)
  * [CheckCouponListener](#checkcouponlistener)
  * [CheckRulesListener](#checkruleslistener)
  * [ConvertToOrderCouponsListener](#converttoordercouponslistener)
  * [MinimumPriceCouponListener](#minimumpricecouponlistener)
  * [OrderCouponManagerListener](#ordercouponmanagerlistener)
  * [RefreshCouponsListener](#refreshcouponslistener)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

The CartCoupon component closes the gap between Cart and Coupon components,
managing relationship between the former and the latter through a set of tools.
You can see this components working on the [Bamboo] project to set discounts.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/cart-coupon packagist](https://packagist.org/packages/elcodi/cart-coupon)
by just executing the following line

``` bash
$ composer require "elcodi/cart-coupon:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file

``` json
{
    "require": {
        "elcodi/cart-coupon": "~0.5.*"
    }
}
```

# Dependencies

The CartCoupon component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/event-dispatcher:** Events are dispatched at some points
- **elcodi/core:** Elcodi core component
- **elcodi/cart:** Elcodi cart component
- **elcodi/coupon:** Elcodi coupon component
- **elcodi/rule:** Elcodi rule component

# Tests

*Tests docs*

# Model layer

The model for this component simply adds a relationship between the pieces of
Cart and Coupon, which are the following:

## CartCoupon

[View code](https://github.com/elcodi/CartCoupon/blob/master/Entity/CartCoupon.php)

A many-to-many relationship between a Cart and a Coupon.

**Fields**
- **Id:** The identifier **(Unique)**
- **Cart:** The `CartInterface` object.
- **Coupon:** The `CouponInterface` object.

## OrderCoupon

[View code](https://github.com/elcodi/CartCoupon/blob/master/Entity/OrderCoupon.php)

This models the same relationship as before, when the Cart materializes to an Order.

**Fields**
- **Id:** The identifier **(Unique)**
- **Order:** The `OrderInterface` object.
- **Coupon:** The `CouponInterface` object.

# Service layer

These are the useful component services that you should know.

## Services/CartCouponManager.php

[View code](https://github.com/elcodi/CartCoupon/blob/master/Services/CartCouponManager.php)

This service manages coupon instances inside carts.

**Methods**
- **getCartCoupons(CartInterface *cart*)**: Get all *the relationships* between a given cart and its cupons.
- **getCoupons(CartInterface *cart*)**: Get all *the coupons* related to a given cart.
- **addCouponByCode(CartInterface $cart, $couponCode)**: Find a coupon by code and try to add it to a cart.
- **addCoupon(CartInterface *cart*, CouponInterface *coupon*)**: Add a coupon to a cart.
- **removeCouponByCode(CartInterface *cart*, *couponCode*)**: Remove a coupon by code from a cart.
- **removeCoupon(CartInterface *cart*, CouponInterface *coupon*)**: Remove a coupon from a cart.

## Services/CartCouponRuleManager.php

[View code](https://github.com/elcodi/CartCoupon/blob/master/Services/CartCouponRuleManager.php)

Helps with coupon validation through rules.

**Methods**
- **checkCouponValidity(CartInterface *cart*, CouponInterface *coupon*)**: Validates a coupon Rule on a given Cart.

**e.g.** *This service is used when a customer adds a discount code, to check for
validation of the given coupon rules on the current cart*

## Services/OrderCouponManager.php

[View code](https://github.com/elcodi/CartCoupon/blob/master/Services/OrderCouponManager.php)

This service manages coupon instances inside orders.

**Methods**
- **getOrderCoupons(OrderInterface *order*)**: Get all *the relationships* between a given order and its cupons.
- **getCoupons(OrderInterface *order*)**: Get all *the coupons* related to a given order.

# Event layer

These are all the events for this bundle. You can get all the event names as
constant properties at the component
[ElcodiCartCouponEvents.php](https://github.com/elcodi/CartCoupon/blob/master/ElcodiCartCouponEvents.php)
file.

## CartCouponOnCheckEvent

Sent when we want to check for coupon validation in a cart context. If no listener
throws an `AbstractCouponException`, the check is considered valid. You can listen
to this event to ask for extra conditions.

**e.g.** *A product is added to cart and we check if current coupons still apply*

**Event properties**
- **Coupon**: The coupon to check validation
- **Cart**: The context cart where to check the coupon

## CartCouponOnApplyEvent

Launched when a coupon has passed all validation and the relationship is being
created. You can still throw `AbstractCouponException` from those listeners to
avoid the generation of the relationship.

**e.g.** *A coupon is added to a cart and we check if is duplicated*

**Event properties**
- **Coupon**: The coupon to check validation
- **Cart**: The context cart where to check the coupon
- **CartCoupon**: The relationship that just has been created

Listeners with priority higher than 0 will not have access to the `CartCoupon` object.

## CartCouponOnRemoveEvent

Launched when an existing relationship between cart and coupon will be removed.

**e.g.** *A customer removes a coupon from the UI*

**Event properties**
- **Coupon**: The applied coupon
- **Cart**: The cart where the coupon is applied
- **CartCoupon**: The relationship that would be removed

## CartCouponOnRejectedEvent

Launched after removing automatically an existing relationship between cart and coupon.
This event is purely instructive and can not be stopped.

**e.g.** *A coupon is removed from a cart because its conditions are no longer met*

**Event properties**
- **Coupon**: The coupon to check validation
- **Cart**: The context cart where to check the coupon

## OrderCouponOnApplyEvent

Launched for each coupon in a cart while converting to order.

**e.g.** *A customer purchases a cart*

**Event properties**
- **Coupon**: The coupon to apply
- **Order**: The context order where to apply the coupon
- **OrderCoupon**: The relationship that just has been created

Listeners with priority higher than 0 can stop the process by throwing exceptions
or calling `stopPropagation`, but will not have access to the `OrderCoupon` object.

# Event listeners

There are many listeners predefined for application.

## AutomaticCouponApplicatorListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/AutomaticCouponApplicatorListener.php)

Check in cart loading if any automatic coupon can be applied.

## AvoidDuplicatesListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/AvoidDuplicatesListener.php)

Fails when a coupon is applied twice to any cart.

## CartCouponManagerListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/CartCouponManagerListener.php)

Manages creating and removing the actual relations between `Cart` and `Coupon`.
This should be triggered with priority 0 to allow "pre" and "post" listeners.

## CheckCartCouponListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/CheckCartCouponListener.php)

Dispatches the check event when trying to apply a coupon.

## CheckCouponListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/CheckCouponListener.php)

Check for a coupon to be applicable.

## CheckRulesListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/CheckRulesListener.php)

Check for a coupon rule to be valid for a given cart.

## ConvertToOrderCouponsListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/ConvertToOrderCouponsListener.php)

Set up `CartCoupon` for conversion on order creation.

## MinimumPriceCouponListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/MinimumPriceCouponListener.php)

Check for a cart to exceed the coupon's minimum price to be appliable.

## OrderCouponManagerListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/OrderCouponManagerListener.php)

Add new `OrderCoupon` and notify coupon usage.
This should have priority 0 to allow "pre" and "post" listeners.

## RefreshCouponsListener

[View code](https://github.com/elcodi/CartCoupon/blob/master/EventListener/RefreshCouponsListener.php)

On cart load, validates coupons related to the current cart.

# Tags

* Use last unstable version (alias of `dev-master`) to stay always in last commit
* Use last stable version tag to stay in a stable release.

# Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass
phpcs checks. Read more details about
[Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition](https://github.com/opensky/Symfony2-coding-standard)
to run code validation.

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New features must come paired with PHPUnit tests.

If you would like to contribute, please read the [Contributing Code][1] in the
project documentation. If you are submitting a pull request, please follow the
guidelines in the [Submitting a Patch][2] section and use the
[Pull Request Template][3].

[1]: http://symfony.com/doc/current/contributing/code/index.html
[2]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[3]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[MIT]: (http://opensource.org/licenses/MIT)
[Composer]: (https://getcomposer.org/)
[Bamboo]: https://github.com/elcodi/bamboo
