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

namespace Elcodi\Component\Page\Tests\Entity;

use Elcodi\Component\Page\Entity\Page;

/**
 * Class PageTest
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 */
class PageTest extends \PHPUnit_Framework_TestCase
{
    protected $values = [

    ];

    /**
     * @return array
     */
    public function methodProvider()
    {
        return [
            'title' => [
                'setterMethod' => 'setTitle',
                'getterMethod' => 'getTitle',
                'value' => 'Contact page title'
            ],
            'content' => [
                'setterMethod' => 'setContent',
                'getterMethod' => 'getContent',
                'value' => 'This is the content of the contact page'
            ],
            'path' => [
                'setterMethod' => 'setPath',
                'getterMethod' => 'getPath',
                'value' => '/contact'
            ]
        ];
    }

    /**
     * @param $setterMethod
     * @param $getterMethod
     * @param $value
     *
     * @dataProvider methodProvider
     */
    public function testSetterAndGetterTest($setterMethod, $getterMethod, $value)
    {
        $page = new Page();

        call_user_func([$page, $setterMethod], $value);
        $result = call_user_func([$page, $getterMethod]);

        $this->assertEquals($value, $result);
    }
}
