CoreBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/CoreBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiCoreBundle Bundle
 *
 * This is the core of the suite.
 * All available bundles in this suite could have this bundle as a main
 * dependency.
 */
```

### Services

``` yml
#
# $this->get('elcodi.core.core.twig.text_extension');
#
elcodi.core.core.twig.text_extension:
    class: Elcodi\CoreBundle\Twig\TextExtension
    scope: container
    tags:
      - { name: twig.extension }    

#
# $this->get('elcodi.core.core.twig.price_extension');
#
elcodi.core.core.twig.price_extension:
    class: Elcodi\CoreBundle\Twig\PriceExtension
    scope: container
    arguments:
      - locale.info: service("elcodi.core.core.services.locale_manager").getLocaleInfo()
    tags:
      - { name: twig.extension }    

#
# $this->get('elcodi.core.core.transformers.abstract');
#
elcodi.core.core.transformers.abstract:
    class: Elcodi\CoreBundle\Transformers\Abstracts\AbstractElasticaToModelTransformer
    abstract: true
    scope: container
    calls:
      - [setPropertyAccessor, [fos_elastica.property_accessor]]    
      - [setRequest, [request]]    
      - [setLogger, [logger]]    

#
# $this->get('elcodi.core.core.builders.route_builder');
#
elcodi.core.core.builders.route_builder:
    class: Elcodi\CoreBundle\Builder\AdminRouteBuilder
    scope: container

#
# $this->get('elcodi.core.core.services.abstract_cache_wrapper');
#
elcodi.core.core.services.abstract_cache_wrapper:
    class: Elcodi\CoreBundle\Wrapper\Abstracts\AbstractCacheWrapper
    abstract: true
    scope: container
    calls:
      - [setEntityManager, [doctrine.orm.entity_manager]]    
      - [setCache, [liip_doctrine_cache.ns.elcodi]]
      - [setRequest, [request]]    
      - [setKey, []]    

#
# $this->get('elcodi.core.core.services.language_manager');
#
# public getLanguages()
#
elcodi.core.core.services.language_manager:
    class: Elcodi\CoreBundle\Services\LanguageManager
    scope: container
    arguments:
      - language_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiCoreBundle:Language")

#
# $this->get('elcodi.core.core.services.locale_manager');
#
# public initialize()
# public getLocale()
# public setLocale($locale)
# public getEncoding()
# public setEncoding($encoding)
# public getLocaleInfo()
# public getCountryCode()
# public getTranslationsLocale()
#
elcodi.core.core.services.locale_manager:
    class: Elcodi\CoreBundle\Services\LocaleManager
    scope: container
    arguments:
      - locale: service("request_stack").getCurrentRequest() ? service("request_stack").getCurrentRequest().getLocale() : parameter("locale")
      - encoding: %elcodi.core.core.encoding%
      - locale_country_associations: %elcodi.core.core.locale_country_associations%
      - locale_translation_associations: %elcodi.core.core.locale_translation_associations%
    calls:
      - [initialize, []]    

#
# $this->get('elcodi.core.core.form_types.language');
#
elcodi.core.core.form_types.language:
    class: Elcodi\CoreBundle\Form\Type\LanguageType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_language }

#
# $this->get('elcodi.core.core.param_converters.create_formtype');
#
elcodi.core.core.param_converters.create_formtype:
    class: Elcodi\CoreBundle\Request\ParamConverter\CreateFormTypeParamConverter
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
      - form_factory: @form.factory
      - session: @session
      - translator: @translator
      - form_registry: @form.registry
    tags:
      - { name: request.param_converter, priority: -2, converter: create_formtype_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.create_entity');
#
elcodi.core.core.param_converters.create_entity:
    class: Elcodi\CoreBundle\Request\ParamConverter\CreateEntityParamConverter
    scope: container
    arguments:
      - kernel: @kernel
    tags:
      - { name: request.param_converter, priority: -1, converter: create_entity_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.enable_entity');
#
elcodi.core.core.param_converters.enable_entity:
    class: Elcodi\CoreBundle\Request\ParamConverter\EnableEntityParamConverter
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
    tags:
      - { name: request.param_converter, priority: -1, converter: enable_entity_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.delete_entity');
#
elcodi.core.core.param_converters.delete_entity:
    class: Elcodi\CoreBundle\Request\ParamConverter\DeleteEntityParamConverter
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
    tags:
      - { name: request.param_converter, priority: -1, converter: delete_entity_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.authorize_shop_access');
#
elcodi.core.core.param_converters.authorize_shop_access:
    class: Elcodi\CoreBundle\Request\ParamConverter\AuthorizeShopAccessParamConverter
    scope: container
    arguments:
      - entity_manager: @security.context
    tags:
      - { name: request.param_converter, priority: -1, converter: authorize_shop_access_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.create_filter');
#
elcodi.core.core.param_converters.create_filter:
    class: Elcodi\CoreBundle\Request\ParamConverter\CreateFilterParamConverter
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
    tags:
      - { name: request.param_converter, priority: -1, converter: create_filter_param_converter }    

#
# $this->get('elcodi.core.core.param_converters.create_pagination');
#
elcodi.core.core.param_converters.create_pagination:
    class: Elcodi\CoreBundle\Request\ParamConverter\CreatePaginationParamConverter
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
      - knp_paginator: @knp_paginator
      - admin_route_builder: @elcodi.core.core.builders.route_builder
      - results_per_page: %elcodi.core.core.paginator_number_of_results_per_page%
    tags:
      - { name: request.param_converter, converter: create_pagination_param_converter }    

```

### Entities
####Language.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Language.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity;

/**
 * Currency
 *
 * @ORM\Entity(repositoryClass="Elcodi\CoreBundle\Repository\LanguageRepository")
 * @ORM\Table(name="languages")
 */
class Language
{
}
```

####Traits/ValidIntervalTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/ValidIntervalTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for add Entity valid interval
 */
trait ValidIntervalTrait
{
}
```

####Traits/DateTimeTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/DateTimeTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for DateTime common variables and methods
 */
trait DateTimeTrait
{
}
```

####Traits/EnabledTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/EnabledTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for add Entity enabled funct
 */
trait EnabledTrait
{
}
```

####Traits/ETaggableTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/ETaggableTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for entities that can hash their state and return an ETag header
 */
trait ETaggableTrait
{
}
```

####Traits/TranslatableTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/TranslatableTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * Translatable trait.
 *
 * Should be used inside entity, that needs to be translated.
 */
trait TranslatableTrait
{
}
```

####Traits/MetaDataTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/MetaDataTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for add Meta data
 *
 *
 */
trait MetaDataTrait
{
}
```

####Traits/RevisedTrait.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Traits/RevisedTrait.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Traits;

/**
 * trait for add Entity revised funct
 */
trait RevisedTrait
{
}
```

####Abstracts/AbstractEntity.php

> [View file](src/Elcodi/Bundles/Core/CoreBundle/Entity/Abstracts/AbstractEntity.php) - [Back to bundle](#corebundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CoreBundle\Entity\Abstracts;

/**
 * Base Web User
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 */
abstract class AbstractEntity
{
}
```


