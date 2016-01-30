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

namespace Elcodi\Component\Core\Generator;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;

/**
 * Class Sha1Generator.
 *
 * This class is a sha1 string generator.
 */
class Sha1Generator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
     *
     * Generator
     */
    private $generator;

    /**
     * Construct.
     *
     * @param GeneratorInterface $generator Generator
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generates a random string.
     *
     * @param int $length Length of string generated
     *
     * @return string Result of generation
     */
    public function generate($length = 1)
    {
        return hash(
            'sha1',
            $this
                ->generator
                ->generate($length)
        );
    }
}
