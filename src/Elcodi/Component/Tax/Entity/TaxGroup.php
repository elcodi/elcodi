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

namespace Elcodi\Component\Tax\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Tax\Entity\Interfaces\TaxGroupInterface;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

/**
 * Class TaxGroup
 */
class TaxGroup implements TaxGroupInterface
{
    /**
     * @var integer
     *
     * id
     */
    protected $id;

    /**
     * @var string
     *
     * name
     */
    protected $name;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var Collection
     *
     * taxes
     */
    protected $taxes;

    /**
     * Get Id
     *
     * @return integer Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param integer $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get TaxGroup description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets TaxGroup description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Taxes
     *
     * @return Collection Taxes
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Sets Taxes
     *
     * @param Collection $taxes Taxes
     *
     * @return $this Self object
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Add a tax into the group if not exists
     *
     * @param TaxInterface $tax Tax
     *
     * @return $this Self object
     */
    public function addTax(TaxInterface $tax)
    {
        if (!$this->taxes->contains($tax)) {
            $this
                ->taxes
                ->add($tax);
        }

        return $this;
    }

    /**
     * Removes Tax from the group if exists
     *
     * @param TaxInterface $tax Tax
     *
     * @return $this Self object
     */
    public function removeTax(TaxInterface $tax)
    {
        $this
            ->taxes
            ->removeElement($tax);

        return $this;
    }

    /**
     * Returns the group name
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}
