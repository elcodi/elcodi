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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;

/**
 * Language manager Services with promoted addition.
 */
class PromotedLanguageManager
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
     * Construct method.
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
     * Return all languages with the master one promoted to the first position.
     *
     * @return Collection Languages collection
     */
    public function getLanguagesWithMasterLanguagePromoted()
    {
        $languages = $this
            ->languageManager
            ->getLanguages()
            ->toArray();

        $masterLocale = $this
            ->masterLocale
            ->getIso();

        $index = array_search($masterLocale, $languages);

        if (false !== $index) {
            $mainLanguage = $languages[$index];
            unset($languages[$index]);
            array_unshift($languages, $mainLanguage);
        }

        return new ArrayCollection($languages);
    }
}
