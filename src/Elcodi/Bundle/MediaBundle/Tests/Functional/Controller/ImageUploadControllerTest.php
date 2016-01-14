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
use Symfony\Component\Routing\RouteCollection;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Media\Entity\Interfaces\FileInterface;

/**
 * Class ImageUploadControllerTest.
 */
class ImageUploadControllerTest extends WebTestCase
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
    public function testUploadAction()
    {
        /**
         * @var RouteCollection $routeCollection
         */
        $client = $this->createClient();
        $routeCollection = $this
            ->get('router')
            ->getRouteCollection();

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
        $this
            ->get('elcodi.manager.media_file')
            ->downloadFile($image);

        $this->assertNotEmpty($image->getContent());
    }
}
