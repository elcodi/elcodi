<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Core\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use UnexpectedValueException;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ObjectDirector.
 *
 * This object is a facade for these different persistance-related elements
 *
 * * Object Manager
 * * Repository
 * * Factory
 *
 * Allows final user to manage in a simple way an entity or a set of entities.
 * Provides a reduced (but useful) set of methods.
 */
class ObjectDirector
{
    /**
     * @var ObjectManager
     *
     * Manager
     */
    private $manager;

    /**
     * @var ObjectRepository
     *
     * Repository
     */
    private $repository;

    /**
     * @var AbstractFactory
     *
     * Factory
     */
    private $factory;

    /**
     * Construct.
     *
     * @param ObjectManager    $manager    Manager
     * @param ObjectRepository $repository Repository
     * @param AbstractFactory  $factory    Factory
     */
    public function __construct(
        ObjectManager $manager,
        ObjectRepository $repository,
        AbstractFactory $factory
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return object|null Fetched object
     */
    public function find($id)
    {
        return $this
            ->repository
            ->find($id);
    }

    /**
     * Finds all objects in the repository.
     *
     * @return array Set of fetched objects
     */
    public function findAll()
    {
        return $this
            ->repository
            ->findAll();
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array Set of fetched objects
     *
     * @throws UnexpectedValueException
     */
    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null)
    {
        return $this
            ->repository
            ->findBy(
                $criteria,
                $orderBy,
                $limit,
                $offset
            );
    }

    /**
     * Finds a single object given a criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return object|null Fetched object
     */
    public function findOneBy(array $criteria)
    {
        return $this
            ->repository
            ->findOneBy(
                $criteria
            );
    }

    /**
     * Create a new entity instance, result of the factory creation method.
     *
     * @return object new Instance
     */
    public function create()
    {
        return $this
            ->factory
            ->create();
    }

    /**
     * Save the instance into database. Given data can be a single object or
     * an array of objects.
     *
     * This method will persist and flush given object/array of objects
     *
     * @param object|array $data Data to save into database
     *
     * @return object|array Saved data
     */
    public function save($data)
    {
        if (is_array($data)) {
            foreach ($data as $entity) {
                $this
                    ->manager
                    ->persist($entity);
            }
        } else {
            $this
                ->manager
                ->persist($data);
        }

        $this
            ->manager
            ->flush($data);

        return $data;
    }

    /**
     * Remove the instance from the database. Given data can be a single object or
     * an array of objects.
     *
     * This method will remove and flush given object/array of objects
     *
     * @param object|array $data Data to remove from database
     *
     * @return object|array Removed data
     */
    public function remove($data)
    {
        if (is_array($data)) {
            foreach ($data as $entity) {
                $this
                    ->manager
                    ->remove($entity);
            }
        } else {
            $this
                ->manager
                ->remove($data);
        }

        $this
            ->manager
            ->flush($data);

        return $data;
    }
}
