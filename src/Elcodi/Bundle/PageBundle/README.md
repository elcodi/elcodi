Elcodi Page bundle
==================
You can find the last version [here](https://github.com/elcodi/page-bundle).

This component is part of [Elcodi project](https://github.com/elcodi).

[Elcodi](http://elcodi.io) is a set of flexible e-commerce components for [Symfony2](http://symfony.com), built as decoupled and isolated repositories and under [MIT license](http://opensource.org/licenses/MIT).

Rationale
---------
This bundle integrates `elcodi/page` into your Symfony2 application.

Installation
------------
1. Open a terminal and use [Composer](https://getcomposer.org/download) to grab the library.
    ``` bash
    $ composer require elcodi/page-bundle
    ```

2. Register the `Elcodi\Bundle\PageBundle\ElcodiPageBundle` in your application `Kernel`.
3. Optionally configure the bundle in your `config.yml`.

Configuration
-------------
Working default values are provided so you can skip this step.

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

Routing
-------
To create a routing entry point for your pages, just load the following resource anytime:
``` yaml
your_route_name:
    resource: "@ElcodiPageBundle/Resources/config/routing.yml"
    prefix: /content
```
And now all your pages are available under the `/content` path.
You can do that as many times as you like.

You can make them available under root `/`, but make sure this is the last route you load.

Documentation
-------------
Check the documentation in [Elcodi Docs](http://docs.elcodi.io). Feel free to propose new recipes, examples or guides; our main goal is to help the developer building their site.

Contributing
------------
All issues and Pull Requests should be on the main repository [elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs checks. Read more details about [Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html) and install the corresponding [CodeSniffer definition](https://github.com/opensky/Symfony2-coding-standard) to run code validation.

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the review process easy in order to accept and merge them. New features must come paired with PHPUnit tests.

If you would like to contribute, please read the [Contributing Code][1] in the project documentation. If you are submitting a pull request, please follow the guidelines in the [Submitting a Patch][2] section and use the [Pull Request Template][3].

[1]: http://symfony.com/doc/current/contributing/code/index.html
[2]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[3]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
