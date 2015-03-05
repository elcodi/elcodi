Elcodi Geo component for Symfony2
=================================

Table of contents
-----------------
1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [Location](#location)
  * [Address](#address)
1. [Service layer](#service-layer)
  * [Formatter/AddressFormatter.php](#formatteraddressformatterphp)
  * [Services/AddressManager.php](#servicesaddressmanagerphp)
  * [Services/LocationApiProvider.php](#serviceslocationapiproviderphp)
  * [Services/LocationBuilder.php](#serviceslocationbuilderphp)
  * [Services/LocationServiceProvider.php](#serviceslocationserviceproviderphp)
1. [Event layer](#event-layer)
  * [AddressOnCloneEvent](#addressoncloneevent)
1. [Controllers](#controllers)
  * [LocationApiController](#locationapicontroller)
1. [Commands](#commands)
  * [LocationPopulateCommand](#locationpopulatecommand)
1. [Tags](#tags)
1. [Contributing](#contributing)


# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

The Geo component provides us with the needed tools to manage the geo location
you can see this components working on the [Bamboo] project to manage customer
addresses.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/geo packagist](https://packagist.org/packages/elcodi/geo) by just
adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/geo": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/geo:~0.5.*"
```

# Dependencies

The Geo component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **mmoreram/extractor:** A file extractor to extract compressed files used on
the location geo populator
- **goodby/csv:** Used on the populator to process csv files
- **elcodi/core:** Elcodi core component

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to manage geo location,
these tools are the following

## Location

[View code](https://github.com/elcodi/Geo/blob/master/Entity/Location.php)

The location entity maps the information to geographically localize anything, it
is structured in a tree that contains all the imported countries on the root and
all the levels of data that [Geonames][4] can provide us.

**Fields**
- **Id:** The identifier **(Unique)**
- **Name:** The name. `e.g. Spain`
- **Code:** The code, usually the ISO code. `e.g. ES`
- **Type:** The type, from country on the root level to the lowest level. `e.g.
Country`

## Address

[View code](https://github.com/elcodi/Geo/blob/master/Entity/Address.php)

The address entity provides a way to save a full address, it is thought to use
soft relations with locations to save the city and the postal code.

**Address Fields**
- **Id:** The identifier **(Unique)**
- **Name:** The address name, usually a name to identify the address from other
address. `e.g. My home`
- **Recipient name:** The name for the address recipient. `e.g. Homer`
- **Recipient surname:** The surname for the address recipient. `e.g. Simpson`
- **City:** The address city, usually a soft link to a location saving a
location id. `e.g. ES_CT_B_Barcelona`
- **Postal code**: The address postal code, usually a soft link to a location
saving a location id. `e.g. `
- **Address**: The city address. `e.g. C/València 333`
- **Address more**: A second line to save the city address. `e.g. Baixos`
- **Phone**: An address phone number. `e.g. 958647856`
- **Mobile**: An address mobile phone number. `e.g. 648563258`
- **Comments**: An address comment, usually for the carrier. `e.g. It's an
office`
- **Created at**: The date time when the address was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the address was updated. `e.g. 2015-03-05
12:52:20`
- **Enabled**: If the address is enabled. `e.g. 1`

# Service layer

## Formatter/AddressFormatter.php

[View code](https://github.com/elcodi/Geo/blob/master/Formatter/AddressFormatter.php)

The address formatter provides various utilities to format an address.

**e.g.** *This service can be used to print the address in string format to do a
call to the Google Maps API*

## Services/AddressManager.php

[View code](https://github.com/elcodi/Geo/blob/master/Services/AddressManager.php)

The address manager provides a safety way to save an address, it checks if the
address is being edited and in this case creates a copy so other entities that
could be using this address.

**e.g.** *This service is used when a customer is editing one of his existing
addresses to ensure that any older order keeps the right address*

## Services/LocationApiProvider.php

[View code](https://github.com/elcodi/Geo/blob/master/Services/LocationApiProvider.php)

This service uses the Locations API to provide locations and their info (Root,
Childrens, Parents, hierarchy, etc.)

**e.g.** *This service is used to fill the location selectors on the forms to
add a new address*

## Services/LocationBuilder.php

[View code](https://github.com/elcodi/Geo/blob/master/Services/LocationBuilder.php)

Builds a location given the location information

**e.g.** *This service is used to build location entities using the info
received by the locations API*

## Services/LocationServiceProvider.php

[View code](https://github.com/elcodi/Geo/blob/master/Services/LocationServiceProvider.php)

This service uses the Locations repository to provide locations and their info
(Root, Childrens, Parents, hierarchy, etc.)

**e.g.** *This service is used to fill the location selectors on the forms to
add a new address*


# Event layer

## AddressOnCloneEvent

This event is launched every time that an address is cloned, that happens when
an address is being edited. We create a clone because other entities could be
pointing to this address. A copy is created while other entities can keep the
pointer to the old address.

**e.g.** *A customer edits his address but hi has old orders pointing to the
address being edited*

> More info about this on the
> [Services/AddressManager.php](#servicesaddressmanagerphp) section

# Controllers

## LocationApiController

[View code](https://github.com/elcodi/Geo/blob/master/Controller/LocationApiController.php)

The location Api controller provides the actions needed to use the location
service as an API

# Commands

## LocationPopulateCommand

[View code](https://github.com/elcodi/Geo/blob/master/Command/LocationPopulateCommand.php)

``` bash
$ php app/console elcodi:locations:populate CountryIso
```

Populates the database with all the locations for the received country. It gets
all the data from [Geonames].

**Parameters:**
- CountryIso: The [ISO 3166-1 (Alpha-2 code)](http://en.wikipedia.org/wiki/ISO_3166-1#Current_codes) for the country
that you want to populate.

# Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last
commit
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
[Geonames]: http://www.geonames.org/
