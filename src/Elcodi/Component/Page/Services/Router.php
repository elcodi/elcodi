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

namespace Elcodi\Component\Page\Services;

use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Page\Entity\Interfaces\RoutableInterface;
use Elcodi\Component\Page\Repository\Interfaces\RoutableRepositoryInterface;
use Elcodi\Component\Page\Services\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var RoutableRepositoryInterface
     */
    protected $repository;

    public function handleRequest(Request $request)
    {
        /**
         * @var RoutableInterface
         */
        $routable = $this->repository->findOneByPath($request->getUri());

        return $routable;
    }
}
