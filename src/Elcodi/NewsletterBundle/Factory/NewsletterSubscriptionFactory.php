<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\NewsletterBundle\Factory;

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
            ->setEnabled(true);

        return $newsletterSubscription;
    }
}
