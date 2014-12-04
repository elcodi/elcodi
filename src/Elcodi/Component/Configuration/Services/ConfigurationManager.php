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

namespace Elcodi\Component\Configuration\Services;

use Elcodi\Component\Configuration\Adapter\Interfaces\ParameterFetcherInterface;

class ConfigurationManager
{

    /**
     * @var ParameterFetcherInterface
     */
    protected $parameterFetcher;

    public function __construct(ParameterFetcherInterface $parameterFetcher)
    {
        $this->parameterFetcher = $parameterFetcher;
    }

    /**
     * Gets a parameter value
     *
     * @param $parameter
     * @return mixed
     */
    public function getParameter($parameter)
    {
        return $this->parameterFetcher->getParameter($parameter);
    }
} 