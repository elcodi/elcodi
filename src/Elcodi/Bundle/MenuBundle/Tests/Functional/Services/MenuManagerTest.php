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

namespace Elcodi\Bundle\MenuBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Menu\Services\MenuManager;

/**
 * Class MenuManagerTest
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
        $this->assertInstanceOf(
            'Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface',
            $this
                ->menuManager
                ->loadMenuByCode('menu-admin')
        );
    }

    /**
     * Test load structure
     */
    public function testLoadFrontMenu()
    {
        $this->assertInstanceOf(
            'Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface',
            $this
                ->menuManager
                ->loadMenuByCode('menu-front')
        );
    }
}
