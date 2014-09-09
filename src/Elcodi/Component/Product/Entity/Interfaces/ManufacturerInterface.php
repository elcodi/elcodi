<?php

/**
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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Class ManufacturerInterface
 */
interface ManufacturerInterface extends EnabledInterface, MetaDataInterface
{
    /**
     * Set id
     *
     * @param string $id Id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return ManufacturerInterface Self Object
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return $this self Object
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string Slug
     */
    public function getSlug();

    /**
     * Set products
     *
     * @param Collection $products Products
     *
     * @return $this self Object
     */
    public function setProducts(Collection $products);

    /**
     * Get products
     *
     * @return Collection Products
     */
    public function getProducts();

    /**
     * Add product
     *
     * @param ProductInterface $product Product
     *
     * @return $this self Object
     */
    public function addProduct(ProductInterface $product);

    /**
     * Remove product
     *
     * @param ProductInterface $product Product
     *
     * @return $this self Object
     */
    public function removeProduct(ProductInterface $product);
}
