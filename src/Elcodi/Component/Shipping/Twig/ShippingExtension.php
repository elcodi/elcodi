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

namespace Elcodi\Component\Shipping\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;

/**
 * Class ShippingExtension.
 */
class ShippingExtension extends Twig_Extension
{
    /**
     * @var ShippingWrapper
     *
     * Shipping Wrapper
     */
    private $shippingWrapper;

    /**
     * Construct.
     *
     * @param ShippingWrapper $shippingWrapper Shipping wrapper
     */
    public function __construct(ShippingWrapper $shippingWrapper)
    {
        $this->shippingWrapper = $shippingWrapper;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'elcodi_shipping_methods',
                [$this->shippingWrapper, 'get']
            ),
            new Twig_SimpleFunction(
                'elcodi_shipping_method',
                [$this->shippingWrapper, 'getOneById']
            ),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'elcodi_shipping';
    }
}
