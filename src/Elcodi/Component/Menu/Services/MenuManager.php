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

namespace Elcodi\Component\Menu\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Repository\MenuRepository;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuManager
 */
class MenuManager extends AbstractCacheWrapper
{
    /**
     * @var MenuRepository
     *
     * Menu Repository
     */
    protected $menuRepository;

    /**
     * @var ObjectManager
     *
     * Menu Object manager
     */
    protected $menuObjectManager;

    /**
     * @var MenuChangerInterface[]
     *
     * Menu changers
     */
    protected $menuChangers;

    /**
     * @var string
     *
     * key
     */
    protected $key;

    /**
     * @var Array
     *
     * menus
     */
    protected $menus;

    /**
     * Construct method
     *
     * @param MenuRepository $menuRepository    Menu Repository
     * @param ObjectManager  $menuObjectManager Menu Object Manager
     * @param string         $key               Key
     */
    public function __construct(
        MenuRepository $menuRepository,
        ObjectManager $menuObjectManager,
        $key
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuObjectManager = $menuObjectManager;
        $this->key = $key;
        $this->menuChangers = [];
        $this->menus = [];
    }

    /**
     * Add menu changer
     *
     * @param MenuChangerInterface $menuChanger Menu changer
     *
     * @return $this Self object
     */
    public function addMenuChanger(MenuChangerInterface $menuChanger)
    {
        $this->menuChangers[] = $menuChanger;

        return $this;
    }

    /**
     * Load menu hydration given the code.
     *
     * If the menu is already loaded in local variable, return it.
     * Otherwise, if is saved into cache, load it and save it locally
     * Otherwise, generate the data, save it into cache and save it locally
     *
     * @param string $menuCode Menu code
     *
     * @return array Menu configuration
     *
     * @throws Exception
     */
    public function loadMenuByCode($menuCode)
    {
        $menu = $this->loadFromMemory($menuCode);
        if (!($menu instanceof MenuInterface)) {

            /**
             * Menu generation and caching block
             */
            $key = $this->getCacheKey($menuCode);
            $menu = $this->loadFromCache($key);
            if (!($menu instanceof MenuInterface)) {
                $menu = $this->buildMenuFromRepository($menuCode);

                $this->saveToCache(
                    $key,
                    $menu
                );
            }

            $this->applyMenuChangers($menu);
            $this->saveToMemory($menu);
        }

        return $menu;
    }

    /**
     * Try to get menu configuration from memory
     *
     * @param string $menuCode Code of the menu
     *
     * @return MenuInterface|null Menu configuration
     */
    protected function loadFromMemory($menuCode)
    {
        return isset($this->menus[$menuCode])
            ? $this->menus[$menuCode]
            : null;
    }

    /**
     * Save menu configuration to memory
     *
     * @param MenuInterface $menu Menu loaded and processed
     *
     * @return $this Self object
     */
    protected function saveToMemory(MenuInterface $menu)
    {
        $this->menus[$menu->getCode()] = $menu;

        return $this;
    }

    /**
     * Try to get menu configuration from cache
     *
     * @param string $key Identifier of the menu
     *
     * @return MenuInterface|null Menu
     */
    protected function loadFromCache($key)
    {
        $encoded = $this
            ->cache
            ->fetch($key);

        try {
            return $this
                ->encoder
                ->decode($encoded);
        } catch (Exception $e) {
            // Silent pass
        }

        return null;
    }

    /**
     * Save menu configuration to memory
     *
     * @param string        $key  Cache key
     * @param MenuInterface $menu Menu to cache
     *
     * @return $this Self object
     */
    protected function saveToCache($key, MenuInterface $menu)
    {
        $encodedMenu = $this
            ->encoder
            ->encode($menu);

        $this
            ->cache
            ->save($key, $encodedMenu);

        return $this;
    }

    /**
     * Save menu configuration to memory
     *
     * @param string $menuCode Code of the menu
     *
     * @return $this Self object
     */
    public function removeFromCache($menuCode)
    {
        $key = $this->getCacheKey($menuCode);
        $this
            ->cache
            ->delete($key);

        return $this;
    }

    /**
     * Build menu
     *
     * @param string $menuCode Menu code
     *
     * @return MenuInterface Menu
     *
     * @throws Exception
     */
    protected function buildMenuFromRepository($menuCode)
    {
        $menu = $this
            ->menuRepository
            ->findOneBy([
                'code'    => $menuCode,
                'enabled' => true,
            ]);

        if (!($menu instanceof MenuInterface)) {
            throw new Exception(sprintf(
                'Menu "%s" not found',
                $menuCode
            ));
        }

        $this
            ->menuObjectManager
            ->detach($menu);

        return $menu;
    }

    /**
     * Apply menu changers to Menu
     *
     * @param MenuInterface $menu Menu
     *
     * @return $this Self object
     */
    protected function applyMenuChangers(MenuInterface $menu)
    {
        foreach ($this->menuChangers as $menuChanger) {
            $menuChanger->applyChange($menu);
        }

        return $this;
    }

    /**
     * Build menu key for cache
     *
     * @param string $menuCode Menu code
     *
     * @return string Cache key
     */
    protected function getCacheKey($menuCode)
    {
        return "{$this->key}-{$menuCode}";
    }
}
