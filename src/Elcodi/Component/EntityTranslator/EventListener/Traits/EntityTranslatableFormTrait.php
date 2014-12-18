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

namespace Elcodi\Component\EntityTranslator\EventListener\Traits;

use Elcodi\Component\EntityTranslator\EventListener\EntityTranslatorFormEventListener;

/**
 * Trait EntityTranslatableFormTrait
 */
trait EntityTranslatableFormTrait
{
    /**
     * @var EntityTranslatorFormEventListener
     *
     * Translator form event listener
     */
    protected $entityTranslatorFormEventListener;

    /**
     * Get Translator form event listener
     *
     * @return EntityTranslatorFormEventListener Translator form event listener
     */
    public function getEntityTranslatorFormEventListener()
    {
        return $this->entityTranslatorFormEventListener;
    }

    /**
     * Set Entity Translator Form event listener
     *
     * @param EntityTranslatorFormEventListener $entityTranslatorFormEventListener Translator form event listener
     *
     * @return $this self Object
     */
    public function setEntityTranslatorFormEventListener(EntityTranslatorFormEventListener $entityTranslatorFormEventListener)
    {
        $this->entityTranslatorFormEventListener = $entityTranslatorFormEventListener;

        return $this;
    }
}
