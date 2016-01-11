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

namespace Elcodi\Bundle\MediaBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\RouterInterface;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ImageResizeControllerTest.
 */
class ImageResizeControllerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases.
     *
     * @return bool Load schema
     */
    protected static function loadSchema()
    {
        return true;
    }

    /**
     * Test resize action.
     */
    public function testResizeAction()
    {
        /**
         * @var RouterInterface $router
         */
        $client = $this->createClient();
        $router = $this->get('router');
        $routeCollection = $router->getRouteCollection();

        $image = new UploadedFile(
            dirname(__FILE__) . '/images/image.png',
            'image.png',
            'image/png',
            3966,
            null,
            true
        );

        $client->request(
            'POST',
            $routeCollection
                ->get('elcodi.route.image_upload')
                ->getPath(),
            [],
            ['file' => $image]
        );

        $client->request(
            'GET',
            $router->generate(
                'elcodi.route.image_view', [
                    'id' => 1,
                    '_format' => 'json',
                ]
            )
        );

        $responseView = $client->getResponse();
        $this->assertEquals(200, $responseView->getStatusCode());
        $this->assertEquals('image/png', $responseView->headers->get('content-type'));
        $this->assertNotEmpty($responseView->getContent());

        $client->request(
            'GET',
            $router->generate(
                'elcodi.route.image_resize', [
                    'id' => 1,
                    'height' => 30,
                    'width' => 30,
                    'type' => 2,
                    '_format' => 'json',
                ]
            )
        );

        $responseResize = $client->getResponse();
        $this->assertEquals(200, $responseResize->getStatusCode());
        $this->assertEquals('image/jpeg', $responseResize->headers->get('content-type'));
        $this->assertNotEmpty($responseResize->getContent());
        $this->assertNotEquals(
            $responseView->getContent(),
            $responseResize->getContent()
        );
    }
}
