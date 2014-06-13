<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Services;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Class RepositoryProvider
 */
class RepositoryProvider
{
    /**
     * @var ManagerProvider
     *
     * Manager
     */
    protected $managerProvider;

    /**
     * @var ParameterBag
     *
     * Parameter bag
     */
    protected $parameterBag;

    /**
     * Construct method
     *
     * @param ManagerProvider $managerProvider Manager
     * @param ParameterBag    $parameterBag    Parameter bag
     */
    public function __construct(
        ManagerProvider $managerProvider,
        ParameterBag $parameterBag
    )
    {
        $this->managerProvider = $managerProvider;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Given an entity namespace, return associated repository
     *
     * @param string $entityNamespace Entity Namespace
     *
     * @return ObjectRepository Repository
     *
     * @api
     */
    public function getRepositoryByEntityNamespace($entityNamespace)
    {
        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getRepository($entityNamespace);
    }

    /**
     * Given an entity parameter definition, return associated repository
     *
     * This method is only useful when your entities namespaces are defined as
     * a parameter, very useful when you want to provide a way of overriding
     * entities easily
     *
     * @param string $entityParameter Entity Parameter
     *
     * @return ObjectRepository Repository
     *
     * @api
     */
    public function getRepositoryByEntityParameter($entityParameter)
    {
        $entityNamespace = $this
            ->parameterBag
            ->get($entityParameter);

        return $this->getRepositoryByEntityNamespace($entityNamespace);
    }
}
