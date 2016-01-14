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

namespace Elcodi\Component\Core\Services;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class RepositoryProvider.
 */
class RepositoryProvider
{
    /**
     * @var ManagerProvider
     *
     * Manager
     */
    private $managerProvider;

    /**
     * @var ParameterBagInterface
     *
     * Parameter bag
     */
    private $parameterBag;

    /**
     * Construct method.
     *
     * @param ManagerProvider       $managerProvider Manager
     * @param ParameterBagInterface $parameterBag    Parameter bag
     */
    public function __construct(
        ManagerProvider $managerProvider,
        ParameterBagInterface $parameterBag
    ) {
        $this->managerProvider = $managerProvider;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Given an entity namespace, return associated repository.
     *
     * @param string $entityNamespace Entity Namespace
     *
     * @return ObjectRepository Repository
     */
    public function getRepositoryByEntityNamespace($entityNamespace)
    {
        return $this
            ->managerProvider
            ->getManagerByEntityNamespace($entityNamespace)
            ->getRepository($entityNamespace);
    }

    /**
     * Given an entity parameter definition, returns associated repository.
     *
     * This method is only useful when your entities namespaces are defined as
     * a parameter, very useful when you want to provide a way of overriding
     * entities easily
     *
     * @param string $entityParameter Entity Parameter
     *
     * @return ObjectRepository Repository
     */
    public function getRepositoryByEntityParameter($entityParameter)
    {
        $entityNamespace = $this
            ->parameterBag
            ->get($entityParameter);

        return $this->getRepositoryByEntityNamespace($entityNamespace);
    }
}
