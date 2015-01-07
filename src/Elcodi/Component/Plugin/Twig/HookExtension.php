<?php

/*
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

namespace Elcodi\Component\Plugin\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Plugin\Interfaces\HookSystemInterface;

/**
 * Class HookExtension for Twig
 *
 * @author Berny Cantos <be@rny.cc>
 */
class HookExtension extends Twig_Extension
{
    /**
     * @var HookSystemInterface $hookSystem
     *
     * Where to execute the hooks
     */
    protected $hookSystem;

    /**
     * Construct
     *
     * @param HookSystemInterface $hookSystem Where to execute the hooks
     */
    public function __construct(HookSystemInterface $hookSystem)
    {
        $this->hookSystem = $hookSystem;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'elcodi_hook',
                [$this->hookSystem, 'execute'],
                [
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'hook_extension';
    }
}
