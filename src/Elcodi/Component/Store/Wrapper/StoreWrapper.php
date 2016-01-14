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

namespace Elcodi\Component\Store\Wrapper;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;
use Elcodi\Component\Store\Exception\StoreNotFoundException;
use Elcodi\Component\Store\Repository\StoreRepository;

/**
 * Class StoreWrapper.
 */
class StoreWrapper implements WrapperInterface
{
    /**
     * @var StoreInterface
     *
     * Store
     */
    private $store;

    /**
     * @var StoreRepository
     *
     * Store repository
     */
    private $storeRepository;

    /**
     * Construct.
     *
     * @param StoreRepository $storeRepository Store Repository
     */
    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Load store.
     *
     * @return StoreInterface $store Loaded store
     *
     * @throws StoreNotFoundException Store not found
     */
    public function get()
    {
        if ($this->store instanceof StoreInterface) {
            return $this->store;
        }

        $stores = $this
            ->storeRepository
            ->findAll();

        if (empty($stores)) {
            throw new StoreNotFoundException();
        }

        $this->store = reset($stores);

        return $this->store;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        $this->store = null;

        return $this;
    }
}
