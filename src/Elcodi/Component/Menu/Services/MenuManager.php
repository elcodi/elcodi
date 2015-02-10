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

namespace Elcodi\Component\Menu\Services;

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
    )
    {
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
     * @return array|null Result
     */
    public function loadMenuByCode($menuCode)
    {
        $key = $this->buildKey($this->key, $menuCode);

        if (isset($this->menus[$key])) {
            return $this->menus[$key];
        }

        $menuHydrated = $this
            ->encoder
            ->decode($this->cache->fetch($key));

        if (empty($menuHydrated)) {

            $menu = $this
                ->menuRepository
                ->findOneBy([
                    'code'    => $menuCode,
                    'enabled' => true
                ]);

            if (!($menu instanceof MenuInterface)) {
                return null;
            }

            $menuHydrated = $this->loadSubnodes($menu);

            $this
                ->cache
                ->save($key, $this->encoder->encode($menuHydrated));
        }

        $this->menus[$key] = $menuHydrated;

        return $menuHydrated;
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
        $subnodesHydrated = [];

        $node
            ->getSubnodes()
            ->map(function (NodeInterface $node) use (&$subnodesHydrated) {

                $subnodeId = $node->getId();
                $subnodesHydrated[$subnodeId] = $this->hydrateNode($node);
            });

        return $subnodesHydrated;
    }

    /**
     * build menu key
     *
     * @param string $key      Key
     * @param string $menuCode Menu code
     *
     * @return string Cache key
     */
    protected function buildKey($key, $menuCode)
    {
        return $key . '-' . $menuCode;
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
            'id'       => $node->getId(),
            'name'     => $node->getName(),
            'code'     => $node->getCode(),
            'url'      => $node->getUrl(),
            'subnodes' => $this->loadSubnodes($node)
        ];
    }
}
