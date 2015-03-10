Elcodi Menu Bundle for Symfony2
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
1. [Controllers](#controllers)
1. [Commands](#commands)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Bundle

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT] license.

# Overview

The menu bundle allows you to create menus for your project.
This bundle is used on the [Bamboo] store to build the Admin menu on the
store backend.

# Installation & Configuration

You can install this Bundle the same way you will do with another [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/menu-bundle packagist](https://packagist.org/packages/elcodi/menu-bundle)
by just adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/menu-bundle": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/menu-bundle:~0.5.*"
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
            new \Elcodi\Bundle\MenuBundle\ElcodiMenuBundle(),
        );

        // ...
    }
}
```

# Dependencies

The Menu bundle has dependencies with:

- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **doctrine/doctrine-cache-bundle:** To save the menu build on cache
- **symfony/http-kernel:** The Symfony http kernel component needed to extend
the bundle
- **symfony/config:** The symfony config component, needed to override the
configuration
- **symfony/dependency-injection:** The symfony dependency injection component,
needed to define services
- **symfony/twig-bundle:** To use symfony twig extensions e.g. assets
- **mmoreram/simple-doctrine-mapping:** Needed on the compiler pass to be able
to load the entities and related classes from the annotations
- **elcodi/core-bundle:** Elcodi core bundle component
- **elcodi/menu:** Elcodi menu component

# Tests

*Tests docs*

# Model layer

The menu bundle provides you some services to work with the Geo models.

[More info about the model classes on the component documentation](https://github.com/elcodi/Menu/blob/master/README.md#model-layer)

## Menu

- `@elcodi.factory.menu`: A factory to generate a new menu entity
- `@elcodi.object_manager.menu`: A menu entity manager
- `@elcodi.repository.menu`: A menu repository

## Node

- `@elcodi.factory.menu_node`: A factory to generate a new menu node entity
- `@elcodi.object_manager.menu_node`: A menu node entity manager
- `@elcodi.repository.menu_node`: A menu node repository

# Service layer

These are the useful bundle services that you should know.

[More info about the services classes on the component documentation](https://github.com/elcodi/Menu/blob/master/README.md#service-layer)

## Services

- `@elcodi.manager.menu`: The menu manager generates a full menu structure
loading the data from the repository.

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
[MIT]: http://opensource.org/licenses/MIT
[Bamboo]: https://github.com/elcodi/bamboo
[Composer]: https://getcomposer.org/
[Symfony]: http://symfony.com/
