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

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Class ManagerProvider.
 */
class ManagerProvider
{
    /**
     * @var AbstractManagerRegistry
     *
     * Manager
     */
    private $manager;

    /**
     * @var ParameterBag
     *
     * Parameter bag
     */
    private $parameterBag;

    /**
     * Construct method.
     *
     * @param AbstractManagerRegistry $manager      Manager
     * @param ParameterBag            $parameterBag Parameter bag
     */
    public function __construct(
        AbstractManagerRegistry $manager,
        ParameterBag $parameterBag
    ) {
        $this->manager = $manager;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Given an entity namespace, return associated object Manager.
     *
     * @param string $entityNamespace Entity Namespace
     *
     * @return ObjectManager|null Object manager
     */
    public function getManagerByEntityNamespace($entityNamespace)
    {
        return $this
            ->manager
            ->getManagerForClass($entityNamespace);
    }

    /**
     * Given an entity parameter definition, returns associated object Manager.
     *
     * This method is only useful when your entities namespaces are defined as
     * a parameter, very useful when you want to provide a way of overriding
     * entities easily
     *
     * @param string $entityParameter Entity Parameter
     *
     * @return ObjectManager|null Object manager
     */
    public function getManagerByEntityParameter($entityParameter)
    {
        $entityNamespace = $this
            ->parameterBag
            ->get($entityParameter);

        return $this->getManagerByEntityNamespace($entityNamespace);
    }
}
