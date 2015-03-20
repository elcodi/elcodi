Elcodi Page bundle for Symfony2
===============================

# Table of contents

1. [Bundle](#bundle)
1. [Overview](#overview)
1. [Installation & Configuration](#installation-configuration)
1. [Dependencies](#dependencies)
1. [Tests](#tests)
1. [Model layer](#model-layer)
1. [Tags](#tags)
1. [Contributing](#contributing)

# Bundle

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

This component aims to provide a simple content manager and routing system for
pages.
You can see it working on the [Bamboo] backend so the store admin can add new
pages to the store (Terms & conditions, about us, etc.)

# Installation & Configuration

You can install this Bundle the same way you will do with another [Symfony]
bundle, you'll find info on this [symfony documentation page][4]

In a few words, you can use [Composer] to install the bundle getting the package
from
[elcodi/page-bundle packagist](https://packagist.org/packages/elcodi/page-bundle)
by just executing the following line

``` bash
$ composer require "elcodi/page-bundle:~0.5.*"
```

You can also do it manually by adding a line in your `composer.json` file

``` json
{
    "require": {
        "elcodi/page-bundle": "~0.5.*"
    }
}

```

After that you'll have to enable the bundle on your `Appkernel` file.

``` php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...,
            new \Elcodi\Bundle\PageBundle\ElcodiPageBundle(),
        );

        // ...
    }
}
```

To add a routing entry point for the bundle pages, just load the following
resource anytime:

``` yaml
your_route_name:
    resource: "@ElcodiPageBundle/Resources/config/routing.yml"
    prefix: /content
```

The default configuration values for the bundle are:

```yaml
# Default configuration for extension with alias: "elcodi_page"
elcodi_page:
    mapping:
        page:
            # Page entity implementing PageInterface
            class: Elcodi\Component\Page\Entity\Page
            # Doctrine mapping file for this entity
            mapping_file: '@ElcodiPageBundle/Resources/config/doctrine/Page.orm.yml'
            # Doctrine manager name
            manager: default
            # Is this entity enabled?
            enabled: true
    routing:
        # Enable custom routing
        enabled: true
        # Service name for the custom loader for routing pages
        loader: elcodi.core.page.router.simple_loader.loader
        # Route name or prefix to setup the loader
        route_name: elcodi_page_render_view
        # Route path for the loader
        route_path: '/{path}'
        # Which controller:action will process the request
        controller: 'elcodi.core.page.controller.page:renderAction'
```

> You can overwrite them in your own configuration file using the same keys.

# Dependencies

The Page bundle has dependencies with:
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
- **elcodi/page:** Elcodi page component

Also has dev dependences with:
- **elcodi/test-common-bundle:** Our common test utilities
- **elcodi/bamboo-bundle:** We use the bamboo bundle for functional tests
- **elcodi/fixtures-booster-bundle:** Used to boost the tests execution
- **doctrine/data-fixtures:** To load fixtures

# Tests

*Tests docs*

# Model layer

The Currency bundle provides you some services to work with the Page models.

[More info about the model classes on the component documentation](https://github.com/elcodi/Page/blob/master/README.md#model-layer)

## Page

- `@elcodi.factory.page`: A factory to generate a new page entity
- `@elcodi.object_manager.page`: A page entity manager
- `@elcodi.repository.page`: A page repository

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
[4]: http://symfony.com/doc/current/cookbook/bundles/installation.html
[MIT]: http://opensource.org/licenses/MIT
[Bamboo]: https://github.com/elcodi/bamboo
[Open exchange rates]: https://openexchangerates.org/
[Composer]: https://getcomposer.org/
[Symfony]: http://symfony.com/
