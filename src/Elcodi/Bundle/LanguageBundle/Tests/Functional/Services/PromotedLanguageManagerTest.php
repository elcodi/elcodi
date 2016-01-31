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
 * Tests PromotedLanguageManagerTest class.
 */
class PromotedLanguageManagerTest extends WebTestCase
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
     * Test getLanguagesWithMasterLanguagePromoted.
     */
    public function testGetLanguagesWithMasterLanguagePromoted()
    {
        $languages = $this
            ->get('elcodi.manager.promoted_language')
            ->getLanguagesWithMasterLanguagePromoted();

        $this->assertCount(5, $languages);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\Language\Entity\Interfaces\LanguageInterface',
            $languages
        );

        $this->assertEquals(
            'en',
            $languages
                ->first()
                ->getIso()
        );

        $this->assertEquals(
            $languages,
            $this->get('elcodi.languages_with_master_promoted')
        );
    }
}
