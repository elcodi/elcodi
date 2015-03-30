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

namespace Elcodi\Plugin\TwitterBundle\Controller;

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
     *      name = "admin_twitter_configuration",
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
            ->getPlugin('Elcodi\Plugin\TwitterBundle');

        if ('POST' === $request->getMethod()) {
            $pluginManager = $this
                ->get('elcodi.plugin_manager');

            $pluginManager
                ->updatePlugin(
                    'Elcodi\Plugin\TwitterBundle',
                    $plugin->isEnabled(),
                    [
                        'twitter_account' => $request->request->get('twitter_account'),
                    ]
                );

            $this->addFlash('success', 'twitter_plugin.action.result_ok');

            return $this->redirectToRoute('admin_twitter_configuration');
        }

        return [
            'plugin' => $plugin,
        ];
    }
}
