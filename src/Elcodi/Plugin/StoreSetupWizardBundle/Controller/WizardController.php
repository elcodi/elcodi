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

/**
 * Class AdminController
 */
class WizardController extends Controller
{
    /**
     * View dashboard action
     *
     * @return array
     *
     * @Route(
     *      path = "/store-setup-wizard",
     *      name = "admin_store_setup_wizard",
     *      methods = {"GET"}
     * )
     * @Template()
     */
    public function viewAction()
    {
        $wizardStatusService = $this
            ->get('elcodi_templates.wizard_status.service');
        $stepsFinished       = $wizardStatusService->getStepsFinishStatus();

        $activeStep = null;
        foreach ($stepsFinished as $step => $isFinished) {
            if (false == $isFinished) {
                $activeStep = $step;
                break;
            }
        }

        return [
            'stepsFinished' => $stepsFinished,
            'activeStep'    => $activeStep,
        ];
    }
}
