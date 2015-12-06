<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Cart\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class CartIntegrityValidator.
 *
 * Api Methods:
 *
 * * validateCartIntegrity(CartInterface)
 *
 * @api
 */
class CartIntegrityValidator
{
    /**
     * @var CartEventDispatcher
     *
     * Cart EventDispatcher
     */
    private $cartEventDispatcher;

    /**
     * @var CartManager
     *
     * Cart Manager
     */
    private $cartManager;

    /**
     * @var bool
     *
     * Uses stock
     */
    private $useStock;

    /**
     * Built method.
     *
     * @param CartEventDispatcher $cartEventDispatcher Cart event dispatcher
     * @param CartManager         $cartManager         Cart Manager
     * @param bool                $useStock            Use stock
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        CartManager $cartManager,
        $useStock = false
    ) {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
        $this->useStock = $useStock;
    }

    /**
     * Validate cart integrity.
     *
     * @param CartInterface $cart Cart
     */
    public function validateCartIntegrity(CartInterface $cart)
    {
        /**
         * Check every CartLine.
         *
         * @var CartLineInterface $cartLine
         */
        foreach ($cart->getCartLines() as $cartLine) {
            $this->validateCartLine($cartLine);
        }
    }

    /**
     * Check CartLine integrity.
     *
     * When a purchasable is not enabled or its quantity is <=0,
     * the line is discarded and a ElcodiCartEvents::CART_INCONSISTENT
     * event is fired.
     *
     * A further check on stock availability is performed so that when
     * $quantity is greater that the available units, $quantity for this
     * CartLine is set to Purchasable::$stock number
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface CartLine
     */
    private function validateCartLine(CartLineInterface $cartLine)
    {
        $cart = $cartLine->getCart();
        $purchasable = $cartLine->getPurchasable();

        if (
            !($purchasable instanceof PurchasableInterface) ||
            !($purchasable->isEnabled()) ||
            (
                $this->useStock &&
                $cartLine->getQuantity() <= 0
            )
        ) {
            $this->cartManager->silentRemoveLine(
                $cart,
                $cartLine
            );

            /**
             * An inconsistent cart event is dispatched.
             */
            $this
                ->cartEventDispatcher
                ->dispatchCartInconsistentEvent(
                    $cart,
                    $cartLine
                );
        }

        /**
         * We cannot exceed available stock for a given purchasable
         * when setting CartLine::$quantity.
         *
         * This checking has sense when the Product has not infinite stock
         */
        if (
            $this->useStock &&
            ($cartLine->getProduct()->getStock() !== ElcodiProductStock::INFINITE_STOCK) &&
            ($cartLine->getQuantity() > $purchasable->getStock())
        ) {
            $cartLine->setQuantity($purchasable->getStock());
        }

        return $cartLine;
    }
}
