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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Menu\ElcodiMenuEvents;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Event\MenuEvent;
use Elcodi\Component\Menu\Repository\MenuRepository;
use Elcodi\Component\Menu\Serializer\Interfaces\MenuSerializerInterface;

/**
 * Class MenuManager
 */
class MenuManager extends AbstractCacheWrapper
{
    /**
     * @var Array
     *
     * menus
     */
    protected $menus = [];

    /**
     * @var MenuRepository
     *
     * Menu Repository
     */
    protected $menuRepository;

    /**
     * @var MenuSerializerInterface
     *
     * Menu serializer
     */
    protected $serializer;

    /**
     * @var string
     *
     * key
     */
    protected $key;

    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    protected $dispatcher;

    /**
     * Construct method
     *
     * @param MenuRepository          $menuRepository Menu repository
     * @param MenuSerializerInterface $serializer     Menu serializer
     * @param string                  $key            Key
     */
    public function __construct(
        MenuRepository $menuRepository,
        MenuSerializerInterface $serializer,
        $key
    ) {
        $this->menuRepository = $menuRepository;
        $this->serializer = $serializer;
        $this->key = $key;
    }

    /**
     * Set the EventDispatcher
     *
     * @param EventDispatcherInterface $dispatcher
     *
     * @return $this Self object
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

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
        $key = $this->getCacheKey($menuCode);

        $menu = $this->loadFromMemory($key);
        if (!$menu) {

            $menu = $this->loadFromCache($key);
            if (!$menu) {

                $menu = $this->loadFromRepository($menuCode);

                $menu = $this->dispatchMenuEvent(
                    ElcodiMenuEvents::POST_COMPILATION,
                    $menuCode,
                    $menu
                );

                $this->saveToCache($key, $menu);
            }

            $this->saveToMemory($key, $menu);
        }

        $menu = $this->dispatchMenuEvent(
            ElcodiMenuEvents::POST_LOAD,
            $menuCode,
            $menu
        );

        return $menu;
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
     * Try to get menu configuration from cache
     *
     * @param string $code Code to find the menu
     *
     * @return array Menu configuration
     *
     * @throws Exception
     */
    protected function loadFromRepository($code)
    {
        $menu = $this
            ->menuRepository
            ->findOneBy([
                'code' => $code,
                'enabled' => true,
            ]);

        if ($menu instanceof MenuInterface) {

            return $this
                ->serializer
                ->serializeSubnodes($menu);
        }

        throw new Exception(sprintf(
            'Menu "%s" not found',
            $code
        ));
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

    /**
     * Dispatch a menu event and capture the
     *
     * @param string $eventName Name of the event
     * @param string $menuCode  Code of the menu
     * @param array  $menu      Menu settings
     *
     * @return array
     */
    protected function dispatchMenuEvent($eventName, $menuCode, array $menu)
    {
        if (null === $this->dispatcher) {
            return $menu;
        }

        $event = new MenuEvent($menuCode, $menu, $this->serializer);
        $this
            ->dispatcher
            ->dispatch(
                $eventName,
                $event
            );

        return $event->getResult();
    }
}
