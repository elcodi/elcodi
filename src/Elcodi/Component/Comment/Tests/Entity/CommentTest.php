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

namespace Elcodi\Component\Comment\Tests\Entity;

use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

/**
 * Class CommentTest.
 */
class CommentTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Comment\Entity\Comment';
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
                'getter' => 'getSource',
                'setter' => 'setSource',
                'value' => 'value',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getContext',
                'setter' => 'setContext',
                'value' => 'value',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getParent',
                'setter' => 'setParent',
                'value' => '\Elcodi\Component\Comment\Entity\Comment',
                'nullable' => true,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getChildren',
                'setter' => 'setChildren',
                'value' => '\Doctrine\Common\Collections\ArrayCollection',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getAuthorToken',
                'setter' => 'setAuthorToken',
                'value' => 'token',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getAuthorEmail',
                'setter' => 'setAuthorEmail',
                'value' => 'email@email.com',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getContent',
                'setter' => 'setContent',
                'value' => 'this is my content',
                'nullable' => false,
            ]],
        ];
    }
}
