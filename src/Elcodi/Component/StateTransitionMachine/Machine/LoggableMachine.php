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

use Psr\Log\LoggerInterface;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;

/**
 * Class LoggableMachine
 */
class LoggableMachine implements MachineInterface
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    protected $machine;

    /**
     * @var LoggerInterface
     *
     * Logger
     */
    protected $logger;

    /**
     * Construct
     *
     * @param MachineInterface $machine Machine
     * @param LoggerInterface  $logger  Logger
     */
    public function __construct(
        MachineInterface $machine,
        LoggerInterface $logger
    )
    {
        $this->machine = $machine;
        $this->logger = $logger;
    }

    /**
     * Get machine id
     *
     * @return string Machine identifier
     */
    public function getId()
    {
        return $this
            ->machine
            ->getId();
    }

    /**
     * Get point of entry
     *
     * @return string Point of entry
     */
    public function getPointOfEntry()
    {
        return $this
            ->machine
            ->getPointOfEntry();
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
        return $this
            ->machine
            ->can($startStateName, $transitionName);
    }

    /**
     * Applies an transition given a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return Transition Transition done
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     */
    public function go($startStateName, $transitionName)
    {
        $transition = $this
            ->machine
            ->go($startStateName, $transitionName);

        $this
            ->logger
            ->info(
                'Transition {transition_name} in machine "{machine_id}" from "{state_from}" to "{state_to}"',
                array(
                    'transition_name' => $transition->getName(),
                    'machine_id'      => $this->machine->getId(),
                    'state_from'      => $transition->getStart()->getName(),
                    'state_to'        => $transition->getFinal()->getName()
                )
            );

        return $transition;
    }
}
