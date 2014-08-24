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

namespace Elcodi\Component\Core\Generator;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;

/**
 * Class RandomString
 *
 * This class is a random string generator.
 *
 * A simple set of chars is defined inside, and can be easily overwritten by
 * Overriding the method
 *
 * You can also overwrite getLength() method to override default string length
 */
class RandomStringGenerator implements GeneratorInterface
{
    /**
     * Return needed charset to create random string
     *
     * @return string Set of chars
     */
    protected function getCharset()
    {
        return 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    /**
     * Return the length of desired generator
     *
     * @return string Length of string
     */
    protected function getLength()
    {
        return 10;
    }

    /**
     * Generates a random string
     *
     * @return string Result of generation
     */
    public function generate()
    {
        $string = '';
        $length = $this->getLength();

        for ($i = 0; $i < $length; $i++) {

            $string .= substr(
                $this->getCharset(),
                mt_rand(0, strlen($this->getCharset()) - 1),
                1
            );
        }

        return $string;
    }
}
