Elcodi State Machine component for Symfony2
===========================================

This bundle is part of [elcodi project](https://github.com/elcodi).
Elcodi is a set of flexible e-commerce components for Symfony2, built as a
decoupled and isolated repositories and under
[MIT](http://opensource.org/licenses/MIT) license.

Documentation
-------------

This Component provides a State Machine to any object instance. Let's see a
small example of what we can do.

## Installing the Status Machine

You have to add require line into you composer.json file

``` yml
"require": {
    "php": ">=5.4",
    ...

    "elcodi/state-machine": "dev-master",
}
```

Then you have to use composer to update your project dependencies

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar update
```

## Usage

This state machine is very simple. Let's see a small example of how we can
handle different states. Imagine we are working with Orders. Let's work with a
small Order object

``` php
<?php

use Elcodi\Component\StateMachine\Entity\Interfaces\StateableInterface;
use Elcodi\Component\StateMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateMachine\Entity\StateLine;

/**
 * Class Order
 */
class Order implements StateableInterface
{
    /**
     * @var array
     *
     * State Lines
     */
    public $stateLines = array();

    /**
     * Add state line
     *
     * @param StateLine $stateLine State line
     *
     * @return $this self Object
     */
    public function addStateLine(StateLine $stateLine)
    {
        $this->stateLines[] = $stateLine;
    }

    /**
     * Get last state line
     *
     * @return StateLineInterface|null last StateLine
     */
    public function getLastStateLine()
    {
        $lastStateLine = end($this->stateLines);

        return $lastStateLine;
    }
}
```

As we can see, Order class must implement `StateableInterface` to be handled by
the machine.

Then, we must define a simple structure of state transitions, something like
"In which states can go, given a starting state". An example

``` php
<?php

$states = array(
    'new' => array('accepted'),
    'accepted' => array('problem', 'paid'),
    'problem' => array('accepted', 'cancelled'),
    'cancelled' => array(),
    'paid' => array(),
);
```

In this example, we can have this history

* New
* Accepted
* Paid

this other one

* New
* Accepted
* Problem
* Accepted
* Paid

Or, finally, this other one

* New
* Accepted
* Problem
* Cancelled

So, let's see how to build a new Machine given the configuration.

``` php
<?php

use Elcodi\Component\StateMachine\Factory\MachineFactory;
use Elcodi\Component\StateMachine\Machine\MachineBuilder;

$states = array(
    'new' => array('accepted'),
    'accepted' => array('problem', 'paid'),
    'problem' => array('accepted', 'cancelled'),
    'cancelled' => array(),
    'paid' => array(),
);

$machineFactory = new MachineFactory()
$machine = new MachineBuilder(
    $machineFactory,
    'order_states',
    $states,
    'new'
);
```

## Compiling the Machine

Once the MachineBuilder is created we can configure it and compile it. The
result of this compilation is a Machine object.

``` php
<?php

use Elcodi\Component\StateMachine\Factory\MachineFactory;
use Elcodi\Component\StateMachine\Machine\MachineBuilder;

$machineFactory = new MachineFactory()
$machineBuilder = new Machine(
    $machineFactory,
    'order_states',
    $states,
    'new'
);
$machine = $machineBuilder->compile();
```

## Using the Machine

Given an instance of previous defined Order, we will change the states of the
entity, taking in account the configuration of available transitions.

``` php
<?php

use Elcodi\Component\StateMachine\Factory\MachineFactory;
use Elcodi\Component\StateMachine\Machine\MachineBuilder;

$states = array(
    'new' => array('accepted'),
    'accepted' => array('problem', 'paid'),
    'problem' => array('accepted', 'cancelled'),
    'cancelled' => array(),
    'paid' => array(),
);

$machineFactory = new MachineFactory()
$machineBuilder = new MachineBuilder(
    $machineFactory,
    'order_states',
    $states,
    'new'
);
$machine = $machineBuilder->compile();

$order = new Order();

/**
 * Let's add some valid states to our order
 */
$machine->addState($order, 'new', 'New order');
$machine->addState($order, 'accepted', 'The order has been accepted');

/**
 * And let's add some invalid states of our order. Because our Order's last
 * state is accepted, and from accepted we only can go to problem or paid, if we
 * try to go to cancelled, we will not be able to do that.
 *
 * The value of $result will be false
 */
$result = $machine->addState($order, 'cancelled', 'Order cancelled');

/**
 * We need first of all go to problem, report the problem, and then cancel the
 * order, as is shown.
 *
 * The value of $result will be true
 */
$machine->addState($order, 'problem', 'Stock unavailable');
$result = $machine->addState($order, 'cancelled', 'Order cancelled');
```

Because the management of the objects states is something very related to the
business logic and should be always controlled, any specification or requesting
of a non-existing state will cause a
`Elcodi\Component\StateMachine\Exception\StateNotValidException`. To avoid the
problem you can just check if an specific State is contained in a Machine
instance.

``` php
<?php

/**
 * Given the previous configuration, the value of $hasState will be false
 */
$hasState = $machine->hasState('state9');
```

## Cyclic machine

We can consider disallowing our machine to be cyclic. If we want to specify this
restriction we must configure it as follows.

``` php
<?php

use Elcodi\Component\StateMachine\Factory\MachineFactory;
use Elcodi\Component\StateMachine\Machine\MachineBuilder;

$states = array(
    'new' => array('accepted'),
    'accepted' => array('problem', 'paid'),
    'problem' => array('accepted', 'cancelled'),
    'cancelled' => array(),
    'paid' => array(),
);

$machineFactory = new MachineFactory()
$machineBuilder = new MachineBuilder(
    $machineFactory,
    'order_states',
    $states,
    'new'
);
$machineBuilder->allowCycles(false);
$machine = $machineBuilder->compile();
```

By default this configuration is `true`.

If we compile a non-cyclable machine with a cyclic configuration, the Machine
will throw a
`Elcodi\Component\StateMachine\Exception\CyclesNotAllowedException`.

## Configuring StateGroups

An state group is just a set of available states, identified by a string. You
can group several states in one group to easily check if a `Stateable` object
belongs to this group (Its last state is part of this group)

``` php
<?php

use Elcodi\Component\StateMachine\Factory\MachineFactory;
use Elcodi\Component\StateMachine\Machine\MachineBuilder;

$states = array(
    'new' => array('accepted'),
    'accepted' => array('problem', 'paid'),
    'problem' => array('accepted', 'cancelled'),
    'cancelled' => array(),
    'paid' => array(),
);

$machineFactory = new MachineFactory()
$machineBuilder = new MachineBuilder(
    $machineFactory,
    'order_states',
    $states,
    'new'
);
$machineBuilder->addStatGroup('processing', array(
    'accepted', 'problem'
));
$machine = $machineBuilder->compile();
```

You can also check if an specific group is defined in current Machine.

``` php
<?php

/**
 * Given the previous configuration, the value of $hasState will be false
 */
$hasStateGroup = $machine->hasState('shipped');
```

## Tags

* Use last unstable version ( alias of `dev-master` ) to stay always in last commit
* Use last stable version tag to stay in a stable release.

## Contributing

All issues and Pull Requests should be on the main repository
[elcodi/elcodi](https://github.com/elcodi/elcodi), so this one is read-only.

This projects follows Symfony2 coding standards, so pull requests must pass phpcs
checks. Read more details about
[Symfony2 coding standards](http://symfony.com/doc/current/contributing/code/standards.html)
and install the corresponding [CodeSniffer definition](https://github.com/opensky/Symfony2-coding-standard)
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
