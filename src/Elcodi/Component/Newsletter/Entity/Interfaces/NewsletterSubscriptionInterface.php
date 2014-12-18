<?php

/*
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

namespace Elcodi\Component\Newsletter\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setReason($reason);

    /**
     * Get the unsubscribe reason
     *
     * @return string Reason
     */
    public function getReason();
}
