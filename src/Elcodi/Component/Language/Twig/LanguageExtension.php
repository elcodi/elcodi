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
     * Construct method
     *
     * @param LanguageManager $languageManager Language manager
     */
    public function __construct(LanguageManager $languageManager)
    {
        $this->languageManager = $languageManager;
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
     * @param string $masterLanguage
     *
     * @return array Available languages
     */
    public function getLanguages($masterLanguage = null)
    {
        $languages = $this
            ->languageManager
            ->getLanguages()
            ->toArray();

        if ($masterLanguage === null) {
            return $languages;
        }

        return $this->promoteMasterLanguage($languages, $masterLanguage);
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
     * @param string              $masterLocaleIso
     *
     * @return \Elcodi\Component\Language\Entity\Interfaces\LanguageInterface[]
     */
    protected function promoteMasterLanguage(array $languages, $masterLocaleIso)
    {
        $index = array_search($masterLocaleIso, $languages);

        if (false !== $index) {
            unset($languages[$index]);
            array_unshift($languages, $masterLocaleIso);
        }

        return $languages;
    }
}
