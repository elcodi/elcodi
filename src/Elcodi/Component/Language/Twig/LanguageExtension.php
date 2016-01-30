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

namespace Elcodi\Component\Language\Twig;

use Twig_Extension;
use Twig_Extension_GlobalsInterface;

use Elcodi\Component\Language\Services\PromotedLanguageManager;

@trigger_error('The class LanguageExtension is deprecated since v1.0.14 and will
be removed in v2.0.0. Define the global in your project config.yml instead.',
    E_USER_DEPRECATED);

/**
 * Class LanguageExtension.
 */
class LanguageExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    /**
     * @var PromotedLanguageManager
     *
     * Promoted Language manager
     */
    private $promotedLanguageManager;

    /**
     * Construct method.
     *
     * @param PromotedLanguageManager $promotedLanguageManager Promoted Language manager
     */
    public function __construct(PromotedLanguageManager $promotedLanguageManager)
    {
        $this->promotedLanguageManager = $promotedLanguageManager;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'elcodi_languages' => $this
                ->promotedLanguageManager
                ->getLanguagesWithMasterLanguagePromoted(),
        ];
    }

    /**
     * return extension name.
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'language_extension';
    }
}
