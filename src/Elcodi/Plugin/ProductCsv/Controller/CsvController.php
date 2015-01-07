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

namespace Elcodi\Plugin\ProductCsv\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class Controller for ProductCsv plugin
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
        $repository = $this->get('elcodi.repository.product');
        $exporter = $this->get('elcodi_plugin.product_csv.exporter');

        $response = new StreamedResponse();
        $response->setCallback(function () use ($repository, $exporter) {
            $rows = $repository->findAll();

            $exporter->export($rows);
        });

        return $this->makeDownloadable($response, 'products.csv', 'text/csv');
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