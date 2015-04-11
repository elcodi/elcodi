Elcodi for Symfony
===================
[![Build Status](https://travis-ci.org/elcodi/elcodi.svg?branch=master)](https://travis-ci.org/elcodi/elcodi)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elcodi/elcodi/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elcodi/elcodi/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/elcodi/elcodi/v/stable.png)](https://packagist.org/packages/elcodi/elcodi)
[![Total Downloads](https://poser.pugx.org/elcodi/elcodi/downloads.png)](https://packagist.org/packages/elcodi/elcodi)
[![Latest Unstable Version](https://poser.pugx.org/elcodi/elcodi/v/unstable.png)](https://packagist.org/packages/elcodi/elcodi)
[![License](https://poser.pugx.org/elcodi/elcodi/license.png)](https://packagist.org/packages/elcodi/elcodi)

> Warning. This project is not tagged as stable yet. It means that we don't
> promise BC between minor versions or patch versions. As soon as possible, we
> will release our first Release Candidate, and the first Stable Version will
> be release on June 1st. Stay Tuned and enjoy Elcodi.

Elcodi is a suite of e-commerce bundles and components developed for the 
**Symfony Framework**.
It aims to promote SOLID principles, efficient code reutilization, separation of 
concerns as effective building blocks for the development of e-commerce 
applications.

Elcodi is now in an early development stage and provides a reference 
implementation for the basic core components found in e-commerce web projects.

See the [front-end store](http://bamboo.elcodi.com) and the 
[back-office](http://bamboo.elcodi.com/admin) demo application in action.

Check out the source code for [Bamboo](https://github.com/elcodi/bamboo).

Requirements
------------

Elcodi is supported on PHP 5.4.* and up.


Documentation
-------------

Check the documentation in [Elcodi Docs](http://elcodi.io/docs).

This documentation is being developed and will be in alpha version until the 
first stable project version.


Tags
----

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit.
* Use last stable version tag to stay in a stable release.
* [![Latest Unstable Version](https://poser.pugx.org/elcodi/elcodi/v/unstable.png)](https://packagist.org/packages/elcodi/elcodi)  [![Latest Stable Version](https://poser.pugx.org/elcodi/elcodi/v/stable.png)](https://packagist.org/packages/elcodi/elcodi)


Projects
--------

Have you developed an application on top of Elcodi components? Let us know it 
and use this badge for your github repository.  
[![Powered By Elcodi](http://elcodi.io/static/elcodi.badge.png)](http://github.com/elcodi)


Contributing
------------

This project follows some standards. If you want to collaborate, please ensure
that your code fulfills these standards before any Pull Request.

``` bash
composer.phar update
bin/php-cs-fixer fix
bin/php-formatter formatter:use:sort src/
bin/php-formatter formatter:header:fix src/
```

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New features must come paired with Unit and/or Functional
tests.
