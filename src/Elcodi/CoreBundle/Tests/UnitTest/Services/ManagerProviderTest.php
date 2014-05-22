<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\CoreBundle\Tests\UnitTest\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase;

use Elcodi\CoreBundle\Services\ManagerProvider;

/**
 * Class ManagerProviderTest
 */
class ManagerProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ManagerProvider
     *
     * Manager provider
     */
    protected $managerProvider;

    /**
     * @var string
     *
     * Entity Parameter
     */
    protected $entityParameter = 'elcodi.entity.namespace';

    /**
     * @var string
     *
     * Entity Namespace
     */
    protected $entityNamespace = '\Elcodi\Entity\Namespace';

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $objectManager;

    /**
     * Setup method
     */
    public function setUp()
    {
        $this->objectManager = $this
            ->getMock('Doctrine\Common\Persistence\ObjectManager');

        $parametersBag = new ParameterBag(array(
            $this->entityParameter => $this->entityNamespace,
        ));

        $managerRegistry = $this
            ->getMockBuilder('Symfony\Bridge\Doctrine\ManagerRegistry')
            ->disableOriginalConstructor()
            ->getMock();

        $managerRegistry
            ->expects($this->once())
            ->method('getManagerForClass')
            ->with($this->equalTo($this->entityNamespace))
            ->will($this->returnValue($this->objectManager));

        $this->managerProvider = new ManagerProvider(
            $managerRegistry,
            $parametersBag
        );

    }

    /**
     * Test getManagerByEntityNamespace
     */
    public function testGetManagerByEntityNamespace()
    {
        $this->assertEquals(
            $this->objectManager,
            $this->managerProvider
                ->getManagerByEntityNamespace($this->entityNamespace)
        );
    }

    /**
     * Test getManagerByEntityParameter
     */
    public function testGetManagerByEntityParameter()
    {
        $this->assertEquals(
            $this->objectManager,
            $this->managerProvider
                ->getManagerByEntityParameter($this->entityParameter)
        );
    }
}
 