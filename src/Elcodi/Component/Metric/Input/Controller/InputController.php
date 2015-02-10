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

namespace Elcodi\Component\Metric\Input\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Metric\Core\Services\MetricManager;

/**
 * Class InputController
 */
class InputController
{
    /**
     * @var string
     *
     * Transparent png pixel data
     */
    const IMAGE_CONTENT = 'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==';

    /**
     * @var RequestStack
     *
     * Request Stack
     */
    protected $requestStack;

    /**
     * @var MetricManager
     *
     * Metric manager
     */
    protected $metricManager;

    /**
     * Construct
     *
     * @param RequestStack  $requestStack  Request Stack
     * @param MetricManager $metricManager Metric manager
     */
    public function __construct(
        RequestStack $requestStack,
        MetricManager $metricManager
    )
    {
        $this->requestStack = $requestStack;
        $this->metricManager = $metricManager;
    }

    /**
     * /token/event.pixel
     *
     * @param string $token Event
     * @param string $event Token
     *
     * @return Response Empty response
     */
    public function addEntryAction($token, $event)
    {
        $context = $this
            ->requestStack
            ->getCurrentRequest()
            ->query
            ->get('c', []);

        $this
            ->metricManager
            ->addEntry(
                $token,
                $event,
                $context
            );

        $content = base64_decode(self::IMAGE_CONTENT);
        $response = new Response($content);
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}
