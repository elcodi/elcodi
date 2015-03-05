Elcodi Geo Bundle for Symfony2
==============================

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

Table of contents
-----------------
1. [Documentation](#documentation)
    * [Overview](#overview)
    * [Installation / Configuration](#installation-configuration)
    * [Dependencies](#dependencies)
    * [Tests](#tests)
    * [Model layer](#model-layer)
    * [Service layer](#service-layer)
    * [Event layer](#event-layer)
    * [Controllers](#controllers)
    * [Commands](#commands)
1. [Tags](#tags)
1. [Contributing](#contributing)

Table of contents
-----------------
1. [Documentation](#documentation)
    * [Quick overview](#quick-overview)
    * [Entities](#entities)
      * [Location entity](#location-entity)
          * [Location fields](#location-fields)
      * [Address entity](#address-entity)
          * [Address fields](#address-fields)
    * [Populating the locations](#populating-the-locations)
    * [Locations API vs Service](#locations-api-vs-service)
    * [Feel free to help](#feel-free-to-help)
1. [Tags](#tags)
1. [Contributing](#contributing)

Documentation
-------------

# Quick overview

The GeoBundle provides us with a flexible and easy way to work with Geo
locations.

The bundle works with two entities, `Location` and `Address` to manage all the
data.

The bundle also provides you with a really powerful command to populate the
database with all the geo data needed to provide localization for your site and
the possibility to use the locations from a service or an API, among other
things.

# Entities

## Location entity
The location entity maps the information to geographically localize anything, it
is structured in a tree that contains all the imported countries on the root and
all the levels of data that [Geonames][4] can provide us.

### Location Fields
- **Id:** The identifier **(Unique)**
- **Name:** The name. `e.g. Spain`
- **Code:** The code, usually the ISO code. `e.g. ES`
- **Type:** The type, from country on the root level to the lowest level. `e.g.
Country`

## Address entity

The address entity provides a way to save a full address, it is thought to use
soft relations with locations to save the city and the postal code.

### Address Fields
- **Id:** The identifier **(Unique)**
- **Name:** The address name, usually a name to identify the address from other
address. `e.g. My home`
- **Recipient name:** The name for the address recipient. `e.g. Homer`
- **Recipient surname:** The surname for the address recipient. `e.g. Simpson`
- **City:** The address city, usually a soft link to a location saving a
location id. `e.g. ES_CT_B_Barcelona`
- **Postal code**: The address postal code, usually a soft link to a location
saving a location id. `e.g. `
- **Address**: The city address. `e.g. C/València 333`
- **Address more**: A second line to save the city address. `e.g. Baixos`
- **Phone**: An address phone number. `e.g. 958647856`
- **Mobile**: An address mobile phone number. `e.g. 648563258`
- **Comments**: An address comment, usually for the carrier. `e.g. It's an
office`
- **Created at**: The date time when the address was created. `e.g. 2015-03-05
12:52:20`
- **Updated at**: The date time when the address was updated. `e.g. 2015-03-05
12:52:20`
- **Enabled**: If the address is enabled. `e.g. 1`

# Locations API vs Service

The locations database uses to be immutable and heavy. So, why would you like to
have this database replicated on all your projects? That's what we have created
an easy way to transparently change from a service to an API.

This bundle contains an interface (`LocationProviderInterface`), that's
implemented by two services, the first one (`LocationServiceProvider`) accesses
directly to the database and the second one (`LocationApiProvider`) uses an API
to access the data.

You can rely on the interface to build your own code and inject the service
`@elcodi.location_provider`.

By default this service is an alias for the `elcodi.location_provider.service`
but you can customize it to use the API service by only adding a parameter:

``` yml
elcodi.location_provider: elcodi.location_provider.api
```

# Populating the locations

After the bundle is added and enabled on your project you can simply do:

``` bash
$ php app/console elcodi:locations:populate ES
```

Where `ES` is the code for any of the
[ISO 3166-1 (Alpha-2 code)](http://en.wikipedia.org/wiki/ISO_3166-1#Current_codes)
. This will populate all the locations for the given country. You can also add
multiple countries separated by commas.

This command generates a full tree with all the levels needed to locate your
users.

# Feel free to help

Check the documentation in [Elcodi Docs](http://docs.elcodi.io). Feel free to
propose new recipes, examples or guides; our main goal is to help the developer
building their site.

Tags
----

* Use last unstable version ( alias of `dev-master` ) to stay always in last
commit
* Use last stable version tag to stay in a stable release.

Contributing
------------

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
[4]: http://www.geonames.org/
