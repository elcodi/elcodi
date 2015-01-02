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

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
use Elcodi\Component\Rule\Factory\RuleFactory;

/**
 * Class RuleData
 */
class RuleData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var RuleFactory         $ruleFactory
         * @var ExpressionInterface $expressionTrue
         * @var ExpressionInterface $expressionFalse
         * @var ExpressionInterface $expressionVariables
         */
        $ruleFactory = $this->getFactory('rule');
        $ruleObjectManager = $this->getObjectManager('rule');
        $expressionTrue = $this->getReference('expression-true');
        $expressionFalse = $this->getReference('expression-false');
        $expressionVariables = $this->getReference('expression-variables');

        $ruleTrue = $ruleFactory
            ->create()
            ->setName('Rule true')
            ->setCode('rule-true')
            ->setEnabled(true)
            ->setExpression($expressionTrue);

        $ruleObjectManager->persist($ruleTrue);
        $this->addReference('rule-true', $ruleTrue);

        $ruleFalse = $ruleFactory
            ->create()
            ->setName('Rule false')
            ->setCode('rule-false')
            ->setEnabled(true)
            ->setExpression($expressionFalse);

        $ruleObjectManager->persist($ruleFalse);
        $this->addReference('rule-false', $ruleFalse);

        $ruleVariables = $ruleFactory
            ->create()
            ->setName('Rule variables')
            ->setCode('rule-variables')
            ->setEnabled(true)
            ->setExpression($expressionVariables);

        $ruleObjectManager->persist($ruleVariables);
        $this->addReference('rule-variables', $ruleVariables);

        $ruleObjectManager->flush([
            $ruleTrue,
            $ruleFalse,
            $ruleVariables,
        ]);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\RuleBundle\DataFixtures\ORM\ExpressionData',
        ];
    }
}
