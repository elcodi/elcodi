Elcodi Geo Bundle for Symfony2
==============================

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

The GeoBundle provides us with a flexible and easy way to work with Geo
locations.

The bundle also provides you with a really powerful command to populate the
database with all the geo data needed to work with localization for your site
and the possibility to consume it directly or through an API among other
things.

# Installation & Configuration

You can install this Bundle the same way you will do with another [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/geo-bundle packagist](https://packagist.org/packages/elcodi/geo-bundle)
by just adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/geo-bundle": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/geo-bundle:~0.5.*"
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
            new \Elcodi\Bundle\GeoBundle\ElcodiGeoBundle(),
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
- **symfony/proxy-manager:** A proxy manager, needed to define lazy services.
- **symfony/proxy-manager-bridge:** The bridge between symfony and the proxy
manager.
- **mmoreram/simple-doctrine-mapping:** Needed on the compiler pass to be able
to load the entities and related classes from the annotations
- **elcodi/core-bundle:** Elcodi core bundle component
- **elcodi/geo:** The geo components

Also has dev dependences with:
- **elcodi/test-common-bundle:** Our common test utilities
- **elcodi/bamboo-bundle:** We use the bamboo bundle for functional tests
- **elcodi/fixtures-booster-bundle:** Used to boost the tests execution
- **doctrine/data-fixtures:** To load fixtures

# Tests

*Tests docs*

# Model layer

The Geo bundle provides you some services to work with the Geo models.

[More info about the model classes on the component documentation](https://github.com/elcodi/Geo/blob/master/README.md#model-layer)

## Location
- `@elcodi.factory.location`: A factory to generate a new location entity
- `@elcodi.object_manager.location`: A location entity manager
- `@elcodi.repository.location`: A location repository
- `@elcodi.director.location`: The location director contains the three previous
services (Object manager, repository and factory) for the location entity.

## Address
- `@elcodi.factory.address`: A factory to generate a new address entity
- `@elcodi.object_manager.address`: A address entity manager
- `@elcodi.repository.address`: A address repository
- `@elcodi.director.address`: The address director contains the three previous
services (Object manager, repository and factory) for the address entity.

# Service layer

These are the useful bundle services that you should know.

[More info about the services classes on the component documentation](https://github.com/elcodi/Geo/blob/master/README.md#service-layer)

## Factories
- `@elcodi.factory.location_data`: A factory to generate location data value
objects

## Formatter
- `@elcodi.formatter.address`: A formatter to convert an address to different
formats

# Services
- `@elcodi.location_provider`: A service to get locations info
- `@elcodi.manager.address`: This service allows us to safely save an address
without a risk of breaking a relation from another entity
- `@elcodi.transformer.location_to_location_data`: This service transforms a
location entity into a value object (`LocationData`)

# Event layer

These are all the events for this components. You can get all the event names as
constant properties at
[ElcodiGeoEvents.php](https://github.com/elcodi/Geo/blob/master/ElcodiGeoEvents.php)
file.

[More info about the events on the component documentation](https://github.com/elcodi/Geo/blob/master/README.md#event-layer)

## AddressOnCloneEvent

This event is launched every time that an address is cloned, that happens when
an address is being edited. We create a clone because other entities could be
pointing to this address. A copy is created while other entities can keep the
pointer to the old address.

**e.g.** *A customer edits his address but hi has old orders pointing to the
address being edited*

# Controllers

These are the useful bundle controllers that you should know.

[More info about the controller classes on the component documentation](https://github.com/elcodi/Geo/blob/master/README.md#controllers)

## LocationApiController

The location Api controller provides the actions needed to use the location
service as an API

These controllers are automatically loaded with the bundle. You can customize
their behavior on the `parameters.yml` file (Routes, prefix, etc.).

# Commands

These are the useful bundle commands that you should know.

[More info about the Command classes on the component documentation](https://github.com/elcodi/Geo/blob/master/README.md#controllers)

## LocationPopulateCommand

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
phpcs
checks. Read more details about
[Symfony2 coding standards]
(http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition]
(https://github.com/opensky/Symfony2-coding-standard)
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
[4]: http://symfony.com/doc/current/cookbook/bundles/installation.html
[Composer]: (https://getcomposer.org/)
[Symfony]: http://symfony.com/
[Geonames]: http://www.geonames.org/
[Bamboo]: https://github.com/elcodi/bamboo
