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

namespace Elcodi\Component\Media\Services;

use Gaufrette\Filesystem;

use Elcodi\Component\Media\Entity\Interfaces\FileInterface;
use Elcodi\Component\Media\Transformer\Interfaces\FileIdentifierTransformerInterface;

/**
 * Class FileManager.
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
    private $filesystem;

    /**
     * @var FileIdentifierTransformerInterface
     *
     * File identifier Transformer
     */
    private $fileIdentifierTransformer;

    /**
     * Construct method.
     *
     * @param Filesystem                         $fileSystem                Filesystem
     * @param FileIdentifierTransformerInterface $fileIdentifierTransformer File identifier transformer
     */
    public function __construct(
        Filesystem $fileSystem,
        FileIdentifierTransformerInterface $fileIdentifierTransformer
    ) {
        $this->filesystem = $fileSystem;
        $this->fileIdentifierTransformer = $fileIdentifierTransformer;
    }

    /**
     * Adds a File to an specific FileSystem, given an specific data.
     *
     * Last parameter determines if file must be overwritten if already exists
     *
     * @param FileInterface $file      File to upload
     * @param string        $data      File data
     * @param bool          $overwrite Overwrite file if exists
     *
     * @return $this Self object
     */
    public function uploadFile(FileInterface $file, $data, $overwrite = true)
    {
        $this
            ->filesystem
            ->write(
                $this
                    ->fileIdentifierTransformer
                    ->transform($file),
                $data,
                $overwrite
            );

        return $this;
    }

    /**
     * Given a Doctrine mapped File instance, retrieves its data and fill
     * content local variable with it.
     *
     * @param FileInterface $file File to download
     *
     * @return FileInterface File downloaded
     */
    public function downloadFile(FileInterface $file)
    {
        /**
         * @var string $content
         */
        $content = $this
            ->filesystem
            ->read($this
                ->fileIdentifierTransformer
                ->transform($file)
            );

        $file->setContent($content);

        return $file;
    }
}
