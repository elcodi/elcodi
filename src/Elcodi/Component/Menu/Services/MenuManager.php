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

use Exception;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\EventDispatcher\Interfaces\MenuEventDispatcherInterface;
use Elcodi\Component\Menu\Processor\MenuEventProcessor;
use Elcodi\Component\Menu\Repository\MenuRepository;
use Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface;

/**
 * Class MenuManager
 */
class MenuManager extends AbstractCacheWrapper
{
    /**
     * @var MenuEventDispatcherInterface
     *
     * Menu Event dispatcher
     */
    protected $menuEventDispatcher;

    /**
     * @var MenuRepository
     *
     * Menu Repository
     */
    protected $menuRepository;

    /**
     * @var MenuSerializerInterface
     *
     * Menu Serializer
     */
    protected $menuSerializer;

    /**
     * @var MenuEventProcessor
     *
     * Menu Event Processor
     */
    protected $menuEventProcessor;

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
     * @param MenuEventDispatcherInterface $menuEventDispatcher Menu Event Dispatcher
     * @param MenuEventProcessor           $menuEventProcessor  Menu Event Processor
     * @param MenuSerializerInterface      $menuSerializer      Menu Serializer
     * @param MenuRepository               $menuRepository      Menu Repository
     * @param string                       $key                 Key
     */
    public function __construct(
        MenuEventDispatcherInterface $menuEventDispatcher,
        MenuEventProcessor $menuEventProcessor,
        MenuSerializerInterface $menuSerializer,
        MenuRepository $menuRepository,
        $key
    ) {
        $this->menuEventDispatcher = $menuEventDispatcher;
        $this->menuEventProcessor = $menuEventProcessor;
        $this->menuSerializer = $menuSerializer;
        $this->menuRepository = $menuRepository;
        $this->key = $key;
        $this->menus = [];
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
        $key = $this->getCacheKey($menuCode);

        $processedMenu = $this->loadFromMemory($key);
        if (!$processedMenu) {

            /**
             * Menu generation and caching block
             */
            $processedMenu = $this->loadFromCache($key);
            if (!$processedMenu) {
                $processedMenu = $this->buildMenuFromRepository($menuCode);
                $this->saveToCache(
                    $key,
                    $processedMenu
                );
            }

            $this->saveToMemory(
                $key,
                $processedMenu
            );
        }

        $event = $this
            ->menuEventDispatcher
            ->dispatchPostMenuLoad(
                $menuCode,
                $processedMenu
            );

        $processedLoadedMenu = $this
            ->menuEventProcessor
            ->getProcessedMenu($event);

        return $processedLoadedMenu;
    }

    /**
     * Try to get menu configuration from memory
     *
     * @param string $key Identifier of the menu
     *
     * @return array|null Menu configuration
     */
    protected function loadFromMemory($key)
    {
        return isset($this->menus[$key]) ? $this->menus[$key] : null;
    }

    /**
     * Save menu configuration to memory
     *
     * @param string $key   Identifier of the menu
     * @param array  $value Configuration to cache
     */
    protected function saveToMemory($key, array $value)
    {
        $this->menus[$key] = $value;
    }

    /**
     * Try to get menu configuration from cache
     *
     * @param string $key Identifier of the menu
     *
     * @return array|null Menu configuration
     */
    protected function loadFromCache($key)
    {
        $encoded = $this
            ->cache
            ->fetch($key);

        return $this
            ->encoder
            ->decode($encoded);
    }

    /**
     * Save menu configuration to memory
     *
     * @param string $key   Identifier of the menu
     * @param array  $value Configuration to cache
     */
    protected function saveToCache($key, $value)
    {
        $encoded = $this
            ->encoder
            ->encode($value);

        $this
            ->cache
            ->save($key, $encoded);
    }

    /**
     * Build menu
     *
     * @param string $menuCode Menu code
     *
     * @return array Menu configuration
     *
     * @throws Exception
     */
    protected function buildMenuFromRepository($menuCode)
    {
        $menuNodesSerialized = $this->loadFromRepository($menuCode);

        $event = $this
            ->menuEventDispatcher
            ->dispatchPostMenuCompilation(
                $menuCode,
                $menuNodesSerialized
            );

        return $this
            ->menuEventProcessor
            ->getProcessedMenu($event);
    }

    /**
     * Try to get menu configuration from cache
     *
     * @param string $code Code to find the menu
     *
     * @return array Menu nodes serialized
     *
     * @throws Exception Menu not found
     */
    protected function loadFromRepository($code)
    {
        $menu = $this
            ->menuRepository
            ->findOneBy([
                'code'    => $code,
                'enabled' => true,
            ]);

        if (!($menu instanceof MenuInterface)) {
            throw new Exception(sprintf(
                'Menu "%s" not found',
                $code
            ));
        }

        return $this
            ->menuSerializer
            ->serializeSubnodes($menu);
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
