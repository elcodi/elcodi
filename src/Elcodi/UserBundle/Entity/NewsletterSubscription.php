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
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Language;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * NewsletterSubscription
 *
 * @ORM\Entity(repositoryClass="Elcodi\UserBundle\Repository\NewsletterSubscriptionRepository")
 * @ORM\Table(name="newsletter_subscription")
 * @ORM\HasLifecycleCallbacks
 */
class NewsletterSubscription extends AbstractEntity
{

    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true, unique=true)
     */
    protected $email;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="\Elcodi\UserBundle\Entity\Abstracts\AbstractCustomer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $customer;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="\Elcodi\CoreBundle\Entity\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     */
    protected $language;

    /**
     * @var String
     *
     * @ORM\Column(name="hash", type="string", length=64)
     */
    protected $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=64, nullable=true)
     */
    protected $reason;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

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
