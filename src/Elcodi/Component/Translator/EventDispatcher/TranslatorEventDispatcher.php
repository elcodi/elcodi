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

namespace Elcodi\Component\Translator\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Translator\ElcodiTranslatorEvents;
use Elcodi\Component\Translator\Event\TranslatorWarmUpEvent;

/**
 * Class TranslatorEventDispatcher
 */
class TranslatorEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch cache warm-up
     */
    public function dispatchTranslatorWarmUp()
    {
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiTranslatorEvents::TRANSLATOR_WARMUP,
                new TranslatorWarmUpEvent()
            );
    }
}
