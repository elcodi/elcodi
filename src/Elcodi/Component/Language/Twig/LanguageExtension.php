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
    protected $languageManager;

    /**
     * @var string
     *
     * Master locale ISO
     */
    protected $masterLocaleIso;

    /**
     * Construct method
     *
     * @param LanguageManager $languageManager Language manager
     * @param string          $masterLocaleIso Master locale ISO
     */
    public function __construct(
        LanguageManager $languageManager,
        $masterLocaleIso
    ) {
        $this->languageManager = $languageManager;
        $this->masterLocaleIso = $masterLocaleIso;
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
    protected function promoteMasterLanguage(array $languages)
    {
        $index = array_search($this->masterLocaleIso, $languages);

        if (false !== $index) {
            unset($languages[$index]);
            array_unshift($languages, $this->masterLocaleIso);
        }

        return $languages;
    }
}
