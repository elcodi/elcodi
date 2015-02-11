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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Language\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Language\Services\LanguageManager;

/**
 * Class LanguageExtension
 */
class LanguageExtension extends Twig_Extension
{
    /**
     * @var LanguageManager
     *
     * Language manager
     */
    protected $languageManager;

    /**
     * @var string
     *
     * Master locale
     */
    protected $masterLocale;

    /**
     * Construct method
     *
     * @param LanguageManager $languageManager Language manager
     * @param string          $masterLocale    Master locale
     */
    public function __construct(
        LanguageManager $languageManager,
        $masterLocale
    ) {
        $this->languageManager = $languageManager;
        $this->masterLocale = $masterLocale;
    }

    /**
     * Return all filters
     *
     * @return Twig_SimpleFunction[] Filters created
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('languages', array($this, 'getLanguages')),
        );
    }

    /**
     * Return all available languages
     *
     * @return array Available languages
     */
    public function getLanguages()
    {
        $languages = $this
            ->languageManager
            ->getLanguages();

        $masterLanguage = $languages
            ->filter(function (LanguageInterface $language) {
                return $language->getIso() === $this->masterLocale;
            })
            ->first();

        $languages->removeElement($masterLanguage);
        $otherLanguagesArray = $languages->toArray();

        return array_merge(
            [$masterLanguage],
            $otherLanguagesArray
        );
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'language_extension';
    }
}
