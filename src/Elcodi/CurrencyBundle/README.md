CurrencyBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/CurrencyBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiCurrencyBundle Bundle
 */
```

### Services

``` yml
#
# $this->get('elcodi.core.currency.manager.currency_manager');
#
elcodi.core.currency.manager.currency_manager:
    class: Elcodi\CurrencyBundle\Manager\CurrencyManager
    scope: container
    arguments:
      - currency_repo: service('doctrine').getRepository(parameter('elcodi.core.currency.entity.currency.class'))
      - exchange_rates_repo: service('doctrine').getRepository(parameter('elcodi.core.currency.entity.currency_exchange_rate.class'))

#
# $this->get('elcodi.core.currency.service.exchange_rates_provider');
#
elcodi.core.currency.service.exchange_rates_provider:
    class: Elcodi\CurrencyBundle\Provider\OpenExchangeRatesProvider
    scope: container
    arguments:
      - open_exchange_rates_service: @open_exchange_rates_service

#
# $this->get('elcodi.core.currency.form_types.currency');
#
elcodi.core.currency.form_types.currency:
    class: Elcodi\CurrencyBundle\Form\Type\CurrencyType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_currency }

#
# $this->get('elcodi.core.currency.factory.currency');
#
elcodi.core.currency.factory.currency:
    class: Elcodi\CurrencyBundle\Factory\CurrencyFactory
    scope: container

#
# $this->get('elcodi.core.currency.factory.currency_exchange_rate');
#
elcodi.core.currency.factory.currency_exchange_rate:
    class: Elcodi\CurrencyBundle\Factory\CurrencyExchangeRateFactory
    scope: container

#
# $this->get('elcodi.core.currency.twig.print_price');
#
elcodi.core.currency.twig.print_price:
    class: Elcodi\CurrencyBundle\Twig\PrintPriceExtension
    scope: container
    arguments:
      - exchange_rates: service('elcodi.core.currency.manager.currency_manager').getExchangeRateList(parameter('elcodi.core.currency.default_currency'))
      - currency_symbols: service('elcodi.core.currency.manager.currency_manager').getSymbols()
      - locale_manager: service('elcodi.core.core.services.locale_manager').getLocale()
    tags:
      - { name: twig.extension }    

```

### Entities
####Interfaces/CurrencyInterface.php

> [View file](src/Elcodi/Bundles/Core/CurrencyBundle/Entity/Interfaces/CurrencyInterface.php) - [Back to bundle](#currencybundle) - [Back to index](#table-of-contents)

``` php
<?php

namespace Elcodi\CurrencyBundle\Entity\Interfaces;

/**
 * Interface CurrencyInterface
 *
 * @package Elcodi\CurrencyBundle\Entity\Interfaces
 */
class CurrencyInterface
{
}
```

####Interfaces/CurrencyExchangeRateInterface.php

> [View file](src/Elcodi/Bundles/Core/CurrencyBundle/Entity/Interfaces/CurrencyExchangeRateInterface.php) - [Back to bundle](#currencybundle) - [Back to index](#table-of-contents)

``` php
<?php

namespace Elcodi\CurrencyBundle\Entity\Interfaces;

/**
 * Interface CurrencyExchangeRateInterface
 *
 * @package Elcodi\CurrencyBundle\Entity\Interfaces
 */
class CurrencyExchangeRateInterface
{
}
```

####Currency.php

> [View file](src/Elcodi/Bundles/Core/CurrencyBundle/Entity/Currency.php) - [Back to bundle](#currencybundle) - [Back to index](#table-of-contents)

``` php
<?php

namespace Elcodi\CurrencyBundle\Entity;

/**
 * Currency
 */
class Currency
{
}
```

####CurrencyExchangeRate.php

> [View file](src/Elcodi/Bundles/Core/CurrencyBundle/Entity/CurrencyExchangeRate.php) - [Back to bundle](#currencybundle) - [Back to index](#table-of-contents)

``` php
<?php

namespace Elcodi\CurrencyBundle\Entity;

/**
 * Class CurrencyExchangeRate
 *
 * @package Elcodi\CurrencyBundle\Entity
 */
class CurrencyExchangeRate
{
}
```


