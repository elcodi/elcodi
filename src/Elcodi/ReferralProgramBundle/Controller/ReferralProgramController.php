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

namespace Elcodi\ReferralProgramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\ReferralProgramBundle\ElcodiReferralProgramBundle;

/**
 * Class ReferralProgramRoutesLoader
 */
class ReferralProgramController extends Controller
{
    /**
     * When a simple web user click a referral link, this code is executed.
     *
     * A hash is defined in the route ( at least should be defined ), so we
     * can retrieve referral line given this hash.
     *
     * If hash exists, current hash is saved in the cookie, so if user
     * registers or makes a purchase, this value will be used for
     * referral program engine.
     *
     * If cookie is already set, hash value is overwritten.
     *
     * @param string $hash Referral Program Hash
     *
     * @return Response Response object
     */
    public function trackAction($hash)
    {
        $cookie = new Cookie(ElcodiReferralProgramBundle::REFERRAL_PROGRAM_COOKIE_NAME, $hash);
        $response = $this->redirect($this->generateUrl($this->container->getParameter('elcodi.core.referral_program.controller_redirect')));
        $response->headers->setCookie($cookie);

        return $response;
    }
}
