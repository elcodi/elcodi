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

namespace Elcodi\Bundle\LanguageBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Tests LanguageManagerTest class.
 */
class LanguageManagerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiLanguageBundle',
        ];
    }

    /**
     * Test get languages.
     */
    public function testGetLanguages()
    {
        $languages = $this
            ->get('elcodi.manager.language')
            ->getLanguages();

        $this->assertCount(5, $languages);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Language\Entity\Interfaces\LanguageInterface',
            $languages
        );
        $this->assertEquals(
            'es',
            $languages
                ->first()
                ->getIso()
        );
    }

    /**
     * Test get languages iso.
     */
    public function testGetLanguagesIso()
    {
        $languages = $this
            ->get('elcodi.manager.language')
            ->getLanguagesIso();

        $this->assertEquals(
            ['es', 'en', 'fr', 'it', 'de'],
            $languages->toArray()
        );
    }
}
