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

namespace Elcodi\Bundle\MediaBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class FileServiceTest.
 */
class FileServiceTest extends WebTestCase
{
    /**
     * Given a file, upload using single local filesystem.
     * This method also tests download method.
     */
    public function testUploadAndDownloadFile()
    {
        $image = $this->get('elcodi.factory.image')->create();
        $image->setId(1);

        $fileTransformer = $this->get('elcodi.transformer.media_file_identifier');
        $imageName = $fileTransformer->transform($image);
        $imageData = file_get_contents(realpath(dirname(__FILE__)) . '/images/image-10-10.gif');

        $this
            ->get('elcodi.manager.media_file')
            ->uploadFile($image, $imageData, true);

        $this->assertTrue($this
            ->get('elcodi.media_filesystem')
            ->has($imageName)
        );

        $image = $this
            ->get('elcodi.manager.media_file')
            ->downloadFile($image);

        $this->assertEquals($imageData, $image->getContent());

        $this
            ->get('elcodi.media_filesystem')
            ->delete($imageName);
    }
}
