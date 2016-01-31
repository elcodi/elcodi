CHANGELOG for 1.0.x
===================

This changelog references the relevant changes done in 2.x.x versions

To get the diff for a specific change, go to
https://github.com/elcodi/elcodi/commit/XXX where XXX is the change hash To
get the diff between two versions, go to
https://github.com/elcodi/elcodi/compare/v2.0.0...v2.0.1

### v2.0.0 (30-01-2016)

Added the new Purchasable schema

* A new usable interface called PurchasableInterface has been created
* Using Doctrine CTI (Class Table Inheritance)[http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/inheritance-mapping.html#class-table-inheritance]
to make more usable the purchasable implementation
* Changed how the Cart is actually using products and variants. Now uses
Purchasables instead of
* Introduced a new Purchasable element called Pack, a set of other purchasables,
including as well other packs
* Removed as well all legacy code marked as Deprecated code, including both
packages Configuration and ConfigurationBundle

#### Release Log

* [`a768a22`](https://github.com/elcodi/elcodi/commit/a768a22622ffc78360ac580bbe5395ef5a1fe69c) Removed all deprecated code (mmoreram)
* [`1924f4a`](https://github.com/elcodi/elcodi/commit/1924f4aa185e6adfc37ea4b9a45f28b7c91b46cb) Updated dev-master in all components (mmoreram)
* [`f6d511b`](https://github.com/elcodi/elcodi/commit/f6d511be76c9b0f2990042a27c7cad764928f893) Updated componsents to work with ^2.0 (mmoreram)
* [`9e093cd`](https://github.com/elcodi/elcodi/commit/9e093cd98392c81f121ffd6217cb7b5b084c36f2) Fixes after rebase with master (mmoreram)
* [`bddfb11`](https://github.com/elcodi/elcodi/commit/bddfb1117d8a62ea71a6d509ac846c983c56dcc1) Fixed some headers (mmoreram)
* [`9d16fcb`](https://github.com/elcodi/elcodi/commit/9d16fcb509e1509a8c8187f762dfa5edac4c30b5) Added Categorizable interface (mmoreram)
* [`665a8a7`](https://github.com/elcodi/elcodi/commit/665a8a715f2c4b28a14046c777ee5865857c1861) Updated and Improved Purchasable Schema map (mmoreram)