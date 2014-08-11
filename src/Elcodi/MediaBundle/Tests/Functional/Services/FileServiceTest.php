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

namespace Elcodi\MediaBundle\Tests\Functional\Services;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

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
        $image = $this->get('elcodi.core.media.factory.image')->create();
        $image->setId(1);

        $fileTransformer = $this->get('elcodi.core.media.transformer.file_identifier_transformer');
        $imageName = $fileTransformer->transform($image);
        $imageData = file_get_contents(realpath(dirname(__FILE__)) . '/images/image-10-10.gif');

        $this
            ->get('elcodi.core.media.service.file_manager')
            ->uploadFile($image, $imageData, true);

        $this->assertTrue($this
            ->get('elcodi.core.media.filesystem.default')
            ->has($imageName)
        );

        $image = $this
            ->get('elcodi.core.media.service.file_manager')
            ->downloadFile($image);

        $this->assertEquals($imageData, $image->getContent());

        $this
            ->get('elcodi.core.media.filesystem.default')
            ->delete($imageName);
    }
}
