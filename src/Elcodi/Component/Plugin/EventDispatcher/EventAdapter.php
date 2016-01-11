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

namespace Elcodi\Component\Plugin\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;

/**
 * Class EventAdapter.
 *
 * @author Berny Cantos <be@rny.cc>
 */
class EventAdapter extends Event implements EventInterface
{
    /**
     * @var array
     *
     * Context from the caller
     */
    private $context;

    /**
     * @var string
     *
     * Content to be returned
     */
    private $content;

    /**
     * Create a new event from context and content.
     *
     * @param array  $context Caller's context
     * @param string $content Original content
     */
    public function __construct(array $context = [], $content = '')
    {
        $this->content = $content;
        $this->context = $context;
    }

    /**
     * Get a value from the context, with a fallback default.
     *
     * @param string     $key     Index in the context
     * @param mixed|null $default Default value if there's no entry
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->context)) {
            return $this->context[$key];
        }

        return $default;
    }

    /**
     * Get full context.
     *
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Get current content.
     *
     * @return string
     */
    public function getContent()
    {
        return (string) $this->content;
    }

    /**
     * Set current content.
     *
     * @param string $content
     *
     * @return $this Self object
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
