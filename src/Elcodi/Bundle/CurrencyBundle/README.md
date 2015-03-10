Elcodi Currency Bundle for Symfony2
===================================

# Table of contents

1. [Bundle](#bundle)
1. [Overview](#overview)
1. [Installation & Configuration](#installation-configuration)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
1. [Service layer](#service-layer)
1. [Event layer](#event-layer)
1. [Controllers](#controllers)
1. [Commands](#commands)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Bundle

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

# Overview

The CurrencyBundle provides you with all the needed tools to work with different
currencies, exchange rates and money. It also offers you a way to print money
objects directly from twig.
The bundle also comes with an adapter to get the current rates exchange from
[Open exchange rates] using a command.
You can see this bundle working on the [Bamboo] project to manage product prices
in different currencies, and carts with products in multiple currencies or also
view the cart also in different currencies.

# Installation & Configuration

You can install this Bundle the same way you will do with another [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/currency-bundle packagist](https://packagist.org/packages/elcodi/currency-bundle)
by just adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/currency-bundle": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/currency-bundle:~0.5.*"
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
            new \Elcodi\Bundle\CurrencyBundle\ElcodiCurrencyBundle(),
        );

        // ...
    }
}
```

# Dependencies

The Geo bundle has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/http-kernel:** The Symfony http kernel component needed to extend
the bundle
- **symfony/config:** The symfony config component, needed to override the
configuration
- **symfony/dependency-injection:** The symfony dependency injection component,
needed to define services
- **ocramius/proxy-manager:** A proxy manager, needed to define lazy services.
- **symfony/proxy-manager-bridge:** The bridge between symfony and the proxy
manager.
- **mmoreram/simple-doctrine-mapping:** Needed on the compiler pass to be able
to load the entities and related classes from the annotations
- **elcodi/core-bundle:** Elcodi core bundle component
- **elcodi/language-bundle:** Elcodi language bundle used to print money on
different locale formats
- **elcodi/currency:** Elcodi currency component

Also has dev dependences with:
- **elcodi/test-common-bundle:** Our common test utilities
- **elcodi/bamboo-bundle:** We use the bamboo bundle for functional tests
- **elcodi/fixtures-booster-bundle:** Used to boost the tests execution
- **doctrine/data-fixtures:** To load fixtures

# Tests

*Tests docs*

# Model layer

The Geo bundle provides you some services to work with the Geo models.

[More info about the model classes on the component documentation](https://github.com/elcodi/Currency/blob/master/README.md#model-layer)

## Currency

- `@elcodi.factory.currency`: A factory to generate a new currency entity
- `@elcodi.object_manager.currency`: A currency entity manager
- `@elcodi.repository.currency`: A currency repository

## CurrencyExchangeRate

- `@elcodi.factory.currency_exchange_rate`: A factory to generate a new currency
exchange rate entity
- `@elcodi.object_manager.currency_exchange_rate`: A currency exchange rate
entity manager
- `@elcodi.repository.currency_exchange_rate`: A currency exchange rate
repository

# Service layer

These are the useful bundle services that you should know.

[More info about the services classes on the component documentation](https://github.com/elcodi/Currency/blob/master/README.md#service-layer)

## Services
- `@elcodi.converter.currency`: This service allows you to convert between
different currencies.
- `@elcodi.manager.currency`: This service can be used to get the exchange rate
for a given currency getting the data from the last exchange rate import.

## Wrapper
- `@elcodi.wrapper.currency`: This wrapper offers a way to work with currencies
hiding the management. This wrapper gets the currency from the session when
available it can be reloaded from the database if needed.

# Commands

These are the useful component commands that you should know.

[More info about the command classes on the component documentation](https://github.com/elcodi/Currency/blob/master/README.md#model-layer)

## CurrencyExchangeRatesPopulateCommand

[View code](https://github.com/elcodi/Currency/blob/master/Command/CurrencyExchangeRatesPopulateCommand.php)

``` bash
$ php app/console elcodi:exchangerates:populate
```

Populates the database with all the currencies exchange rate. By default, It
gets all the data from [Open exchange rates] but can be changed defining a
different provider adapter.

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
[Open exchange rates]: https://openexchangerates.org/
