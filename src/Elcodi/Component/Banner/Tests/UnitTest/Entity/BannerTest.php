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

namespace Elcodi\Component\Banner\Tests\UnitTest\Entity;

use Elcodi\Component\Banner\Entity\Banner;
use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

/**
 * Class BannerTest.
 */
class BannerTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Banner\Entity\Banner';
    }

    /**
     * Return the fields to test in entities.
     *
     * [
     *      [[
     *          "type" => $this::GETTER_SETTER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *          "nullable" => true
     *      ]],
     *      [[
     *          "type" => $this::ADDER_REMOVER|$this::ADDER_REMOVER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "adder" => "addValue",
     *          "removed" => "removeValue",
     *          "bag" => "collection", // can be array
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *      ]]
     * ]
     *
     * @return array Fields
     */
    public function getTestableFields()
    {
        return [
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getName',
                'setter' => 'setName',
                'value' => sha1(rand()),
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getDescription',
                'setter' => 'setDescription',
                'value' => sha1(rand()),
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getUrl',
                'setter' => 'setUrl',
                'value' => sha1(rand()),
                'nullable' => false,
            ]],
            [[
                'type' => $this::ADDER_REMOVER,
                'getter' => 'getBannerZones',
                'setter' => 'setBannerZones',
                'adder' => 'addBannerZone',
                'remover' => 'removeBannerZone',
                'bag' => '\Doctrine\Common\Collections\ArrayCollection',
                'value' => '\Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface',
            ]],
        ];
    }

    /**
     * Test the string casting.
     */
    public function testToString()
    {
        $object = new Banner();
        $id = rand();
        $name = sha1(rand());

        $object->setId($id);
        $object->setName($name);

        $this->assertSame(sprintf('%s - %s', $id, $name), (string) $object);
    }
}
