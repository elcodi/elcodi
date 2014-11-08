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

namespace Elcodi\Component\Page\Factory;

use Elcodi\Component\Page\Entity\Page;

/**
 * Class PageFactory
 *
 * @author Cayetano Soriano <neoshadybeat@gmail.com>
 * @author Jordi Grados <planetzombies@gmail.com>
 * @author Damien Gavard <damien.gavard@gmail.com>
 */
class PageFactory
{
    /**
     * @var string
     *
     * Entity namespace
     */
    protected $entityNamespace = 'Elcodi\Component\Page\Entity\Page';

    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @param string $title   The title
     * @param string $content The content
     * @param string $path    The path
     *
     * @return Page entity
     */
    public function create($title, $content, $path)
    {
        /**
         * @var Page $page
         */
        $page = new $this->entityNamespace();
        $page
            ->setTitle($title)
            ->setContent($content)
            ->setPath($path);

        return $page;
    }
}
