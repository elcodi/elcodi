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

namespace Elcodi\CoreBundle\Services;

/**
 * Locale manager service
 *
 * Manages locale
 */
class LocaleManager
{
    /**
     * @var string
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
     * @param string $locale                        Locale
     * @param string $encoding                      Encoding
     * @param array  $localeCountryAssociations     Locale to country associations
     * @param array  $localeTranslationAssociations Locale to translation assocs
     */
    public function __construct($locale, $encoding = null, $localeCountryAssociations = null, $localeTranslationAssociations = null)
    {
        $this->locale = $locale;
        $this->encoding = $encoding;
        $this->localeCountryAssociations = $localeCountryAssociations;
        $this->localeTranslationAssociations = $localeTranslationAssociations;
    }

    /**
     * Initialize locale
     *
     * @return LocaleManager self object
     */
    public function initialize()
    {
        setlocale(LC_ALL, $this->locale . '.' . $this->encoding);
        $this->localeInfo = localeconv();

        return $this;
    }

    /**
     * Returns current locale
     *
     * @return string locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets locale
     *
     * @param string $locale locale
     *
     * @return LocaleManager self object
     */
    public function setLocale($locale)
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
     * @return LocaleManager self object
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
    public function getLocaleInfo()
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
        if (in_array($this->locale, array_keys($this->localeCountryAssociations))) {
            return $this->localeCountryAssociations[$this->locale];
        }

        return \Locale::getRegion($this->locale) ?: $this->locale;
    }

    /**
     * Returns the locale used to look for translations, which may not be the same as $this->locale
     *
     * @return string
     */
    public function getTranslationsLocale()
    {
        if (in_array($this->locale, array_keys($this->localeTranslationAssociations))) {
            return $this->localeTranslationAssociations[$this->locale];
        }

        return $this->locale;
    }
}
