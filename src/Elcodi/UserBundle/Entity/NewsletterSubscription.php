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

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Language;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * NewsletterSubscription
 */
class NewsletterSubscription extends AbstractEntity
{

    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayCollection
     */
    protected $customer;

    /**
     * @var ArrayCollection
     */
    protected $language;

    /**
     * @var String
     */
    protected $hash;

    /**
     * @var string
     */
    protected $reason;

    /**
     * Set email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
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

    /**
     * Set Delivery Address
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set Language
     *
     * @param Language $language
     *
     * @return $this
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return LanguageInterface
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the unsubscribe reason
     *
     * @param string $reason
     *
     * @return $this
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get the unsubscribe reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}
