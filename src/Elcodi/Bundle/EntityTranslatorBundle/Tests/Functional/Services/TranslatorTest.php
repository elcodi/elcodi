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

namespace Elcodi\Bundle\EntityTranslatorBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct;

/**
 * Class TranslatorTest
 */
class TranslatorTest extends WebTestCase
{
    /**
     * Test translate
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
     * Test translate
     */
    public function testSave()
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
            ->setName('my default name')
            ->setDescription('my default description');

        $this
            ->get('elcodi.entity_translator')
            ->save($translatableProduct, array(
                'es' => array(
                    'name'        => 'el nombre',
                ),
                'en' => array(
                    'name'         => 'the name',
                ),
                'fr' => array(
                    'name'         => 'le nom',
                ),
            ));

        $this->assertCount(3, $this
            ->findAll('entity_translation')
        );

        $cache = $this->get('doctrine_cache.providers.elcodi');
        $this->assertEquals('el nombre', $cache->fetch('translation_translatable_product_1_name_es'));
        $this->assertEquals('the name', $cache->fetch('translation_translatable_product_1_name_en'));
        $this->assertEquals('le nom', $cache->fetch('translation_translatable_product_1_name_fr'));
    }
}
