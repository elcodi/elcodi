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

namespace Elcodi\Component\Geo\Command\Abstracts;

use InvalidArgumentException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Class AbstractLocationCommand.
 */
class AbstractLocationCommand extends AbstractElcodiCommand
{
    /**
     * @var ObjectDirector
     *
     * Location director
     */
    protected $locationDirector;

    /**
     * Construct.
     *
     * @param ObjectDirector $locationDirector Location director
     */
    public function __construct(ObjectDirector $locationDirector)
    {
        $this->locationDirector = $locationDirector;

        parent::__construct();
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->addOption(
                'country',
                'c',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
                'Countries to be loaded, using Iso format'
            )
            ->addOption(
                'drop-if-exists',
                null,
                InputOption::VALUE_NONE,
                'Drop country if this is already loaded'
            );
    }

    /**
     * Get a country list from an input object or throw an Exception if none is
     * properly defined.
     *
     * @param InputInterface $input Input
     *
     * @return array Country array from input
     *
     * @throws InvalidArgumentException Countries not found
     */
    protected function getCountriesFromInput(InputInterface $input)
    {
        $countries = $input->getOption('country');
        if (!is_array($countries) || empty($countries)) {
            throw new InvalidArgumentException('You need to specify minimum a Country. eg: --country=FR');
        }

        return $countries;
    }

    /**
     * Ensure deletion of a country.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return $this Self object
     */
    protected function deleteCountry(
        InputInterface $input,
        OutputInterface $output,
        $countryCode
    ) {
        $noInteraction = $input->getOption('no-interaction');
        $country = $this
            ->locationDirector
            ->findOneBy([
                'code' => $countryCode,
            ]);

        if ($country instanceof LocationInterface) {
            if (
                !$noInteraction &&
                !$this->confirmRemoval(
                    $input,
                    $output,
                    $countryCode,
                    $output
                )
            ) {
                return $this;
            }

            $this->dropCountry($country, $output);
        } else {
            $this
                ->printMessage(
                    $output,
                    'Geo',
                    'Country ' . $countryCode . ' not found in your database'
                );
        }

        return $this;
    }

    /**
     * Asks to confirm the location removal.
     *
     * @param InputInterface  $input       The input interface
     * @param OutputInterface $output      The output interface
     * @param string          $countryCode The country code
     *
     * @return bool
     */
    private function confirmRemoval(
        InputInterface $input,
        OutputInterface $output,
        $countryCode
    ) {
        /**
         * @var QuestionHelper $questionHelper
         */
        $questionHelper = $this->getHelper('question');
        $message = "<question>Country with code '$countryCode' will be dropped. Continue?</question>";

        return $questionHelper->ask(
            $input,
            $output,
            new ConfirmationQuestion($message, false)
        );
    }

    /**
     * Drops the country and its relations.
     *
     * @param LocationInterface $location The location to remove
     * @param OutputInterface   $output   A console output
     *
     * @return $this Self object
     */
    private function dropCountry(
        LocationInterface $location,
        OutputInterface $output
    ) {
        $countryCode = $location->getCode();
        $this->startStopWatch('drop_location');
        $this
            ->locationDirector
            ->remove($location);

        $stopWatchEvent = $this->stopStopWatch('drop_location');
        $this
            ->printMessage(
                $output,
                'Geo',
                'Country ' . $countryCode . ' dropped in ' . $stopWatchEvent->getDuration() . ' milliseconds'
            );

        return $this;
    }
}
