<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\RuleBundle\Factory\RuleFactory;

/**
 * Class RuleData
 */
class RuleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var RuleFactory   $ruleFactory
         */
        $ruleFactory = $this->container->get('elcodi.core.rule.factory.rule');
        $expressionTrue = $this->getReference('expression-true');
        $expressionFalse = $this->getReference('expression-false');
        $expressionVariables = $this->getReference('expression-variables');
        $ruleTrue = $ruleFactory->create();
        $ruleTrue
            ->setName('Rule true')
            ->setCode('rule-true')
            ->setEnabled(true)
            ->setExpression($expressionTrue);
        $manager->persist($ruleTrue);
        $this->addReference('rule-true', $ruleTrue);

        $ruleFalse = $ruleFactory->create();
        $ruleFalse
            ->setName('Rule false')
            ->setCode('rule-false')
            ->setEnabled(true)
            ->setExpression($expressionFalse);
        $manager->persist($ruleFalse);
        $this->addReference('rule-false', $ruleFalse);

        $ruleVariables = $ruleFactory->create();
        $ruleVariables
            ->setName('Rule variables')
            ->setCode('rule-variables')
            ->setEnabled(true)
            ->setExpression($expressionVariables);
        $manager->persist($ruleVariables);
        $this->addReference('rule-variables', $ruleVariables);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
