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

use Elcodi\CoreBundle\Repository\Abstracts\AbstractBaseRepository;

/**
 * CategoryRepository
 */
class CategoryRepository extends AbstractBaseRepository
{
    /**
     * Get root categories
     *
     * @return mixed
     */
    public function getParentCategories()
    {
        return $this
            ->createQueryBuilder('c')
            ->andWhere('c.root = :root')
            ->andWhere('c.enabled = :enabled')
            ->where('c.deleted = :deleted')
            ->setParameters(array(
                'deleted'   =>  false,
                'enabled'   =>  true,
                'root'      =>  true,
            ))
            ->getQuery()
            ->getResult();
    }

    /**
     * Get category by name and locale
     *
     * @param string $locale       Locale
     * @param string $categoryName CategoryName
     *
     * @return Category
     */
    protected function getCategoryByName($categoryName, $locale)
    {
        return $this
            ->getEntityManager()
            ->getRepository('ElcodiProductBundle:CategoryTranslation')
            ->findOneBy(array(
                'locale' => $locale,
                'name' => $categoryName,
            ))
            ->getTranslatable();
    }
}
