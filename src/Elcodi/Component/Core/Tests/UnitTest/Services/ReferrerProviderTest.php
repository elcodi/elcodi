<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Core\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\Component\Core\Services\ReferrerProvider;

/**
 * Class ReferrerProviderTest.
 */
class ReferrerProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SessionInterface
     *
     * Session
     */
    protected $session;

    /**
     * @var ReferrerProvider
     *
     * Referrer provider
     */
    protected $referrerProvider;

    /**
     * Setup.
     */
    public function setup()
    {
        $this->session = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $this->referrerProvider = new ReferrerProvider($this->session);
    }

    /**
     * Test get referrer with not empty in session.
     */
    public function testGetReferrerNotEmpty()
    {
        $this
            ->session
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue('value'));

        $this->assertEquals(
            'value',
            $this
                ->referrerProvider
                ->getReferrer()
        );
    }

    /**
     * Test get referrer with empty in session.
     */
    public function testGetReferrerEmpty()
    {
        $this
            ->session
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue(false));

        $this->assertEquals(
            false,
            $this
                ->referrerProvider
                ->getReferrer()
        );
    }

    /**
     * Test get referrer domain.
     *
     * @dataProvider getReferrerDomainTest
     */
    public function testGetReferrerDomain($referrer, $domain)
    {
        $this
            ->session
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($referrer));

        $this->assertEquals(
            $domain,
            $this
                ->referrerProvider
                ->getReferrerDomain()
        );
    }

    /**
     * Data for testGetReferrerDomain.
     */
    public function getReferrerDomainTest()
    {
        return [
            [null, ''],
            [false, ''],
            [true, ''],
            ['', ''],
            ['http://google', 'google'],
            ['http://google.es/', 'google.es'],
            ['http://google.com', 'google.com'],
            ['http://google.com/', 'google.com'],
            ['http://google.com/whatever/can/be.com', 'google.com'],
            ['https://google.com', 'google.com'],
            ['https://somestuff.google.com', 'somestuff.google.com'],
        ];
    }

    /**
     * Test referrer is search engine.
     *
     * @dataProvider dataReferrerIsSearchEngine
     */
    public function testReferrerIsSearchEngine($referrer, $isSearchEngine)
    {
        $this
            ->session
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($referrer));

        $this->assertEquals(
            $isSearchEngine,
            $this
                ->referrerProvider
                ->referrerIsSearchEngine()
        );
    }

    /**
     * Data for testReferrerIsSearchEngine.
     */
    public function dataReferrerIsSearchEngine()
    {
        return [
            [null, false],
            [false, false],
            [true, false],
            ['', false],
            ['http://google.es/', true],
            ['http://google.com', true],
            ['http://engonga.com/', false],
            ['http://my.engonga.com/', false],
            ['http://facebook.com/whatever/can/be.com', false],
            ['https://duckduckgo.co.uk', true],
        ];
    }
}
