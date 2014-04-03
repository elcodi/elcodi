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

namespace Elcodi\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\ProductBundle\Entity\Interfaces\ManufacturerInterface;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Traits\MetaDataTrait;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * Manufacturer
 */
class Manufacturer extends AbstractEntity implements ManufacturerInterface
{
    use DateTimeTrait, EnabledTrait, MetaDataTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var Collection
     *
     * Products
     */
    protected $products;

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return Manufacturer Self Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return Manufacturer self Object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return Manufacturer self Object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set products
     *
     * @param Collection $products Products
     *
     * @return Manufacturer self Object
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return Collection Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add product
     *
     * @param ProductInterface $product Product
     *
     * @return Manufacturer self Object
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products->add($product);

        return $this;
    }

    /**
     * Remove product
     *
     * @param ProductInterface $product Product
     *
     * @return Manufacturer self Object
     */
    public function removeProduct(ProductInterface $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}
