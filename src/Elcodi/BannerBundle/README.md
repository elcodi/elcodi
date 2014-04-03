BannerBundle
-----
>[View bundle](src/Elcodi/Bundles/Core/BannerBundle) - [Back to index](#table-of-contents)

``` php
/**
 * ElcodiBannerBundle Bundle
 */
```

### Services

``` yml
#
# $this->get('elcodi.core.banner.services.banner_manager');
#
# public getBannersFromBannerZoneCode($bannerZoneCode, $language)
# public getBannersFromBannerZone($bannerZone, $language)
#
elcodi.core.banner.services.banner_manager:
    class: Elcodi\BannerBundle\Services\BannerManager
    scope: container
    arguments:
      - banner_zone_repository: service("doctrine.orm.entity_manager").getRepository("ElcodiBannerBundle:BannerZone")

#
# $this->get('elcodi.core.banner.form_types.banner');
#
elcodi.core.banner.form_types.banner:
    class: Elcodi\BannerBundle\Form\Type\BannerType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_banner }

#
# $this->get('elcodi.core.banner.form_types.bannerzone');
#
elcodi.core.banner.form_types.bannerzone:
    class: Elcodi\BannerBundle\Form\Type\BannerZoneType
    scope: container
    tags:
      - { name: form.type, alias: elcodi_core_form_types_bannerzone }

```

### Entities
####BannerZone.php

> [View file](src/Elcodi/Bundles/Core/BannerBundle/Entity/BannerZone.php) - [Back to bundle](#bannerbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\BannerBundle\Entity;

/**
 * BannerZone
 *
 * @ORM\Entity(repositoryClass="Elcodi\BannerBundle\Repository\BannerZoneRepository")
 * @ORM\Table(name="banner_zones", uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name = "search_idx",
 *          columns = {"code", "language_id"}
 *      )
 * })
 * @ORM\HasLifecycleCallbacks
 */
class BannerZone
{
}
```

####Interfaces/BannerInterface.php

> [View file](src/Elcodi/Bundles/Core/BannerBundle/Entity/Interfaces/BannerInterface.php) - [Back to bundle](#bannerbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\BannerBundle\Entity\Interfaces;

/**
 * BannerInterface
 */
class BannerInterface
{
}
```

####Interfaces/BannerZoneInterface.php

> [View file](src/Elcodi/Bundles/Core/BannerBundle/Entity/Interfaces/BannerZoneInterface.php) - [Back to bundle](#bannerbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\BannerBundle\Entity\Interfaces;

/**
 * BannerZoneInterface
 */
class BannerZoneInterface
{
}
```

####Banner.php

> [View file](src/Elcodi/Bundles/Core/BannerBundle/Entity/Banner.php) - [Back to bundle](#bannerbundle) - [Back to index](#table-of-contents)

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

namespace Elcodi\BannerBundle\Entity;

/**
 * Banner
 *
 * @ORM\Entity(repositoryClass="Elcodi\BannerBundle\Repository\BannerRepository")
 * @ORM\Table(name="banners")
 * @ORM\HasLifecycleCallbacks
 */
class Banner
{
}
```


