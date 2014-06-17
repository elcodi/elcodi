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

namespace Elcodi\NewsletterBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;
use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;

/**
 * Class NewsletterSubscriptionInterface
 */
interface NewsletterSubscriptionInterface extends DateTimeInterface, EnabledInterface
{
    /**
     * Set email
     *
     * @param string $email Email
     *
     * @return NewsletterSubscriptionInterface self Object
     */
    public function setEmail($email);

    /**
     * Return email
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Set Language
     *
     * @param LanguageInterface $language Language
     *
     * @return NewsletterSubscriptionInterface self Object
     */
    public function setLanguage(LanguageInterface $language = null);

    /**
     * Get language
     *
     * @return LanguageInterface Language
     */
    public function getLanguage();

    /**
     * Set hash
     *
     * @param string $hash Hash
     *
     * @return NewsletterSubscriptionInterface self Object
     */
    public function setHash($hash);

    /**
     * Get hash
     *
     * @return string Hash
     */
    public function getHash();

    /**
     * Set the unsubscribe reason
     *
     * @param string $reason Reason
     *
     * @return NewsletterSubscriptionInterface self Object
     */
    public function setReason($reason);

    /**
     * Get the unsubscribe reason
     *
     * @return string Reason
     */
    public function getReason();
}
