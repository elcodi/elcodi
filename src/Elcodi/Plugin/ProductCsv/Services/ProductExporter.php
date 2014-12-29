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

namespace Elcodi\Plugin\ProductCsv\Services;

use DateTime;
use Goodby\CSV\Export\Protocol\ExporterInterface;

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Converts Product lists into CSV
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ProductExporter
{
    /**
     * @var ExporterInterface
     *
     * CSV exporter
     */
    protected $exporter;

    /**
     * @param ExporterInterface $exporter
     */
    public function __construct(ExporterInterface $exporter)
    {
        $this->exporter = $exporter;
    }

    /**
     * Export a Product list to standard output formatted as CSV
     *
     * @param ProductInterface[] $products product list
     */
    public function export(array $products)
    {
        $rows = $this->serializeRows($products);

        $this->exporter->export('php://output', $rows);
    }

    /**
     * Convert from a Product list to a plain array
     *
     * @param ProductInterface[] $products product list
     *
     * @return array
     */
    protected function serializeRows(array $products)
    {
        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'slug' => $product->getSlug(),
                'description' => $product->getDescription(),
                'stock' => $product->getStock(),
                'price' => $product->getPrice()->getAmount(),
                'currency' => $product->getPrice()->getCurrency()->getSymbol(),
                'reducedPrice' => $product->getReducedPrice()->getAmount(),
                'reducedPriceCurrency' => $product->getReducedPrice()->getCurrency()->getSymbol(),
                'manufacturer' => $product->getManufacturer() ? $product->getManufacturer()->getName() : '',
                'principalCategory' => $product->getPrincipalCategory()->getName(),
                'showInHome' => $product->getShowInHome() ? 'yes' : 'no',
                'weight' => $product->getWeight(),
                'depth' => $product->getDepth(),
                'width' => $product->getWidth(),
                'height' => $product->getHeight(),
                'createdAt' => $product->getCreatedAt()->format(DateTime::ATOM),
                'updatedAt' => $product->getUpdatedAt()->format(DateTime::ATOM),
                'enabled' => $product->isEnabled() ? 'yes' : 'no',
            ];
        }

        // Add row with keys at the top
        if (!empty($result)) {
            $keys = array_keys($result[0]);
            array_unshift($result, $keys);
        }

        return $result;
    }
}
