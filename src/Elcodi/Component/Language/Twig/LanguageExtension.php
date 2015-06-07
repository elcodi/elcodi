<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;
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
    private $languageManager;

    /**
     * @var LocaleInterface
     *
     * Master locale
     */
    private $masterLocale;

    /**
     * Construct method
     *
     * @param LanguageManager $languageManager Language manager
     * @param LocaleInterface $masterLocale    Master locale
     */
    public function __construct(
        LanguageManager $languageManager,
        LocaleInterface $masterLocale
    ) {
        $this->languageManager = $languageManager;
        $this->masterLocale = $masterLocale;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'elcodi_languages' => $this->getLanguages(),
        ];
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
            ->getLanguages()
            ->toArray();

        return $this->promoteMasterLanguage($languages);
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

    /**
     * Move master language to the first position
     *
     * @param LanguageInterface[] $languages
     *
     * @return LanguageInterface[]
     */
    private function promoteMasterLanguage(array $languages)
    {
        $masterLocale = $this->masterLocale->getIso();
        $index = array_search($masterLocale, $languages);

        if (false !== $index) {
            unset($languages[$index]);
            array_unshift($languages, $masterLocale);
        }

        return $languages;
    }
}
