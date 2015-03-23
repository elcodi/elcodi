Elcodi Cart component for Symfony2
==================================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [Cart](#cart)
  * [CartLine](#cartline)
  * [Order](#order)
  * [OrderLine](#orderline)
1. [Service layer](#service-layer)
  * [Services/CartManager.php](#servicescartmanagerphp)
  * [Transformer/CartOrderTransformer.php](#transformercartordertransformerphp)
  * [Services/CartManager.php](#wrappercartwrapperphp)
1. [Event layer](#event-layer)
  * [CartInconsistentEvent](#cartinconsistentevent)
  * [CartLineOnAddEvent](#cartlineonaddevent)
  * [CartLineOnEditEvent](#cartlineoneditevent)
  * [CartLineOnRemoveEvent](#addressoncloneevent)
  * [CartOnEmptyEvent](#cartonemptyevent)
  * [CartOnLoadEvent](#cartonloadevent)
  * [CartPreLoadEvent](#cartpreloadevent)
  * [OrderLineOnCreatedEvent](#orderlineoncreatedevent)
  * [OrderOnCreatedEvent](#orderoncreatedevent)
  * [OrderPreCreatedEvent](#orderprecreatedevent)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

This component aims to provide a simple store cart and order system for your
store.

You can see this component working on the [Bamboo] cart.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/cart packagist](https://packagist.org/packages/elcodi/cart) by just
executing the following line

``` bash
$ composer require "elcodi/cart:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file


``` json
{
    "require": {
        "elcodi/cart": "~0.5.*"
    }
}

```

# Dependencies

The Geo component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/event-dispatcher:** Used to dispatch events
- **symfony/http-foundation:** Used to manage sessions
- **sebastian/money:** Used to work with money
- **elcodi/core:** Elcodi core component
- **elcodi/user:** Used to work with the user filling the cart
- **elcodi/product:** Needed to work with the products being added to the cart
- **elcodi/state-transition-machine:** Carts have states, we use the transition
machines to use them
- **elcodi/currency:** Used to work with currency on cart products prices
- **elcodi/shipping:** Needed to manage the cart shipping properties

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to manage the store cart.

## Cart

[View code](https://github.com/elcodi/Cart/blob/master/Entity/Cart.php)

The Cart entity provides a way to save all the cart data, customer, products,
addresses, etc.

**Cart Fields**
- **Id**: The identifier **(Unique)**
- **Quantity**: The quantity of products on the cart. `e.g. 42`
- **Ordered**: If the cart has been ordered. `e.g. 1`
- **Created at**: The date time when the cart was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the cart was updated. `e.g. 2015-03-05
12:52:20`
- **Order**: The order processed from the cart (If the process has been
  finished)
- **Customer**: The customer that owns the cart.
- **Delivery address**: The address where the cart products will be delivered
- **Billing address**: The address that will be used for the billing
- **Shipping range**: The range for the shipping that will be applied to this
cart
- **Cart lines**: The lines on the cart, each line is a product type added to
the cart

## CartLine

[View code](https://github.com/elcodi/Cart/blob/master/Entity/CartLine.php)

The cart line represents one item type added to the cart. For example a specific
product, with it's quantity, price, etc.

**CartLine Fields**
- **Id**: The identifier **(Unique)**
- **Product Amount**: The price for a product on this line `e.g. 26`
- **Amount**: The price for all the products on this line  `e.g. 52`
- **Quantity**: The quantity of products on this line. `e.g. 2`
- **Order line**: After the cart is processed the current line is mapped on the
related order line
- **Cart**:  The cart that owns this cart line
- **Product currency**: The currency for the product on this cart line
- **Currency**: The currency for the cart line
- **Product**: The product on this cart line
- **Variant**: The variant for this product if any

## Order

[View code](https://github.com/elcodi/Cart/blob/master/Entity/Order.php)

The order represents a cart that has been processed on the checkout process

**Order Fields**
- **Id**: The identifier **(Unique)**
- **Quantity**: The quantity of products on this order. `e.g. 2`
- **Product amount**: The price for all the products on the order. `e.g. 42`
- **Coupon amount**: The price saved by a coupon. `e.g. 5`
- **Shipping amount**: The price being added by the shipping. `e.g. 10`
- **Amount**: The price for the entire order. `e.g. 47`
- **Height**: The height for the order `e.g. 50`
- **Width**: The width for the order `e.g. 50`
- **Depth**: The depth for the order `e.g. 20`
- **Weight**: The weight for the order `e.g. 89`
- **Created at**: The date time when the order was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the order was updated. `e.g. 2015-03-05
12:52:20`
- **Cart**: The cart that was converted on the current order
- **Payment last state line**: The state for the payment
- **Shipping last state line**: The state for the shipping
- **Customer**: The customer that owns this order
- **Currency**: The currency for the full order amount
- **Product currency**: The currency for the products amount
- **Coupon currency**: The currency for the applied coupon
- **Shipping currency**: The currency for the shipping amount
- **Delivery address**: The order delivery address
- **Billing address**: The order billing address
- **Order lines**: The order lines for this order (The equivalence for the cart
  lines on the order)
- **Shipping state lines**: The current state for the order shipping
- **Payment state lines**: The current state for the order payment

## OrderLine

[View code](https://github.com/elcodi/Cart/blob/master/Entity/OrderLine.php)

The order line represents one item type added to the order. For example a
specific product, with it's quantity, price, etc.

**Order Fields**
- **Id**: The identifier **(Unique)**
- **Product amount**: The price for all the products on the order line.
`e.g. 42`
- **Amount**: The price for the entire order line (All products). `e.g. 47`
- **Height**: The height for the order line. `e.g. 50`
- **Width**: The width for the order line. `e.g. 50`
- **Depth**: The depth for the order line. `e.g. 20`
- **Weight**: The weight for the order line. `e.g. 89`
- **Quantity**: The quantity of products on this order line. `e.g. 2`
- **Order**: The order that owns this order line.
- **Currency**: The currency for the order line amount.
- **Product**: The product on this order line.
- **Variant**: The variant for this product if any

# Service layer

These are the useful component services that you should know.

## Services/CartManager.php

[View code](https://github.com/elcodi/Cart/blob/master/Services/CartManager.php)

This service is thought to work with the cart, you can do all the actions
related with cart lines or products.

You can add products, lines, remove it, increase/decrease the quantity or even
empty the lines.

**e.g.** *This service is used on the [Bamboo] store every time that a user
adds a product to the cart, adds more quantity for a product or empties the car*

## Transformer/CartOrderTransformer.php

[View code](https://github.com/elcodi/Cart/blob/master/Transformer/CartOrderTransformer.php)

This service allows to convert a cart to an order, loud and clear.

**e.g.** *This is used on the [Bamboo] store every time that a user finishes the
checkout process, the cart being processed is converted to an order using this
service*

## Wrapper/CartWrapper.php

[View code](https://github.com/elcodi/Cart/blob/master/Wrapper/CartWrapper.php)

The main functionality for this service is to get the current cart. This service
does all the needed work so you don't have bother trying to check if the current
user already has a cart on the database or the session. This class tries to get
the user cart from all the available sources.

If the user is registered and already had a cart on database it gets the
car from this source, otherwise it gets the cart from the session. If the user
does not have a cart you'll get a new empty cart.

**e.g.** *Every time that we get the cart on the [Bamboo] store this service is
called.*

# Event layer

These are all the events for this components. You can get all the event names as
constant properties at
[ElcodiCartEvents.php](https://github.com/elcodi/Cart/blob/master/ElcodiCartEvents.php)
file.

## CartInconsistentEvent

This event is dispatched when an inconsistency is found in a cart.

**e.g.** *The cart line that is supposed to be added is not enabled or there's
not enough stock*

**Event properties**
- **Cart**: The inconsistent cart
- **Cart line**:  The inconsistent cart line

## CartLineOnAddEvent

This event is dispatched when a cart line is being added to a cart.

**e.g.** *When the customer adds a new product to the cart*

**Event properties**
- **Cart**: The cart in which the line is being added
- **Cart line**:  The line being added

## CartLineOnEditEvent

This event is dispatched when a cart line is edited.

**e.g.** *When the customer adds more quantity for the same product*

**Event properties**
- **Cart**: The cart in which the line is being edited
- **Cart line**:  The line being edited

## CartLineOnRemoveEvent

This event is dispatched when a cart line is removed from a cart.

**e.g.** *A customer removes a product from the cart*

**Event properties**
- **Cart**: The cart in which the line is being removed
- **Cart line**:  The line being removed

## CartOnEmptyEvent

This event is dispatched when the cart is emptied.

**e.g.** *A customer empties the cart*

**Event properties**
- **Cart**: The cart being emptied

## CartOnLoadEvent

This event is dispatched when the cart is loaded. With loaded we mean loaded
from memory, database etc. by the source code to update it or simply get info
from it.

**e.g.** *A customer visits the cart page*

**Event properties**
- **Cart**: The cart being loaded

## CartPreLoadEvent

This event is dispatched before the cart is loaded. With loaded we mean loaded
from memory, database etc. by the source code to update it or simply get info
from it.

**e.g.** *A customer visits the cart page*

**Event properties**
- **Cart**: The cart being loaded

## OrderLineOnCreatedEvent

This event is dispatched when a new order line is created.

**e.g.** *A customer adds a new product to the cart*

**Event properties**
- **Order**: The order in which the line is being added
- **Order line**: The cart order being loaded
- **Cart line**: The cart line being mapped by the order line

## OrderOnCreatedEvent

This event is dispatched when a new order is created.

**e.g.** *A customer finishes the checkout process and the cart is converted to
an order*

**Event properties**
- **Order**: The order being created
- **Cart**: The cart where the order comes from

## OrderPreCreatedEvent

This event is dispatched before a new order is created.

**e.g.** *A customer finishes the checkout process and the cart is converted to
an order*

**Event properties**
- **Order**: The order being created
- **Cart**: The cart where the order comes from

# Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit
* Use last stable version tag to stay in a stable release.

# Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs
checks. Read more details about
[Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition](https://github.com/opensky/Symfony2-coding-standard)
to run code validation.

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New features must come paired with PHPUnit tests.

If you would like to contribute, please read the [Contributing Code][1] in the project
documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][2] section and use the [Pull Request Template][3].

[1]: http://symfony.com/doc/current/contributing/code/index.html
[2]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[3]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[MIT]: (http://opensource.org/licenses/MIT)
[Composer]: (https://getcomposer.org/)
[Bamboo]: https://github.com/elcodi/bamboo
