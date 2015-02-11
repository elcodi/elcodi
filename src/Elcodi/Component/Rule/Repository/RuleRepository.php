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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Rule\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class RuleRepository
 */
class RuleRepository extends EntityRepository
{
    /**
     * Return a rule by name
     *
     * @param $name
     *
     * @return null|RuleInterface
     */
    public function findOneByName($name)
    {
        return parent::findOneBy(['name' => $name]);
    }
}
