<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\ConfigurationBundle\Tests\Functional\Fixtures;

/**
 * Class MyClass
 */
class MyClass
{
    /**
     * @var string
     *
     * Configuration element
     */
    public $value;

    /**
     * Construct
     *
     * @param string $value Value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get Value
     *
     * @return string Value
     */
    public function getValue()
    {
        return $this->value;
    }
}
