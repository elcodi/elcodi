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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Elcodi\Component\Language\Entity\Locale;

/**
 * Class LocaleProvider
 */
class LocaleProvider
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    protected $requestStack;

    /**
     * @var string
     *
     * Default locale
     */
    protected $defaultLocale;

    /**
     * Construct method
     *
     * @param RequestStack $requestStack  Request Stack
     * @param string       $defaultLocale Default Locale
     */
    public function __construct(
        RequestStack $requestStack,
        $defaultLocale
    )
    {
        $this->requestStack = $requestStack;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * Get usable locale from current request environment
     *
     * @return Locale Locale loaded
     */
    public function getLocale()
    {
        $locale = $this->requestStack->getCurrentRequest() instanceof Request
            ? $this->requestStack->getCurrentRequest()->getLocale()
            : $this->defaultLocale;

        return new Locale($locale);
    }
}
