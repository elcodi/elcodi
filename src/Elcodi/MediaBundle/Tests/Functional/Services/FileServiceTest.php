<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Tests\Functional\Services;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class FileServiceTest
 */
class FileServiceTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.media.service.file_manager',
            'elcodi.file_manager'
        ];
    }

    /**
     * Given a file, upload using single local filesystem.
     * This method also tests download method.
     */
    public function testUploadAndDownloadFile()
    {
        $image = $this->container->get('elcodi.core.media.factory.image')->create();
        $image->setId(1);

        $fileTransformer = $this->container->get('elcodi.core.media.transformer.file');
        $imageName = $fileTransformer->transform($image);
        $imageData = file_get_contents(realpath(dirname(__FILE__)) . '/images/image-10-10.gif');

        $this
            ->container
            ->get('elcodi.core.media.service.file_manager')
            ->uploadFile($image, $imageData, true);

        $this->assertTrue($this
            ->container
            ->get('elcodi.core.media.filesystem.default')
            ->has($imageName)
        );

        $image = $this
            ->container
            ->get('elcodi.core.media.service.file_manager')
            ->downloadFile($image);

        $this->assertEquals($imageData, $image->getContent());

        $this
            ->container
            ->get('elcodi.core.media.filesystem.default')
            ->delete($imageName);
    }
}
