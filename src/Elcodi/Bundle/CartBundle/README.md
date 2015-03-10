Elcodi Cart Bundle for Symfony2
===============================

# Table of contents

1. [Bundle](#bundle)
1. [Overview](#overview)
1. [Installation & Configuration](#installation-configuration)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
1. [Service layer](#service-layer)
1. [Event layer](#event-layer)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Bundle

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

# Overview

The CartBundle provides us with all the tools needed to work with an e-commerce
cart and orders.

With this bundle you can create, persist and manage carts, update it or convert
it to orders.

# Installation & Configuration

You can install this Bundle the same way you will do with another [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/geo-bundle packagist](https://packagist.org/packages/elcodi/cart-bundle)
by just adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/cart-bundle": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/cart-bundle:~0.5.*"
```

After that you'll have to enable the bundle on your `Appkernel` file.

``` php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...,
            new \Elcodi\Bundle\CartBundle\ElcodiCartBundle(),
        );

        // ...
    }
}
```
# Dependencies

The Geo component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/http-kernel:** The Symfony http kernel component needed to extend
the bundle
- **symfony/config:** The symfony config component, needed to override the
configuration
- **symfony/dependency-injection:** The symfony dependency injection component,
needed to define services
- **mmoreram/simple-doctrine-mapping:** Needed on the compiler pass to be able
to load the entities and related classes from the annotations
- **elcodi/core-bundle:** Elcodi core bundle component
- **elcodi/user-bundle:** Used to map the owner of the cart or order
- **elcodi/product-bundle:** Used to add items to the cart or order
- **elcodi/currency-bundle:** Used to save the prices for the items, cart,
order, etc. on the right currency
- **elcodi/state-transition-machine-bundle:** This bundle is used to handle the
statuses for the cart and orders
- **elcodi/shipping-bundle:** Used to manage cart or order shipping properties
- **elcodi/cart:** The cart component

Also has dev dependences with:
- **elcodi/test-common-bundle:** Our common test utilities
- **elcodi/bamboo-bundle:** We use the bamboo bundle for functional tests
- **elcodi/fixtures-booster-bundle:** Used to boost the tests execution
- **doctrine/data-fixtures:** To load fixtures

# Tests

*Tests docs*

# Model layer

The Cart bundle provides you some services to work with the Cart models

[More info about the model classes on the component documentation](https://github.com/elcodi/Cart/blob/master/README.md#model-layer)

## Cart
- `@elcodi.factory.cart`: A factory to generate a new cart entity
- `@elcodi.object_manager.cart`: A cart entity manager
- `@elcodi.repository.cart`: A cart repository
- `@elcodi.director.cart`: The cart director contains the three previous
services (Object manager, repository and factory) for the cart entity.

## CartLine
- `@elcodi.factory.cart_line`: A factory to generate a new cart line entity
- `@elcodi.object_manager.cart_line`: A cart line entity manager
- `@elcodi.repository.cart_line`: A cart line repository
- `@elcodi.director.cart_line`: The cart line director contains the three
previous services (Object manager, repository and factory) for the cart line
entity.

## Order
- `@elcodi.factory.order`: A factory to generate a new order entity
- `@elcodi.object_manager.order`: A order entity manager
- `@elcodi.repository.order`: A order repository
- `@elcodi.director.order`: The order director contains the three previous
services (Object manager, repository and factory) for the order entity.

## OrderLine
- `@elcodi.factory.order_line`: A factory to generate a new order line entity
- `@elcodi.object_manager.order_line`: An order line entity manager
- `@elcodi.repository.order_line`: An order line repository
- `@elcodi.director.order_line`: The order line director contains the three
previous services (Object manager, repository and factory) for the order line
entity.

# Service layer

[More info about the services classes on the component documentation](https://github.com/elcodi/Cart/blob/master/README.md#service-layer)

## Services
- `@elcodi.cart.manager`: This service is thought to work with the cart, you can
do all the actions related with cart lines or products

## Transformer
- `@elcodi.transformer.cart_order`: This service allows to convert a cart to an
order, loud and clear.

## Wrapper
- `@elcodi.wrapper.cart`: This service does wrapps the cart entity so you don't
have bother trying to check if the current user already has a cart on the
database or the session. This class tries to get the user cart from all the
available sources.

# Event layer

These are all the events for this bundle. You can get all the event names as
constant properties at the component
[ElcodiCartEvents.php](https://github.com/elcodi/Cart/blob/master/ElcodiCartEvents.php)
file.

[More info about the events classes on the component](https://github.com/elcodi/Cart/blob/master/README.md#event-layer)

**Events**
- **CartInconsistentEvent**: This event is dispatched when an inconsistence is
found in a cart.
- **CartLineOnAddEvent**: This event is dispatched when a cart line is being
added to a cart.
- **CartLineOnEditEvent**: This event is dispatched when a cart line is edited.
- **CartLineOnRemoveEvent**: This event is dispatched when a cart line is
removed from a cart.
- **CartOnEmptyEvent**: This event is dispatched when the cart is emptied.
- **CartOnLoadEvent**: This event is dispatched when the cart is loaded. With
loaded we mean loaded from memory, database etc. by the source code to update it
or simply get info from it.
- **CartPreLoadEvent**: This event is dispatched before the cart is loaded. With
loaded we mean loaded from memory, database etc. by the source code to update it
or simply get info from it.
- **OrderLineOnCreatedEvent**: This event is dispatched when a new order line is
created.
- **OrderOnCreatedEvent**: This event is dispatched when a new order is created.
- **OrderPreCreatedEvent**: This event is dispatched before a new order is
created.

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
[4]: http://symfony.com/doc/current/cookbook/bundles/installation.html
[Symfony]: http://symfony.com/
