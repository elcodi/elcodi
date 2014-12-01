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

namespace Elcodi\Component\StateTransitionMachine\Machine;

use Elcodi\Component\StateTransitionMachine\Definition\State;
use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Exception\CyclesNotAllowedException;
use Elcodi\Component\StateTransitionMachine\Exception\InconsistentTransitionConfigurationException;
use Elcodi\Component\StateTransitionMachine\Exception\InvalidPointOfEntryException;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotValidException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Factory\MachineFactory;

/**
 * Class MachineBuilder
 */
class MachineBuilder
{
    /**
     * @var MachineFactory
     *
     * Machine factory
     */
    protected $machineFactory;

    /**
     * @var array
     *
     * Configuration
     */
    protected $configuration;

    /**
     * @var TransitionChain
     *
     * Transition chain
     */
    protected $transitionChain;

    /**
     * @var string
     *
     * Point of entry
     */
    protected $pointOfEntry;

    /**
     * @var boolean
     *
     * Can be cyclic
     */
    protected $canBeCyclic;

    /**
     * construct method
     *
     * @param MachineFactory $machineFactory Machine factory
     * @param string         $machineId      Machine id
     * @param array          $configuration  State configuration
     * @param string         $pointOfEntry   Point of entry
     */
    public function __construct(
        MachineFactory $machineFactory,
        $machineId,
        array $configuration,
        $pointOfEntry
    )
    {
        $this->machineFactory = $machineFactory;
        $this->machineId = $machineId;
        $this->configuration = $configuration;
        $this->transitionChain = TransitionChain::create();
        $this->pointOfEntry = $pointOfEntry;
        $this->canBeCyclic = true;
    }

    /**
     * Set allow cycles
     *
     * @param boolean $canBeCyclic The Machine can be cyclic
     *
     * @return $this self Object
     */
    public function allowCycles($canBeCyclic)
    {
        $this->canBeCyclic = $canBeCyclic;

        return $this;
    }

    /**
     * Compile machine
     *
     * @throws TransitionNotValidException                  Transition not valid
     * @throws StateNotValidException                       state is not valid
     * @throws CyclesNotAllowedException                    Cycles found not allowed
     * @throws InvalidPointOfEntryException                 Invalid point of entry
     * @throws InconsistentTransitionConfigurationException Duplicated pair of
     *                                                      state-transition
     */
    public function compile()
    {
        $nodesVisited = array();

        /**
         * Checking the configuration
         */
        $this
            ->checkTransitionsConfiguration($this->configuration)
            ->checkPointOfEntry(
                $this->configuration,
                $this->pointOfEntry
            )
            ->checkCycles(
                $this->configuration,
                $this->pointOfEntry,
                $nodesVisited
            );

        /**
         * Once checked we compile the structure
         */
        $this->transitionChain = $this->compileTransitions($this->configuration);

        /**
         * We check the compilation
         */
        $this
            ->checkTransitionDuplicates($this->transitionChain)
            ->checkStates($this->transitionChain);

        $machine = $this
            ->machineFactory
            ->generate(
                $this->machineId,
                $this->transitionChain,
                $this->pointOfEntry
            );

        return $machine;
    }

    /**
     * Given an array of configuration, checks that all data is prepared for
     * being compiled
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
     *
     * @throws TransitionNotValidException Transition not valid
     */
    protected function checkTransitionsConfiguration(array $configuration)
    {
        foreach ($configuration as $transitionConfiguration) {

            if (
                !is_array($transitionConfiguration) ||
                (count($transitionConfiguration) != 3) ||
                !isset($transitionConfiguration[0]) ||
                !is_string($transitionConfiguration[0]) ||
                empty($transitionConfiguration[0]) ||
                !isset($transitionConfiguration[1]) ||
                !is_string($transitionConfiguration[1]) ||
                empty($transitionConfiguration[1]) ||
                !isset($transitionConfiguration[2]) ||
                !is_string($transitionConfiguration[2]) ||
                empty($transitionConfiguration[2])
            ) {

                throw new TransitionNotValidException();
            }
        }

        return $this;
    }

    /**
     * Check point of entry
     *
     * @param array  $configuration Configuration
     * @param string $pointOfEntry  Point of entry
     *
     * @return $this self Object
     *
     * @throws InvalidPointOfEntryException Invalid point of entry
     */
    protected function checkPointOfEntry(array $configuration, $pointOfEntry)
    {
        foreach ($configuration as $transitionConfiguration) {

            if ($transitionConfiguration[0] === $pointOfEntry) {
                return $this;
            }
        }

        throw new InvalidPointOfEntryException($pointOfEntry);
    }

    /**
     * Check cycles
     *
     * @param array  $configuration Configuration
     * @param string $node          Node to check
     * @param array  $nodesVisited  All visited nodes name
     *
     * @return $this self Object
     *
     * @throws CyclesNotAllowedException Cycles found not allowed
     */
    protected function checkCycles(
        array $configuration,
        $node,
        array &$nodesVisited
    )
    {
        if (in_array($node, $nodesVisited)) {

            if (!$this->canBeCyclic) {

                throw new CyclesNotAllowedException();
            }

            return $this;
        }

        $nodesVisited[] = $node;

        foreach ($configuration as $transitionConfiguration) {

            if ($transitionConfiguration[0] === $node) {

                $this->checkCycles(
                    $configuration,
                    $transitionConfiguration[2],
                    $nodesVisited
                );
            }
        }

        return $this;
    }

    /**
     * Compile transitions and return structure compiled
     *
     * @param array $configuration Configuration
     *
     * @return TransitionChain Transition chain compiled
     */
    protected function compileTransitions(array $configuration)
    {
        $transitionChain = TransitionChain::create();

        foreach ($configuration as $transitionConfiguration) {

            list(
                $startStateName,
                $transitionName,
                $finalStateName
                ) = $transitionConfiguration;

            $startState = new State($startStateName);
            $finalState = new State($finalStateName);
            $transition = new Transition(
                $transitionName,
                $startState,
                $finalState
            );

            $transitionChain->addTransition($transition);
        }

        return $transitionChain;
    }

    /**
     * Check transitions duplicates
     *
     * An transition from a state should exist once
     *
     * @param TransitionChain $transitionChain Transition chain
     *
     * @return $this self Object
     *
     * @throws InconsistentTransitionConfigurationException Duplicated pair of
     *                                                      state-transition
     */
    protected function checkTransitionDuplicates(TransitionChain $transitionChain)
    {
        $states = array();

        /**
         * @var Transition $transition
         */
        foreach ($transitionChain->getTransitions() as $transition) {

            $startingStateName = $transition->getStart()->getName();
            $transitionName = $transition->getName();

            if (isset($states[$startingStateName])) {

                if (isset($states[$startingStateName][$transitionName])) {

                    throw new InconsistentTransitionConfigurationException(
                        $startingStateName,
                        $transitionName
                    );
                }
            } else {

                $states[$startingStateName] = array();
            }

            $states[$startingStateName][$transitionName] = true;
        }

        return $this;
    }

    /**
     * Compile next states of each state
     *
     * @param TransitionChain $transitionChain Transition chain
     *
     * @return $this self Object
     *
     * @throws StateNotValidException state is not valid
     */
    protected function checkStates(TransitionChain $transitionChain)
    {
        /**
         * @var Transition $transition
         */
        foreach ($transitionChain->getTransitions() as $transition) {

            $initialStateName = $transition->getStart()->getName();

            if ($initialStateName === $this->pointOfEntry) {

                continue;
            }

            if (empty($this->transitionChain->getTransitionsByFinalState($initialStateName))) {

                throw new StateNotValidException($initialStateName);
            }
        }

        return $this;
    }
}
