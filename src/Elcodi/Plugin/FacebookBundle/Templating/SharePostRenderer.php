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

namespace Elcodi\Plugin\FacebookBundle\Templating;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Component\Product\Entity\Product;

/**
 * Class SharePostRenderer
 */
class SharePostRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var UrlGeneratorInterface
     *
     * An url generator
     */
    protected $urlGenerator;

    /**
     * @var TranslatorInterface
     *
     * A translator
     */
    protected $translator;

    /**
     * Builds a new share tweet renderer class.
     *
     * @param UrlGeneratorInterface $urlGenerator An url generator
     * @param TranslatorInterface   $translator   A translator
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    /**
     * Set plugin
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
     * Renders the share product button.
     *
     * @param EventInterface $event The event
     */
    public function renderShareProduct(EventInterface $event)
    {
        if ($this->plugin->isEnabled()) {
            /**
             * @var Product $product
             */
            $product = $event->get('product');

            $shareUrl = $this
                ->urlGenerator
                ->generate(
                    'store_product_view',
                    [
                        'id'   => $product->getId(),
                        'slug' => $product->getSlug(),
                    ],
                    true
                );

            $this->appendTemplate(
                '@ElcodiFacebook/Post/share.html.twig',
                $event,
                [
                    'url' => $shareUrl,
                ]
            );
        }
    }

    /**
     * Renders the share product button.
     *
     * @param EventInterface $event The event
     */
    public function renderShareOrder(EventInterface $event)
    {
        if ($this->plugin->isEnabled()) {
            $shareUrl = $this
                ->urlGenerator
                ->generate(
                    'store_homepage',
                    [],
                    true
                );

            $this->appendTemplate(
                '@ElcodiFacebook/Post/share.html.twig',
                $event,
                [
                    'url' => $shareUrl,
                ]
            );
        }
    }
}
