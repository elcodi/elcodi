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

namespace Elcodi\Component\Core\Encoder;

use Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface;

/**
 * Class JsonEncoder
 */
class JsonEncoder implements EncoderInterface
{
    /**
     * Encode incoming data
     *
     * @param mixed $data Data
     *
     * @return string encoded data
     */
    public function encode($data)
    {
        return json_encode($data);
    }

    /**
     * Decode incoming data
     *
     * @param string $serializedData Serialized data
     *
     * @return mixed Decoded data
     */
    public function decode($serializedData)
    {
        return json_decode($serializedData, true);
    }
}
