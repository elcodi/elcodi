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

namespace Elcodi\NewsletterBundle\Entity;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\LanguageBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\NewsletterBundle\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * NewsletterSubscription
 */
class NewsletterSubscription extends AbstractEntity implements NewsletterSubscriptionInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Email
     */
    protected $email;

    /**
     * @var CustomerInterface
     *
     * Customer
     */
    protected $customer;

    /**
     * @var LanguageInterface
     *
     * Newsletter subscription language
     */
    protected $language;

    /**
     * @var String
     *
     * Subscription Hash
     */
    protected $hash;

    /**
     * @var string
     *
     * Reason
     */
    protected $reason;

    /**
     * Set email
     *
     * @param string $email Email
     *
     * @return NewsletterSubscription self Object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Return email
     *
     * @return string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Language
     *
     * @param LanguageInterface $language Language
     *
     * @return NewsletterSubscription self Object
     */
    public function setLanguage(LanguageInterface $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return LanguageInterface Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set hash
     *
     * @param string $hash Hash
     *
     * @return NewsletterSubscription self Object
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string Hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the unsubscribe reason
     *
     * @param string $reason Reason
     *
     * @return NewsletterSubscription self Object
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get the unsubscribe reason
     *
     * @return string Reason
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Returns a string representation of the class
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getEmail();
    }
}
