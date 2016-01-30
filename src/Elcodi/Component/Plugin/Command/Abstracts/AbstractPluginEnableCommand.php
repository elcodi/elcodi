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

namespace Elcodi\Component\Plugin\Command\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;
use Elcodi\Component\Plugin\Repository\PluginRepository;

/**
 * Class AbstractPluginEnableCommand.
 */
abstract class AbstractPluginEnableCommand extends AbstractElcodiCommand
{
    /**
     * @var PluginRepository
     *
     * Plugin repository
     */
    protected $pluginRepository;

    /**
     * @var ObjectManager
     *
     * Plugin ObjectManager
     */
    protected $pluginObjectManager;

    /**
     * Constructor.
     *
     * @param PluginRepository $pluginRepository    Plugin repository
     * @param ObjectManager    $pluginObjectManager pluginObjectManager
     */
    public function __construct(
        PluginRepository $pluginRepository,
        ObjectManager $pluginObjectManager
    ) {
        parent::__construct();

        $this->pluginRepository = $pluginRepository;
        $this->pluginObjectManager = $pluginObjectManager;
    }
}
