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

namespace Elcodi\Component\Configuration\Adapter;

use Doctrine\Common\Persistence\ObjectRepository;
use Elcodi\Component\Configuration\Adapter\Interfaces\ParameterFetcherInterface;

/**
 * Class DoctrineORMParameterFetcher
 */
class DoctrineParameterFetcher implements ParameterFetcherInterface
{
    const ADAPTER_NAME = 'doctrine';

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $parameter
     *
     * @return string
     */
    public function getParameter($parameter)
    {
        return $this->repository->findOneBy(['parameter' => $parameter]);
    }
} 