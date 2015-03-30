<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\EntityTranslator\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\EntityTranslator\ElcodiTranslatorEvents;
use Elcodi\Component\EntityTranslator\Event\EntityTranslatorWarmUpEvent;

/**
 * Class EntityTranslatorEventDispatcher
 */
class EntityTranslatorEventDispatcher extends AbstractEventDispatcher
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
                new EntityTranslatorWarmUpEvent()
            );
    }
}
