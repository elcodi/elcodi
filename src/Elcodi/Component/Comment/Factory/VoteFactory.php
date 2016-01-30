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

use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class VoteFactory.
 */
class VoteFactory extends AbstractFactory
{
    /**
     * Creates an instance of Vote.
     *
     * @return Vote New Vote entity
     */
    public function create()
    {
        /**
         * @var Vote $vote
         */
        $classNamespace = $this->getEntityNamespace();
        $vote = new $classNamespace();
        $vote->setCreatedAt($this->now());

        return $vote;
    }

    /**
     * Creates an instance of Up Vote.
     *
     * @return Vote New Up Vote entity
     */
    public function createUp()
    {
        return $this
            ->create()
            ->setType(Vote::UP);
    }

    /**
     * Creates an instance of Down Vote.
     *
     * @return Vote New Down Vote entity
     */
    public function createDown()
    {
        return $this
            ->create()
            ->setType(Vote::DOWN);
    }
}
