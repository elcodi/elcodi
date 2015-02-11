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

namespace Elcodi\Component\ReferralProgram\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\Component\ReferralProgram\Entity\ReferralRule;

/**
 * Class ReferralRuleFactory
 */
class ReferralRuleFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return ReferralRule Empty entity
     */
    public function create()
    {
        /**
         * @var ReferralRuleInterface $referralRule
         */
        $classNamespace = $this->getEntityNamespace();
        $referralRule = new $classNamespace();
        $referralRule
            ->setReferralLines(new ArrayCollection())
            ->setEnabled(false);

        return $referralRule;
    }
}
