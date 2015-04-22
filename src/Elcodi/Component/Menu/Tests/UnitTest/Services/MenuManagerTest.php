<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Menu\Tests\UnitTest\Services;

use Doctrine\Common\Cache\CacheProvider;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface;
use Elcodi\Component\Menu\ElcodiMenuEvents;
use Elcodi\Component\Menu\Repository\MenuRepository;
use Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface;
use Elcodi\Component\Menu\Services\MenuManager;

/**
 * Class MenuManagerTest
 */
class MenuManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MenuManager
     *
     * Menu manager
     */
    protected $menuManager;

    /**
     * @var MenuRepository
     *
     * Menu repository
     */
    protected $menuRepository;

    /**
     * @var CacheProvider
     *
     * Cache provider
     */
    protected $cacheProvider;

    /**
     * @var MenuSerializerInterface
     *
     * Menu serializer
     */
    protected $serializer;

    /**
     * @var EncoderInterface
     *
     * Encoder service
     */
    protected $encoder;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->cacheProvider = $this
            ->getMockBuilder('Doctrine\Common\Cache\ArrayCache')
            ->disableOriginalConstructor()
            ->setMethods([
                'fetch',
                'save',
            ])
            ->getMock();

        $this->menuRepository = $this
            ->getMockBuilder('Elcodi\Component\Menu\Repository\MenuRepository')
            ->disableOriginalConstructor()
            ->setMethods([
                'findOneBy',
            ])
            ->getMock();

        $this->serializer = $this
            ->getMockForAbstractClass('Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface');

        $this->encoder = $this
            ->getMockForAbstractClass('\Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface');

        $this->menuManager = new MenuManager(
            $this->menuRepository,
            $this->serializer,
            'menus'
        );

        $this
            ->menuManager
            ->setCache($this->cacheProvider)
            ->setEncoder($this->encoder);
    }

    /**
     * Test empty cache
     */
    public function testEmptyCache()
    {
        $menuName = 'admin';
        $keyName = 'menus-admin';

        $menuProphecy = $this->prophesize(
            'Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface'
        );

        $menu = $menuProphecy->reveal();

        $expected = [
            'id'         => 1,
            'name'       => null,
            'code'       => null,
            'url'        => null,
            'activeUrls' => ['url'],
            'subnodes'   => [],
        ];

        $encoded = serialize($expected);

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('fetch')
            ->with($keyName)
            ->will($this->returnValue(null));

        $this
            ->encoder
            ->expects($this->once())
            ->method('decode')
            ->with(null)
            ->will($this->returnValue(null));

        $this
            ->menuRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with([
                'code' => $menuName,
                'enabled' => true,
            ])
            ->will($this->returnValue($menu));

        $this
            ->serializer
            ->expects($this->once())
            ->method('serializeSubnodes')
            ->with($menu)
            ->will($this->returnValue($expected));

        $this
            ->encoder
            ->expects($this->once())
            ->method('encode')
            ->with($expected)
            ->will($this->returnValue($encoded));

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('save')
            ->with($keyName, $encoded);

        /**
         * @var $dispatcherProphecy EventDispatcherInterface|ObjectProphecy
         */
        $dispatcherProphecy = $this->prophesize(
            'Symfony\Component\EventDispatcher\EventDispatcherInterface'
        );

        $dispatcherProphecy
            ->dispatch(
                ElcodiMenuEvents::POST_COMPILATION,
                Argument::type('Elcodi\Component\Menu\Event\MenuEvent')
            )
            ->shouldBeCalled();

        $dispatcherProphecy
            ->dispatch(
                ElcodiMenuEvents::POST_LOAD,
                Argument::type('Elcodi\Component\Menu\Event\MenuEvent')
            )
            ->shouldBeCalled();

        $this
            ->menuManager
            ->setEventDispatcher(
                $dispatcherProphecy->reveal()
            );

        $this->assertEquals(
            $expected,
            $this
                ->menuManager
                ->loadMenuByCode($menuName)
        );
    }

    /**
     * Test load from cache cache
     */
    public function testFullCache()
    {
        $menuName = 'admin';
        $keyName = 'menus-admin';

        $expected = [
            'id'         => 1,
            'name'       => null,
            'code'       => null,
            'url'        => null,
            'activeUrls' => ['url'],
            'subnodes'   => [],
        ];

        $encoded = serialize($expected);

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('fetch')
            ->with($keyName)
            ->will($this->returnValue($encoded));

        $this
            ->encoder
            ->expects($this->once())
            ->method('decode')
            ->with($encoded)
            ->will($this->returnValue($expected));

        $this
            ->menuRepository
            ->expects($this->never())
            ->method('findOneBy');

        $this
            ->serializer
            ->expects($this->never())
            ->method('serializeSubnodes');

        $this
            ->encoder
            ->expects($this->never())
            ->method('encode');

        $this
            ->cacheProvider
            ->expects($this->never())
            ->method('save');

        $this->assertEquals(
            $expected,
            $this
                ->menuManager
                ->loadMenuByCode($menuName)
        );

        /**
         * @var $dispatcherProphecy EventDispatcherInterface|ObjectProphecy
         */
        $dispatcherProphecy = $this->prophesize(
            'Symfony\Component\EventDispatcher\EventDispatcherInterface'
        );

        $dispatcherProphecy
            ->dispatch(
                ElcodiMenuEvents::POST_COMPILATION,
                Argument::type('Elcodi\Component\Menu\Event\MenuEvent')
            )
            ->shouldNotBeCalled();

        $dispatcherProphecy
            ->dispatch(
                ElcodiMenuEvents::POST_LOAD,
                Argument::type('Elcodi\Component\Menu\Event\MenuEvent')
            )
            ->shouldBeCalled();

        $this
            ->menuManager
            ->setEventDispatcher(
                $dispatcherProphecy->reveal()
            );

        /**
         * Load again to test internal array cache
         */
        $this->assertEquals(
            $expected,
            $this
                ->menuManager
                ->loadMenuByCode($menuName)
        );
    }
}
