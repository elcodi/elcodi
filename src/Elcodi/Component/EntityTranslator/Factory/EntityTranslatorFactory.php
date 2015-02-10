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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\EntityTranslator\Factory;

use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslationProviderInterface;

/**
 * Class EntityTranslatorFactory
 */
class EntityTranslatorFactory
{
    use EntityNamespaceTrait;

    /**
     * Creates an instance of a translator
     *
     * @param EntityTranslationProviderInterface $entityTranslationProvider Entity Translation Provider
     * @param array                              $configuration             Configuration
     *
     * @return Object Empty entity
     */
    public function create(
        EntityTranslationProviderInterface $entityTranslationProvider,
        array $configuration
    )
    {
        return new $this->entityNamespace(
            $entityTranslationProvider,
            $configuration
        );
    }
}
