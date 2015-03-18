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

namespace Elcodi\Plugin\TwitterBundle\Templating;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;

/**
 * Class FollowRenderer
 */
class FollowRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Set the plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders the follow button.
     *
     * @param EventInterface $event The event
     */
    public function renderFollowButton(EventInterface $event)
    {
        $pluginConfiguration = $this
            ->plugin
            ->getConfiguration();

        if (
            $this->plugin->isEnabled() &&
            !empty($pluginConfiguration['twitter_account'])
        ) {
            $this->appendTemplate(
                '@ElcodiTwitter/Follow/follow.html.twig',
                $event,
                ['twitter_account' => $pluginConfiguration['twitter_account']]
            );
        }
    }
}
