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

namespace Elcodi\Component\Comment\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Comment\Entity\Comment;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class CommentFactory.
 */
class CommentFactory extends AbstractFactory
{
    /**
     * Creates an instance of Comment.
     *
     * @return Comment New Cart entity
     */
    public function create()
    {
        /**
         * @var Comment $comment
         */
        $classNamespace = $this->getEntityNamespace();
        $comment = new $classNamespace();
        $comment
            ->setParent(null)
            ->setChildren(new ArrayCollection())
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $comment;
    }
}
