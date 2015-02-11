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

namespace Elcodi\Component\Product\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Component\Media\Entity\Interfaces\PrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Class ManufacturerInterface
 */
interface ManufacturerInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface,
    MetaDataInterface,
    ImagesContainerInterface,
    PrincipalImageInterface
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function addProduct(ProductInterface $product);

    /**
     * Remove product
     *
     * @param ProductInterface $product Product
     *
     * @return $this Self object
     */
    public function removeProduct(ProductInterface $product);
}
