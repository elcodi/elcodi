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

namespace Elcodi\Plugin\DisqusBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Component\Plugin\Entity\Plugin;

/**
 * Class DisqusController
 */
class DisqusController extends Controller
{
    /**
     * @Route(
     *      path = "/disqus",
     *      name = "admin_disqus_configuration",
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
            ->getPlugin('Elcodi\Plugin\DisqusBundle');

        if ('POST' === $request->getMethod()) {
            $this
                ->get('elcodi.plugin_manager')
                ->updatePlugin(
                    'Elcodi\Plugin\DisqusBundle',
                    $plugin->isEnabled(),
                    [
                        'disqus_identifier' => $request->request->get('disqus_identifier'),
                        'disqus_enabled_product' => $request->request->get('disqus_enabled_product'),
                        'disqus_enabled_blog_post' => $request->request->get('disqus_enabled_blog_post'),
                    ]
                );

            return $this->redirectToRoute('admin_disqus_configuration');
        }

        return [
            'plugin' => $plugin,
        ];
    }
}
