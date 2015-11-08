<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Bundle\LanguageBundle\Tests\Functional\Twig;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class LanguageExtensionTest
 */
class LanguageExtensionTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.twig_extension.language',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiLanguageBundle',
        ];
    }

    /**
     * Test the result of the function
     */
    public function testGetLanguages()
    {
        $this->assertCount(
            5,
            $this
                ->get('elcodi.twig_extension.language')
                ->getLanguages()
        );
    }
}
