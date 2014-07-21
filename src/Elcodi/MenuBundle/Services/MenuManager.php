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

namespace Elcodi\MenuBundle\Services;

use Elcodi\CoreBundle\Encoder\Interfaces\EncoderInterface;
use Elcodi\CoreBundle\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\MenuBundle\Entity\Menu\Interfaces\MenuInterface;
use Elcodi\MenuBundle\Entity\Menu\Interfaces\NodeInterface;
use Elcodi\MenuBundle\Entity\Menu\Interfaces\SubnodesAwareInterface;
use Elcodi\MenuBundle\Repository\MenuRepository;

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
     * Load menu hidration given the code.
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

        $menuHidrated = $this
            ->encoder
            ->decode($this->cache->fetch($key));

        if (empty($menuHidrated)) {

            $menu = $this
                ->menuRepository
                ->findOneBy([
                    'code'    => $menuCode,
                    'enabled' => true
                ]);

            if (!($menu instanceof MenuInterface)) {
                return null;
            }

            $menuHidrated = $this->loadSubnodes($menu);

            $this
                ->cache
                ->save($key, $this->encoder->encode($menuHidrated));
        }

        $this->menus[$key] = $menuHidrated;

        return $menuHidrated;
    }

    /**
     * Given a subnodes wrapper, load all subnodes and return their hidration
     *
     * @param SubnodesAwareInterface $node Node
     *
     * @return array Nodes hidrated
     */
    protected function loadSubnodes(SubnodesAwareInterface $node)
    {
        $subnodesHidrated = [];

        $node
            ->getSubnodes()
            ->map(function (NodeInterface $node) use (&$subnodesHidrated) {

                $subnodeId = $node->getId();
                $subnodesHidrated[$subnodeId] = $this->hidrateNode($node);
            });

        return $subnodesHidrated;
    }

    /**
     * buld menu key
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
     * Generate node hidration
     *
     * @param NodeInterface $node Node
     *
     * @return array Node hidrated
     */
    public function hidrateNode(NodeInterface $node)
    {
        return [
            'id'       => $node->getId(),
            'name'     => $node->getName(),
            'url'      => $node->getUrl(),
            'subnodes' => $this->loadSubnodes($node)
        ];
    }
}
