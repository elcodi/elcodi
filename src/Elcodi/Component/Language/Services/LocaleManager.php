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

namespace Elcodi\Component\Language\Services;

use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;
use Elcodi\Component\Language\Entity\Locale;

/**
 * Locale manager service
 *
 * Manages locale
 */
class LocaleManager
{
    /**
     * @var Locale
     *
     * Locale
     */
    protected $locale;

    /**
     * @var string
     *
     * Encoding
     */
    protected $encoding;

    /**
     * @var array
     *
     * Locale information
     */
    protected $localeInfo;

    /**
     * @var array
     *
     * Locale to country associations
     */
    protected $localeCountryAssociations;

    /**
     * @var array
     *
     * Locale to translation associations
     */
    protected $localeTranslationAssociations;

    /**
     * Construct method
     *
     * @param Locale $locale                        Locale
     * @param string $encoding                      Encoding
     * @param array  $localeCountryAssociations     Locale to country associations
     * @param array  $localeTranslationAssociations Locale to translation assocs
     */
    public function __construct(
        Locale $locale,
        $encoding = null,
        $localeCountryAssociations = null,
        $localeTranslationAssociations = null
    )
    {
        $this->locale = $locale;
        $this->encoding = $encoding;
        $this->localeCountryAssociations = $localeCountryAssociations;
        $this->localeTranslationAssociations = $localeTranslationAssociations;
    }

    /**
     * Initialize locale
     *
     * @return $this self Object
     */
    public function initialize()
    {
        setlocale(LC_ALL, $this->locale->getIso() . '.' . $this->encoding);
        $this->localeInfo = localeconv();

        return $this;
    }

    /**
     * Returns current locale
     *
     * @return Locale locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets locale
     *
     * @param LocaleInterface $locale locale
     *
     * @return $this self Object
     */
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;
        $this->initialize();

        return $this;
    }

    /**
     * Returns current encoding
     *
     * @return string encoding
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets encoding
     *
     * @param string $encoding encoding
     *
     * @return $this self Object
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        $this->initialize();

        return $this;
    }

    /**
     * Returns current locale info
     *
     * @return array localeInfo
     */
    public function getIsoInfo()
    {
        return $this->localeInfo;
    }

    /**
     * Returns the ISO code of the country according to locale
     *
     * @return string 2-letter ISO code
     */
    public function getCountryCode()
    {
        $localeIso = $this->locale->getIso();

        if (isset($this->localeCountryAssociations[$localeIso])) {
            return new Locale($this->localeCountryAssociations[$localeIso]);
        }

        $regionLocale = \Locale::getRegion($localeIso);

        return $regionLocale
            ? new Locale($regionLocale)
            : $this->locale;
    }

    /**
     * Returns the locale used to look for translations, which may not be the
     * same as $this->locale
     *
     * @return Locale Locale
     */
    public function getTranslationsLocale()
    {
        $localeIso = $this->locale->getIso();

        if (isset($this->localeTranslationAssociations[$localeIso])) {
            return new Locale($this->localeTranslationAssociations[$localeIso]);
        }

        return $this->locale;
    }
}
