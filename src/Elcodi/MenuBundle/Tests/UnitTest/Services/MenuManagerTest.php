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

namespace Elcodi\MenuBundle\Tests\UnitTest\Services;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\CoreBundle\Encoder\JsonEncoder;
use Elcodi\MenuBundle\Entity\Menu\Menu;
use Elcodi\MenuBundle\Entity\Menu\Node;
use Elcodi\MenuBundle\Repository\MenuRepository;
use Elcodi\MenuBundle\Services\MenuManager;

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
            ->getMockBuilder('Elcodi\MenuBundle\Repository\MenuRepository')
            ->disableOriginalConstructor()
            ->setMethods([
                'findOneBy',
            ])
            ->getMock();

        $this->menuManager = new MenuManager($this->menuRepository, 'menus');
        $this
            ->menuManager
            ->setCache($this->cacheProvider)
            ->setEncoder(new JsonEncoder());
    }

    /**
     * Test empty cache
     */
    public function testEmptyCache()
    {
        $node = new Node();
        $node
            ->setSubnodes(new ArrayCollection)
            ->setId(1);

        $menu = new Menu();
        $menu
            ->setSubnodes(new ArrayCollection)
            ->addSubnode($node);

        $this
            ->menuRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($menu));

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue(null));

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo('menus-admin'),
                $this->equalTo(
                    '{"1":{"id":1,"name":null,"code":null,"url":null,"subnodes":[]}}'
                )
            );

        $this->assertEquals(
            $this->menuManager->loadMenuByCode('admin'),
            [
                1 => [
                    'id'       => 1,
                    'name'     => null,
                    'code'     => null,
                    'url'      => null,
                    'subnodes' => [],
                ]
            ]
        );
    }

    /**
     * Test load from cache cache
     */
    public function testFullCache()
    {
        $node = new Node();
        $node
            ->setSubnodes(new ArrayCollection)
            ->setId(1);

        $menu = new Menu();
        $menu
            ->setSubnodes(new ArrayCollection)
            ->addSubnode($node);

        $this
            ->menuRepository
            ->expects($this->any())
            ->method('findOneBy');

        $this
            ->cacheProvider
            ->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue(
                '{"1":{"id":1,"name":null,"url":null,"subnodes":[]}}'
            ));

        $this
            ->cacheProvider
            ->expects($this->any())
            ->method('save');

        /**
         * Data is required twice to test how many times data is fetched from
         * cache provider, and to test than both times, returned data is the
         * same
         */
        $this->assertEquals(
            $this->menuManager->loadMenuByCode('admin'),
            [
                1 => [
                    'id'       => 1,
                    'name'     => null,
                    'url'      => null,
                    'subnodes' => [],
                ]
            ]
        );

        $this->assertEquals(
            $this->menuManager->loadMenuByCode('admin'),
            [
                1 => [
                    'id'       => 1,
                    'name'     => null,
                    'url'      => null,
                    'subnodes' => [],
                ]
            ]
        );
    }
}
