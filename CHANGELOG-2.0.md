CHANGELOG for 1.0.x
===================

This changelog references the relevant changes done in 2.x.x versions

To get the diff for a specific change, go to
https://github.com/elcodi/elcodi/commit/XXX where XXX is the change hash To
get the diff between two versions, go to
https://github.com/elcodi/elcodi/compare/v2.0.0...v2.0.1

### v2.0.3 (15-02-2016)

* Some fixes and tests
* Added as well strict gender

#### Release Log

* [`80d8d71`](https://github.com/elcodi/elcodi/commit/80d8d713a1cf9c5fd6ecbce82c1650e2a25ea877) Fixed gaufrette bundle deps in media bundle (mmoreram)
* [`5e98b99`](https://github.com/elcodi/elcodi/commit/5e98b99c81c9e0aacb1db090fc8a1706baa39b8f) Added country check in all geo commands (mmoreram)
* [`ae49206`](https://github.com/elcodi/elcodi/commit/ae4920637e0003e7ad93ccb0b0797ef186e0ecdd) Added coupon entity test (mmoreram)
* [`195a088`](https://github.com/elcodi/elcodi/commit/195a0883b11a9438ed22caa2db6717fdc5032b57) strict user gender (Emanuele Minotto)

### v2.0.2 (31-01-2016)

* Added languages with master promoted services
* Removed twig dependencies

#### Release Log

* [`ae19d5a`](https://github.com/elcodi/elcodi/commit/ae19d5a51618f7b68f45fc398b4068b98006b7c4) Removed twig deps. No longer used (mmoreram)
* [`cfe5922`](https://github.com/elcodi/elcodi/commit/cfe59228071a1404a0fde3a636cd4099f4d20a9e) Added languages with master promoted service (mmoreram)

### v2.0.1 (31-01-2016)

Some fixes related to v2.0.0

#### Release Log

* [`8883710`](https://github.com/elcodi/elcodi/commit/8883710eb9765b5f444fd0b399d77d44714ee505) Some fixes related to v2.0.0 (mmoreram)

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