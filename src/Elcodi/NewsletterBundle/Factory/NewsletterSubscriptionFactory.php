<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\NewsletterBundle\Factory;

use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\NewsletterBundle\Entity\NewsletterSubscription;

/**
 * Class NewsletterSubscriptionFactory
 */
class NewsletterSubscriptionFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return NewsletterSubscription Empty entity
     */
    public function create()
    {
        /**
         * @var NewsletterSubscription $newsletterSubscription
         */
        $classNamespace = $this->getEntityNamespace();
        $newsletterSubscription = new $classNamespace();
        $newsletterSubscription
            ->setCreatedAt(new DateTime())
            ->setEnabled(true);

        return $newsletterSubscription;
    }
}
