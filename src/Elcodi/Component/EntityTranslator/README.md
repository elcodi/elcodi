Elcodi Entity Translation component
===================================

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

## Installing the Entity Translation

You have to add require line into you composer.json file

``` yml
"require": {
    "php": ">=5.4",
    ...

    "elcodi/entity-translation": "dev-master",
}
```

Then you have to use composer to update your project dependencies

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar update
```

## Usage

The model is the most important part of a project, right? We strongly believe
that, so we think that coupling the entities with the translation infrastructure
is a bad practice.

This component provides an external translation engine with some nice services
to make an entity translation something really easy and enjoyable.

Let's figure out we are working with a Product object. Our model clean, with two
fields: name and description. All this documentation assumes the usage of this
class.

``` php
/**
 * Class Product
 */
class Product
{
    /**
     * @var string
     *
     * id
     */
    protected $id;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * Get Id
     *
     * @return string Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param string $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Name
     *
     * @return mixed Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param mixed $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
```

We want to manage the translations of both properties. Important, each project
needs to define what fields must be translatable, this is not related to the
component itself.

## EntityTranslationProvider

The translation provider is responsible to connect with the persistent layer and
provide the results, using an specific format, to the managers and services.

``` php
/**
 * Interface EntityTranslationProviderInterface
 */
interface EntityTranslationProviderInterface
{
    /**
     * Get translation
     *
     * @param string $entityType  Type of entity
     * @param string $entityId    Id of entity
     * @param string $entityField Field of entity
     * @param string $locale      Locale
     *
     * @return string Value fetched
     */
    public function getTranslation(
        $entityType,
        $entityId,
        $entityField,
        $locale
    );

    /**
     * Set translation
     *
     * @param string $entityType       Type of entity
     * @param string $entityId         Id of entity
     * @param string $entityField      Field of entity
     * @param string $translationValue Translated value
     * @param string $locale           Locale
     *
     * @return string Value fetched
     */
    public function setTranslation(
        $entityType,
        $entityId,
        $entityField,
        $translationValue,
        $locale
    );

    /**
     * Flush all previously set translations.
     *
     * @return $this self Object
     */
    public function flushTranslations();
}
```

There is the possibility of using specific providers for some specific
decorations, for example, the `CachedEntityTranslationProvider` implementation,
that decorates the main provider by adding an extra cache layer.

## EntityTranslatorBuilder

Translation configuration is not set on the fly. It means that a Translator
needs to know what entities and what fields must take in account for
translations.

For that reason we need to build the translator using a TranslatorBuilder.

``` php
$entityTranslationProvider;
$entityTranslatorFactory = new TranslatorFactory();
$entityTranslator = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslator', array(), array(), '', false);

$configuration = array(
    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct' => array(
        'alias'  => 'product',
        'idGetter' => 'getId',
        'fields' => array(
            'name' => array(
                'setter' => 'setName',
                'getter' => 'getName',
            )
        )
    ),
);

$entityTranslatorBuilder = new EntityTranslatorBuilder(
    $entityTranslationProvider,
    $translatorFactory,
    $configuration
);
$entityTranslator = $translatorBuilder->compile();
```

A compiled translator is, somehow, an immutable object. This means that,
internally, can change because of new instances, but externally can only be
accessed by getters.

## EntityTranslator

The translator itself. This implementation enables you to work with entities
instead of translations.

``` php
/**
 * Interface EntityTranslatorInterface
 */
interface EntityTranslatorInterface
{
    /**
     * Translate object
     *
     * @param Object $object Object
     * @param string $locale Locale to be translated
     */
    public function translate($object, $locale);

    /**
     * Saves object translations
     *
     * @param Object $object       Object
     * @param array  $translations Translations
     */
    public function save($object, array $translations);
}
```

Using the same configuration than before, lets see an example about how we can
manage our entity translations using this service.

``` php
$product = new TranslatableProduct();
$product
    ->setId(1)
    ->setName('productName');

$entityTranslator->save($product, array(
    'es' => array(
        'name' => 'el nombre',
        'description' => 'la descripción',
    ),
    'en' => array(
        'name' => 'the name',
        'description' => 'the description',
        'anotherfield' => 'some value',
    ),
));

/**
 * At this point, all the data have been persisted to database and cached.
 * As you can see, the `translate` method returns the translated object, but
 * both objects are the same
 */

$translatedProduct = $translator->translate($product, 'en');

$translatedName = $translatedProduct->getName();
echo $translatedName;
// = "the name"

/**
 * So because both object are the same, you can just apply the translation
 * without using the returned object
 */

$translator->translate($product, 'es');

$translatedName = $product->getName();
echo $translatedName;
// = "el nombre"

```

To when you save all the translations of an entity, the `EntityTranslator` will
make a unique flush to the persistence layer, in order to improve this action.

## Documentation

Check the documentation in [Elcodi Docs](http://docs.elcodi.io). Feel free to
propose new recipes, examples or guides; our main goal is to help the developer
building their site.

## Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit
* Use last stable version tag to stay in a stable release.

## Contributing

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
