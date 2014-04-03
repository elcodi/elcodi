CouponBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/CouponBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiCouponBundle Bundle
 */
```
### Exceptions
####CouponIncompatibleException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponIncompatibleException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponIncompatibleException
 */
class CouponIncompatibleException
{
}
```

####CouponBelowMinimumPurchaseException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponBelowMinimumPurchaseException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponBelowMinimumPurchaseException
 */
class CouponBelowMinimumPurchaseException
{
}
```

####CouponFreeShippingExistsException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponFreeShippingExistsException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponFreeShippingExistsException
 */
class CouponFreeShippingExistsException
{
}
```

####CouponNotActiveException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponNotActiveException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponNotActiveException
 */
class CouponNotActiveException
{
}
```

####CouponAppliedException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponAppliedException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponAppliedException
 */
class CouponAppliedException
{
}
```

####CouponNotAvailableException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/CouponNotAvailableException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception;

/**
 * Custom CouponNotAvailableException
 */
class CouponNotAvailableException
{
}
```

####Abstracts/AbstractCouponException.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Exception/Abstracts/AbstractCouponException.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Exception\Abstracts;

/**
 * Custom AbstractCouponException
 */
abstract class AbstractCouponException
{
}
```


### Services

``` yml
#
# $this->get('elcodi.core.coupon.services.coupon_manager');
#
# public addCouponToCart($cart, $coupon)
# public removeCouponFromCart($cart, $coupon)
# public checkCouponFromCart($cart, $coupon)
# public checkCustomerCoupon($coupon, $customer)
# public getPriceCouponsShipping($cart)
# public getPriceCoupons($cart)
# public getPriceCoupon($cart, $coupon)
# public duplicateCoupon($coupon, $dateFrom, $couponCodeGenerator)
#
elcodi.core.coupon.services.coupon_manager:
    class: Elcodi\CouponBundle\Services\CouponManager
    scope: container
    arguments:
      - event_dispatcher: @event_dispatcher

#
# $this->get('elcodi.core.coupon.form_types.coupon');
#
elcodi.core.coupon.form_types.coupon:
    class: Elcodi\CouponBundle\Form\Type\CouponType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_coupon }

```

### Entities
####Interfaces/CouponInterface.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Entity/Interfaces/CouponInterface.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Entity\Interfaces;

/**
 * CouponInterface
 */
class CouponInterface
{
}
```

####Coupon.php

> [View file](src/Elcodi/Bundles/Core/CouponBundle/Entity/Coupon.php) - [Back to bundle](#couponbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\CouponBundle\Entity;

/**
 * Coupon
 *
 * @ORM\Entity(repositoryClass="Elcodi\CouponBundle\Repository\CouponRepository")
 * @ORM\Table(name="coupons")
 * @ORM\HasLifecycleCallbacks
 */
class Coupon
{
}
```


