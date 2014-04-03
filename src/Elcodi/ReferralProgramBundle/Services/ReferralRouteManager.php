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

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface;

/**
 * Class ReferralRouteManager
 */
class ReferralRouteManager
{
    /**
     * @var UrlGeneratorInterface
     *
     * Router
     */
    protected $routeGenerator;

    /**
     * @var string
     *
     * Execution route name
     */
    protected $controllerRouteName;

    /**
     * @param UrlGeneratorInterface $routeGenerator      Route generator
     * @param string                $controllerRouteName Tracking route name
     */
    public function __construct(UrlGeneratorInterface $routeGenerator, $controllerRouteName)
    {
        $this->routeGenerator = $routeGenerator;
        $this->controllerRouteName = $controllerRouteName;
    }

    /**
     * Generates referral program tracking route
     *
     * @param ReferralHashInterface $referralHash Referral hash
     *
     * @return string
     */
    public function generateControllerRoute(ReferralHashInterface $referralHash)
    {
        /**
         * Referral link generation
         */

        return $this
            ->routeGenerator
            ->generate($this->controllerRouteName, array(
                'hash' => $referralHash->getHash()
            ), true);
    }
}
