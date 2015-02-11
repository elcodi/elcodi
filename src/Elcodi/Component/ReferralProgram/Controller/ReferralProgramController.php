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

namespace Elcodi\Component\ReferralProgram\Controller;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Elcodi\Component\ReferralProgram\ElcodiReferralProgramCookie;

/**
 * Class ReferralProgramRoutesLoader
 */
class ReferralProgramController
{
    /**
     * @var UrlGeneratorInterface
     *
     * UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var string
     *
     * Controller redirect
     */
    protected $controllerRedirect;

    /**
     * @var RequestStack
     *
     * Request stack
     */
    protected $requestStack;

    /**
     * Construct method
     *
     * @param RequestStack          $requestStack       Request stack
     * @param UrlGeneratorInterface $urlGenerator       Url Generator
     * @param string                $controllerRedirect Controller Redirect
     */
    public function __construct(
        RequestStack $requestStack,
        UrlGeneratorInterface $urlGenerator,
        $controllerRedirect
    ) {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
        $this->controllerRedirect = $controllerRedirect;
    }

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
     * @return Response Response object
     */
    public function trackAction()
    {
        $hash = $this
            ->requestStack
            ->getCurrentRequest()
            ->query
            ->get('hash');

        $cookie = new Cookie(ElcodiReferralProgramCookie::REFERRAL_PROGRAM_COOKIE_NAME, $hash);

        $responseUrl = $this
            ->urlGenerator
            ->generate($this->controllerRedirect);

        $response = RedirectResponse::create($responseUrl);
        $response->headers->setCookie($cookie);

        return $response;
    }
}
