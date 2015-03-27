Elcodi Currency component for Symfony2
======================================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [Currency](#currency)
  * [CurrencyExchangeRate](#currencyexchangerate)
  * [Money](#money)
1. [Service layer](#service-layer)
  * [Formatter/AddressFormatter.php](#formatteraddressformatterphp)
  * [Services/AddressManager.php](#servicesaddressmanagerphp)
  * [Services/LocationApiProvider.php](#serviceslocationapiproviderphp)
  * [Services/LocationBuilder.php](#serviceslocationbuilderphp)
  * [Services/LocationServiceProvider.php](#serviceslocationserviceproviderphp)
  * [Twig/PrintMoneyExtension.php](#twigprintmoneyextensionphp)
1. [Twig extensions](#twig-extensions)
  * [PrintMoneyExtension](#printmoneyextension)
1. [Commands](#commands)
  * [LocationPopulateCommand](#locationpopulatecommand)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

# Overview

This component aims to provide some currency tools to work with different
currencies, exchange rates and money. It also offers you a way to print money
objects directly from twig.

You can see this component working on the [Bamboo] project to manage product
prices in different currencies, and carts with products in multiple currencies
or also view the cart also in different currencies.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/currency packagist](https://packagist.org/packages/elcodi/currency) by
just executing the following line

``` bash
$ composer require "elcodi/page:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file


``` json
{
    "require": {
        "elcodi/currency": "~0.5.*"
    }
}

```

# Dependencies

The Currency component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/http-foundation:** For session management
- **sebastian/money:** To work with money object value
- **twig/twig:** To add twig extensions to print money

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to manage money, exchange
rates and currencies these tools are the following

## Currency

[View code](https://github.com/elcodi/Currency/blob/master/Entity/Currency.php)

The currency entity maps a real currency, like the Euro (€) or the Dollars ($).

**Fields**
- **ISO:** The currency [ISO 4217](http://es.wikipedia.org/wiki/ISO_4217)
identifier **(Unique)**
- **Name:** The name. `e.g. Euro`
- **Symbol:** The currency symbol. `e.g. €`
- **Created at**: The date time when the address was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the address was updated. `e.g. 2015-03-05
12:52:20`
- **Enabled**: If the address is enabled. `e.g. 1`

## CurrencyExchangeRate

[View code](https://github.com/elcodi/Currency/blob/master/Entity/CurrencyExchangeRate.php)

The currency exchange rate entity maps the exchange rate between the currencies.

**Fields**
- **Id**: The identifier **(Unique)**
- **Exchange rate**: The exchange rate. `e.g. 0.54`
- **Source Currency**: The currency that we want to exchange
- **Target Currency**: The currency that we want to get from the exchanges

## Money

[View code](https://github.com/elcodi/Currency/blob/master/Entity/Money.php)

The money entity maps the monetary value.

**Fields**
- **Amount**: The total amount of money `e.g. 20`
- **Wrapped money**: The value object for the money.
- **Wrapped currency**: The value object for the currency.

# Service layer

These are the useful component services that you should know.

## Services/CurrencyConverter.php

[View code](https://github.com/elcodi/Currency/blob/master/Services/CurrencyConverter.php)

This service allows you to convert between different currencies.

**e.g.** *This service is used to get the amount of money that the customer has
to pay on the store currency*

## Services/CurrencyManager.php

[View code](https://github.com/elcodi/Currency/blob/master/Services/CurrencyManager.php)

This service can be used to get the exchange rate for a given currency getting
the data from the last exchange rate import.

**e.g.** *This service is used to get the amount of money that the customer has
to pay for a product in other currencies*

## Wrapper/CurrencyWrapper.php

[View code](https://github.com/elcodi/Currency/blob/master/Wrapper/CurrencyWrapper.php)

This wrapper offers a way to work with currencies hiding the management. This
wrapper gets the currency from the session when available it can be reloaded
from the database if needed.

**e.g.** *This wrapper is used on the twig extension to take the default money
in case you want to print money only from value*

# Twig extensions

## PrintMoneyExtension

[View code](https://github.com/elcodi/Currency/blob/master/Twig/PrintMoneyExtension.php)

This twig extension provides a three functions to print money:
- `printMoney(money)`: Prints a formatted money.
- `printConvertMoney(money, targetCurrency)`: Prints a formatted money
converted to the target currency.
- `printMoneyFromValue(value)`: Prints a formatted money for the received value
getting the currency from the [CurrencyWrapper](#wrappercurrencywrapperphp)

# Commands

These are the useful component commands that you should know.

## CurrencyExchangeRatesPopulateCommand

[View code](https://github.com/elcodi/Currency/blob/master/Command/CurrencyExchangeRatesPopulateCommand.php)

Populates the database with all the currencies exchange rate.

# Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit
* Use last stable version tag to stay in a stable release.

# Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs
checks. Read more details about
[Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition](https://github.com/escapestudios/Symfony2-coding-standard)
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
