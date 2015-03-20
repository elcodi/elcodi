Elcodi Plugin component
=======================
You can find the last version [here](https://github.com/elcodi/plugin).

This component is part of [Elcodi project](https://github.com/elcodi).

[Elcodi](http://elcodi.io) is a set of flexible e-commerce components for [Symfony2](http://symfony.com), built as decoupled and isolated repositories and under [MIT license](http://opensource.org/licenses/MIT).

Rationale
---------
This component adds simple plugin support by a `HookSystem`, where you can define "hooks" and listen to them. 

Installation
------------
Open a terminal and use [Composer](https://getcomposer.org/download) to grab the library.
``` bash
$ composer require elcodi/plugin
```

Documentation
-------------
All classes are under the `Elcodi\Component\Plugin` namespace.

The basic one is `HookSystemInterface`, which defined how all implementations should behave. You can add listeners 
with `listen` method, and execute hooks with `execute`. Each listener receives an `EventInterface` with the current 
context and content passed to the execution.

The basic implemntation is an adapter over `symfony/event-dispatcher`.

Check the documentation in [Elcodi Docs](http://docs.elcodi.io). Feel free to propose new recipes, examples or guides; our main goal is to help the developer building their site.

Contributing
------------
All issues and Pull Requests should be on the main repository [elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs checks. Read more details about [Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html) and install the corresponding [CodeSniffer definition](https://github.com/escapestudios/Symfony2-coding-standard) to run code validation.

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the review process easy in order to accept and merge them. New features must come paired with PHPUnit tests.

If you would like to contribute, please read the [Contributing Code][1] in the project documentation. If you are submitting a pull request, please follow the guidelines in the [Submitting a Patch][2] section and use the [Pull Request Template][3].

[1]: http://symfony.com/doc/current/contributing/code/index.html
[2]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[3]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
