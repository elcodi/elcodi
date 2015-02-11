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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Core\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Class ManagerProvider
 */
class ManagerProvider
{
    /**
     * @var ManagerRegistry
     *
     * Manager
     */
    protected $manager;

    /**
     * @var ParameterBag
     *
     * Parameter bag
     */
    protected $parameterBag;

    /**
     * Construct method
     *
     * @param ManagerRegistry $manager      Manager
     * @param ParameterBag    $parameterBag Parameter bag
     */
    public function __construct(
        ManagerRegistry $manager,
        ParameterBag $parameterBag
    ) {
        $this->manager = $manager;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Given an entity namespace, return associated object Manager
     *
     * @param string $entityNamespace Entity Namespace
     *
     * @return ObjectManager Object manager
     */
    public function getManagerByEntityNamespace($entityNamespace)
    {
        return $this
            ->manager
            ->getManagerForClass($entityNamespace);
    }

    /**
     * Given an entity parameter definition, return associated object Manager
     *
     * This method is only useful when your entities namespaces are defined as
     * a parameter, very useful when you want to provide a way of overriding
     * entities easily
     *
     * @param string $entityParameter Entity Parameter
     *
     * @return ObjectManager Object manager
     */
    public function getManagerByEntityParameter($entityParameter)
    {
        $entityNamespace = $this
            ->parameterBag
            ->get($entityParameter);

        return $this->getManagerByEntityNamespace($entityNamespace);
    }
}
