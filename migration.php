<?php

namespace Elcodi;

use Symfony\Component\Finder\Finder;

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
require "vendor/autoload.php";
$m = new migration();
$m->run();

/**
 * Class migration
 */
class migration
{
    public $path;
    public $bucket = [];

    public function __construct()
    {
        $this->path = dirname(__FILE__) . '/src/Elcodi/';
    }

    public function run()
    {
        $files = new Finder();
        $files
            ->files()
            ->name('*.php')
            ->in($this->path);

        foreach ($files as $file) {

            $validNamespace = str_replace('/var/www/elcodi/elcodi/src/', '', $file->getRealpath());
            $validNamespace = str_replace('/', '\\', $validNamespace);
            $validNamespace = str_replace('.php', '', $validNamespace);
            $validNamespace = explode('\\', $validNamespace);
            array_pop($validNamespace);
            $validNamespace = implode('\\', $validNamespace);
            $existingNamespace = $this->getFileClassNamespace($file->getRealpath());
            $existingNamespace = explode('\\', $existingNamespace);
            array_pop($existingNamespace);
            $existingNamespace = implode('\\', $existingNamespace);

            $this->bucket[$existingNamespace] = $validNamespace;
        }

        $files = new Finder();
        $files
            ->files()
            ->in($this->path);

        foreach ($files as $file) {

            $str = file_get_contents($file->getRealpath());
            $str = str_replace(array_keys($this->bucket), array_values($this->bucket), $str);
            file_put_contents($file->getRealpath(), $str);
        }

        print_r($this->bucket);
    }

    /**
     * Returns file class namespace, if exists
     *
     * @param string $file A PHP file path
     *
     * @return string|false Full class namespace if found, false otherwise
     */
    public function getFileClassNamespace($file)
    {
        $filenameBlock = explode(DIRECTORY_SEPARATOR, $file);
        $filename = explode('.', end($filenameBlock), 2);
        $filename = reset($filename);

        preg_match('/\snamespace\s+(.+?);/s', file_get_contents($file), $match);

        return    is_array($match) && isset($match[1])
                ? $match[1] . '\\' . $filename
                : false;
    }
}
 