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

namespace Elcodi\Component\Core\Encoder;

use Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface;

/**
 * Class PHPEncoder.
 */
class PHPEncoder implements EncoderInterface
{
    /**
     * Encode incoming data.
     *
     * @param mixed $data Data
     *
     * @return string|bool encoded data
     */
    public function encode($data)
    {
        return serialize($data);
    }

    /**
     * Decode incoming data.
     *
     * @param string|bool $serializedData Serialized data
     *
     * @return mixed Decoded data
     */
    public function decode($serializedData)
    {
        return unserialize($serializedData);
    }
}
