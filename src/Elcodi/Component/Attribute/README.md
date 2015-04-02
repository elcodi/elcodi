Elcodi Product Attribute component for Symfony
===============================================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

This component aims to provide a simple attributes system to add particularities
to any item.

You can see this bundle working on [Bamboo] to manage the product attributes
like color or sizes.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/attribute packagist](https://packagist.org/packages/elcodi/attribute)
by just executing the following line

``` bash
$ composer require "elcodi/attribute:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file


``` json
{
    "require": {
        "elcodi/attribute": "~0.5.*"
    }
}

```

# Dependencies

The Attribute component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/common:** A doctrine extension for php
- **doctrine/orm:** The doctrine object-relational mapping

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to manage attributes

## Attribute

[View code](https://github.com/elcodi/Attribute/blob/master/Entity/Attribute.php)

The attribute entity maps the information for an item attribute.

**Fields**
- **Id**: The identifier **(Unique)**
- **Name**: The name. `e.g. Color`
- **Created at**: The date time when the attribute was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the attribute was updated. `e.g. 2015-03-05
12:52:20`
- **Enabled**: If the address is enabled. `e.g. 1`
- **values**: All the available values for this attribute

## Value

[View code](https://github.com/elcodi/Attribute/blob/master/Entity/Value.php)

**Fields**
- **Id**: The identifier **(Unique)**
- **Value**: The name. `e.g. Blue`
- **Attribute**: All the attributes that contain this value

# Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit
* Use last stable version tag to stay in a stable release.

# Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony coding standards, so pull requests must pass phpcs
checks. Read more details about
[Symfony coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
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
