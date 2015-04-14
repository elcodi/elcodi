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

namespace Elcodi\Plugin\StoreSetupWizardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;

/**
 * Class AdminController
 */
class WizardController extends Controller
{
    /**
     * View dashboard action
     *
     * @return array
     */
    public function viewAction()
    {
        $wizardStatusService = $this
            ->get('elcodi_templates.wizard_status.service');
        $stepsFinished       = $wizardStatusService->getStepsFinishStatus();

        $firstCarrier = $this
            ->get('elcodi.repository.carrier')
            ->findOneBy(
                ['enabled' => true],
                ['id' => 'ASC']
            );

        $firstCarrier = ($firstCarrier instanceof CarrierInterface)
            ? $firstCarrier
            : false;

        $activeStep = null;
        foreach ($stepsFinished as $step => $isFinished) {
            if (false === $isFinished) {
                $activeStep = $step;
                break;
            }
        }

        return $this->render('ElcodiStoreSetupWizardBundle:Wizard:view.html.twig', [
            'stepsFinished' => $stepsFinished,
            'activeStep'    => $activeStep,
            'carrier'       => $firstCarrier,
        ]);
    }
}
