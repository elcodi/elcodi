Elcodi CartCoupon Bundle for Symfony2
=====================================

# Bundle

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

# Overview

The CartCouponBundle provides all the tools needed to manage cart-coupons relationships
in your Symfony2 projects.

You can see this bundle working on the [Bamboo] project to manage coupons, both
manual and automatic, into the cart.

# Installation & Configuration

You can install this Bundle the same way you will do with any other [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/cart-coupon-bundle packagist](https://packagist.org/packages/elcodi/cart-coupon-bundle)
by just adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/cart-coupon-bundle": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/cart-coupon-bundle:~0.5.*"
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
            // ...

            // Add this bundle,
            new \Elcodi\Bundle\CartCouponBundle\ElcodiCartCouponBundle(),

            // Required dependencies
            new \Elcodi\Bundle\CartBundle\ElcodiCartBundle(),
            new \Elcodi\Bundle\CouponBundle\ElcodiCouponBundle(),

            // Optional dependencies
            new \Elcodi\Bundle\RuleBundle\ElcodiRuleBundle(),

            // ...
        );

        // ...
    }
}
```

# Dependencies

The CartCouponBundle has dependencies with:
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
- **elcodi/cart-bundle:** Elcodi cart bundle component
- **elcodi/coupon-bundle:** Elcodi coupon bundle component
- **elcodi/rule-bundle:** Elcodi rule bundle component
- **elcodi/cart-coupon:** Elcodi cart-coupon component

Also has dev dependences with:
- **elcodi/test-common-bundle:** Our common test utilities
- **elcodi/bamboo-bundle:** We use the bamboo bundle for functional tests
- **elcodi/fixtures-booster-bundle:** Used to boost the tests execution
- **doctrine/data-fixtures:** To load fixtures

# Tests

*Tests docs*

# Model layer

This bundle provides some services to work with the CartCoupon model.

[More info about the model classes on the component documentation](https://github.com/elcodi/CartCoupon/blob/master/README.md#model-layer)

## CartCoupon

- `@elcodi.factory.cart_coupon`: A factory to generate a new CartCoupon entity
- `@elcodi.object_manager.cart_coupon`: A CartCoupon entity manager
- `@elcodi.repository.cart_coupon`: A CartCoupon repository

# Service layer

These are the useful bundle services that you should know.

[More info about the services classes on the component documentation](https://github.com/elcodi/CartCoupon/blob/master/README.md#service-layer)

## Services
- `@elcodi.manager.cart_coupon`: This service manages cart-coupon relationships
- `@elcodi.manager.cart_coupon_rule`: Validate cart-coupon rules if applicable
- `@elcodi.manager.order_coupon`: Manage order-coupon collections

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
[Bamboo]: https://github.com/elcodi/bamboo
