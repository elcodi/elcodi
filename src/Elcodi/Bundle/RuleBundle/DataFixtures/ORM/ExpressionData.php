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

namespace Elcodi\Bundle\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
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
         * @var ExpressionFactory   $expressionFactory
         * @var ExpressionInterface $expressionTrue
         */
        $expressionFactory = $this->container->get('elcodi.core.rule.factory.expression');
        $expressionTrue = $expressionFactory->create();
        $expressionTrue->setExpression('true === true');
        $manager->persist($expressionTrue);
        $this->addReference('expression-true', $expressionTrue);

        /**
         * @var ExpressionInterface $expressionFalse
         */
        $expressionFactory = $this->container->get('elcodi.core.rule.factory.expression');
        $expressionFalse = $expressionFactory->create();
        $expressionFalse->setExpression('true === false');
        $manager->persist($expressionFalse);
        $this->addReference('expression-false', $expressionFalse);

        /**
         * @var ExpressionInterface $expressionVariables
         */
        $expressionVariables = $expressionFactory->create();
        $expressionVariables->setExpression('parameter("elcodi.core.rule.test.parameter") == parameter_value');
        $manager->persist($expressionVariables);
        $this->addReference('expression-variables', $expressionVariables);

        $manager->flush();
    }
}
