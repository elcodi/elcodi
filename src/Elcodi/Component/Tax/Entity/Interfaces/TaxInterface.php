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

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface TaxInterface
 */
interface TaxInterface extends EnabledInterface
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
     * Gets Tax name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets tax name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get Tax description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets Tax description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * Sets Tax value in percentage
     *
     * @return float
     */
    public function getValue();

    /**
     * Gets Tax value in percentage
     *
     * @param float $value
     *
     * @return self
     */
    public function setValue($value);

    /**
     * Get TaxGroup
     *
     * @return TaxGroupInterface TaxGroup
     */
    public function getTaxGroup();

    /**
     * Sets TaxGroup
     *
     * @param TaxGroupInterface $taxGroup TaxGroup
     *
     * @return self
     */
    public function setTaxGroup($taxGroup);
}
