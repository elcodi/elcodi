Elcodi Menu component for Symfony2
==================================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [Menu](#menu)
  * [Node](#node)
1. [Service layer](#service-layer)
  * [Services/MenuManager.php](#servicesmenumanagerphp)
1. [Twig extensions](#twig-extensions)
  * [PrintMoneyExtension](#printroutextension)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

# Overview

The menu component allows you to create menus for your project.
This component is used on the [Bamboo] store to build the Admin menu on the
store backend.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/menu packagist](https://packagist.org/packages/elcodi/menu)  by just
executing the following line

``` bash
$ composer require "elcodi/menu:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file

``` json
{
    "require": {
        "elcodi/menu": "~0.5.*"
    }
}

```

# Dependencies

The Geo component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping
- **symfony/routing:** Used to generate the menu urls
- **elcodi/core:** Elcodi core components

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to represent the menus

## Menu

[View code](https://github.com/elcodi/Menu/blob/master/Entity/Menu/Menu.php)

The menu entity maps represents an entire menu.

**Fields**
- **Id:** The identifier **(Unique)**
- **Code:** The menu code. `e.g. admin`
- **Description:** The menu description. `e.g. The admin menu`
- **Sort:** The sort type. `e.g. ASC`
- **Subnodes:** The menu subnodes
- **Enabled**: If the address is enabled. `e.g. 1`

## Node

[View code](https://github.com/elcodi/Menu/blob/master/Entity/Menu/Node.php)

The node entity maps each of the nodes of the menu, saving the menu node
properties.

**Fields**
- **Id:** The identifier **(Unique)**
- **Code:** The menu code. `e.g. admin`
- **Name:** The node name. `e.g. Products`
- **Url:** The node route. `e.g. products_list`
- **Active urls:** The node active urls, saved in JSON format.
`e.g. ["url_products_list","url_products_edit"]`
- **Sort:** The sort type. `e.g. ASC`
- **Subnodes:** The node subnodes
- **Enabled**: If the address is enabled. `e.g. 1`

# Service layer

These are the useful component services that you should know.

## Services/MenuManager.php

[View code](https://github.com/elcodi/Menu/blob/master/Services/MenuManager.php)

The menu manager generates a full menu structure loading the data from the
repository.

**e.g.** *This service is used on the [Bamboo] backend to build the admin menu*

# Twig extensions

## PrintRouteExtension

[View code](https://github.com/elcodi/Menu/blob/master/Twig/PrintRouteExtension.php)

This twig extension provides:
- `printUrl(route)`: Generates a url for the given route.

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
