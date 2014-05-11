<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */
 
namespace Elcodi\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;
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
         * @var RuleFactory $ruleFactory
         * @var RuleGroupInterface $ruleGroupTrue
         * @var RuleGroupInterface $ruleGroupFalse
         * @var RuleInterface $rule
         */
        $ruleFactory = $this->container->get('elcodi.core.rule.factory.rule');
        $ruleGroupTrue = $this->getReference('rule-group-true');
        $ruleGroupFalse = $this->getReference('rule-group-false');
        $ruleTrue = $ruleFactory->create();
        $ruleTrue
            ->setName('Rule true')
            ->setCode('rule-true')
            ->setExpression('true === true')
            ->addRuleGroup($ruleGroupTrue);
        $manager->persist($ruleTrue);
        $this->addReference('rule-true', $ruleTrue);

        $ruleFalse = $ruleFactory->create();
        $ruleFalse
            ->setName('Rule false')
            ->setCode('rule-false')
            ->setExpression('true === false')
            ->addRuleGroup($ruleGroupTrue)
            ->addRuleGroup($ruleGroupFalse);
        $manager->persist($ruleFalse);
        $this->addReference('rule-false', $ruleFalse);

        $ruleGroupTrue
            ->addRule($ruleTrue);

        $ruleGroupFalse
            ->addRule($ruleTrue)
            ->addRule($ruleFalse);

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
 