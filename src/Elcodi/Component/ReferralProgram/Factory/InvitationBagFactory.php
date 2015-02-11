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
use Elcodi\Component\ReferralProgram\Entity\InvitationBag;

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
            ->setErrorInvitations(new ArrayCollection())
            ->setSentInvitations(new ArrayCollection());

        return $invitationBag;
    }
}
