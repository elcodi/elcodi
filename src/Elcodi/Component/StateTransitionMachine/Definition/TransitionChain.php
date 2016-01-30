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

namespace Elcodi\Component\StateTransitionMachine\Definition;

/**
 * Class TransitionChain.
 */
class TransitionChain
{
    /**
     * @var array
     *
     * Transitions
     */
    private $transitions = [];

    /**
     * add Transition.
     *
     * @param Transition $transition Transition
     *
     * @return $this Self object
     */
    public function addTransition(Transition $transition)
    {
        $this->transitions[] = $transition;

        return $this;
    }

    /**
     * add Transition.
     *
     * @return array Transitions of the chain
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * Has transition.
     *
     * @param string $transitionName Transition name
     *
     * @return bool Transition exists
     */
    public function hasTransition($transitionName)
    {
        return !is_null($this->getTransitionsByName($transitionName));
    }

    /**
     * Get transitions with specific name.
     *
     * @param string $transitionName Transition name
     *
     * @return array|null Transitions with specific name
     */
    public function getTransitionsByName($transitionName)
    {
        return array_filter(
            $this->transitions,
            function (Transition $transition) use ($transitionName) {
                return $transition->getName() === $transitionName;
            }
        );
    }

    /**
     * Get transitions given the name of the start state.
     *
     * @param string $stateName State name
     *
     * @return array|null Transitions with specific start state
     */
    public function getTransitionsByStartingState($stateName)
    {
        return array_filter(
            $this->transitions,
            function (Transition $transition) use ($stateName) {
                return $transition
                    ->getStart()
                    ->getName() === $stateName;
            }
        );
    }

    /**
     * Get transitions given the name of the final state name.
     *
     * @param string $stateName State name
     *
     * @return array|null Transitions with specific final state
     */
    public function getTransitionsByFinalState($stateName)
    {
        return array_filter(
            $this->transitions,
            function (Transition $transition) use ($stateName) {
                return $transition
                    ->getFinal()
                    ->getName() === $stateName;
            }
        );
    }

    /**
     * Get transition starting state name and transition name.
     *
     * @param string $stateName      State name
     * @param string $transitionName Transition name
     *
     * @return Transition|null Transition if exists
     */
    public function getTransitionByStartingStateAndTransitionName(
        $stateName,
        $transitionName
    ) {
        $transition = array_filter(
            $this->transitions,
            function (Transition $transition) use ($stateName, $transitionName) {
                return
                    $transition->getName() === $transitionName &&
                    $transition->getStart()->getName() === $stateName;
            }
        );

        return !empty($transition)
            ? reset($transition)
            : null;
    }

    /**
     * Get transition starting state name and final state name.
     *
     * @param string $startStateName Start state name
     * @param string $finalStateName Final state name
     *
     * @return Transition|null Transition if exists
     */
    public function getTransitionByStartingStateAndFinalState(
        $startStateName,
        $finalStateName
    ) {
        $transition = array_filter(
            $this->transitions,
            function (Transition $transition) use ($startStateName, $finalStateName) {
                return
                    $transition->getStart()->getName() === $startStateName &&
                    $transition->getFinal()->getName() === $finalStateName;
            }
        );

        return !empty($transition)
            ? reset($transition)
            : null;
    }

    /**
     * Create new TransitionChain instance.
     *
     * @return TransitionChain Instance
     */
    public static function create()
    {
        return new self();
    }
}
