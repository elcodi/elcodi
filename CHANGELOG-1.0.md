CHANGELOG for 1.0.x
===================

This changelog references the relevant changes done in 1.x.x versions

To get the diff for a specific change, go to
https://github.com/elcodi/elcodi/commit/XXX where XXX is the change hash To
get the diff between two versions, go to
https://github.com/elcodi/elcodi/compare/v1.0.0...v1.0.1

### v1.0.14 (16-12-2015)

Added Product Pack implementation
Deprecations and improvements for new Symfony versions

#### Release Log

* [`e78b0cf`](https://github.com/elcodi/elcodi/commit/e78b0cf261659a28eb72dc3c8fa0fe963fae85ce) Issue #1042 Deprecated class and service (mmoreram)
* [`ed88f83`](https://github.com/elcodi/elcodi/commit/ed88f8384cf5049c91da214adf4ed66c296f53f4) Added Product Pack (mmoreram)
* [`79b183b`](https://github.com/elcodi/elcodi/commit/79b183be8a43d793178348b46589592c795ee7aa) Moved form type name into `getBlockPrefix` (Emanuele Minotto)
* [`e198ed9`](https://github.com/elcodi/elcodi/commit/e198ed9bd9ce794103dcdd778b86c9c2c9c06d0e) Implemented tests for Banner component (Emanuele Minotto)

### v1.0.13 (11-12-2015)

Adding extra layer of cache when bundles are resolved on tests
Added two new methods in Product Repository (from a deprecated method) and added
some changes for improving the performance.

#### Release Log

* [`981cca4`](https://github.com/elcodi/elcodi/commit/981cca4c9add0ca6e0498b0c43f102d13c9ecf6f) Added methods to product repository (mmoreram)
* [`d80f3d3`](https://github.com/elcodi/elcodi/commit/d80f3d37aa1e6a3e32bb7e307fda8c2a7477fe81) Improved the abstract factory method (mmoreram)
* [`ca0df05`](https://github.com/elcodi/elcodi/commit/ca0df054952483620b9fd7fe9dd75e0bca6f130c) Fixed BC Break and improved Kernels (mmoreram)
* [`2004e1e`](https://github.com/elcodi/elcodi/commit/2004e1e1d97cea650affdc9651a4bb7d8c524518) Updated resolver deps version (mmoreram)

### v1.0.12 (09-12-2015)

Fixed some DIC definitions.
Some tests for entities and factories

#### Release Log

* [`bf9a802`](https://github.com/elcodi/elcodi/commit/bf9a802683e1da5e56d25393572b783fc811da1c) Fixed stdClass DIC definitions (mmoreram)
* [`88ab625`](https://github.com/elcodi/elcodi/commit/88ab625e98109bc205a4ffd1f4b000d0ec67125d) Added entity tests for cart component (mmoreram)
* [`e957e4e`](https://github.com/elcodi/elcodi/commit/e957e4e49455c8b12a5253dd82b0855902356774) travis: drop unused fast_finish (Tomáš Votruba)
* [`8a0874c`](https://github.com/elcodi/elcodi/commit/8a0874c9ba867da3cbdefd6d5e67ee0d1f0f0881) Twig Extensions are private (mmoreram)
* [`03a2a3d`](https://github.com/elcodi/elcodi/commit/03a2a3d6c08406525040f96e3bcdd1bf029f2eda) Implemented tests for Tax component (Emanuele Minotto)

### v1.0.11 (07-12-2015)

First steps for Entity and Factory unit tests
Fixed as well some issues with new Symfony versions
Upgraded the code style with new formatters versions

#### Release Log

* [`8bd8778`](https://github.com/elcodi/elcodi/commit/8bd8778dbf436d2fc547f005cfd27afae6256ff7) Added abstract tests for entity & factory (Emanuele Minotto)
* [`eb64036`](https://github.com/elcodi/elcodi/commit/eb640360c57ad5de25f6a26fa57ea05171a54392) Updated contribution policy (mmoreram)
* [`edfd514`](https://github.com/elcodi/elcodi/commit/edfd5147d82d9150908547981225150df2cdc85f) quoted strings correctly to solve yaml component deprecation (Emanuele Minotto)
* [`49af2e7`](https://github.com/elcodi/elcodi/commit/49af2e78fef7d220944e1d014163d8c4b404d2aa) Updated formatters versions (mmoreram)
* [`49eadb4`](https://github.com/elcodi/elcodi/commit/49eadb4b1d8db4286812336ce6f9ffd843579818) Fixed tests for Symfony3 (mmoreram)
* [`424aa10`](https://github.com/elcodi/elcodi/commit/424aa10a30b053929250e97b2d59f9788f4771db) Added checking layer in setPassword() (mmoreram)
* [`33a6d1c`](https://github.com/elcodi/elcodi/commit/33a6d1c99a04ddf78b517334fd59c2dfbf3e5ee2) Added a layer of checking on Node (mmoreram)

### v1.0.10 (29-11-2015)

This version fixes a bug in cart prices calculation.
Introduces as well a new component called CartShipping and a new bundle called
CartShippingBundle. Placed there all related to Cart shipping calculation.

#### Release Log

* [`4f8fa43`](https://github.com/elcodi/elcodi/commit/4f8fa430f6801656e76a16162ca2051df6e0b376) Fixed issue related to cart amount (mmoreram)
* [`f7d0655`](https://github.com/elcodi/elcodi/commit/f7d06555ec427dd58830e46db15d4ade10e756ea) Added finder^3.0 as well (mmoreram)
* [`52aa24a`](https://github.com/elcodi/elcodi/commit/52aa24a4b54d2758e5bfcf3c28392be065c46efb) Removed from composer the configuration-bundle line (mmoreram)
* [`6026c8c`](https://github.com/elcodi/elcodi/commit/6026c8c098a22ff30383064da2c83e40e0ac4347) exclude tests from production classes map (Emanuele Minotto)

### v1.0.9 (27-11-2015)

This version deprecates the usage of internal classes related to dependencies
between bundles, and makes use of the external library
[symfony-bundle-dependencies](https://github.com/mmoreram/symfony-bundle-dependencies).

#### Release Log

* [`ca69eee`](https://github.com/elcodi/elcodi/commit/ca69eeec925a25d584d9bdddd73a10397b17e870) Added new dependency with library (mmoreram)

### v1.0.8 (27-11-2015)

This version fixes some important issues related to Cart and Coupon. Symfony3
support has been added.

* Refactored full CartCoupon and CartCouponBundle
* Important to read #997 in order to understand the direction of all components
  and bundles
* Increased tests coverage

#### Release Log

* [`9bab937`](https://github.com/elcodi/elcodi/commit/9bab93751b8abc505030c5fd6c5dda2bddd60cea) Big refactor to CartCoupon layer (mmoreram)
* [`14d02cc`](https://github.com/elcodi/elcodi/commit/14d02cc663c0ca78e32128888579e485e4527367) added some Descriptions to tests (mmoreram)
* [`ba8e311`](https://github.com/elcodi/elcodi/commit/ba8e31189d5f9d15e5f62c54b03aaa41782a490e) Issue #986 Isolated stackable business logic (mmoreram)
* [`d3a094c`](https://github.com/elcodi/elcodi/commit/d3a094c018298b0b2408f2e20a3006006011e0bf) Adding configuration comp+bundle deprecation (mmoreram)
* [`d604ceb`](https://github.com/elcodi/elcodi/commit/d604ceb8f6604d61c04578ea498f748a569835ab) fixed getter (Emanuele Minotto)
* [`61138d8`](https://github.com/elcodi/elcodi/commit/61138d8f30cee7b531fd5f52db394871c7925ca7) Fixes optional dependency (Berny Cantos)
* [`d5232f3`](https://github.com/elcodi/elcodi/commit/d5232f3119205a4f95b7cb1ce90f5be6bff02c0a) Fixed event-listener that updated coupon usage (mmoreram)
* [`17a80ad`](https://github.com/elcodi/elcodi/commit/17a80adcc0f3912347dcdc0eea496b8063e84c93) Removed minimum-stability and prefer-stable (mmoreram)
* [`70fb72f`](https://github.com/elcodi/elcodi/commit/70fb72f896ee95f70995d915463af655a59c31cb) Added support for Symfony3 (mmoreram)

### v1.0.7 (18-11-2015)

This version introduces some breaking changes if you have implemented your Order
instance using OrderInterface. In that case you will have to implement three
more methods.

* Added PaymentMethod field in Order
* Added a placeholder for some extra data for shipping and payment methods (each
  one can use an array to store some extra data)
* Fixed object manager definition (by default, doesn't change anything)
* Removed logic from TwigExtension, created some extra services and using
  Extension as a simple entry point to the service layer

#### Release Log

* [`df27c86`](https://github.com/elcodi/elcodi/commit/df27c864a478f244c534f46984eb143b6e907877) Issue #894 Added payment method in Order (mmoreram)
* [`b156b44`](https://github.com/elcodi/elcodi/commit/b156b44fa382bebb31a5ccbe5adbcf1b34e1b28f) Removed logic from TwigExtension (mmoreram)
* [`37e733d`](https://github.com/elcodi/elcodi/commit/37e733d8e2e91e336a1f736e2bb5ee0f1b228342) Update objectManagers.yml (Germán Figna)

### v1.0.6 (09-11-2015)

This version introduces some breaking changes. This is because there were some
issues (not about architecture, but casting and initialization) that needed to
be improved.

#### TL;DR

* Fixed som castings in the domain layer
* Added command for Translations Cache Warm-up
* Some improvements related to architecture (decreasing Twig extension 
  responsibilities)

#### Release Log

* [`a135723`](https://github.com/elcodi/elcodi/commit/a1357236d1a3f55b1554d7b8a07fb66d9847b14b) Issue #974 Created anonymous functions (mmoreram)
* [`947cd81`](https://github.com/elcodi/elcodi/commit/947cd81552ee6bebb4579c22cde66e3771e4b4b4) phpdoc fixes + attributes initialization (Emanuele Minotto)
* [`3f8c07a`](https://github.com/elcodi/elcodi/commit/3f8c07a69df5edf0b9f0a161a4f48c0b4773ce73) Issue #921 All events set final classes (mmoreram)
* [`84ccc53`](https://github.com/elcodi/elcodi/commit/84ccc5381c02dd3eee85090d8728f01d9889dfc2) Placed all logic in service layer (mmoreram)
* [`21c3fe3`](https://github.com/elcodi/elcodi/commit/21c3fe3c7e3a6d2d376fdd660217ba9f0eee6666) Issue #890 Created command (mmoreram)
* [`b17656c`](https://github.com/elcodi/elcodi/commit/b17656c7dcc8e36e1584a7f24d9cb07762dac642) types casting (Emanuele Minotto)
* [`8a0eed7`](https://github.com/elcodi/elcodi/commit/8a0eed7aa5f9aa7a6df269b5189ca7565efdadb5) Fixed query builder in adapter (mmoreram)

### v1.0.5 (04-11-2015)

Fixed related purchasable provider adapter.
Some improvements related to travis

#### Release Log

* [`68dc92b`](https://github.com/elcodi/elcodi/commit/68dc92bf7bbfafddcb856b5e59cfcb5464726482) Fixed tests for green color! (mmoreram)
* [`63ab636`](https://github.com/elcodi/elcodi/commit/63ab6365d74a6f8e8c2a22e749ea5d4edf615ef1) moved setup and teardown before and after class (Emanuele Minotto)
* [`c2bf4d2`](https://github.com/elcodi/elcodi/commit/c2bf4d2ff6e3dc3b49b1917c37a06ef8864f3f1c) appveyor tests improvement (Emanuele Minotto)
* [`1ee466f`](https://github.com/elcodi/elcodi/commit/1ee466f47d5b3346c3cbca2ee1a72a6e6bd20929) added code coverage for components and bundles (Emanuele Minotto)
* [`b25f774`](https://github.com/elcodi/elcodi/commit/b25f7741b5f6819862ccb154ac2566deff5fed11) Fixed adapter for related purchasables (mmoreram)

### v1.0.4 (04-11-2015)

Some work related to tests and integrations with CI services

#### TL;DR

* Some integrations with third party services have been created here with an
amazing job by Emanuele Minotto.
* Improved travis for the main packages and all components
* Created infrastructure for Related Purchasable Provider adapters
* All code is compatible with PHP versions ^5.4 and ^7.0
* Some small fixes

#### Release Log

* [`eb7b86c`](https://github.com/elcodi/elcodi/commit/eb7b86c82fc55b352b1c01b027d35a79881c1026) added travis cache and new infrastructure (Emanuele Minotto)
* [`4865b86`](https://github.com/elcodi/elcodi/commit/4865b86d12055186b7c254cad0c522c2c8af7eb2) Added Related purchasable adapter (mmoreram)
* [`eb6509b`](https://github.com/elcodi/elcodi/commit/eb6509b35284da3e29c17aa50d3782f2afff29d8) Added dependency from Configuration to Console (mmoreram)
* [`60b994f`](https://github.com/elcodi/elcodi/commit/60b994f35010974c2ae0f99c776e61f2f263de21) Issue #946 Changed dependencies (mmoreram)
* [`1b4bb11`](https://github.com/elcodi/elcodi/commit/1b4bb111ac2a922ec749e451fe91822045ff615b) Update BundleDependenciesResolver.php (Rucheng Tang)
* [`015952b`](https://github.com/elcodi/elcodi/commit/015952b0bfb6b74a62a8f9fdcc2c95f221093ac9) some travis fixes (Emanuele Minotto)
* [`955166d`](https://github.com/elcodi/elcodi/commit/955166dae9edaeaae9987e5589d0e6e2b97d54e8) restored default bin-dir (Emanuele Minotto)
* [`d7331c5`](https://github.com/elcodi/elcodi/commit/d7331c5d052a6c7de468a97e63ed7327d6646dbf) fixed php 5.6 version and phpunit path (Emanuele Minotto)
* [`442bd44`](https://github.com/elcodi/elcodi/commit/442bd449d50e38fe45d6983f8688543f2904e937) moved documentation to gh-pages using sami and travis (Emanuele Minotto)
* [`7df50cf`](https://github.com/elcodi/elcodi/commit/7df50cf311a4cba82112c0a9a1e15437b5ce4cbb) moved code coverage to coveralls (Emanuele Minotto)
* [`6de664d`](https://github.com/elcodi/elcodi/commit/6de664dd178952857ada9b7cb34ecadb506172a7) expanded repos matrix + indentation (Emanuele Minotto)
* [`a226a4a`](https://github.com/elcodi/elcodi/commit/a226a4a8f14ce04eab32960551b94b912453836d) Updated php dependency for ^5.4 & 7.* (mmoreram)
* [`5289860`](https://github.com/elcodi/elcodi/commit/52898608d4e6261e85814d7acaa146a7e6afda0b) Closes #937 Added Sami (mmoreram)
* [`9dae0a5`](https://github.com/elcodi/elcodi/commit/9dae0a51688b3cb43934a719ef19c93cd9f0563b) Added test coverage report (mmoreram)
* [`6c853dd`](https://github.com/elcodi/elcodi/commit/6c853dde9593c43c290ade00fc3212482960e296) Removed lock and travis updates (mmoreram)
* [`a91ec6e`](https://github.com/elcodi/elcodi/commit/a91ec6ea4e11e7ce360f4760b0ed8c7bd989ccab) added php versions matrix (Emanuele Minotto)
* [`ffcf0ae`](https://github.com/elcodi/elcodi/commit/ffcf0ae4ca66728f4a4c344c6df86b3a824e4c6f) Removed unstable version badge (Marc Morera)
* [`09e3b4d`](https://github.com/elcodi/elcodi/commit/09e3b4d918ecd690592433dbbd489be4de9e75ba) appveyor configuration & badge (Emanuele Minotto)
* [`86fcce4`](https://github.com/elcodi/elcodi/commit/86fcce4ea2798578ff6c67def1d8ec8a4bf76a59) skipping testResize if convert is not provided (Emanuele Minotto)
* [`c5c4acd`](https://github.com/elcodi/elcodi/commit/c5c4acd4c7bc18b5d0a6aca4b97d2e00936985f9) added composer scripts (Emanuele Minotto)

### v1.0.3 (13-10-2015)

Added cart in Payment Collector

#### Release Log

* [`1a9c85d`](https://github.com/elcodi/elcodi/commit/1a9c85d5f1fa36194901d8fff633f03170a24b4f) Issue #893 Added constructor and getter (mmoreram)
* [`8b3577d`](https://github.com/elcodi/elcodi/commit/8b3577d5b8e4e4e79ab5f61fd252777c7aca0363) Removed beta warning from README (Aldo Chiecchia)
* [`c0126d5`](https://github.com/elcodi/elcodi/commit/c0126d595795ac59fcfade264b10950261568b64) Fixes #887 Removed file (mmoreram)

### v1.0.2 (07-10-2015)

Commands are more configurable for third party implementations

#### Release Log

* [`19dc4a0`](https://github.com/elcodi/elcodi/commit/19dc4a02e9b9c0fb0d46196cdb99101c7bcdfcaf) Added project header method in abstract command (mmoreram)
* [`f479c3c`](https://github.com/elcodi/elcodi/commit/f479c3c95674956407c4fa51be7dd7e02b94d1c0) Updated changelog with new stable versions (mmoreram)

### v1.0.1 (28-09-2015)

Elcodi can be installed now without Redis

#### TL;DR

* Deprecated CartManager methods in favor of more semantic methods
* Fixed metrics to work without Redis server

#### Release Log

* [`17322d3`](https://github.com/elcodi/elcodi/commit/17322d31f0c1f4161b5a2d1fdd08dc6519a76aac) Changed tests for using new methods. (mmoreram)
* [`05b7c13`](https://github.com/elcodi/elcodi/commit/05b7c13d98ed96d868402bae7142f04897142f18) Fixed wrong method PHPDoc (mmoreram)
* [`546fb09`](https://github.com/elcodi/elcodi/commit/546fb0933f1c290ac40fbd8e302966aadf2e6218) Issue #907 (mmoreram)
* [`58ed5cf`](https://github.com/elcodi/elcodi/commit/58ed5cf796a0b070987e46ee4e61381eceb27ac4) Issue #897 (mmoreram)

### v1.0.0 (22-09-2015)

First stable version for Elcodi

#### TL;DR

* Created new stable version for Elcodi, with the solid base of last beta
* Created a new EventDispatcher for Machine, and placed there all related methods
* Changed the Exchange rate calculator
* Fixed minor issues, and errors
* Updated all dependencies to *semver* notation
* Updated LICENSE

#### Release log

* [`7bc0d7a`](https://github.com/elcodi/elcodi/commit/7bc0d7a4fb1faf1a33a87a028e62c13e42fd317d) Lazy plugins have been removed. (mmoreram)
* [`87e090c`](https://github.com/elcodi/elcodi/commit/87e090cc4aa3a76af5731ab88be60050186a32b3) Created state machine event dispatcher (mmoreram)
* [`7be9362`](https://github.com/elcodi/elcodi/commit/7be93623d7b380d02f4a643a64c69ede0659851f) Added Machine EventDispatcher (mmoreram)
* [`822e7a2`](https://github.com/elcodi/elcodi/commit/822e7a2cf8b960fba811a0633c323ca298117616) Fixed minor typo (mmoreram)
* [`df980e8`](https://github.com/elcodi/elcodi/commit/df980e887eaf7b135822981f98c3f8aa49a44767) Fixed Shipping EventDispatcher method name (mmoreram)
* [`a0a4ab3`](https://github.com/elcodi/elcodi/commit/a0a4ab35e6333866e3408b9a7241168bd825e00e) Updated all dep versions to ^1.0 (mmoreram)
* [`86d8f03`](https://github.com/elcodi/elcodi/commit/86d8f0344de24d3962083d7768b8c15ee66fb39e) Updated license to all files (mmoreram)
* [`0b32f54`](https://github.com/elcodi/elcodi/commit/0b32f54ca086824e1da80322c18289c632274831) can disable entities (Berny Cantos)
* [`08b9b42`](https://github.com/elcodi/elcodi/commit/08b9b4260a36bb7c29c3c3022d3a404269466053) Update LICENSE (Marc Morera)
* [`0f28b23`](https://github.com/elcodi/elcodi/commit/0f28b2301d6f28d1d99f9670d72fb54ff827fc54) Fixed typo (Berny Cantos)
* [`5a7df21`](https://github.com/elcodi/elcodi/commit/5a7df21043a4612e9668dcb7312810ead1484df8) Updated config to use parameters (Roger Gros)
* [`f81a69c`](https://github.com/elcodi/elcodi/commit/f81a69c049c07d9077158242f819d034a51adad1) Exchange rate calculator (Roger Gros)
* [`23915a2`](https://github.com/elcodi/elcodi/commit/23915a2b60f8282adb47254f377ea8d84a0ed0af) Make plugin services lazy by default (Berny Cantos)

### v1.0.0-beta3 (10-07-2015)

Release focused on fixes and standardization and simplification.

#### TL;DR

* Added new GD Image resize adapter and using by default
* Improved all Command implementation by adding some common features in a new
  abstract Command class
* Fixed dependencies between packages during the Beta and RC stage
* Added Location commands to manage all location structure in a very easy way
* Removed all Location dumps and placed to another Repository. Usage of new
  Command
* Updated [Predis ](https://github.com/nrk/predis/releases/tag/v1.0.1)
  dependency to stable

#### Release log

* [`443ccc4`](https://github.com/elcodi/elcodi/commit/443ccc41ec846f5ae9c7baca6b004338ef116241) Fixed class name (mmoreram)
* [`87e35a9`](https://github.com/elcodi/elcodi/commit/87e35a9e05ed20ddb1e1491fc743821d128dfca3) Updated some commands to work with new Abstract (mmoreram)
* [`5bf1a56`](https://github.com/elcodi/elcodi/commit/5bf1a563d54637004e9ba1db45ad8f43dc63189c) Removed comment parser (mmoreram)
* [`2842fa8`](https://github.com/elcodi/elcodi/commit/2842fa8dec53dcc1849f96bac177e148c54705ff) Removed suggestion because is required already (mmoreram)
* [`6849f43`](https://github.com/elcodi/elcodi/commit/6849f437a03ae98f6604b54e399b217e160c87a2) Removed property and access methods (mmoreram)
* [`a6e4583`](https://github.com/elcodi/elcodi/commit/a6e458367f4e18b50195032257cbefa0f5b51dac) Fixed naming in currency bundle for adapters (mmoreram)
* [`541a521`](https://github.com/elcodi/elcodi/commit/541a521e6e7b93c76a84f8c634a4231df7f7743d) Added Guzzle service in CoreBundle (mmoreram)
* [`47b03ea`](https://github.com/elcodi/elcodi/commit/47b03ea9b26d656e850d7162ea0d3929a3561953) Using self.version during Beta and RC (mmoreram)
* [`ab1f54e`](https://github.com/elcodi/elcodi/commit/ab1f54e662dd00d77458746d8e54e92992ba6463) Refactored some naming inside MediaBundle (mmoreram)
* [`70e6301`](https://github.com/elcodi/elcodi/commit/70e63017c7ca1635098552ea6599bd27f75485a0) Refactor for some Location-related actions (mmoreram)
* [`06fd8b5`](https://github.com/elcodi/elcodi/commit/06fd8b5699d82da903b281a7be05ae2b86147cea) Some internal changes for CoreBundle (mmoreram)
* [`9eaa223`](https://github.com/elcodi/elcodi/commit/9eaa223fd664b93e884449775b8d18486b6f52b7) Removed all location dumps (mmoreram)
* [`1b2955c`](https://github.com/elcodi/elcodi/commit/1b2955caf44c4da877edf23120b8c931e0902da7) Removed console dependency in most Bundles (mmoreram)
* [`62dce91`](https://github.com/elcodi/elcodi/commit/62dce917c5c7121c0b2b8b2b2a6de12f43a27c4a) Used AbstractElcodiBundle in all package bundles (mmoreram)
* [`bc347e0`](https://github.com/elcodi/elcodi/commit/bc347e08787d7f99f84f4aafdc8f380efdf0f968) Improved some code for Scrutinizer (mmoreram)
* [`3c051d8`](https://github.com/elcodi/elcodi/commit/3c051d8f7e353fd3af2ff91496a11783e664612d) Added StoreBundle dependencies (mmoreram)
* [`c5b7fb0`](https://github.com/elcodi/elcodi/commit/c5b7fb00440461ced2349b3d7d12a17b113cdc3f) Updated predis dependency to stable 1.* (mmoreram)
* [`757465d`](https://github.com/elcodi/elcodi/commit/757465d41d02e0780c398b9d66f4599772fada6a) abstract PluginTypeExtension ease creation (Berny Cantos)
* [`90f8d6f`](https://github.com/elcodi/elcodi/commit/90f8d6fb2ab275bc5b7813d374bf7554b1023044) make PluginType stateless (Berny Cantos)
* [`866b53d`](https://github.com/elcodi/elcodi/commit/866b53d3ea68106cb3c1756eacae38d09eac27c2) Redefined interdependencies (mmoreram)
* [`f195063`](https://github.com/elcodi/elcodi/commit/f195063d96094dc4a79409d44772c84b9ceb7f64) Downgraded predis version and fixed deps (mmoreram)
* [`21b53df`](https://github.com/elcodi/elcodi/commit/21b53dfff477a25cbf1580ed3e7503b6dd08fb5a) Adding new stable version for predis (mmoreram)
* [`d1f639e`](https://github.com/elcodi/elcodi/commit/d1f639ebd7dbdda4d1ae7c2f0a2cf0fba44b32ec) Removed minimum-stability and prefer-stable (mmoreram)
* [`60e04c2`](https://github.com/elcodi/elcodi/commit/60e04c2660d939d2bcc74b61c9a50e3828fea982) dependencies between components set to @dev (mmoreram)
* [`507d04b`](https://github.com/elcodi/elcodi/commit/507d04b273cf0ee355b03a53b7e5fd67659d89cd) Updated composer json file (mmoreram)
* [`2a70b7f`](https://github.com/elcodi/elcodi/commit/2a70b7fc0a599ee5d7affcb887f5f9090f27025e) Removed prefer-lowest (mmoreram)
* [`b4f3a90`](https://github.com/elcodi/elcodi/commit/b4f3a900cba202491c07b519d26115b01f55e5bf) Fixed mediabundle tests (mmoreram)
* [`f646726`](https://github.com/elcodi/elcodi/commit/f6467265f855a04fa84643b7411b2c9f6cbcae8a) Added GD adapter for image resize (mmoreram)
* [`ce4d63f`](https://github.com/elcodi/elcodi/commit/ce4d63f8478f010a396c6bd0697323d142649acb) Added composer.lock in order to boost travis (mmoreram)
* [`bf04441`](https://github.com/elcodi/elcodi/commit/bf044419b455793f9a6d2ab3fc4cf0947856a42f) Fixed tests (mmoreram)
* [`7ca9ff2`](https://github.com/elcodi/elcodi/commit/7ca9ff21034d1ca717039f2afb8bae43b500df22) Removed innecessary value pre-set (mmoreram)
* [`2cc6d78`](https://github.com/elcodi/elcodi/commit/2cc6d78b32b86ea82aea2d8d61a07c0f83d765dc) Removed setters on Money as is a ValueObject (mmoreram)
* [`c87405b`](https://github.com/elcodi/elcodi/commit/c87405be75dc07f728ffdfbe5f7b8c12ae957c07) Update services.yml (Berny Cantos)
* [`bac2236`](https://github.com/elcodi/elcodi/commit/bac22367e3cedeedfaedda938de703330d94a950) Update tracker.js (Berny Cantos)
* [`90cbae0`](https://github.com/elcodi/elcodi/commit/90cbae02430678fa9270c12c03b370a54f75c895) Fixed tracking url (mmoreram)
* [`59ec2b7`](https://github.com/elcodi/elcodi/commit/59ec2b7c2342d038e266d674fdd5e749e3caab05) Plugins are disabled by default but can be enabled (Roger Gros)
* [`7f98589`](https://github.com/elcodi/elcodi/commit/7f98589bdf806d76fe93210e709e0669ac18e158) added productCurrency to OrderLine ORM (Joan Galvan)
* [`905b8c8`](https://github.com/elcodi/elcodi/commit/905b8c8ce6bc4107e98318a7afc8c8b81d913d75) Added shipping dependency to cart bundle (mmoreram)
* [`36f184d`](https://github.com/elcodi/elcodi/commit/36f184dd72ed25ab3cd902f5e5a0bf222e81b35b) Fixed currency component dependencies (mmoreram)

### v1.0.0-beta2 (15-06-2015)

Early release to fix some errors in dependencies between packages

* [`e6daaa6`](https://github.com/elcodi/elcodi/commit/e6daaa64bedb1901101784d140bd2ff465889263) Fixed dev-master alias for all components (mmoreram)
* [`8f3c896`](https://github.com/elcodi/elcodi/commit/8f3c8968c4c9b20b6552a64cfb890c974dee08ef) Changed readme text to beta stage (mmoreram)
* [`b9fe8e5`](https://github.com/elcodi/elcodi/commit/b9fe8e520bc60fde7f2e92a636db4b678c611c95) Added all package dependencies strategy to beta (mmoreram)

### v1.0.0-beta1 (14-06-2015)

* [`0634ec1`](https://github.com/elcodi/elcodi/commit/0634ec1de55ceb85112d371aa619c1f73ed55ef3) Fixed use_stock injection and fixed tests (mmoreram)
* [`c2f4e3d`](https://github.com/elcodi/elcodi/commit/c2f4e3d926efc3f48586396365d593924840f6e7) Fixed address view factory (mmoreram)
* [`3e4b250`](https://github.com/elcodi/elcodi/commit/3e4b250540d4dfe0b20e79b989f37553075bf4eb) Fixed product factory definition (Roger Gros)
* [`e68d0b7`](https://github.com/elcodi/elcodi/commit/e68d0b78b1a61bebe693cc27be8f5f3ef8aae4ba) Plugin field type turned free (mmoreram)
* [`dc843ea`](https://github.com/elcodi/elcodi/commit/dc843eaadb9c6105cd0359482035b48644cf39fb) Removed address view (mmoreram)
* [`66952fe`](https://github.com/elcodi/elcodi/commit/66952fead73d08ee3fa44754a76a271ea6e0c720) Fixed plugins routes (mmoreram)
* [`b228183`](https://github.com/elcodi/elcodi/commit/b2281833ae69f420e40aaa78fc234026f93013ff) Fixed Currency population (mmoreram)
* [`03f8dd1`](https://github.com/elcodi/elcodi/commit/03f8dd122a1e0c82808d09ff997f3dbb2069b241) Plugins now accept choice type (Roger Gros)
* [`de081e8`](https://github.com/elcodi/elcodi/commit/de081e8b91a33e783a65e3abcf3d18a83d14e1c4) New shipment flow (Roger Gros)
* [`7d0bdf5`](https://github.com/elcodi/elcodi/commit/7d0bdf54e12a1eed6bf4e2771c421e6683f92255) Address view (Roger Gros)
* [`858e31a`](https://github.com/elcodi/elcodi/commit/858e31ac550d8558826fe1d9a67bf6eecc5951f9) transform to/from json in persistence (Berny Cantos)
* [`617a4d7`](https://github.com/elcodi/elcodi/commit/617a4d76243f23c23a22995e794112cb04274943) Added order badge even if 0 (mmoreram)
* [`1b84a54`](https://github.com/elcodi/elcodi/commit/1b84a54e521e51c5c116da13d70722a491e0e8b0) Added field $loaded in Cart (mmoreram)
* [`7ce98d8`](https://github.com/elcodi/elcodi/commit/7ce98d8de59daad5d48501a18a4bf81588419004) Added warnings in menu node for badges (mmoreram)
* [`b573ea0`](https://github.com/elcodi/elcodi/commit/b573ea05496aa8f6910d30ae433466a5cfe0f7ea) Fixed and completed all shipping stuff (mmoreram)
* [`fcd037b`](https://github.com/elcodi/elcodi/commit/fcd037b921a37814c8ceb5cdb8d7735ad6c992fd) Fixed method loadFixtures and fixed tests (mmoreram)
* [`2e1a8a6`](https://github.com/elcodi/elcodi/commit/2e1a8a652294f3adac181e1064c959635f86d161) Added Kernel object when reaching Bundle deps (mmoreram)
* [`edca850`](https://github.com/elcodi/elcodi/commit/edca850dbe38368a6c44193f7eab9763f09d1b87) Added routing strategy feature in store (mmoreram)
* [`98068f5`](https://github.com/elcodi/elcodi/commit/98068f54a03a963943a8bdc1a516c2de3cd6b987) Added elcodi.store_default_language_iso service (mmoreram)
* [`dd7e152`](https://github.com/elcodi/elcodi/commit/dd7e152744ce14126b6720fc48071c8ed798c508) method loadSchema takes in account fixtures (mmoreram)
* [`aab9329`](https://github.com/elcodi/elcodi/commit/aab932988feb4161919464c341cbc6f1119c9213) Placed all Money print in a service (mmoreram)
* [`45276c5`](https://github.com/elcodi/elcodi/commit/45276c5153aebd5af54181cc6c1a426ce408d81e) Fixed tests for PrintMoneyExtension (mmoreram)
* [`7290110`](https://github.com/elcodi/elcodi/commit/7290110c604c3a483c6fa78e78580e4687dbe456) Fixed names for payment_methods and shipping_methods (mmoreram)
* [`4d61d7a`](https://github.com/elcodi/elcodi/commit/4d61d7a2fb8b3e5e42029ef8ea41b50e2cefd371) Added priorities to Menu and fixed issue (mmoreram)
* [`02f68d0`](https://github.com/elcodi/elcodi/commit/02f68d0f84b166a990d7ed62535fb83836de8290) Fixed some PHPDoc (mmoreram)
* [`ef92ae5`](https://github.com/elcodi/elcodi/commit/ef92ae5fab0e8061af5923f4ac4e0c2907eb8fe6) Fixed PHPDoc (mmoreram)
* [`cc47127`](https://github.com/elcodi/elcodi/commit/cc47127bf86c4f7c70de5e2a10e79559cf7adbc0) Added option to generate absolute urls on image extension (Roger Gros)
* [`4ff9771`](https://github.com/elcodi/elcodi/commit/4ff9771614cc7bf29a28ac40c712b0ced70f5498) Some arch refactoring for scrutinizer happiness (mmoreram)
* [`2eca0fb`](https://github.com/elcodi/elcodi/commit/2eca0fb2c9aa302eeb5b75194e5674e55829ebdc) Fixed city exists validator (Roger Gros)
* [`c1aea36`](https://github.com/elcodi/elcodi/commit/c1aea363aaf3ef9d18410e7d79f9a4f7779dccb7) Updated Visibility (API) of components (mmoreram)
* [`1d383af`](https://github.com/elcodi/elcodi/commit/1d383afd1fbdc927ecce51b81ccfa800893b5d13) Changed all README files from components (mmoreram)
* [`f996f8b`](https://github.com/elcodi/elcodi/commit/f996f8b07fd82d2b7e7e7c213166048ecf0aa496) Some small fixes (mmoreram)
* [`b4c073d`](https://github.com/elcodi/elcodi/commit/b4c073dd99b1b7b9bd971b304e34257c2885af85) Fixed Location API (mmoreram)
* [`881ec80`](https://github.com/elcodi/elcodi/commit/881ec8087f80f2f8d1a6241ce71e58199a5ea9b1) Fixed variables to camelCase (mmoreram)
* [`b8bec3c`](https://github.com/elcodi/elcodi/commit/b8bec3cf0ad56e79feb89eec386469b8e81f14bc) Updated Payment and Store component meta files (mmoreram)
* [`69a7a81`](https://github.com/elcodi/elcodi/commit/69a7a8170b11e0881127b028ca16c553b8ee1c86) Added default_language and default_currency in DIC (mmoreram)
* [`e47330a`](https://github.com/elcodi/elcodi/commit/e47330a8d5f24420f237b795d5147810c20a2554) Fixed some PHPDoc and dependencies (mmoreram)
* [`d7b305d`](https://github.com/elcodi/elcodi/commit/d7b305d4bac2e42b08ea74e80b85dd10cdb68160) Added PaymentBundle meta files (mmoreram)
* [`8afbb51`](https://github.com/elcodi/elcodi/commit/8afbb5183b27822de01e7ddc0c7d0abd7c34daaf) Added StoreBundle meta files (mmoreram)
* [`37b1994`](https://github.com/elcodi/elcodi/commit/37b19949fb5653273f65f5d21d659b8e1531b053) Fixed factory definitions in DIC (mmoreram)
* [`b659f5b`](https://github.com/elcodi/elcodi/commit/b659f5b6f8398eeae989d13f5e7107202db391f9) Formatted all service arguments (mmoreram)
* [`18c9a74`](https://github.com/elcodi/elcodi/commit/18c9a7438c2816667dcb88d0dcf2b1b9613d6fa2) Stabilization of all dependencies (mmoreram)
* [`e5ee9a1`](https://github.com/elcodi/elcodi/commit/e5ee9a117e6fdef0a328035214c808b1f822b394) Store, Plugins, Shipping, Menu and more... (mmoreram)
* [`53ef311`](https://github.com/elcodi/elcodi/commit/53ef311e9191f4443f0ac5fca3b42740c1a1a4c0) Fix bug use stock (Roger Gros)
* [`c769750`](https://github.com/elcodi/elcodi/commit/c769750dee2149be3879beef9da407eb312d9190) fix plugin loader (Berny Cantos)
* [`e610f79`](https://github.com/elcodi/elcodi/commit/e610f79aee161165a96ed9e66cf771de6530e1ad) Fixed interface for images container (Roger Gros)
* [`c1741f2`](https://github.com/elcodi/elcodi/commit/c1741f2d1329ccf287a1b7df33089a791bf1c876) fix class for plugin repository (Berny Cantos)
* [`8d0f642`](https://github.com/elcodi/elcodi/commit/8d0f64239edefc9d61612048f771ef6fd98af157) Updated command to allow disabling booster (mmoreram)
* [`57fc19f`](https://github.com/elcodi/elcodi/commit/57fc19f2886f9b9d6b9392e36b84e6e31d2497a7) Fixed cs (mmoreram)
* [`9bd3294`](https://github.com/elcodi/elcodi/commit/9bd3294f5d5cbe4f86547e27a85035e833254387) Updated fixtures dependency for prefer-lowest (mmoreram)
* [`db27bad`](https://github.com/elcodi/elcodi/commit/db27bad4dc5544867f89d28d28be5ccbb4e60f01) Updated package version (mmoreram)
* [`d15ed60`](https://github.com/elcodi/elcodi/commit/d15ed60c7924525f8e13b896c67e87e558fa04b1) Fixed order factory when empty coupon (Issel Guberna)
* [`1cef088`](https://github.com/elcodi/elcodi/commit/1cef088340178eca5e36e92c922cab7458a93bc9) Moved to director (Roger Gros)
* [`b5fb08d`](https://github.com/elcodi/elcodi/commit/b5fb08d8a8f45e9d080cfa67554e5e29582d21de) Moved test to director (Roger Gros)
* [`3b02271`](https://github.com/elcodi/elcodi/commit/3b022714919d9b3fe7e459cfb2efc1c2824e1961) Fixed category integrity for new products and product edit (Roger Gros)
* [`eca5257`](https://github.com/elcodi/elcodi/commit/eca52577794d4e797b1db3ecd39dbecce65683b4) Any root catgory is saved with parents (Roger Gros)
