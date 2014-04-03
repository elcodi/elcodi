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

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ReferralProgramBundle\Entity\ReferralHash;

/**
 * Class ReferralHashFactory
 */
class ReferralHashFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return ReferralHash Empty entity
     */
    public function create()
    {
        /**
         * @var ReferralHashInterface $referralHash
         */
        $classNamespace = $this->getEntityNamespace();
        $referralHash = new $classNamespace();
        $referralHash
            ->setReferralLines(new ArrayCollection);

        return $referralHash;
    }
}
