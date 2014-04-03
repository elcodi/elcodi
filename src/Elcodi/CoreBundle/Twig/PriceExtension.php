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
 * Price extension
 */
class PriceExtension extends Twig_Extension
{
    /**
     * @var array
     *
     * Locale information
     */
    protected $localeInfo;

    /**
     * Build method
     *
     * @param array $localeInfo
     */
    public function __construct($localeInfo)
    {
        $this->localeInfo = $localeInfo;
    }

    /**
     * Returns current locale info
     *
     * @return array localeInfo
     */
    public function getLocaleInfo()
    {
        return $this->localeInfo;
    }

    /**
     * Local filters
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('price_format', array($this, 'priceFormatFilter')),
            new Twig_SimpleFilter('currency_symbol', array($this, 'currencySymbol')),
        );
    }

    /**
     * Gets the right format for locale and transforms param in it
     *
     * @param integer $number        number to format
     * @param boolean $show_decimals show price with decimals or not
     *
     * @return string
     */
    public function priceFormatFilter($number, $show_decimals = true)
    {
        $price = $number;

        if (!empty($this->localeInfo)) {

            $fracDigits = $this->localeInfo['frac_digits'];

            if (!$show_decimals) {
                $fracDigits = 0;
            }

            // not show decimals in case they are zero
            if (($price - intval($price)) == 0) {
                $fracDigits = 0;
            }

            $price = number_format($number, $fracDigits, $this->localeInfo['mon_decimal_point'], $this->localeInfo['thousands_sep']);

            if ($this->localeInfo['p_cs_precedes']) {

                $price = $this->localeInfo['currency_symbol'].$price;
            } else {

                $price .= $this->localeInfo['currency_symbol'];
            }

        } else {
            return 'No valid';
        }

        return $price;
    }

    /**
     * Returns currency symbol in its position depending on the country
     * The filter can accept 'pre', 'post' or '' (empty) value
     *
     * @param string $value Value
     *
     * @return string
     */
    public function currencySymbol($value = '')
    {
        if ($value == '') {
            return '';
        }

        $symbol = $this->localeInfo['currency_symbol'];

        if ($value == 'pre' && $this->localeInfo['p_cs_precedes']) {
            return $symbol;

        } elseif ($value == 'post' && !$this->localeInfo['p_cs_precedes']) {
            return $symbol;
        }

        return '';
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'price_extension';
    }
}
