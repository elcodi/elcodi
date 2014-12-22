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
 */

namespace Elcodi\Bundle\MediaBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Media\Entity\Interfaces\FileInterface;

/**
 * Class ImageUploadControllerTest
 */
class ImageUploadControllerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.media.controller.image_upload';
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
    public function testUploadAction()
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

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals('ok', $content['status']);

        /**
         * @var FileInterface $image
         */
        $image = $this->find('image', 1);
        $this->assertInstanceOf('Elcodi\Component\Media\Entity\Interfaces\ImageInterface', $image);
        $this->assertEmpty($image->getContent());
        $this->get('elcodi.file_manager')->downloadFile($image);

        $this->assertNotEmpty($image->getContent());
    }
}
