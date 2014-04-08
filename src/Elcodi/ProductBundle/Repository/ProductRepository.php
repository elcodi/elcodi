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

namespace Elcodi\ProductBundle\Repository;

use Doctrine\ORM\QueryBuilder;

use Elcodi\CoreBundle\Repository\Abstracts\AbstractBaseRepository;
use Elcodi\ProductBundle\Entity\ColorValue;
use Elcodi\ProductBundle\Entity\Product;
use Elcodi\ProductBundle\Entity\Value;

/**
 * ProductRepository
 *
 * @todo Check full class
 */
class ProductRepository extends AbstractBaseRepository
{
    public function getProductList(
        $idFilter = 0,
        $referenceFilter = "",
        $nameFilter = "",
        $familyFilter = "",
        $shopNameFilter = "",
        $showHomeFilter = "",
        $enabledFilter = "")
    {
        $query = $this->createQueryBuilder('o')->orderBy('o.id', 'DESC');
        if ($idFilter) {
            $query->andWhere("o.id = :id");
            $query->setParameter('id', $idFilter);
        }
        if ($referenceFilter) {
            $query->innerJoin('o.items', 'i');
            $query->andWhere("i.reference LIKE :reference");
            $query->setParameter('reference', '%'.$referenceFilter.'%');
        }
        if ($nameFilter) {
            $query->innerJoin('o.translations', 't');
            $query->andWhere("t.name LIKE :name");
            $query->setParameter('name', '%'.$nameFilter.'%');
        }
        if ($familyFilter) {
            $query->andWhere("o.family LIKE :family");
            $query->setParameter('family', '%'.$familyFilter.'%');
        }
        if ($shopNameFilter) {
            $query->innerJoin('o.shop', 's');
            $query->andWhere("s.name LIKE :shopname");
            $query->setParameter('shopname', '%'.$shopNameFilter.'%');
        }
        if ($showHomeFilter != "") {
            $query->andWhere("o.showInHome = :inHome");
            $query->setParameter('inHome', $showHomeFilter);
        }
        if ($enabledFilter != "") {
            $query->andWhere("o.enabled = :enabled");
            $query->setParameter('enabled', (bool) $enabledFilter);
        }

        $query->andWhere('o.deleted = :deleted');
        $query->setParameter('deleted', false);

        return $query->getQuery();
    }

    /**
     * @return QueryBuilder
     */
    public function getElasticSearchQueryBuilder()
    {
        $b = $this->createQueryBuilder("ElasticSearch");
        $b->add('select', 'p, t1.name as name_es, t2.name as name_en, t3.name as name_it, t4.name as name_fr');
        $b->add('from', 'ElcodiProductBundle:Product p');
        $b->leftJoin('p.translations', 't1', 'WITH', 't1.object = p.id AND t1.locale = '.$b->expr()->literal('"es"'));
        $b->leftJoin('p.translations', 't2', 'WITH', 't1.object = p.id AND t1.locale = '.$b->expr()->literal('"en"'));
        $b->leftJoin('p.translations', 't3', 'WITH', 't1.object = p.id AND t1.locale = '.$b->expr()->literal('"it"'));
        $b->leftJoin('p.translations', 't4', 'WITH', 't1.object = p.id AND t1.locale = '.$b->expr()->literal('"fr"'));

        return $b;
    }

    /**
     * Sorts images
     *
     * @param $imagesSort
     * @param $images
     * @param $principalImageId
     *
     * @return mixed
     */
    protected function sortImages($imagesSort, $images, $principalImageId)
    {
        $orderCollection = array_reverse($imagesSort);
        $imagesCollection = $images;
        if (!$principalImageId) {
            $principalImageId = 0;
        }

        usort($imagesCollection, function ($a, $b) use ($orderCollection, $principalImageId) {
            /** @var ImageMedia $a */
            /** @var ImageMedia $b */
            $aPos = array_search($a->getId(), $orderCollection);
            $bPos = array_search($b->getId(), $orderCollection);

            if ($a->getId() == $principalImageId) {
                return -1;
            } elseif ($b->getId() == $principalImageId) {
                return 1;
            }

            return  ($aPos < $bPos) ? 1 : -1;
        });

        return $imagesCollection;
    }

    /**
     * Get product images
     *
     * @param $product
     *
     * @return array with 'products' key (images from the product, ordered) and 'items' which is an associative array
     *               with key = itemId, and values the item's images, ordered
     */
    public function getProductImages(Product $product)
    {
        //get imagesSort of product
        $dqlImagesProduct = "
            SELECT i0.id, p.imagesSort as imagesSort, pi.id as principalImageId
            FROM
            ElcodiProductBundle:Product p
            INNER JOIN p.images i0
            LEFT JOIN p.principalImage pi
            WHERE
            p.enabled = :enabled
            AND p.deleted = :deleted
            AND p.id = :id
            AND i0.enabled = :enabled
            AND i0.deleted = :deleted
        ";
        $queryProductImages = $this->getEntityManager()->createQuery($dqlImagesProduct);
        $queryProductImages->setParameter('enabled', true);
        $queryProductImages->setParameter('deleted', false);
        $queryProductImages->setParameter('id', $product->getId());
        $productImages = $queryProductImages->getResult();
        $imagesIds = array();
        foreach ($productImages as $productImage) {
            $imagesIds[] = $productImage['id'];
        }
        $finalImagesArray = array();
        $finalImagesArray['product'] = array();
        $finalImagesArray['product'] = $imagesIds;
        $finalImagesArray['productSort'] = array();
        $finalImagesArray['productPrincipalImageId'] = 0;
        if (isset($productImage)) {
            $finalImagesArray['productSort'] = json_decode($productImage['imagesSort']);
            $finalImagesArray['productPrincipalImageId'] = $productImage['principalImageId'];
        }
        if (empty($imagesIds)) {
            $finalImagesArray['items'] = array();

            return $finalImagesArray;
        }

        //get each product items with their principal id and imagesSort
        $dqlImagesItem = "
            SELECT i0.id as imageId, i.id as itemId, i.imagesSort as imagesSort, pi.id as principalImageId
            FROM
            ElcodiProductBundle:Product p
            INNER JOIN p.items i
            LEFT JOIN i.images i0
            LEFT JOIN i.principalImage pi
            WHERE
            p.enabled = :enabled
            AND p.deleted = :deleted
            AND p.id = :id
            AND i.enabled = :enabled
            AND i.deleted = :deleted
        ";
        $queryItemImages = $this->getEntityManager()->createQuery($dqlImagesItem);
        $queryItemImages->setParameter('enabled', true);
        $queryItemImages->setParameter('deleted', false);
        $queryItemImages->setParameter('id', $product->getId());
        //$queryItemImages->setParameter('imagesIds', $imagesIds);

        //join imagesSort of product and his items and extract their images ids
        $itemImages = $queryItemImages->getResult();
        foreach ($itemImages as $itemImage) {
            if (empty($finalImagesArray['items'][$itemImage['itemId']])) {
                $finalImagesArray['items'][$itemImage['itemId']] = array();
                $finalImagesArray['itemsSort'][$itemImage['itemId']] = "";
            }
            if ($itemImage['imageId']) {
                $finalImagesArray['items'][$itemImage['itemId']][] = $itemImage['imageId'];
                $finalImagesArray['itemsSort'][$itemImage['itemId']] = json_decode($itemImage['imagesSort']);
                $finalImagesArray['itemsPrincipalImage'][$itemImage['itemId']] = $itemImage['principalImageId'];
                $imagesIds[] = $itemImage['imageId'];
            }
        }
        $imagesIds = array_unique($imagesIds);

        //get images by their ids
        $dqlImages = "
            SELECT i FROM
            ElcodiMediaBundle:ImageMedia i
            WHERE i.id IN (:imagesIds)
        ";
        $queryImages = $this->getEntityManager()->createQuery($dqlImages);
        $queryImages->setParameter('imagesIds', $imagesIds);

        $images = $queryImages->getResult();

        foreach ($finalImagesArray['product'] as $k => $imageId) {
            foreach ($images as $image) {
                if (is_int($imageId) && $image->getId() == $imageId) {
                    $finalImagesArray['product'][$k] = $image;
                    break;
                }
            }
        }

        if (empty($finalImagesArray['productSort']) || is_null($finalImagesArray['productSort'])) {
            $finalImagesArray['productSort'] = array();
        }
        $finalImagesArray['product'] = $this->sortImages($finalImagesArray['productSort'], $finalImagesArray['product'], $finalImagesArray['productPrincipalImageId']);

        if (empty($finalImagesArray['items'])) {
            //items have no images
            return $finalImagesArray;
        }

        foreach ($finalImagesArray['items'] as $itemId => $imageIds) {
            if (empty($imageIds)) {
                //this item has no images, unset
                unset($finalImagesArray['items'][$itemId]);
                unset($finalImagesArray['itemsSort'][$itemId]);
                unset($finalImagesArray['itemsPrincipalImage'][$itemId]);
                continue;
            }
            foreach ($imageIds as $k => $imageId) {
                foreach ($images as $image) {
                    if (is_int($imageId) && $image->getId() == $imageId) {
                        $finalImagesArray['items'][$itemId][$k] = $image;
                        break;
                    }
                }
            }
        }

        foreach ($finalImagesArray['items'] as $itemId => $images) {
            if (empty($finalImagesArray['itemsSort'][$itemId]) || is_null($finalImagesArray['itemsSort'][$itemId])) {
                $finalImagesArray['itemsSort'][$itemId] = array();
            }
            $finalImagesArray['items'][$itemId] = $this->sortImages($finalImagesArray['itemsSort'][$itemId], $finalImagesArray['items'][$itemId], $finalImagesArray['itemsPrincipalImage'][$itemId]);
        }

        return $finalImagesArray;
    }


    /**
     * Get a list of the values of a product, separeted by key = id of their attribute
     *
     * @param Product $product
     */
    public function getProductAttributeValues(Product $product)
    {

        $dqlValues = "
            SELECT v
            FROM
            ElcodiProductBundle:Value v
            LEFT JOIN v.translations t
            WHERE v.id IN (
                SELECT DISTINCT(av.id) FROM
                ElcodiProductBundle:Product p
                INNER JOIN p.items i
                INNER JOIN i.attributeValues av
                INNER JOIN av.attribute a
                WHERE
                p.enabled = :enabled
                AND p.deleted = :deleted
                AND p.id = :id
            )
            AND t.locale = :locale
        ";

        $query = $this->getEntityManager()->createQuery($dqlValues);
        $query->setParameter('enabled', true);
        $query->setParameter('deleted', false);
        $query->setParameter('locale', $product->getCurrentLocale());
        $query->setParameter('id', $product->getId());

        $valuesFamily = array();
        $allValues = $query->getResult();

        $valuesIds = array();
        foreach ($allValues as $value) {
            $valuesIds[] = $value->getId();
        }
        if (empty($valuesIds)) {
            $valuesIds = array(0);
        }
        $dqlItemValues = "
            SELECT i.id as itemId, av.id as valueId
            FROM
            ElcodiProductBundle:Item i
            INNER JOIN i.attributeValues av
            WHERE
            i.product = :product AND i.enabled = :enabled AND i.deleted = :deleted AND i.stock > 0
            AND
            av.id IN (:valuesIds)
        ";
        $queryItemIds = $this->getEntityManager()->createQuery($dqlItemValues);
        $queryItemIds->setParameter('enabled', true);
        $queryItemIds->setParameter('deleted', false);
        $queryItemIds->setParameter('product', $product);
        $queryItemIds->setParameter('valuesIds', $valuesIds);

        $itemsWithValues = $queryItemIds->getResult();


        $itemIds = array();
        foreach ($itemsWithValues as $id) {
            if (empty($itemIds[$id['valueId']])) {
                $itemIds[$id['valueId']] = array();
            }
            $itemIds[$id['valueId']][] = $id['itemId'];
        }
        foreach ($allValues as $value) {
            $attributeId = $value->getAttribute()->getId();
            $valueId = $value->getId();
            if (!isset($valuesFamily[$attributeId])) {
                $valuesFamily[$attributeId] = array();
            }
            if (!empty($itemIds[$valueId])) {
                //only add this value if it has items related to it
                $value->itemId = $itemIds[$valueId];
                $valuesFamily[$attributeId][] = $value;
            }
        }

        return $valuesFamily;
    }


    public function getProductAttributes($product)
    {
        $dqlAttributes = "
            SELECT a
            FROM ElcodiProductBundle:Attribute a
            LEFT JOIN a.translations t
            WHERE a.id IN (
                SELECT DISTINCT(ai.id) FROM
                ElcodiProductBundle:Product p
                INNER JOIN p.items i
                INNER JOIN i.attributeValues av
                INNER JOIN av.attribute ai
                WHERE
                p.enabled = :enabled
                AND p.deleted = :deleted
                AND p.id = :id
                AND i.deleted = :deleted
                AND i.enabled = :enabled
            )
            AND t.locale = :locale
        ";

        $query = $this->getEntityManager()->createQuery($dqlAttributes);
        $query->setParameter('enabled', true);
        $query->setParameter('deleted', false);
        $query->setParameter('locale', $product->getCurrentLocale());
        $query->setParameter('id', $product->getId());
        $attributes = $query->getResult();

        $attributeIds = array(0);
        foreach ($attributes as $attribute) {
            $attributeIds[] = $attribute->getId();
        }

        $dqlAttributeHasColor = "
            SELECT distinct(a.id) as id
            FROM ElcodiProductBundle:ColorValue v
            INNER JOIN v.attribute a
            WHERE a.id IN (:idsList)
        ";
        if (empty($attributeIds)) {
            $attributeIds = array(0);
        }
        $queryHasColor = $this->getEntityManager()->createQuery($dqlAttributeHasColor);
        $queryHasColor->setParameter('idsList', $attributeIds);
        $attributesWithColors = $queryHasColor->getResult();
        $attributesWithColorsIds = array();
        foreach ($attributesWithColors as $attributeWithColor) {
            $attributesWithColorsIds[] = $attributeWithColor['id'];
        }

        foreach ($attributes as &$attribute) {
            $attribute->isColor = false;
            if (in_array($attribute->getId(), $attributesWithColorsIds)) {
                $attribute->isColor = true;
            }
        }

        return $attributes;
    }

    /**
     * Get array of products ids of specific shops
     *
     * @param array $shopsIds array of shops ids
     *
     * @return array
     */
    public function getProductsIdsOfShops($shopsIds)
    {
        $productRepo = $this->getEntityManager()->getRepository('ElcodiProductBundle:Product');
        $query = $productRepo->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.shop IN (:shopsIds)')
            ->setParameter('shopsIds', $shopsIds)
            ->getQuery();
        $collection = $query->getArrayResult();
        $ids = array();
        foreach ($collection as $value) {
            $ids[] = $value['id'];
        }

        return $ids;
    }
}
