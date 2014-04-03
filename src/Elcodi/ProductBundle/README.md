ProductBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/ProductBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiProductBundle Bundle
 */
```

### Services

``` yml
#
# $this->get('elcodi.core.product.twig.product_extension');
#
elcodi.core.product.twig.product_extension:
    class: Elcodi\ProductBundle\Twig\ProductExtension
    scope: container
    arguments:
      - languages: %elcodi.core.product.product_display_name%
      - translator: @translator
    tags:
      - { name: twig.extension }    
    calls:
      - [setRequest, [request]]    

#
# $this->get('elcodi.core.product.twig.category_extension');
#
elcodi.core.product.twig.category_extension:
    class: Elcodi\ProductBundle\Twig\CategoryExtension
    scope: container
    tags:
      - { name: twig.extension }    

#
# $this->get('elcodi.core.product.transformers.product_transformer');
#
elcodi.core.product.transformers.product_transformer:
    class: Elcodi\ProductBundle\Transformers\ProductTransformer
    scope: container
    arguments:
      - doctrine: @doctrine
      - model: ElcodiProductBundle:Product
    calls:
      - [setPropertyAccessor, [fos_elastica.property_accessor]]    
      - [setRequest, [request]]    
      - [setLogger, [logger]]    

#
# $this->get('elcodi.core.product.transformers.shop_transformer');
#
elcodi.core.product.transformers.shop_transformer:
    class: Elcodi\ProductBundle\Transformers\ShopTransformer
    scope: container
    arguments:
      - doctrine: @doctrine
      - model: ElcodiProductBundle:Shop
    calls:
      - [setPropertyAccessor, [fos_elastica.property_accessor]]    
      - [setRequest, [request]]    
      - [setLogger, [logger]]    

#
# $this->get('elcodi.core.product.transformers.category_transformer');
#
elcodi.core.product.transformers.category_transformer:
    class: %elcodi.core.core.transformers.translatable.class%
    scope: container
    arguments:
      - doctrine: @doctrine
      - model: ElcodiProductBundle:Category
    calls:
      - [setPropertyAccessor, [fos_elastica.property_accessor]]    
      - [setRequest, [request]]    
      - [setLogger, [logger]]    

#
# $this->get('elcodi.core.product.transformers.country_transformer');
#
elcodi.core.product.transformers.country_transformer:
    class: %elcodi.core.core.transformers.translatable.class%
    scope: container
    arguments:
      - doctrine: @doctrine
      - model: ElcodiGeoBundle:Country
    calls:
      - [setPropertyAccessor, [fos_elastica.property_accessor]]    
      - [setRequest, [request]]    
      - [setLogger, [logger]]    

#
# $this->get('elcodi.core.product.services.product_manager');
#
# public setProductScoreListener($productScoreListener)
# public storeCategoryHierarchy($product, $flush)
# public updateManufacturerProductScoring($manufacturer)
#
elcodi.core.product.services.product_manager:
    class: Elcodi\ProductBundle\Services\ProductManager
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager

#
# $this->get('elcodi.core.product.services.category_manager');
#
# public setLoadOnlyCategoriesWithProducts($loadOnlyCategoriesWithProducts)
# public load()
# public buildCategoryTree()
# public getCategoryTree()
# public setEntityManager($entityManager)
# public setCache($cache)
# public setRequest($request)
# public setKey($key)
# public getLocale()
# public emptyCurrent()
# public emptyAll()
#
elcodi.core.product.services.category_manager:
    class: Elcodi\ProductBundle\Services\CategoryManager
    scope: container
    calls:
      - [setKey, [%elcodi.core.product.menu_cache_key%]]
      - [setLoadOnlyCategoriesWithProducts, [%elcodi.core.product.load_only_categories_with_products%]]
      - [load, []]    

#
# $this->get('elcodi.core.product.services.product_collection_provider');
#
# public getHomeProducts($limit)
# public getOfferProducts($limit)
#
elcodi.core.product.services.product_collection_provider:
    class: Elcodi\ProductBundle\Services\ProductCollectionProvider
    scope: container
    arguments:
      - product_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiProductBundle:Product")
      - locale: %locale%

#
# $this->get('elcodi.core.product.services.attribute_manager');
#
# public getAttributeValueFromItemByAttributeName($item, $name)
#
elcodi.core.product.services.attribute_manager:
    class: Elcodi\ProductBundle\Services\AttributeManager
    scope: container

#
# $this->get('elcodi.core.product.form_types.attribute');
#
elcodi.core.product.form_types.attribute:
    class: Elcodi\ProductBundle\Form\Type\AttributeType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_attribute }

#
# $this->get('elcodi.core.product.form_types.attribute_type');
#
elcodi.core.product.form_types.attribute_type:
    class: Elcodi\ProductBundle\Form\Type\AttributeTypeType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_attribute_type }

#
# $this->get('elcodi.core.product.form_types.category');
#
elcodi.core.product.form_types.category:
    class: Elcodi\ProductBundle\Form\Type\CategoryType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_category }

#
# $this->get('elcodi.core.product.form_types.colorvalue');
#
elcodi.core.product.form_types.colorvalue:
    class: Elcodi\ProductBundle\Form\Type\ColorValueType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_colorvalue }

#
# $this->get('elcodi.core.product.form_types.customizable_field');
#
elcodi.core.product.form_types.customizable_field:
    class: Elcodi\ProductBundle\Form\Type\CustomizableFieldType
    scope: container
    arguments:
      - security_context: @security.context
    tags:
      - { name: form.type, alias: elcodi_core_form_types_customizable_field }

#
# $this->get('elcodi.core.product.form_types.item');
#
elcodi.core.product.form_types.item:
    class: Elcodi\ProductBundle\Form\Type\ItemType
    scope: container
    arguments:
      - security_context: @security.context
      - entity.manager: @doctrine.orm.entity_manager
      - router: @router
    tags:
      - { name: form.type, alias: elcodi_core_form_types_item }

#
# $this->get('elcodi.core.product.form_types.manufacturer');
#
elcodi.core.product.form_types.manufacturer:
    class: Elcodi\ProductBundle\Form\Type\ManufacturerType
    scope: container
    arguments:
      - manufacturer_choice_segments_options: %elcodi.core.product.manufacturer_choice_segments_options%
    tags:
      - { name: form.type, alias: elcodi_core_form_types_manufacturer }

#
# $this->get('elcodi.core.product.form_types.product');
#
elcodi.core.product.form_types.product:
    class: Elcodi\ProductBundle\Form\Type\ProductType
    scope: container
    arguments:
      - security_context: @security.context
      - entity.manager: @doctrine.orm.entity_manager
      - router: @router
    tags:
      - { name: form.type, alias: elcodi_core_form_types_product }

#
# $this->get('elcodi.core.product.form_types.shop');
#
elcodi.core.product.form_types.shop:
    class: Elcodi\ProductBundle\Form\Type\ShopType
    scope: container
    arguments:
      - security_context: @security.context
    tags:
      - { name: form.type, alias: elcodi_core_form_types_shop }

#
# $this->get('elcodi.core.product.form_types.tag');
#
elcodi.core.product.form_types.tag:
    class: Elcodi\ProductBundle\Form\Type\TagType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_tag }

#
# $this->get('elcodi.core.product.form_types.value');
#
elcodi.core.product.form_types.value:
    class: Elcodi\ProductBundle\Form\Type\ValueType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_value }

```

### Entities
####CustomizableField.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/CustomizableField.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\CustomizableFieldRepository")
 * @ORM\Table(name="customizable_fields")
 * @ORM\HasLifecycleCallbacks
 */
class CustomizableField
{
}
```

####CategoryTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/CategoryTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class CategoryTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="categories_translations")
 */
class CategoryTranslation
{
}
```

####SingleChoiceAttribute.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/SingleChoiceAttribute.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Single Choice Attribute
 *
 * @ORM\Entity
 * @ORM\Table(name="single_choice_attributes")
 */
class SingleChoiceAttribute
{
}
```

####Value.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Value.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * AbstractValue
 *
 * An attribute is a generic feature that helps define item combinations
 *
 * This entity is part of a STI ( Single Table Inheritance )
 *
 * @link http://martinfowler.com/eaaCatalog/singleTableInheritance.html
 * @link http://docs.doctrine-project.org/en/2.0.x/reference/inheritance-mapping.html
 *
 * @method \Elcodi\ProductBundle\Entity\ValueTranslation translate($locale = null)
 * @method Value setName(string $name)
 * @method string getName()
 * @method Value setDescription(string $descripion)
 * @method string getDescription()
 *
 * @ORM\Entity
 * @ORM\Table(name="`values`")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\ValueRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Value
{
}
```

####Shop.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Shop.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Shop
 *
 * @method \Elcodi\ProductBundle\Entity\ShopTranslation translate($lang)
 * @method Shop setDescription(string $description)
 * @method string getDescription()
 * @method Shop setOwnerQuote(string $ownerQuote)
 * @method string getOwnerQuote()
 *
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\ShopRepository")
 * @ORM\Table(name="shops")
 * @ORM\HasLifecycleCallbacks
 */
class Shop
{
}
```

####AttributeTypeTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/AttributeTypeTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class AttributeTypeTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="attribute_types_translations")
 */
class AttributeTypeTranslation
{
}
```

####AttributeTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/AttributeTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class AttributeTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="attributes_translations")
 */
class AttributeTranslation
{
}
```

####ColorValue.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ColorValue.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Color Values
 *
 * @ORM\Entity
 * @ORM\Table(name="color_values")
 * @ORM\HasLifecycleCallbacks
 */
class ColorValue
{
}
```

####Attribute.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Attribute.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * AbstractAttribute
 *
 * An attribute is a generic feature that helps define item combinations
 *
 * This entity is part of a STI ( Single Table Inheritance )
 *
 * @link http://martinfowler.com/eaaCatalog/singleTableInheritance.html
 * @link http://docs.doctrine-project.org/en/2.0.x/reference/inheritance-mapping.html
 *
 * @method \Elcodi\ProductBundle\Entity\AttributeTranslation translate($locale = null)
 * @method Attribute setName(string $name)
 * @method string getName()
 *
 * @ORM\Entity
 * @ORM\Table(name="attributes")
 *
 * ORM\InheritanceType("SINGLE_TABLE")
 * ORM\DiscriminatorColumn(name="type", type="string")
 * ORM\DiscriminatorMap({"default"       = "Attribute",
 *                        "single_choice" = "SingleChoiceAttribute",
 *                        "multi_choice"  = "MultiChoiceAttribute",
 *                        "color_choice"  = "ColorAttribute"
 * })
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\AttributeRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Attribute
{
}
```

####MultiChoiceAttribute.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/MultiChoiceAttribute.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Single Choice Attribute
 *
 * @ORM\Entity
 * @ORM\Table(name="multi_choice_attributes")
 */
class MultiChoiceAttribute
{
}
```

####Category.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Category.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Category
 *
 * @method \Elcodi\ProductBundle\Entity\CategoryTranslation translate($lang)
 *
 * @method Category setName(string $name)
 * @method string getName()
 * @method Category setSlug(string $slug)
 * @method string getSlug()
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 * @ORM\HasLifecycleCallbacks
 */
class Category
{
}
```

####ValueTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ValueTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class ValueTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="values_translations")
 */
class ValueTranslation
{
}
```

####ColorAttribute.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ColorAttribute.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Single Choice Attribute
 *
 * @ORM\Entity
 * @ORM\Table(name="color_attributes")
 */
class ColorAttribute
{
}
```

####Product.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Product.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Product entity
 *
 * @method \Elcodi\ProductBundle\Entity\ProductTranslation translate($lang = null)
 * @method Product setName(\string $type)
 * @method string getName()
 * @method Product setDescription(\string $description)
 * @method string getDescription()
 * @method Product setShortDescription(\string $shortDescription)
 * @method string getShortDescription()
 * @method Product setMetaDescription(\string $metaDescription)
 * @method string getMetaDescription()
 * @method Product setMetaKeywords(\string $metaKeywords)
 * @method string getMetaKeywords()
 * @method Product setMetaTitle(\string $metaTitle)
 * @method string getMetaTitle()
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\ProductRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
}
```

####Traits/TopCategoriesTrait.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Traits/TopCategoriesTrait.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity\Traits;

/**
* trait for entities that should extract their
* products top categories/universes
*/
trait TopCategoriesTrait
{
}
```

####ShopTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ShopTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class ShopTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="shops_translations")
 */
class ShopTranslation
{
}
```

####Manufacturer.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Manufacturer.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Manufacturer
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\ManufacturerRepository")
 * @ORM\Table(name="manufacturers")
 * @ORM\HasLifecycleCallbacks
 */
class Manufacturer
{
}
```

####Item.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Item.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Item
 *
 * @method Item setName(string $name)
 * @method string getName()
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 */
class Item
{
}
```

####ItemTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ItemTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class ItemTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="items_translations")
 */
class ItemTranslation
{
}
```

####Tag.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/Tag.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Tag
 *
 * @method Tag setName(string $name)
 * @method string getName()
 *
 * @ORM\Entity(repositoryClass="Elcodi\ProductBundle\Repository\TagRepository")
 * @ORM\Table(name="tags")
 * @ORM\HasLifecycleCallbacks
 */
class Tag
{
}
```

####ProductTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/ProductTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class ProductTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="products_translations")
 */
class ProductTranslation
{
}
```

####AttributeType.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/AttributeType.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * AttributeType
 *
 * An attribute type tells the type of an item feature
 * (single-value attribute, multi-value attribute, etc)
 *
 * It is used to aid the process of associating items to
 * attributes depending on their nature
 *
 * @method AttributeType setName(string $name)
 * @method string getName()
 *
 * @ORM\Entity
 * @ORM\Table(name="attribute_types")
 *
 * @ORM\HasLifecycleCallbacks
 */
class AttributeType
{
}
```

####CustomizableFieldTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/CustomizableFieldTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class CountryTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="customizable_fields_translations")
 */
class CustomizableFieldTranslation
{
}
```

####TagTranslation.php

> [View file](src/Elcodi/Bundles/Core/ProductBundle/Entity/TagTranslation.php) - [Back to bundle](#productbundle) - [Back to index](#table-of-contents)

``` php
<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity;

/**
 * Class TagTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="tags_translations")
 */
class TagTranslation
{
}
```


