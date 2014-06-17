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

namespace Elcodi\RuleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;
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
         * @var RuleGroupFactory   $ruleGroupFactory
         * @var RuleGroupInterface $ruleGroup
         * @var RuleInterface      $ruleTrue
         * @var RuleInterface      $ruleFalse
         */
        $ruleGroupFactory = $this->container->get('elcodi.core.rule.factory.rule_group');
        $ruleTrue = $this->getReference('rule-true');
        $ruleFalse = $this->getReference('rule-false');
        $ruleGroupTrue = $ruleGroupFactory->create();
        $ruleGroupTrue
            ->addRule($ruleTrue)
            ->setName('RuleGroupTrue')
            ->setCode('rule-group-true')
            ->setEnabled(true);

        $manager->persist($ruleGroupTrue);
        $this->addReference('rule-group-true', $ruleGroupTrue);

        $ruleGroupFalse = $ruleGroupFactory->create();
        $ruleGroupFalse
            ->addRule($ruleTrue)
            ->addRule($ruleFalse)
            ->setName('RuleGroupFalse')
            ->setCode('rule-group-false')
            ->setEnabled(true);

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
        return 3;
    }
}
