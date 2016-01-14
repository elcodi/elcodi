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

namespace Elcodi\Bundle\EntityTranslatorBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct;

/**
 * Class TranslatorTest.
 */
class TranslatorTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases.
     *
     * @return bool Load schema
     */
    protected static function loadSchema()
    {
        return true;
    }

    /**
     * Test translate.
     */
    public function testTranslate()
    {
        $translation = $this
            ->getFactory('entity_translation')
            ->create()
            ->setEntityType('translatable_product')
            ->setEntityId(1)
            ->setEntityField('name')
            ->setLocale('es')
            ->setTranslation('nombre del producto');

        $this->flush($translation);

        $this
            ->get('elcodi.event_dispatcher.entity_translator')
            ->dispatchTranslatorWarmUp();

        $translatableProduct = new TranslatableProduct();
        $translatableProduct
            ->setId(1)
            ->setName('my default name');

        $translatableProduct = $this
            ->get('elcodi.entity_translator')
            ->translate($translatableProduct, 'es');

        $this->assertEquals('nombre del producto', $translatableProduct->getName());
    }

    /**
     * Test save.
     */
    public function testSave()
    {
        $this->reloadScenario();

        $translation = $this
            ->getFactory('entity_translation')
            ->create()
            ->setEntityType('translatable_product')
            ->setEntityId(1)
            ->setEntityField('name')
            ->setLocale('es')
            ->setTranslation('nombre del producto');

        $this->flush($translation);

        $this
            ->get('elcodi.event_dispatcher.entity_translator')
            ->dispatchTranslatorWarmUp();

        $translatableProduct = new TranslatableProduct();
        $translatableProduct
            ->setId(1)
            ->setName('my default name')
            ->setDescription('my default description');

        $this
            ->get('elcodi.entity_translator')
            ->save($translatableProduct, [
                'es' => [
                    'name' => 'el nombre',
                ],
                'en' => [
                    'name' => 'the name',
                ],
                'fr' => [
                    'name' => 'le nom',
                ],
            ]);

        $this->assertCount(3, $this
            ->findAll('entity_translation')
        );

        $cache = $this->get('doctrine_cache.providers.elcodi_translations');
        $this->assertEquals('el nombre', $cache->fetch('translation_translatable_product_1_name_es'));
        $this->assertEquals('the name', $cache->fetch('translation_translatable_product_1_name_en'));
        $this->assertEquals('le nom', $cache->fetch('translation_translatable_product_1_name_fr'));
    }
}
