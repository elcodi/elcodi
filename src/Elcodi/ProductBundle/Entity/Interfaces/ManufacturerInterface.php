<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * Class ManufacturerInterface
 */
interface ManufacturerInterface extends EnabledInterface, MetaDataInterface
{
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
     * @return ManufacturerInterface self Object
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
     * @return ManufacturerInterface self Object
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
     * @return ManufacturerInterface self Object
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
     * @return ManufacturerInterface self Object
     */
    public function addProduct(ProductInterface $product);

    /**
     * Remove product
     *
     * @param ProductInterface $product Product
     *
     * @return ManufacturerInterface self Object
     */
    public function removeProduct(ProductInterface $product);
}
