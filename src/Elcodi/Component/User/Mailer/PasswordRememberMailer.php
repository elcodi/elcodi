<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\User\Mailer;

use Elcodi\Component\Core\Mailer\Abstracts\AbstractMailer;
use Elcodi\Component\User\Event\PasswordRememberEvent;

/**
 * Class PasswordRememberMailer.
 */
class PasswordRememberMailer extends AbstractMailer
{
    /**
     * Send password remember email.
     *
     * @param PasswordRememberEvent $event Event
     */
    public function sendEmail(PasswordRememberEvent $event)
    {
        $this->renderEmail(
            'Password remember email',
            $event->getUser()->getEmail(),
            [
                'user' => $event->getUser(),
                'rememberUrl' => $event->getRememberUrl(),
            ]
        );
    }
}
