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

namespace Elcodi\Component\Shipping\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

/**
 * Interface CarrierInterface
 */
interface CarrierInterface extends EnabledInterface
{
    /**
     * Get Description
     *
     * @return string Description
     */
    public function getDescription();

    /**
     * Sets Description
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * Get Id
     *
     * @return integer Id
     */
    public function getId();

    /**
     * Sets Id
     *
     * @param integer $id Id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Ranges
     *
     * @return Collection Ranges
     */
    public function getRanges();

    /**
     * Sets Ranges
     *
     * @param Collection $ranges Ranges
     *
     * @return $this Self object
     */
    public function setRanges($ranges);

    /**
     * Get Tax
     *
     * @return TaxInterface Tax
     */
    public function getTax();

    /**
     * Sets Tax
     *
     * @param TaxInterface $tax Tax
     *
     * @return $this Self object
     */
    public function setTax($tax);
}
