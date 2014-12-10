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

namespace Elcodi\Component\Tax\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface TaxGroupInterface
 */
interface TaxGroupInterface
{
    /**
     * Get Id
     *
     * @return int Id
     */
    public function getId();

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return self
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
     * @return self
     */
    public function setName($name);

    /**
     * Get TaxGroup description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets TaxGroup description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * Get Taxes
     *
     * @return Collection Taxes
     */
    public function getTaxes();

    /**
     * Sets Taxes
     *
     * @param Collection $taxes Taxes
     *
     * @return self
     */
    public function setTaxes($taxes);

    /**
     * Add a tax into the group if not exists
     *
     * @param TaxInterface $tax Tax
     *
     * @return self
     */
    public function addTax(TaxInterface $tax);

    /**
     * Removes Tax from the group if exists
     *
     * @param TaxInterface $tax Tax
     *
     * @return self
     */
    public function removeTax(TaxInterface $tax);
}
