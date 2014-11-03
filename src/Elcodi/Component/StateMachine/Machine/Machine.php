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

namespace Elcodi\Component\StateMachine\Machine;

use Elcodi\Component\StateMachine\Definition\State;
use Elcodi\Component\StateMachine\Definition\StateChain;
use Elcodi\Component\StateMachine\Definition\StateGroup;
use Elcodi\Component\StateMachine\Definition\StateGroupChain;
use Elcodi\Component\StateMachine\Entity\Interfaces\StateableInterface;
use Elcodi\Component\StateMachine\Entity\StateLine;
use Elcodi\Component\StateMachine\Exception\CyclesNotAllowedException;
use Elcodi\Component\StateMachine\Exception\InvalidPointOfEntryException;
use Elcodi\Component\StateMachine\Exception\MachineAlreadyCompiledException;
use Elcodi\Component\StateMachine\Exception\MachineNeedsCompilationException;
use Elcodi\Component\StateMachine\Exception\StateNotValidException;

/**
 * Class Machine
 */
class Machine
{
    /**
     * @var array
     *
     * Configuration
     */
    protected $configuration;

    /**
     * @var array
     *
     * StateGroups configuration
     */
    protected $stateGroupsConfiguration;

    /**
     * @var StateChain
     *
     * State chain
     */
    protected $stateChain;

    /**
     * @var StateGroupChain
     *
     * StateGroup chain
     */
    protected $stateGroupChain;

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
     * @var boolean
     *
     * compiled
     */
    protected $compiled;

    /**
     * construct method
     *
     * @param string $machineId     Machine id
     * @param array  $configuration State configuration
     * @param string $pointOfEntry
     */
    public function __construct(
        $machineId,
        array $configuration,
        $pointOfEntry
    )
    {
        $this->machineId = $machineId;
        $this->configuration = $configuration;
        $this->stateGroupsConfiguration = array();
        $this->stateChain = new StateChain();
        $this->stateGroupChain = new StateGroupChain();
        $this->pointOfEntry = $pointOfEntry;
        $this->canBeCyclic = true;
        $this->compiled = false;
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
     * Add point
     *
     * @param string $pointName Point name
     * @param array  $states    States belonging to this point
     *
     * @return $this self Object
     */
    public function addStatGroup($pointName, array $states)
    {
        $this->stateGroupsConfiguration[$pointName] = $states;

        return $this;
    }

    /**
     * Compile machine
     */
    public function compile()
    {
        if ($this->compiled) {

            throw new MachineAlreadyCompiledException();
        }

        $this
            ->checkPointOfEntry($this->configuration, $this->pointOfEntry)
            ->checkStates($this->configuration)
            ->checkCycles($this->configuration, $this->pointOfEntry, $nodesVisited = array())
            ->compileStates($this->configuration)
            ->compileNextStates($this->configuration)
            ->compileStateGroups($this->stateGroupsConfiguration);

        $this->compiled = true;

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
        if (!is_string($pointOfEntry) || !array_key_exists($pointOfEntry, $configuration)) {

            throw new InvalidPointOfEntryException($pointOfEntry);
        }

        return $this;
    }

    /**
     * Given an array of configuration, checks that all data is prepared for
     * being compiled
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
     *
     * @throws StateNotValidException state is not valid
     */
    protected function checkStates(array $configuration)
    {
        foreach ($configuration as $stateName => $nextStates) {

            if (!is_string($stateName) || empty($stateName)) {

                throw new StateNotValidException($stateName);
            }

            foreach ($nextStates as $nextState) {

                if (
                    !is_string($nextState) ||
                    empty($nextState) ||
                    !isset($configuration[$nextState])
                ) {

                    throw new StateNotValidException($nextState);
                }
            }
        }

        return $this;
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
    protected function checkCycles(array $configuration, $node, array &$nodesVisited)
    {
        if (in_array($node, $nodesVisited)) {

            if (!$this->canBeCyclic) {

                throw new CyclesNotAllowedException();
            }

            return $this;
        }

        $nodesVisited[] = $node;

        foreach ($configuration[$node] as $nextNode) {

            $this->checkCycles(
                $configuration,
                $nextNode,
                $nodesVisited
            );
        }

        return $this;
    }

    /**
     * Compile states
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
     *
     * @throws StateNotValidException state is not valid
     */
    protected function compileStates(array $configuration)
    {
        foreach ($configuration as $stateName => $nextStates) {

            $state = new State($stateName, new StateChain());
            $this
                ->stateChain
                ->addState($state);
        }

        return $this;
    }

    /**
     * Compile next states of each state
     *
     * @param array $configuration Configuration
     *
     * @return $this self Object
     *
     * @throws StateNotValidException state is not valid
     */
    protected function compileNextStates(array $configuration)
    {
        foreach ($configuration as $stateName => $nextStates) {

            foreach ($nextStates as $nextStateName) {

                $state = $this->stateChain->getState($stateName);
                $nextState = $this->stateChain->getState($nextStateName);
                $state
                    ->getNextStates()
                    ->addState($nextState);
            }
        }

        return $this;
    }

    /**
     * Compile points
     *
     * @param array $stateGroupsConfiguration StatGroup configuration
     *
     * @return $this self Object
     *
     * @throws StateNotValidException Invalid state
     */
    protected function compileStateGroups(array $stateGroupsConfiguration)
    {
        foreach ($stateGroupsConfiguration as $stateGroupName => $states) {

            $stateGroupStatesChain = new StateChain();

            foreach ($states as $stateName) {

                if (!$this->stateChain->hasState($stateName)) {

                    throw new StateNotValidException($stateName);
                }

                $stateGroupStatesChain->addState(
                    $this
                        ->stateChain
                        ->getState($stateName)
                );
            }

            $this
                ->stateGroupChain
                ->addStateGroup(
                    new StateGroup(
                        $stateGroupName,
                        $stateGroupStatesChain
                    )
                );
        }
    }

    /**
     *
     * Evaluation methods
     *
     */

    /**
     * Has state
     *
     * @param string $stateName State name
     *
     * @return boolean Current machine has the state
     */
    public function hasState($stateName)
    {
        return $this->stateChain->hasState($stateName);
    }

    /**
     * Has state group
     *
     * @param string $stateGroupName State Group name
     *
     * @return boolean Current machine has the state group
     */
    public function hasStateGroup($stateGroupName)
    {
        return $this->stateGroupChain->hasStateGroup($stateGroupName);
    }

    /**
     * The object can change to next specified state
     *
     * @param StateableInterface $object        Stateable object
     * @param string             $nextStateName Next State name
     *
     * @return boolean Object can
     *
     * @throws MachineNeedsCompilationException Machine not compiled yet
     * @throws StateNotValidException           state not valid
     */
    public function canChange(StateableInterface $object, $nextStateName)
    {
        if (!$this->compiled) {

            throw new MachineNeedsCompilationException();
        }

        if (!$this->stateChain->hasState($nextStateName)) {

            throw new StateNotValidException($nextStateName);
        }

        $lastState = $object->getLastStateLine();

        if (!($lastState instanceof StateLine)) {
            return ($nextStateName === $this->pointOfEntry);
        }

        return $this
            ->stateChain
            ->getState($lastState->getName())
            ->getNextStates()
            ->hasState($nextStateName);
    }

    /**
     * Add new state into an stateable object
     *
     * @param StateableInterface $object               Stateable object
     * @param string             $nextStateName        Next State name
     * @param string             $nextStateDescription Next State description
     *
     * @return boolean New State has been added into object
     *
     * @throws MachineNeedsCompilationException Machine not compiled yet
     * @throws StateNotValidException           state not valid
     */
    public function addState(
        StateableInterface $object,
        $nextStateName,
        $nextStateDescription
    )
    {
        if (!$this->compiled) {

            throw new MachineNeedsCompilationException();
        }

        if (!$this->canChange($object, $nextStateName)) {
            return false;
        }

        $nextState = new StateLine(
            $nextStateName,
            $nextStateDescription
        );

        $object->addStateLine($nextState);

        return true;
    }

    /**
     * Belongs to specific group
     *
     * @param StateableInterface $object        Stateable object
     * @param string             $nextStateName Next State name
     *
     * @return boolean belongs to group
     */
    public function belongsTo(
        StateableInterface $object,
        $groupName
    )
    {
        if (!$this->stateGroupChain->hasStateGroup($groupName)) {
            return false;
        }

        $lastState = $object->getLastStateLine();
        $stateName = $lastState instanceof StateLine
            ? $lastState->getName()
            : null;

        return $this
            ->stateGroupChain
            ->getStateGroup($groupName)
            ->getStateChain()
            ->hasState($stateName);
    }
}
