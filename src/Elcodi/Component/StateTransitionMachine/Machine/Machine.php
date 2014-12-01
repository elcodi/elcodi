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

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Exception\Abstracts\AbstractTransitionException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class Machine
 */
class Machine implements MachineInterface
{
    /**
     * @var integer
     *
     * Machine id
     */
    protected $machineId;

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
     * @param integer         $machineId       Machine id
     * @param TransitionChain $transitionChain Transition Chain
     * @param string          $pointOfEntry    Point of entry
     */
    public function __construct(
        $machineId,
        TransitionChain $transitionChain,
        $pointOfEntry
    )
    {
        $this->machineId = $machineId;
        $this->transitionChain = $transitionChain;
        $this->pointOfEntry = $pointOfEntry;
    }

    /**
     * Get machine id
     *
     * @return string Machine identifier
     */
    public function getId()
    {
        return $this->machineId;
    }

    /**
     * Get point of entry
     *
     * @return string Point of entry
     */
    public function getPointOfEntry()
    {
        return $this->pointOfEntry;
    }

    /**
     * Can apply an transition given a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return boolean Can apply transition
     */
    public function can($startStateName, $transitionName)
    {
        try {

            $this
                ->go(
                    $startStateName,
                    $transitionName
                );
        } catch (AbstractTransitionException $exception) {
            return false;
        }

        return true;
    }

    /**
     * Applies a transition given a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return Transition Transition done
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     */
    public function go(
        $startStateName,
        $transitionName
    )
    {
        if (!$this->transitionChain->hasTransition($transitionName)) {

            throw new TransitionNotValidException($transitionName);
        }

        $transition = $this
            ->transitionChain
            ->getTransitionByStartingStateAndTransitionName(
                $startStateName,
                $transitionName
            );

        if (!($transition instanceof Transition)) {

            throw new TransitionNotAccessibleException();
        }

        return $transition;
    }
}
