Elcodi State Transition Machine component
=========================================

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

## Installing the State Transition Machine

You have to add require line into you composer.json file

``` yml
"require": {
    "php": ">=5.4",
    ...

    "elcodi/state-transition-machine": "dev-master",
}
```

Then you have to use composer to update your project dependencies

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar update
```

## Usage

This component provides you a State Transition Machine for your entities. To
understand what is a State Transition Machine, let's see an example about a use
case.

Let's figure out we are working with a Order object. We want to give some states
to this Order, like "new", "paid" and "shipped". Well, this is the perfect
scenario for this component. The only thing you must define is the set of states
and how you should jump from one to another.

Let's see an example.

```php
$configuration = array(
    'new', 'pay', 'paid',
    'paid', 'ship', 'shipped',
    'shipped', 'receive', 'received',
);
```

You have four states here.
* new: First state or point of entry
* paid: The order is paid
* shipped: The order is shipped but is not received yet
* received: The order is received

And we have three transitions between these states.
* pay: We pay an order
* ship: We ship an order
* receive: A ship is being received

## Machine Builder

So, this component provides a way to play with all this information in a very
single way, providing as well one machine for each configuration, identified by
a string. Let's see an example of how to build a useful Machine for our project.

``` php
<?php

use Elcodi\Component\StateTransitionMachine\Factory\MachineFactor;

$machineIdentifier = 'order_states';
$pointOfEntry = 'new';
$machineFactory = new MachineFactory;
$configuration = array(
    'new', 'pay', 'paid',
    'paid', 'ship', 'shipped',
    'shipped', 'receive', 'received',
);

$machineBuilder = new MachineBuilder(
    $machineFactory,
    $machineIdentifier,
    $configuration,
    $pointOfEntry
);
$machine = $machineBuilder->compile();
```

To build a MachineCompiler we need this information:
* Machine Factory: The factory that the MachineBuilder will use to build a new
Machine instance
* Machine identifier: The identifier of the machine. This value must be unique
* Configuration: The states definition. This parameter must be an array of
edges, and each edge must be an array with this elements: `from state`,
`transition name` and `to state`.
* Point of Entry: The first state to add once the object is initialized

## Machine

Once the MachineBuilder is compiled, this method returns us a MachineInterface
implementation, with the possibility of using 4 methods.

``` php
    /**
     * Get machine id
     *
     * @return string Machine identifier
     */
    public function getId();

    /**
     * Get point of entry
     *
     * @return string Point of entry
     */
    public function getPointOfEntry();

    /**
     * Applies a transition from a state
     *
     * @param string $startStateName Start state name
     * @param string $transitionName Transition name
     *
     * @return Transition Transition created
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition name
     */
    public function transition(
        $startStateName,
        $transitionName
    );

    /**
     * Reaches a state given a start state
     *
     * @param string $startStateName Start state name
     * @param string $finalStateName Final state name
     *
     * @return Transition Transition created
     *
     * @throws StateNotReachableException State is not reachable
     */
    public function reachState(
        $startStateName,
        $finalStateName
    );
```

Given the last example with the last configuration, lets try to do apply the
`pay` transition from the `new` state using the `transition` method.

``` php
echo $machine->getId();
// = order_states

echo $machine->getPointOfEntry();
// = new

$transition = $machine->transition('unpaid', 'pay');
echo get_class($transition);
// = \Elcodi\Component\StateTransitionMachine\Definition\Transition

echo $transition->getName();
// = pay

echo $transition->getStart()->getName();
// = new

echo $transition->getFinal()->getName();
// = paid
```

We can use the `reachState` method as well, to reach an specific state no matter
the name of the transition. The result should be the same as the last example.

``` php
$transition = $machine->reachState('new', 'paid');
```

Because using a machine is a transactional action, all errors will be notified
with Exceptions. In that case, because we can not `ship` an `new` order, we
would receive a `TransitionNotAccessibleException` exception.

``` php
$transition = $machine->transition('new', 'ship');
```

## MachineManager

To make things easier and to provide a nice interface for the final user, a
`MachineManager` object is created. This object provide as well a nice interface
to dispatch events using the Symfony Event Dispatcher Component.

Let's see how it works using the previous Machine object. To make it happen, we
must work with implementations of the interface
`\Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StatefulInterface`,
so our `Order` instance is one of these.

Every entity implementing this interface, in order to be able to work with an
specific machine, must be initialized once to make sure that the first state is
already injected. Once this object is initialized, this action is not required
anymore.

``` php
$stateLineFactory = new StateLineFactory();
$eventDispatcher = new EventDispatcher();
$machineManager = new MachineManager(
    $machine,
    $eventDispatcher,
    $stateLineFactory,
);

$order = new Order();
$machineManager->initialize($order, 'First state');
$transition = $machineManager->reachState($order, 'paid', 'The order have been
paid');
```

Because the point of entry state is `new` and we can reach the State `paid`,
this transition will be valid.
In this action, several events will be dispatched from the $eventDispatched
instance.

## Events

* Initialization:
    - An object has been initialized in a specific Machine.
    - The event name is `state_machine.{machine_id}.initialization`, overriding
    the **{machine_id}** with the machine identifier
    Dispatches a `\Elcodi\Component\StateTransitionMachine\Event\InitializationEvent`
    event.
* Transition from a state:
    - An object have had a transition from a state.
    - The event name is `state_machine.{machine_id}.transition_from_{state_name}`,
    overriding **{machine_id}** with the machine identifier and **{state_name}**
    with the state name
    - Dispatches a `\Elcodi\Component\StateTransitionMachine\Event\TransitionEvent`
    event.
* Transition:
    - An object have had a transition.
    The event name is `state_machine.{machine_id}.{transition_name}`, overriding
    **{machine_id}** with the machine identifier and **{transition_name}** with
    the transition name
    - Dispatches a `\Elcodi\Component\StateTransitionMachine\Event\TransitionEvent`
    event.
* Transition to a state:
    - An object have had a transition to a state.
    - The event name is `state_machine.{machine_id}.transition_to_{state_name}`,
    overriding **{machine_id}** with the machine identifier and **{state_name}**
    with the state name
    - Dispatches a `\Elcodi\Component\StateTransitionMachine\Event\TransitionEvent`
    event.

## Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs
checks. Read more details about
[Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition](https://github.com/escapestudios/Symfony2-coding-standard)
to run code validation.

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New features must come paired with PHPUnit tests.

If you would like to contribute, please read the [Contributing Code][1] in the project
documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][2] section and use the [Pull Request Template][3].

[1]: http://symfony.com/doc/current/contributing/code/index.html
[2]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[3]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
