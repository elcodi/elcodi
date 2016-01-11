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

namespace Elcodi\Component\Menu\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Menu\ElcodiMenuStages;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Repository\MenuRepository;
use Elcodi\Component\Menu\Services\Interfaces\MenuChangerInterface;

/**
 * Class MenuManager.
 */
class MenuManager extends AbstractCacheWrapper
{
    /**
     * @var MenuRepository
     *
     * Menu Repository
     */
    private $menuRepository;

    /**
     * @var ObjectManager
     *
     * Menu Object manager
     */
    private $menuObjectManager;

    /**
     * @var MenuChangerInterface[]
     *
     * Menu changers
     */
    private $menuChangers = [];

    /**
     * @var string
     *
     * key
     */
    private $key;

    /**
     * @var array
     *
     * menus
     */
    private $menus = [];

    /**
     * Construct method.
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
    }

    /**
     * Add menu changer.
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
             * Menu generation and caching block.
             */
            $key = $this->getCacheKey($menuCode);
            $menu = $this->loadFromCache($key);
            if (!($menu instanceof MenuInterface)) {
                $menu = $this->buildMenuFromRepository($menuCode);

                $this->applyMenuChangers(
                    $menu,
                    ElcodiMenuStages::BEFORE_CACHE
                );

                $this->saveToCache(
                    $key,
                    $menu
                );
            }

            $this->applyMenuChangers(
                $menu,
                ElcodiMenuStages::AFTER_CACHE
            );

            $this->saveToMemory($menu);
        }

        return $menu;
    }

    /**
     * Save menu configuration to memory.
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
     * Try to get menu configuration from memory.
     *
     * @param string $menuCode Code of the menu
     *
     * @return MenuInterface|null Menu configuration
     */
    private function loadFromMemory($menuCode)
    {
        return isset($this->menus[$menuCode])
            ? $this->menus[$menuCode]
            : null;
    }

    /**
     * Save menu configuration to memory.
     *
     * @param MenuInterface $menu Menu loaded and processed
     *
     * @return $this Self object
     */
    private function saveToMemory(MenuInterface $menu)
    {
        $this->menus[$menu->getCode()] = $menu;

        return $this;
    }

    /**
     * Try to get menu configuration from cache.
     *
     * @param string $key Identifier of the menu
     *
     * @return MenuInterface|null Menu
     */
    private function loadFromCache($key)
    {
        $encoded = (string) $this
            ->cache
            ->fetch($key);

        try {
            return is_string($encoded)
                ? $this
                    ->encoder
                    ->decode($encoded)
                : null;
        } catch (Exception $e) {
            // Silent pass
        }

        return null;
    }

    /**
     * Save menu configuration to memory.
     *
     * @param string        $key  Cache key
     * @param MenuInterface $menu Menu to cache
     *
     * @return $this Self object
     */
    private function saveToCache($key, MenuInterface $menu)
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
     * Build menu.
     *
     * @param string $menuCode Menu code
     *
     * @return MenuInterface Menu
     *
     * @throws Exception
     */
    private function buildMenuFromRepository($menuCode)
    {
        $menu = $this
            ->menuRepository
            ->findOneBy([
                'code' => $menuCode,
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
     * Apply menu changers to Menu.
     *
     * @param MenuInterface $menu  Menu
     * @param string        $stage Stage
     *
     * @return $this Self object
     */
    private function applyMenuChangers(
        MenuInterface $menu,
        $stage
    ) {
        foreach ($this->menuChangers as $menuChanger) {
            $menuChanger
                ->applyChange(
                    $menu,
                    $stage
                );
        }

        return $this;
    }

    /**
     * Build menu key for cache.
     *
     * @param string $menuCode Menu code
     *
     * @return string Cache key
     */
    private function getCacheKey($menuCode)
    {
        return "{$this->key}-{$menuCode}";
    }
}
