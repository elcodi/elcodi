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

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Product;

/**
 * Class ShareTweetRenderer
 */
class ShareTweetRenderer
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
     * @var Translator
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
            $pluginConfiguration = $this->plugin->getConfiguration();

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

            $text     = $product->getName();
            $category = $product->getPrincipalCategory();
            if ($category instanceof CategoryInterface) {
                $text = $category->getName() . ' - ' . $text;
            }

            $this->appendTemplate(
                '@ElcodiTwitter/Tweet/share.html.twig',
                $event,
                [
                    'url'             => $shareUrl,
                    'text'            => $text,
                    'twitter_account' => $pluginConfiguration['twitter_account'],
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
            $pluginConfiguration = $this->plugin->getConfiguration();

            $shareUrl = $this
                ->urlGenerator
                ->generate(
                    'store_homepage',
                    [],
                    true
                );

            $this->appendTemplate(
                '@ElcodiTwitter/Tweet/share.html.twig',
                $event,
                [
                    'url'             => $shareUrl,
                    'text'            => $this->translator->trans('twitter_plugin.tweet.take_look'),
                    'twitter_account' => $pluginConfiguration['twitter_account'],
                ]
            );
        }
    }
}
