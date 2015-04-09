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

use Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\SubnodesAwareInterface;
use Elcodi\Component\Menu\Repository\MenuRepository;

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
     * @var EncoderInterface
     *
     * Encoder
     */
    protected $encoder;

    /**
     * @var string
     *
     * key
     */
    protected $key;

    /**
     * Construct method
     *
     * @param MenuRepository $menuRepository Menu repository
     * @param string         $key            Key
     */
    public function __construct(
        MenuRepository $menuRepository,
        $key
    ) {
        $this->menuRepository = $menuRepository;
        $this->key = $key;
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
        $key = $this->buildKey($this->key, $menuCode);

        $menu = $this->loadFromMemory($key);
        if (!$menu) {

            $menu = $this->loadFromCache($key);
            if (!$menu) {

                $menu = $this->loadFromRepository($menuCode);
                $this->saveToCache($key, $menu);
            }

            $this->saveToMemory($key, $menu);
        }

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
            return $this->loadSubnodes($menu);
        }

        throw new Exception(sprintf(
            'Menu "%s" not found',
            $code
        ));
    }

    /**
     * Given a subnodes wrapper, load all subnodes and return their hydration
     *
     * @param SubnodesAwareInterface $node Node
     *
     * @return array Nodes hydrated
     */
    protected function loadSubnodes(SubnodesAwareInterface $node)
    {
        $subnodes = [];

        $node
            ->getSubnodes()
            ->filter(function (NodeInterface $node) {

                return $node->isEnabled();
            })
            ->map(function (NodeInterface $node) use (&$subnodes) {

                $subnodeId = $node->getId();
                $subnodes[$subnodeId] = $this->hydrateNode($node);
            });

        return $subnodes;
    }

    /**
     * Build menu key for cache
     *
     * @param string $key      Key
     * @param string $menuCode Menu code
     *
     * @return string Cache key
     */
    protected function buildKey($key, $menuCode)
    {
        return "{$key}-{$menuCode}";
    }

    /**
     * Generate node hydration
     *
     * @param NodeInterface $node Node
     *
     * @return array Node hydrated
     */
    public function hydrateNode(NodeInterface $node)
    {
        return [
            'id'         => $node->getId(),
            'name'       => $node->getName(),
            'code'       => $node->getCode(),
            'url'        => $node->getUrl(),
            'activeUrls' => $node->getActiveUrls(),
            'subnodes'   => $this->loadSubnodes($node),
        ];
    }
}
