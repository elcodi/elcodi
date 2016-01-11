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

namespace Elcodi\Component\Core\Mailer\Abstracts;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class AbstractMailer.
 */
abstract class AbstractMailer
{
    /**
     * @var EngineInterface
     *
     * Templating
     */
    private $templatingEngine;

    /**
     * @var Swift_Mailer
     *
     * Mailer
     */
    private $mailer;

    /**
     * @var string
     *
     * layout
     */
    private $layout;

    /**
     * @var string
     *
     * template
     */
    private $template;

    /**
     * @var string
     *
     * Email of the sender
     */
    private $fromEmail;

    /**
     * Constructor.
     *
     * @param EngineInterface $templatingEngine Templating engine
     * @param Swift_Mailer    $mailer           Mailer
     * @param string          $layout           Layout
     * @param string          $template         Template
     * @param string          $fromEmail        From email
     */
    public function __construct(
        EngineInterface $templatingEngine,
        Swift_Mailer $mailer,
        $layout,
        $template,
        $fromEmail
    ) {
        $this->templatingEngine = $templatingEngine;
        $this->mailer = $mailer;
        $this->layout = $layout;
        $this->template = $template;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Render email.
     *
     * @param string $subject       Email subject
     * @param string $receiverEmail Receiver Email
     * @param array  $context       Context
     *
     * @return $this Self object
     */
    protected function renderEmail(
        $subject,
        $receiverEmail,
        array $context = []
    ) {
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->fromEmail)
            ->setTo($receiverEmail)
            ->setContentType('text/html')
            ->setBody(
                $this->templatingEngine->render(
                    $this->template,
                    array_merge(
                        $context,
                        ['layout' => $this->layout]
                    )
                )
            );

        $this
            ->mailer
            ->send($message);

        return $this;
    }
}
