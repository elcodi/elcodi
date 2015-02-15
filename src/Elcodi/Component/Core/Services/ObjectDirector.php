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

namespace Elcodi\Component\Core\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ObjectDirector
 */
class ObjectDirector
{
    /**
     * @var ObjectManager
     *
     * Manager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     *
     * Repository
     */
    protected $repository;

    /**
     * @var AbstractFactory
     *
     * Factory
     */
    protected $factory;

    /**
     * Construct
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
     * @return object The object.
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
     * @return array The objects.
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
     * @return array The objects.
     *
     * @throws \UnexpectedValueException
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
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return object The object.
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
     * Create new instance
     *
     * @return Object new Instance
     */
    public function create()
    {
        return $this
            ->factory
            ->create();
    }

    /**
     * Save the instance in the database
     *
     * This method will persist and flush the object
     *
     * @param object|array $object Object
     *
     * @return object|array Saved object
     */
    public function save($object)
    {
        if (is_array($object)) {

            foreach ($object as $entity) {
                $this
                    ->manager
                    ->persist($entity);
            }

        } else {

            $this
                ->manager
                ->persist($object);
        }

        $this
            ->manager
            ->flush($object);

        return $object;
    }

    /**
     * Remove the instance from the database
     *
     * This method will remove and flush the object
     *
     * @param object|array $object Object
     *
     * @return object|array Saved object
     */
    public function remove($object)
    {
        if (is_array($object)) {

            foreach ($object as $entity) {
                $this
                    ->manager
                    ->remove($entity);
            }

        } else {

            $this
                ->manager
                ->remove($object);
        }

        $this
            ->manager
            ->flush($object);

        return $object;
    }
}
