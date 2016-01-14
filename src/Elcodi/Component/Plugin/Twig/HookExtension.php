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

namespace Elcodi\Component\Plugin\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Plugin\EventDispatcher\Interfaces\HookSystemEventDispatcherInterface;

/**
 * Class HookExtension for Twig.
 *
 * @author Berny Cantos <be@rny.cc>
 */
class HookExtension extends Twig_Extension
{
    /**
     * @var HookSystemEventDispatcherInterface $hookSystem
     *
     * Where to execute the hooks
     */
    private $hookSystemEventDispatcher;

    /**
     * Construct.
     *
     * @param HookSystemEventDispatcherInterface $hookSystemEventDispatcher Where to execute the hooks
     */
    public function __construct(HookSystemEventDispatcherInterface $hookSystemEventDispatcher)
    {
        $this->hookSystemEventDispatcher = $hookSystemEventDispatcher;
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
                [$this->hookSystemEventDispatcher, 'execute'],
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
