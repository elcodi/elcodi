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

namespace Elcodi\CoreBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Text utilities extension
 *
 */
class TextExtension extends Twig_Extension
{

    /**
     * Return all filters
     *
     * @return array Filters created
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('truncatedot', array($this, 'truncateDot'))
        );
    }

    /**
    * Returns a substring with "..." trailing dots
    * @param string $text
    * @param int $length
    * @param string $dots
    *
    * @return string
    */
    public function truncateDot($text, $length, $dots = "…")
    {
        $textTruncated = trim(mb_substr($text, 0, $length));

        if ((mb_strlen($textTruncated) == $length) && ($text != $textTruncated)) {

            $textTruncated .= $dots;
        }

        return $textTruncated;
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'text_extension';
    }
}
