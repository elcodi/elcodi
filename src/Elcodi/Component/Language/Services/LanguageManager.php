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

namespace Elcodi\Component\Language\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Language\Repository\LanguageRepository;

/**
 * Language manager Services
 *
 * Manages all languages actions
 */
class LanguageManager
{
    /**
     * @var LanguageRepository
     *
     * Language repository
     */
    protected $languageRepository;

    /**
     * Construct method
     *
     * @param LanguageRepository $languageRepository Language repository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * Get enabled languages
     *
     * @return Collection Set of enabled languages
     */
    public function getLanguages()
    {
        return new ArrayCollection(
            $this
            ->languageRepository
            ->findBy(array(
                'enabled' => true,
            ))
        );
    }
}
