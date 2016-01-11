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

namespace Elcodi\Component\Core\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class ReferrerProvider.
 */
class ReferrerProvider
{
    /**
     * @var SessionInterface
     *
     * Session
     */
    private $session;

    /**
     * Construct.
     *
     * @param SessionInterface $session Session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Get referrer.
     *
     * @return string Referrer
     */
    public function getReferrer()
    {
        return $this
            ->session
            ->get('referrer', false);
    }

    /**
     * Get referrer.
     *
     * @return string Referrer
     */
    public function getReferrerDomain()
    {
        return parse_url($this->getReferrer(), PHP_URL_HOST);
    }

    /**
     * Referrer is search engine.
     *
     * @return bool Is search engine
     */
    public function referrerIsSearchEngine()
    {
        $referrerHostExploded = explode('.', $this->getReferrerDomain());
        $numberOfPieces = count($referrerHostExploded);
        $positionToCheck = $numberOfPieces - 2;

        if (!isset($referrerHostExploded[$positionToCheck])) {
            return false;
        }

        if (strlen($referrerHostExploded[$positionToCheck]) <= 3) {
            --$positionToCheck;

            if (!isset($referrerHostExploded[$positionToCheck])) {
                return false;
            }
        }

        return in_array(
            $referrerHostExploded[$positionToCheck],
            [
                'baidu',
                'bing',
                'bleikko',
                'duckduckgo',
                'exalead',
                'gigablast',
                'google',
                'munax',
                'qwant',
                'sogou',
                'yahoo',
                'yandex',
            ]
        );
    }
}
