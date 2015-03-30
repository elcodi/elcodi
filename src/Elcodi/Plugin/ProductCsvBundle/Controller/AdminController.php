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

namespace Elcodi\Plugin\ProductCsvBundle\Controller;

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
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Route(
     *      path = "/configuration",
     *      name = "admin_product_csv_configuration",
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
            ->getPlugin('Elcodi\Plugin\ProductCsvBundle');

        if (!$plugin->isEnabled()) {
            $this->createNotFoundException(
                $this
                    ->get('translator')
                    ->trans('product_csv_plugin.error.is_disabled')
            );
        }

        if ('POST' === $request->getMethod()) {
            $this
                ->get('elcodi.plugin_manager')
                ->updatePlugin(
                    'Elcodi\Plugin\ProductCsvBundle',
                    $plugin->isEnabled(),
                    [
                        'export_filename' => $request->request->get('export_filename'),
                    ]
                );

            return $this->redirectToRoute('admin_product_csv_configuration');
        }

        return [
            'plugin' => $plugin,
        ];
    }
}
