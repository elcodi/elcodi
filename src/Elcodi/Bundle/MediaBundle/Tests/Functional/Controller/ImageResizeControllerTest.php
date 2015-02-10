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

namespace Elcodi\Bundle\MediaBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ImageResizeControllerTest
 */
class ImageResizeControllerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return ['elcodi.core.media.controller.image_resize'];
    }

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Test resize action
     */
    public function testResizeAction()
    {
        $client = $this->createClient();
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
            $this->getParameter('elcodi.core.media.image_upload_controller_route'),
            [],
            ['file' => $image]
        );

        $client->request(
            'GET',
            $this->getParameter('elcodi.core.media.image_view_controller_route'),
            ['id' => 1]
        );

        $responseView = $client->getResponse();
        $this->assertEquals(200, $responseView->getStatusCode());
        $this->assertEquals('image/png', $responseView->headers->get('content-type'));
        $this->assertNotEmpty($responseView->getContent());

        $client->request(
            'GET',
            $this->getParameter('elcodi.core.media.image_resize_controller_route'),
            ['id' => 1, 'height' => 30, 'width' => 30, 'type' => 2]
        );

        $responseResize = $client->getResponse();
        $this->assertEquals(200, $responseResize->getStatusCode());
        $this->assertEquals('image/png', $responseResize->headers->get('content-type'));
        $this->assertNotEmpty($responseResize->getContent());
        $this->assertNotEquals(
            $responseView->getContent(),
            $responseResize->getContent()
        );
    }
}
