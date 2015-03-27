Elcodi Comment component for Symfony2
=====================================

# Component

This component is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under [MIT] license.

# Overview

The Comment component provides a comment-reply system that you can use anywhere.

# Installation

You can use [Composer] to install this component getting the package from
[elcodi/comment packagist](https://packagist.org/packages/elcodi/comment) by just
adding a line in your composer.json

``` json
{
    "require": {
        "elcodi/comment": "~0.5.*"
    }
}

```

Or executing the following line

``` bash
$ composer require "elcodi/comment:~0.5.*"
```

# Dependencies

The Comment component has dependencies with:

# Tests

*Tests docs*

# Model layer

## Comment

[View code](https://github.com/elcodi/Geo/blob/master/Entity/Location.php)

The location entity maps the information to geographically localize anything, it
is structured in a tree that contains all the imported countries on the root and
all the available levels.

**Fields**
- **Id:** The identifier **(Unique)**
- **Source:** Name of the source for comments `e.g. http://blog.elcodi.com/`
- **Context:** A string, every source can have multiple contexts to discuss `e.g. on-cart-implementation`
- **Parent:**: Optional self-reference to allow for replies
- **Children:** Collection of comments replying to this
- **AuthorToken:** Token to uniquely identify the comment's author
- **AuthorName:** Name of the comment's author `e.g. John Doe`
- **AuthorEmail:** Email of the comment's author `e.g. john.doe@example.com`
- **Content:** Original raw content of the comment `e.g. # Title`
- **ParsingType:** Original format conversion `e.g. none, markdown, `
- **ParsedContent:** Content after parsing `e.g. <h1>Title</h1>`
- **Enabled:** Whether this is active or not
- **CreatedAt:** Date/time of creation
- **UpdatedAt:** Date/time of last update

# Service layer

These are the useful component services that you should know:

## Formatter/AddressFormatter.php

[View code](https://github.com/elcodi/Geo/blob/master/Formatter/AddressFormatter.php)

The address formatter provides various utilities to format an address.

**e.g.** *This service can be used to print the address in string format to do a to the Google Maps API*

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

These are all the events for this component. You can get all the event names as
constant properties at file
[ElcodiGeoEvents.php](https://github.com/elcodi/Geo/blob/master/ElcodiGeoEvents.php)
.

## AddressOnCloneEvent

This event is launched every time that an address is cloned, that happens when
an address is being edited. We create a clone because other entities could be
pointing to this address. A copy is created while other entities can keep the
pointer to the old address.

**e.g.** *A customer edits his address but hi has old orders pointing to the
address being edited*

**Event properties**
- **Original address**: The original address
- **Cloned address**:  The new cloned address

> More info about this on the
> [Services/AddressManager.php](#servicesaddressmanagerphp) section

# Controllers

These are the useful component controllers that you should know.

## LocationApiController

[View code](https://github.com/elcodi/Geo/blob/master/Controller/LocationApiController.php)

The location Api controller provides the actions needed to use the location
service as an API

# Commands

These are the useful component commands that you should know.

## LocationPopulateCommand

[View code](https://github.com/elcodi/Geo/blob/master/Command/LocationPopulateCommand.php)

Populates the database with all the locations from a country.

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
