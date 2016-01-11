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

namespace Elcodi\Component\Language\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Class LanguageFactory.
 */
class LanguageFactory extends AbstractFactory
{
    /**
     * Creates an instance of a simple language.
     *
     * This method must return always an empty instance for related entity
     *
     * @return LanguageInterface Empty entity
     */
    public function create()
    {
        /**
         * @var LanguageInterface $language
         */
        $classNamespace = $this->getEntityNamespace();
        $language = new $classNamespace();

        $language->setEnabled(false);

        return $language;
    }
}
