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
use Elcodi\RuleBundle\Factory\RuleGroupFactory;

/**
 * Class RuleGroupData
 */
class RuleGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var RuleGroupFactory $ruleGroupFactory
         * @var RuleGroupInterface $ruleGroup
         */
        $ruleGroupFactory = $this->container->get('elcodi.core.rule.factory.rule_group');
        $ruleGroupTrue = $ruleGroupFactory->create();
        $ruleGroupTrue
            ->setName('RuleGroupTrue')
            ->setCode('rule-group-true');

        $manager->persist($ruleGroupTrue);
        $this->addReference('rule-group-true', $ruleGroupTrue);

        $ruleGroupFalse = $ruleGroupFactory->create();
        $ruleGroupFalse
            ->setName('RuleGroupFalse')
            ->setCode('rule-group-false');

        $manager->persist($ruleGroupFalse);
        $this->addReference('rule-group-false', $ruleGroupFalse);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
 