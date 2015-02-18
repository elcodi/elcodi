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

namespace Elcodi\Bundle\ReferralProgramBundle\Tests\Functional\Controller;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramCookie;

/**
 * Class ReferralProgramControllerTest
 */
class ReferralProgramControllerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.controller.referral_program',
        ];
    }

    /**
     * Test track action
     */
    public function testTrackAction()
    {
        $client = $this->createClient();
        $client->request('GET', $this->getParameter('elcodi.core.referral_program.controller_route'), [
            'hash' => '1234',
        ]);

        $response = $client->getResponse();
        $cookieValue = $client
            ->getCookieJar()
            ->get(ElcodiReferralProgramCookie::REFERRAL_PROGRAM_COOKIE_NAME)
            ->getValue();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('1234', $cookieValue);
    }
}
