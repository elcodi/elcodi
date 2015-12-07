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

namespace Elcodi\Component\Core\Tests\UnitTest\Entity;

use PHPUnit_Framework_TestCase;

/**
 * Class AbstractEntityTest.
 */
abstract class AbstractEntityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var int
     *
     * Getters and setters
     */
    const GETTER_SETTER = 1;

    /**
     * @var int
     *
     * Adder and Remover
     */
    const ADDER_REMOVER = 2;

    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    abstract public function getEntityNamespace();

    /**
     * Return the fields to test in entities.
     *
     * [
     *      [
     *          "type" => $this::GETTER_SETTER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *          "nullable" => true
     *      ],
     *      [
     *          "type" => $this::ADDER_REMOVER|$this::ADDER_REMOVER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "adder" => "addValue",
     *          "removed" => "removeValue",
     *          "bag" => "collection", // can be array
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *      ]
     * ]
     *
     * @return array Fields
     */
    abstract public function getTestableFields();

    /**
     * Test all desired tests.
     */
    public function testFields()
    {
        $fields = $this->getTestableFields();
        $fields = $this->addTraits($fields);

        foreach ($fields as $field) {
            if ($field['type'] & $this::GETTER_SETTER) {
                $this->checkGetterSetter($field);
            }

            if ($field['type'] & $this::ADDER_REMOVER) {
                $this->checkAdderRemover($field);
            }
        }
    }

    /**
     * Test getter and setter.
     *
     * @param array $field Field
     */
    private function checkGetterSetter(array $field)
    {
        $classNamespace = $this->getEntityNamespace();
        $class = $this->getMock($classNamespace, null, [], '', false);

        $setter = $field['setter'];
        $getter = $field['getter'];
        $value = $this->getFieldValue($field);

        $this->assertSame(
            $class,
            $class->$setter($value)
        );

        $this->assertEquals(
            $value,
            $class->$getter()
        );

        if ($field['nullable']) {
            $class->$setter(null);
            $this->assertNull($class->$getter());
        }
    }

    /**
     * Test adder and removed.
     *
     * @param array $field Field
     */
    private function checkAdderRemover(array $field)
    {
        $class = $this->getMock(
            $this->getEntityNamespace(),
            null, [], '', false
        );

        $setter = $field['setter'];
        $getter = $field['getter'];
        $adder = $field['adder'];
        $remover = $field['remover'];

        $bagType = $field['bag'];
        $bag = $field['bag'] !== 'array'
            ? new $bagType()
            : [];

        $this->assertSame(
            $class,
            $class->$setter($bag)
        );
        $this->assertEmpty($class->$getter());

        $value1 = $this->getFieldValue($field);
        $this->assertSame(
            $class,
            $class->$adder($value1)
        );
        $this->assertCount(1, $class->$getter());

        $value2 = $this->getFieldValue($field);
        $this->assertSame(
            $class,
            $class->$adder($value2)
        );
        $this->assertCount(2, $class->$getter());

        $this->assertSame(
            $class,
            $class->$remover($value1)
        );
        $this->assertCount(1, $class->$getter());

        $this->assertSame(
            $class,
            $class->$remover($this->getFieldValue($field))
        );
        $this->assertCount(1, $class->$getter());
    }

    /**
     * Get value.
     */
    private function getFieldValue($field)
    {
        $value = $field['value'];
        if (class_exists($value) || interface_exists($value)) {
            $value = $this->getMock($value, [], [], '', false);
        }

        return $value;
    }

    /**
     * Add traits.
     */
    private function addTraits($fields)
    {
        $fields = $this->addTraitDateTime($fields);
        $fields = $this->addTraitEnabled($fields);
        $fields = $this->addTraitIdentifiable($fields);
        $fields = $this->addTraitValidInterval($fields);

        return $fields;
    }

    /**
     * Add trait datetime.
     */
    private function addTraitDateTime($fields)
    {
        $classNamespace = $this->getEntityNamespace();
        if (in_array(
            'Elcodi\Component\Core\Entity\Traits\DateTimeTrait',
            class_uses($classNamespace)
        )) {
            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCreatedAt',
                'setter' => 'setCreatedAt',
                'value' => '\DateTime',
                'nullable' => false,
            ];

            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'getUpdatedAt',
                'setter' => 'setUpdatedAt',
                'value' => '\DateTime',
                'nullable' => false,
            ];
        }

        return $fields;
    }

    /**
     * Add trait datetime.
     */
    private function addTraitEnabled($fields)
    {
        $classNamespace = $this->getEntityNamespace();
        if (in_array(
            'Elcodi\Component\Core\Entity\Traits\EnabledTrait',
            class_uses($classNamespace)
        )) {
            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'isEnabled',
                'setter' => 'setEnabled',
                'value' => '\DateTime',
                'nullable' => false,
            ];
        }

        return $fields;
    }

    /**
     * Add trait datetime.
     */
    private function addTraitIdentifiable($fields)
    {
        $classNamespace = $this->getEntityNamespace();
        if (in_array(
            'Elcodi\Component\Core\Entity\Traits\IdentifiableTrait',
            class_uses($classNamespace)
        )) {
            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'getId',
                'setter' => 'setId',
                'value' => 1,
                'nullable' => false,
            ];
        }

        return $fields;
    }

    /**
     * Add trait datetime.
     */
    private function addTraitValidInterval($fields)
    {
        $classNamespace = $this->getEntityNamespace();
        if (in_array(
            'Elcodi\Component\Core\Entity\Traits\ValidIntervalTrait',
            class_uses($classNamespace)
        )) {
            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'getValidFrom',
                'setter' => 'setValidFrom',
                'value' => '\DateTime',
                'nullable' => false,
            ];

            $fields[] = [
                'type' => $this::GETTER_SETTER,
                'getter' => 'getValidTo',
                'setter' => 'setValidTo',
                'value' => '\DateTime',
                'nullable' => true,
            ];
        }

        return $fields;
    }
}
