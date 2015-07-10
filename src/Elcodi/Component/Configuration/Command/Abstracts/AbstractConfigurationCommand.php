<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Configuration\Command\Abstracts;

use Symfony\Component\Console\Input\InputArgument;

use Elcodi\Component\Configuration\Services\ConfigurationManager;
use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;

/**
 * Class AbstractConfigurationCommand
 */
class AbstractConfigurationCommand extends AbstractElcodiCommand
{
    /**
     * @var ConfigurationManager
     *
     * Configuration manager
     */
    protected $configurationManager;

    /**
     * Constructor
     *
     * @param ConfigurationManager $configurationManager Configuration manager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        parent::__construct();

        $this->configurationManager = $configurationManager;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'Configuration identifier'
            );
    }
}
