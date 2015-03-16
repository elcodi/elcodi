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

namespace Elcodi\Bundle\FixturesBoosterBundle\Command;

use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand as OriginalCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class LoadDataFixturesDoctrineCommand
 *
 * Wrapper of original Doctrine. In order to boost all the fixtures, this
 * command tries to reuse sqlite instances.
 *
 * This strategy takes in account all defined fixture paths (or all if fixtures
 * are not specified) and the Kernel
 */
class LoadDataFixturesDoctrineCommand extends OriginalCommand
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var string
     *
     * Database file path
     */
    protected $databaseFilePath;

    /**
     * Construct
     *
     * @param KernelInterface $kernel           Kernel
     * @param string          $databaseFilePath Database file path
     */
    public function __construct(
        KernelInterface $kernel,
        $databaseFilePath)
    {
        parent::__construct();

        $this->kernel = $kernel;
        $this->databaseFilePath = $databaseFilePath;
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($this->databaseFilePath)) {

            return parent::execute($input, $output);
        }

        /**
         * Same code as parent implementation
         */
        $dirOrFile = $input->getOption('fixtures');
        $paths = array();

        if ($dirOrFile) {
            $paths = is_array($dirOrFile)
                ? $dirOrFile :
                array($dirOrFile);
        } else {
            foreach ($this->getApplication()->getKernel()->getBundles() as $bundle) {
                $paths[] = $bundle->getPath().'/DataFixtures/ORM';
            }
        }

        /**
         * In order to take in account the kernel as well (same fixtures,
         * different kernel/different schema, make the tests crash
         */
        $paths[] = get_class($this->kernel);

        sort($paths, SORT_STRING);
        $backupFileName = '/tmp/'.sha1(serialize($paths)).'.backup.database';
        if (file_exists($backupFileName)) {
            copy($backupFileName, $this->databaseFilePath);

            return 0;
        }

        parent::execute($input, $output);

        /**
         * If new file has been created, copy it with generated hash value. Now
         * this backup will be reusable for next iterations
         */
        if (file_exists($this->databaseFilePath)) {
            copy($this->databaseFilePath, $backupFileName);
        }

        return 0;
    }
}
