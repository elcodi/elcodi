<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\MediaBundle\Services;

use Gaufrette\Filesystem;

use Elcodi\MediaBundle\Entity\Interfaces\FileInterface;
use Elcodi\MediaBundle\Transformer\FileTransformer;

/**
 * Class FileManager
 *
 * This class manages filesystem files
 *
 * Public Methods:
 *
 * * uploadFile(FileInterface, $data, $overwrite)
 * * downloadFile(FileInterface)
 */
class FileManager
{
    /**
     * @var Filesystem
     *
     * Filesystem
     */
    protected $filesystem;

    /**
     * @var FileTransformer
     *
     * File Transformer
     */
    protected $fileTransformer;

    /**
     * Construct method
     *
     * @param Filesystem      $fileSystem      Filesystem
     * @param FileTransformer $fileTransformer File transformer
     */
    public function __construct(Filesystem $fileSystem, FileTransformer $fileTransformer)
    {
        $this->filesystem = $fileSystem;
        $this->fileTransformer = $fileTransformer;
    }

    /**
     * Adds a File to an specific FileSystem, given an specific data
     *
     * Last parameter determines if file must be overwritten if already exists
     *
     * @param FileInterface $file      File to upload
     * @param string        $data      File data
     * @param boolean       $overwrite Overwrite file if exists
     *
     * @return FileManager self Object
     *
     * @api
     */
    public function uploadFile(FileInterface $file, $data, $overwrite = true)
    {
        $this->filesystem->write(
            $this->fileTransformer->transform($file),
            $data,
            $overwrite
        );

        return $this;
    }

    /**
     * Retrieves File data from filesystem
     *
     * @param FileInterface $file File to download
     *
     * @return FileInterface File downloaded
     *
     * @api
     */
    public function downloadFile(FileInterface $file)
    {
        $content = $this
            ->filesystem
            ->read($this
                ->fileTransformer
                ->transform($file)
            );

        $file->setContent($content);

        return $file;
    }
}
