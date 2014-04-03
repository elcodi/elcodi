UserBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/UserBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiUserBundle Bundle
 */
```
### Exceptions
####NewsletterCannotBeAddedException.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Exception/NewsletterCannotBeAddedException.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Exception;

/**
 * Custom NewsletterCannotBeAddedException
 */
class NewsletterCannotBeAddedException
{
}
```

####NewsletterCannotBeRemovedException.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Exception/NewsletterCannotBeRemovedException.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Exception;

/**
 * Custom NewsletterCannotBeRemovedException
 */
class NewsletterCannotBeRemovedException
{
}
```

####Abstracts/AbstractNewsletterException.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Exception/Abstracts/AbstractNewsletterException.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Exception\Abstracts;

/**
 * Custom AbstractNewsletterException
 */
abstract class AbstractNewsletterException
{
}
```


### Services

``` yml
#
# $this->get('elcodi.core.user.services.newsletter_manager');
#
# public subscribe($email, $language)
# public unSubscribe($email, $hash, $reason)
# public isSubscribed($email)
# public getSubscription($email)
#
elcodi.core.user.services.newsletter_manager:
    class: Elcodi\UserBundle\Services\NewsletterManager
    scope: container
    arguments:
      - customer_wrapper: @elcodi.core.user.wrapper.customer_wrapper
      - entity_manager: @doctrine.orm.entity_manager
      - event_dispatcher: @event_dispatcher
      - validator: @validator

#
# $this->get('elcodi.core.user.services.password_manager');
#
# public rememberPasswordByEmail($email, $recoverPasswordUrlName, $customerIdField, $hashField, $recoveryHash)
# public rememberPassword($user, $recoverPasswordUrlName, $customerIdField, $hashField, $recoveryHashFunction)
# public recoverPassword($user, $hash, $newPassword)
#
elcodi.core.user.services.password_manager:
    class: Elcodi\UserBundle\Services\PasswordManager
    scope: container
    arguments:
      - entity_manager: @doctrine.orm.entity_manager
      - router: @router
      - event_dispatcher: @event_dispatcher
      - customer_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiUserBundle:Customer")

#
# $this->get('elcodi.core.user.services.web_user_manager');
#
# public register($user, $providerKey)
#
elcodi.core.user.services.web_user_manager:
    class: Elcodi\UserBundle\Services\WebUserManager
    scope: container
    arguments:
      - event_dispatcher: @event_dispatcher
      - security_context: @security.context

#
# $this->get('elcodi.core.user.wrapper.customer_wrapper');
#
elcodi.core.user.wrapper.customer_wrapper:
    class: Elcodi\UserBundle\Wrapper\CustomerWrapper
    scope: container
    arguments:
      - security_context: @security.context
      - entity_manager: @doctrine.orm.entity_manager
      - session: @session

#
# $this->get('elcodi.core.user.form_types.customer');
#
elcodi.core.user.form_types.customer:
    class: Elcodi\UserBundle\Form\Type\CustomerType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_customer }

#
# $this->get('elcodi.core.user.form_types.shopadminuser');
#
elcodi.core.user.form_types.shopadminuser:
    class: Elcodi\UserBundle\Form\Type\ShopAdminUserType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_shopadminuser }

#
# $this->get('elcodi.core.user.form_types.superadminuser');
#
elcodi.core.user.form_types.superadminuser:
    class: Elcodi\UserBundle\Form\Type\SuperAdminUserType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_superadminuser }

#
# $this->get('elcodi.core.user.event_listener.password');
#
elcodi.core.user.event_listener.password:
    class: Elcodi\UserBundle\EventListener\PasswordEventListener
    scope: container
    arguments:
      - encoder_blowfish: @security.encoder.blowfish
    tags:
      - { name: doctrine.event_listener, event: preUpdate, method: preUpdate }      - { name: doctrine.event_listener, event: prePersist, method: prePersist }    

```

### Entities
####Interfaces/GettableUserInterface.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Interfaces/GettableUserInterface.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity\Interfaces;

/**
 * GettableUserInterface.
 *
 * Provides that an implementing class can return a single UserInterface object
 */
class GettableUserInterface
{
}
```

####Interfaces/GettableUsersInterface.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Interfaces/GettableUsersInterface.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity\Interfaces;

/**
 * GettableUsersInterface.
 *
 * Provides that an implementing class can return a Doctrine collection, supposedly of UserInterface objects
 */
class GettableUsersInterface
{
}
```

####Customer.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Customer.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity;

/**
 * Customer
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks
 */
class Customer
{
}
```

####SuperAdminUser.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/SuperAdminUser.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity;

/**
 * Super admin user
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\SuperAdminUserRepository")
 * @ORM\Table(name="super_admin_users")
 */
class SuperAdminUser
{
}
```

####Abstracts/AbstractUser.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Abstracts/AbstractUser.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity\Abstracts;

/**
 * AbstractUser
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass
 */
abstract class AbstractUser
{
}
```

####Abstracts/AbstractCustomer.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Abstracts/AbstractCustomer.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity\Abstracts;

/**
 * Base Web User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "customer" = "\Elcodi\UserBundle\Entity\Customer",
 *      "seller_customer" = "\Elcodi\UserBundle\Entity\SellerCustomer"
 * })
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractCustomer
{
}
```

####Abstracts/AbstractAdminUser.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/Abstracts/AbstractAdminUser.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity\Abstracts;

/**
 * Shop Admin User
 *
 * @ORM\Entity
 * @ORM\Table(name="admin_users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "superadmin" = "\Elcodi\UserBundle\Entity\SuperAdminUser",
 *      "shopadmin" = "\Elcodi\UserBundle\Entity\ShopAdminUser"
 * })
 * @UniqueEntity("email")
 */
abstract class AbstractAdminUser
{
}
```

####NewsletterSubscription.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/NewsletterSubscription.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity;

/**
 * NewsletterSubscription
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\NewsletterSubscriptionRepository")
 * @ORM\Table(name="newsletter_subscription")
 * @ORM\HasLifecycleCallbacks
 */
class NewsletterSubscription
{
}
```

####SellerCustomer.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/SellerCustomer.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity;

/**
 * Seller Customer
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\SellerCustomerRepository")
 * @ORM\Table(name="seller_customers")
 * @ORM\HasLifecycleCallbacks
 */
class SellerCustomer
{
}
```

####ShopAdminUser.php

> [View file](src/Elcodi/Bundles/Core/UserBundle/Entity/ShopAdminUser.php) - [Back to bundle](#userbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\UserBundle\Entity;

/**
 * Shop admin user
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\ShopAdminUserRepository")
 * @ORM\Table(name="shop_admin_users")
 */
class ShopAdminUser
{
}
```


