Elcodi Page component
=====================

# Table of contents

1. [Component](#component)
1. [Overview](#overview)
1. [Installation](#installation)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
  * [Page](#page)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

This component aims to provide a simple content manager and routing system for
pages.
You can see it working on the [Bamboo] backend so the store admin can add new
pages to the store (Terms & conditions, about us, etc.)

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/page packagist](https://packagist.org/packages/elcodi/page) by just
executing the following line

``` bash
$ composer require "elcodi/page:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file

``` json
{
    "require": {
        "elcodi/page": "~0.5.*"
    }
}

```

# Dependencies

The Geo component has dependencies with:
- **PHP:** Version greater or equal to 5.4
- **doctrine/orm:** The doctrine object-relational mapping
- **elcodi/core:** Elcodi core component
- **elcodi/metadata:** Elcodi metadata entity to add metadata to pages

# Tests

*Tests docs*

# Model layer

The model for this component adds all the tools needed to manage pages.

## Page

[View code](https://github.com/elcodi/Page/blob/master/Entity/Page.php)

The page entity maps the information of a page for your site.

**Fields**
- **Id:** The identifier **(Unique)**
- **Name:** The name. `e.g. Terms & Conditions`
- **Title:** The title. `e.g. Store Terms & Conditions`
- **Content:** The page content. `e.g. These are the terms and conditions...`
- **Type:** The page type,
[You can find all the types here](https://github.com/elcodi/Page/blob/master/ElcodiPageTypes.php).
`e.g. 1`
- **Path:** The store relative path. `e.g. terms-and-conditions`
- **Publication Date**: The date for the page publication. `e.g. 2015-03-05
12:52:20`
- **Persistent:** If the page can be disabled or deleted. `e.g. 0`
- **Meta title:** The meta title for SEO purposes. `e.g. Store Terms &
Conditions`
- **Meta description:** The meta description for SEO purposes. `e.g. This is a
store that sells...`
- **Meta keywords:** The meta keywords for SEO purposes. `e.g. store,commerce`
- **Created at**: The date time when the page was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the page was updated. `e.g. 2015-03-05
12:52:20`
- **Enabled**: If the page is published. `e.g. 1`

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
and install the corresponding [CodeSniffer definition](https://github.com/escapestudios/Symfony2-coding-standard)
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
