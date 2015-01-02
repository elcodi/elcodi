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
 */

namespace Elcodi\Bundle\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Rule\Factory\ExpressionFactory;

/**
 * Class ExpressionData
 */
class ExpressionData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ExpressionFactory $expressionFactory
         */
        $expressionFactory = $this->getFactory('expression');
        $expressionObjectManager = $this->getObjectManager('expression');

        /**
         * True
         */
        $expressionTrue = $expressionFactory
            ->create()
            ->setExpression('true === true');

        $expressionObjectManager->persist($expressionTrue);
        $this->addReference('expression-true', $expressionTrue);

        /**
         * False
         */
        $expressionFalse = $expressionFactory
            ->create()
            ->setExpression('true === false');

        $expressionObjectManager->persist($expressionFalse);
        $this->addReference('expression-false', $expressionFalse);

        /**
         * parameter
         */
        $expressionVariables = $expressionFactory
            ->create()
            ->setExpression('parameter("elcodi.core.rule.test.parameter") == parameter_value');

        $expressionObjectManager->persist($expressionVariables);
        $this->addReference('expression-variables', $expressionVariables);

        $expressionObjectManager->flush([
            $expressionTrue,
            $expressionFalse,
            $expressionVariables,
        ]);
    }
}
