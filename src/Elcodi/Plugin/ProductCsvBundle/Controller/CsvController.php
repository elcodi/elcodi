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
 */

namespace Elcodi\Plugin\ProductCsvBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Elcodi\Plugin\ProductCsvBundle\Services\ProductExporter;

/**
 * Class Controller for ElcodiProductCsvBundle plugin
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CsvController extends Controller
{
    /**
     * @Route(
     *     path = "/products/export",
     *     name = "elcodi_plugin_productcsv_export",
     * )
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function exportAction()
    {
        $plugin = $this
            ->get('elcodi.plugin_manager')
            ->getPlugin('Elcodi\Plugin\ProductCsvBundle');

        if (!$plugin->isEnabled()) {
            $this->createNotFoundException('The plugin is disabled');
        }

        /**
         * @var ProductExporter $exporter
         */
        $exporter = $this->get('elcodi_plugin.product_csv.exporter');
        $repository = $this->get('elcodi.repository.product');

        $response = new StreamedResponse();
        $response->setCallback(function () use ($repository, $exporter) {
            $rows = $repository->findAll();

            $exporter->export($rows);
        });

        $configuration = $plugin->getConfiguration();

        $filename = $configuration['export_filename'];
        if (empty($filename)) {
            $filename = 'products.csv';
        }

        return $this->makeDownloadable($response, $filename, 'text/csv');
    }

    /**
     * Create an HTTP download file from content
     *
     * @param Response $response    Content of the response
     * @param string   $filename    Name that will prompt in the download
     * @param string   $contentType MIME type for the downloaded file
     *
     * @return Response
     */
    protected function makeDownloadable(Response $response, $filename, $contentType)
    {
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Content-Type', $contentType);

        return $response;
    }
}
