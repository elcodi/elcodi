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

namespace Elcodi\Component\StateTransitionMachine\Exception;

use Exception;

/**
 * Class StateNotValidException.
 */
class StateNotValidException extends Exception
{
    /**
     * Exception constructor.
     *
     * @param string    $state    Invalid state
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($state, $code = 0, Exception $previous = null)
    {
        $message = 'State "' . $state . '" is not valid or is unreachable';

        parent::__construct($message, $code, $previous);
    }
}
