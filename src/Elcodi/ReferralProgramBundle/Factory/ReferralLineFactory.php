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

namespace Elcodi\ReferralProgramBundle\Factory;

use DateTime;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralLineInterface;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ReferralProgramBundle\Entity\ReferralLine;

/**
 * Class ReferralLineFactory
 */
class ReferralLineFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return ReferralLine Empty entity
     */
    public function create()
    {
        /**
         * @var ReferralLineInterface $referralLine
         */
        $classNamespace = $this->getEntityNamespace();
        $referralLine = new $classNamespace();
        $referralLine
            ->setReferrerCouponUsed(false)
            ->setInvitedCouponUsed(false)
            ->setCreatedAt(new DateTime)
            ->setEnabled(false)
            ->setClosed(false);

        return $referralLine;
    }
}
