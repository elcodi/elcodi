<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Newsletter\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class NewsletterSubscription.
 */
class NewsletterSubscription implements NewsletterSubscriptionInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait;

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
     * @var string
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
     * Set email.
     *
     * @param string $email Email
     *
     * @return $this Self object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Return email.
     *
     * @return string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Language.
     *
     * @param LanguageInterface $language Language
     *
     * @return $this Self object
     */
    public function setLanguage(LanguageInterface $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return LanguageInterface Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set hash.
     *
     * @param string $hash Hash
     *
     * @return $this Self object
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash.
     *
     * @return string Hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the unsubscribe reason.
     *
     * @param string $reason Reason
     *
     * @return $this Self object
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get the unsubscribe reason.
     *
     * @return string Reason
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Returns a string representation of the class.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getEmail();
    }
}
