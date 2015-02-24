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

namespace Elcodi\Component\Geo\Validator\Constraints;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Elcodi\Component\Geo\Services\Interfaces\LocationProviderInterface;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class CityExistsValidator
 */
class CityExistsValidator extends ConstraintValidator
{
    /**
     * @var LocationProviderInterface
     *
     * A location provider
     */
    protected $locationProvider;

    /**
     * Builds a new class.
     *
     * @param LocationProviderInterface $locationProvider
     */
    public function __construct(
        LocationProviderInterface $locationProvider
    ) {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        /**
         * @var LocationData $location
         */
        try {
            $location = $this->locationProvider->getLocation(
                $value
            );
        } catch (EntityNotFoundException $e) {
            $location = null;
        }

        if (
            is_null($location) ||
            'city' != $location->getType()
        ) {
            $this
                ->context
                ->buildViolation('Select a city')
                ->addViolation();
        }
    }
}
