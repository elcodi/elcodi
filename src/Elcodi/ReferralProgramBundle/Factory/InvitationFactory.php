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

namespace Elcodi\ReferralProgramBundle\Factory;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ReferralProgramBundle\Entity\Invitation;

/**
 * Class InvitationFactory
 */
class InvitationFactory extends AbstractFactory
{
    /**
     * Creates an instance of Invitation model
     *
     * @return Invitation Empty model
     */
    public function create()
    {
        /**
         * @var Invitation $invitationBag
         */
        $classNamespace = $this->getEntityNamespace();
        $invitation = new $classNamespace();

        return $invitation;
    }
}
