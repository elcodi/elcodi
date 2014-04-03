ReferralProgramBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/ReferralProgramBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ReferralProgram Bundle
 */
```

### Services

``` yml
#
# $this->get('elcodi.core.referral_program.services.referral_program_manager');
#
# public invite($referrer, $invitedEmails)
# public resolve($customer, $hash)
#
elcodi.core.referral_program.services.referral_program_manager:
    class: Elcodi\ReferralProgramBundle\Services\ReferralProgramManager
    scope: container
    arguments:
      - event_dispatcher: @event_dispatcher
      - referral_rule_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiReferralProgramBundle:ReferralRule")
      - referral_line_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiReferralProgramBundle:ReferralLine")
      - entity_manager: @doctrine.orm.default_entity_manager
      - referral_route_manager: @elcodi.core.referral_program.services.referral_route_manager
      - referral_hash_manager: @elcodi.core.referral_program.services.referral_hash_manager

#
# $this->get('elcodi.core.referral_program.services.referral_route_manager');
#
# public generateControllerRoute($referralHash)
#
elcodi.core.referral_program.services.referral_route_manager:
    class: Elcodi\ReferralProgramBundle\Services\ReferralRouteManager
    scope: container
    arguments:
      - router: @router
      - controller_route_name: %elcodi.core.referral_program.controller.route.name%

#
# $this->get('elcodi.core.referral_program.services.referral_hash_manager');
#
# public getReferralHashByCustomer($customer)
# public getReferralHashByHash($hash)
#
elcodi.core.referral_program.services.referral_hash_manager:
    class: Elcodi\ReferralProgramBundle\Services\ReferralHashManager
    scope: container
    arguments:
      - referral_hash_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiReferralProgramBundle:ReferralHash")
      - entity_manager: @doctrine.orm.default_entity_manager
      - referral_hash_generator: @elcodi.core.referral_program.generator.hash_generator

#
# $this->get('elcodi.core.referral_program.services.referral_coupon_manager');
#
# public checkCouponAssignment($customer, $hash, $type)
# public checkCouponsUsed($customer, $coupons)
#
elcodi.core.referral_program.services.referral_coupon_manager:
    class: Elcodi\ReferralProgramBundle\Services\ReferralCouponManager
    scope: container
    arguments:
      - event_dispatcher: @event_dispatcher
      - referral_program_manager: @elcodi.core.referral_program.services.referral_program_manager
      - entity_manager: @doctrine.orm.default_entity_manager
      - coupon_manager: @elcodi.core.coupon.services.coupon_manager
      - referral_line_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiReferralProgramBundle:ReferralLine")
      - referral_hash_manager: @elcodi.core.referral_program.services.referral_hash_manager

#
# $this->get('elcodi.core.referral_program.services.referral_rule_manager');
#
# public enableReferralRule($referralRule, $enable)
#
elcodi.core.referral_program.services.referral_rule_manager:
    class: Elcodi\ReferralProgramBundle\Services\ReferralRuleManager
    scope: container
    arguments:
      - referral_rule_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiReferralProgramBundle:ReferralRule")
      - entity_manager: @doctrine.orm.default_entity_manager

#
# $this->get('elcodi.core.referral_program.generator.hash_generator');
#
elcodi.core.referral_program.generator.hash_generator:
    class: Elcodi\ReferralProgramBundle\Generator\ReferralHashGenerator
    scope: container

#
# $this->get('elcodi.core.referral_program.routes.loader');
#
elcodi.core.referral_program.routes.loader:
    class: Elcodi\ReferralProgramBundle\Router\ReferralProgramRoutesLoader
    scope: container
    arguments:
      - controller.route.name: %elcodi.core.referral_program.controller.route.name%
      - controller.route: %elcodi.core.referral_program.controller.route%
    tags:
      - { name: routing.loader }    

#
# $this->get('elcodi.core.user.form_types.referralrule');
#
elcodi.core.user.form_types.referralrule:
    class: Elcodi\ReferralProgramBundle\Form\Type\ReferralRuleType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_referralrule }

#
# $this->get('elcodi.core.user.form_types.referralline');
#
elcodi.core.user.form_types.referralline:
    class: Elcodi\ReferralProgramBundle\Form\Type\ReferralLineType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_referralline }

#
# $this->get('elcodi.core.user.form_types.referralhash');
#
elcodi.core.user.form_types.referralhash:
    class: Elcodi\ReferralProgramBundle\Form\Type\ReferralHashType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_referralhash }

#
# $this->get('elcodi.core.user.event_listeners.referral_program_event_listener');
#
elcodi.core.user.event_listeners.referral_program_event_listener:
    class: Elcodi\ReferralProgramBundle\EventListener\ReferralProgramEventListener
    scope: container
    arguments:
      - referral_coupon_manager: @elcodi.core.referral_program.services.referral_coupon_manager
      - request_stack: @request_stack
    tags:
      - { name: kernel.event_listener, event: user.register, method: onUserRegister }      - { name: kernel.event_listener, event: order.created, method: onOrderCreated }    

```

### Entities
####Interfaces/ReferralRuleInterface.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/Interfaces/ReferralRuleInterface.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity\Interfaces;

/**
 * ReferralRule interface
 */
class ReferralRuleInterface
{
}
```

####Interfaces/ReferralLineInterface.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/Interfaces/ReferralLineInterface.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity\Interfaces;

/**
 * ReferralLine interface
 */
class ReferralLineInterface
{
}
```

####Interfaces/ReferralHashInterface.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/Interfaces/ReferralHashInterface.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity\Interfaces;

/**
 * Class ReferralHashInterface
 */
class ReferralHashInterface
{
}
```

####ReferralRule.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/ReferralRule.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity;

/**
 * ReferralRule entity
 *
 * @ORM\Entity(repositoryClass="Elcodi\ReferralProgramBundle\Repository\ReferralRuleRepository")
 * @ORM\Table(name="referral_rules")
 */
class ReferralRule
{
}
```

####ReferralLine.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/ReferralLine.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity;

/**
 * Class ReferralLine
 *
 * @ORM\Entity(repositoryClass="Elcodi\ReferralProgramBundle\Repository\ReferralLineRepository")
 * @ORM\Table(
 *      name = "referral_lines",
 *      uniqueConstraints = {
 *          @ORM\UniqueConstraint(name = "referrer_idx", columns = {"referralhash_id", "invited_email"})
 *      }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ReferralLine
{
}
```

####ReferralHash.php

> [View file](src/Elcodi/Bundles/Core/ReferralProgramBundle/Entity/ReferralHash.php) - [Back to bundle](#referralprogrambundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\ReferralProgramBundle\Entity;

/**
 * Class ReferralHash
 *
 * @ORM\Entity(repositoryClass="Elcodi\ReferralProgramBundle\Repository\ReferralHashRepository")
 * @ORM\Table(name="referral_hashes")
 */
class ReferralHash
{
}
```


