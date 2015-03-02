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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * Configuration action.
     *
     * @Route(
     *      path = "/configuration",
     *      name = "admin_store_setup_wizard_configuration",
     *      methods = {"GET", "POST"}
     * )
     * @Template()
     *
     * @return array
     */
    public function configurationAction()
    {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.plugin_manager')
            ->getPlugin('Elcodi\Plugin\StoreSetupWizardBundle');

        return [
            'plugin' => $plugin,
        ];
    }
}
