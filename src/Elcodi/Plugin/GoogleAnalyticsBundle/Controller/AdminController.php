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

namespace Elcodi\Plugin\GoogleAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function configurationAction(Request $request)
    {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.plugin_manager')
            ->getPlugin('Elcodi\Plugin\GoogleAnalyticsBundle');

        if ($request->isMethod(Request::METHOD_POST)) {
            $this
                ->get('elcodi.plugin_manager')
                ->updatePlugin(
                    'Elcodi\Plugin\GoogleAnalyticsBundle',
                    $plugin->isEnabled(),
                    [
                        'analytics_tracker_id' => $request->request->get('analytics_tracker_id'),
                    ]
                );

            return $this->redirectToRoute('admin_google_analytics_configuration');
        }

        return $this->render('ElcodiGoogleAnalyticsBundle:Admin:configuration.html.twig', [
            'plugin' => $plugin,
        ]);
    }
}
