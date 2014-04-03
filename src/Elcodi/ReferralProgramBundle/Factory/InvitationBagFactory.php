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

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ReferralProgramBundle\Model\InvitationBag;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InvitationBagFactory
 */
class InvitationBagFactory extends AbstractFactory
{
    /**
     * Creates an instance of InvitationBag
     *
     * @return InvitationBag Empty instance
     */
    public function create()
    {
        /**
         * @var InvitationBag $invitationBag
         */
        $classNamespace = $this->getEntityNamespace();
        $invitationBag = new $classNamespace();
        $invitationBag
            ->setErrorInvitations(new ArrayCollection)
            ->setSentInvitations(new ArrayCollection);

        return $invitationBag;
    }
}
