<?php

/**
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

namespace Elcodi\MediaBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Elcodi\MediaBundle\Entity\Interfaces\FileInterface;
use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ImageUploadControllerTest
 */
class ImageUploadControllerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.media.controller.image_upload';
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
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
            ['image' => $image]
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['status' => 'ok'], json_decode($response->getContent(), true));

        /**
         * @var FileInterface $image
         */
        $image = $this->find('image', 1);
        $this->assertInstanceOf('Elcodi\MediaBundle\Entity\Interfaces\ImageInterface', $image);
        $this->assertEmpty($image->getContent());
        $this->get('elcodi.file_manager')->downloadFile($image);

        $this->assertNotEmpty($image->getContent());
    }
}
