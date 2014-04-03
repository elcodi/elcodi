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

namespace Elcodi\ReferralProgramBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\ReferralProgramBundle\Repository\ReferralRuleRepository;

/**
 * Class ReferralRuleManager
 */
class ReferralRuleManager
{

    /**
     * @var ReferralRuleRepository
     *
     * ReferralRule Repository
     */
    protected $referralRuleRepository;

    /**
     * @var ObjectManager
     *
     * manager
     */
    protected $manager;

    /**
     * Construct method
     *
     * @param ReferralRuleRepository $referralRuleRepository Referralrule repository
     * @param ObjectManager          $manager                Manager
     */
    public function __construct(
        ReferralRuleRepository $referralRuleRepository,
        ObjectManager $manager
    )
    {
        $this->referralRuleRepository = $referralRuleRepository;
        $this->manager = $manager;
    }

    /**
     * Given a ReferralRule, disable all other entities and enabled it.
     * Second parameter lets you disable the entity
     *
     * Changed content is flushed
     *
     * @param ReferralRuleInterface $referralRule Referral Rule
     * @param boolean               $enable       Enable
     *
     * @return ReferralRouteManager self Object
     */
    public function enableReferralRule(ReferralRuleInterface $referralRule, $enable = true)
    {
        $referralRule->setEnabled($enable);
        $referralRules = $this->referralRuleRepository->findAll();
        $referralRules->removeElement($referralRule);
        $referralRules->map(function (ReferralRuleInterface $referralRule) {
            $referralRule->setEnabled(false);
        });

        $this->manager->flush();

        return $this;
    }
}
