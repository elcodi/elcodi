<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Factory;

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\CoreBundle\Entity\Language;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class LanguageFactory
 */
class LanguageFactory extends AbstractFactory
{

    /**
     * Creates an instance of a simple language.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Language Empty entity
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
