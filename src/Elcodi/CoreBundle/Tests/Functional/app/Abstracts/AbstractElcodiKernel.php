<?php

/**
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

namespace Elcodi\CoreBundle\Tests\Functional\app\Abstracts;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * AbstractElcodiKernel for all Elcodi specific Kernels
 */
abstract class AbstractElcodiKernel extends Kernel
{
    /**
     * Register container configuration
     *
     * @param LoaderInterface $loader Loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $classInfo = new \ReflectionClass($this);
        $dir =  dirname($classInfo->getFileName());
        $loader->load($dir . '/config.yml');
    }

    /**
     * Return Cache dir
     *
     * @return string
     */
    public function getCacheDir()
    {
        return  sys_get_temp_dir() .
        DIRECTORY_SEPARATOR .
        'Elcodi' .
        DIRECTORY_SEPARATOR .
        $this->getContainerClass() . '/Cache/';

    }

    /**
     * Return log dir
     *
     * @return string
     */
    public function getLogDir()
    {
        return  sys_get_temp_dir() .
        DIRECTORY_SEPARATOR .
        'Elcodi' .
        DIRECTORY_SEPARATOR .
        $this->getContainerClass() . '/Log/';
    }
}
