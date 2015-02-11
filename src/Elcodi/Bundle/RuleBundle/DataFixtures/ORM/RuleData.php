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

namespace Elcodi\Bundle\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Rule\Factory\RuleFactory;

/**
 * Class RuleData
 */
class RuleData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var RuleFactory $ruleFactory
         */
        $ruleFactory = $this->getFactory('rule');

        /**
         * @var ObjectManager $ruleObjectManager
         */
        $ruleObjectManager = $this->getObjectManager('rule');

        $cartOver1000Euros = $ruleFactory
            ->create()
            ->setName('cart_over_1000euros')
            ->setExpression('cart.getAmount() > 1000');

        $ruleObjectManager->persist($cartOver1000Euros);

        $cartUnder10Products = $ruleFactory
            ->create()
            ->setName('cart_under_10products')
            ->setExpression('cart.getQuantity() < 10');

        $ruleObjectManager->persist($cartUnder10Products);

        $cartValuableItems = $ruleFactory
            ->create()
            ->setName('cart_valuable_items')
            ->setExpression('rule("cart_over_1000euros") and rule("cart_under_10products")');

        $ruleObjectManager->persist($cartValuableItems);

        $ruleObjectManager->flush();
    }
}
