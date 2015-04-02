<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Bundle\TaxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class TaxGroupData
 */
class TaxGroupData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $taxGroupDirector
         */
        $taxGroupDirector = $this->getDirector('tax_group');

        $andorranTaxes = $taxGroupDirector
            ->create()
            ->setName('andorran-taxes')
            ->setDescription('All andorran taxes');

        $taxGroupDirector->save($andorranTaxes);
        $this->addReference('tax-group-andorran', $andorranTaxes);
    }
}
