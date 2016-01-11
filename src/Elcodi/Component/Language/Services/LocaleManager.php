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

namespace Elcodi\Component\Language\Services;

use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;
use Elcodi\Component\Language\Entity\Locale;

/**
 * Locale manager service.
 *
 * Manages locale
 */
class LocaleManager
{
    /**
     * @var LocaleInterface
     *
     * Locale
     */
    private $locale;

    /**
     * @var string
     *
     * Encoding
     */
    private $encoding;

    /**
     * @var array
     *
     * Locale information
     */
    private $localeInfo;

    /**
     * @var array
     *
     * Locale to country associations
     */
    private $localeCountryAssociations;

    /**
     * @var array
     *
     * Locale to translation associations
     */
    private $localeTranslationAssociations;

    /**
     * Construct method.
     *
     * @param LocaleInterface $locale                        Locale
     * @param string          $encoding                      Encoding
     * @param array           $localeCountryAssociations     Locale to country associations
     * @param array           $localeTranslationAssociations Locale to translation assocs
     */
    public function __construct(
        LocaleInterface $locale,
        $encoding = '',
        array $localeCountryAssociations = [],
        array $localeTranslationAssociations = []
    ) {
        $this->locale = $locale;
        $this->encoding = $encoding;
        $this->localeCountryAssociations = $localeCountryAssociations;
        $this->localeTranslationAssociations = $localeTranslationAssociations;
    }

    /**
     * Initialize locale.
     *
     * @return $this Self object
     */
    public function initialize()
    {
        setlocale(LC_ALL, $this->locale->getIso() . '.' . $this->encoding);
        $this->localeInfo = localeconv();

        return $this;
    }

    /**
     * Returns current locale.
     *
     * @return Locale locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Returns current locale.
     *
     * @return Locale locale
     */
    public function getLocaleIso()
    {
        return $this
            ->getLocale()
            ->getIso();
    }

    /**
     * Sets locale.
     *
     * @param LocaleInterface $locale locale
     *
     * @return $this Self object
     */
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;
        $this->initialize();

        return $this;
    }

    /**
     * Returns current encoding.
     *
     * @return string encoding
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets encoding.
     *
     * @param string $encoding encoding
     *
     * @return $this Self object
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        $this->initialize();

        return $this;
    }

    /**
     * Returns current locale info.
     *
     * @return array localeInfo
     */
    public function getIsoInfo()
    {
        return $this->localeInfo;
    }

    /**
     * Returns the ISO code of the country according to locale.
     *
     * @return Locale 2-letter ISO code
     */
    public function getCountryCode()
    {
        $localeIso = $this->locale->getIso();

        if (isset($this->localeCountryAssociations[$localeIso])) {
            return Locale::create($this->localeCountryAssociations[$localeIso]);
        }

        $regionLocale = \Locale::getRegion($localeIso);

        return $regionLocale
            ? Locale::create($regionLocale)
            : $this->locale;
    }

    /**
     * Returns the locale used to look for translations, which may not be the
     * same as $this->locale.
     *
     * @return Locale Locale
     */
    public function getTranslationsLocale()
    {
        $localeIso = $this->locale->getIso();

        if (isset($this->localeTranslationAssociations[$localeIso])) {
            return Locale::create($this->localeTranslationAssociations[$localeIso]);
        }

        return $this->locale;
    }
}
