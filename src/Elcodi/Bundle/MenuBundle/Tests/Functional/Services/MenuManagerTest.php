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

namespace Elcodi\Bundle\MenuBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Menu\Services\MenuManager;

/**
 * Class MenuManager
 */
class MenuManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.manager.menu',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiMenuBundle',
        ];
    }

    /**
     * @var MenuManager
     *
     * Menu manager
     */
    protected $menuManager;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->menuManager = $this->get('elcodi.manager.menu');
    }

    /**
     * Test load structure
     */
    public function testLoadAdminMenu()
    {
        $this->assertEquals(
            $this->menuManager->loadMenuByCode('menu-admin'),
            [
                1 => [
                    'id'       => 1,
                    'name'     => 'vogue',
                    'code'     => 'vogue',
                    'url'      => null,
                    'subnodes' => [
                        2 => [
                            'id'       => 2,
                            'name'     => 'him',
                            'code'     => 'him',
                            'url'      => 'elcodi.dev/him',
                            'subnodes' => [],
                        ],
                        3 => [
                            'id'       => 3,
                            'name'     => 'her',
                            'code'     => 'her',
                            'url'      => 'elcodi.dev/her',
                            'subnodes' => [],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Test load structure
     */
    public function testLoadFrontMenu()
    {
        $this->assertEquals(
            $this->menuManager->loadMenuByCode('menu-front'),
            [
                2 => [
                    'id'       => 2,
                    'name'     => 'him',
                    'code'     => 'him',
                    'url'      => 'elcodi.dev/him',
                    'subnodes' => [],
                ],
                3 => [
                    'id'       => 3,
                    'name'     => 'her',
                    'code'     => 'her',
                    'url'      => 'elcodi.dev/her',
                    'subnodes' => [],
                ],
            ]
        );
    }
}
