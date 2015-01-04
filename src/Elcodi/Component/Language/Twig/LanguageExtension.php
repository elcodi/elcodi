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

namespace Elcodi\Component\Language\Twig;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Language\Services\LanguageManager;
use Twig_Extension;

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
     * @return Collection Available languages
     */
    public function getLanguages()
    {
        return $this
            ->languageManager
            ->getLanguages();
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
