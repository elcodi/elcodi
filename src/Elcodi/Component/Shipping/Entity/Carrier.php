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

namespace Elcodi\Component\Shipping\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

/**
 * Class Carrier
 */
class Carrier implements CarrierInterface
{
    use EnabledTrait;

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
     * description
     */
    protected $description;

    /**
     * @var Collection
     *
     * ranges
     */
    protected $ranges;

    /**
     * @var TaxInterface
     *
     * Tax
     */
    protected $tax;

    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param int $id Id
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
     * Get Ranges
     *
     * @return Collection Ranges
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * Sets Ranges
     *
     * @param Collection $ranges Ranges
     *
     * @return $this Self object
     */
    public function setRanges($ranges)
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * Get Tax
     *
     * @return TaxInterface Tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets Tax
     *
     * @param TaxInterface $tax Tax
     *
     * @return $this Self object
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }
}
