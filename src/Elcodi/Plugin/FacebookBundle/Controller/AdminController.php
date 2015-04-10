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

namespace Elcodi\Plugin\FacebookBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * Configure plugin action page
     *
     * @param Request $request The current request
     *
     * @return array|RedirectResponse The response
     *
     * @Route(
     *      path = "/configuration",
     *      name = "admin_facebook_configuration",
     *      methods = {"GET", "POST"}
     * )
     * @Template()
     */
    public function configurationAction(Request $request)
    {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.plugin_manager')
            ->getPlugin('Elcodi\Plugin\FacebookBundle');

        if ($request->isMethod(Request::METHOD_POST)) {
            $pluginManager = $this
                ->get('elcodi.plugin_manager');

            $pluginManager
                ->updatePlugin(
                    'Elcodi\Plugin\FacebookBundle',
                    $plugin->isEnabled(),
                    [
                        'facebook_account' => $request->request->get('facebook_account'),
                    ]
                );

            $this->addFlash('success', 'facebook_plugin.action.result_ok');

            return $this->redirectToRoute('admin_facebook_configuration');
        }

        return [
            'plugin' => $plugin,
        ];
    }
}
