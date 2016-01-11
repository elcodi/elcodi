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

namespace Elcodi\Component\Sitemap\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Elcodi\Component\Core\Command\Abstracts\AbstractElcodiCommand;

/**
 * Class SitemapProfileCommand.
 */
class SitemapProfileCommand extends AbstractElcodiCommand
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    private $container;

    /**
     * Construct.
     *
     * @param ContainerInterface $container Container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    /**
     * configure.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:sitemap:profile')
            ->setDescription('Build a profile')
            ->addArgument(
                'profile-name',
                InputArgument::REQUIRED,
                'Profile name'
            )
            ->addArgument(
                'basepath',
                InputArgument::REQUIRED,
                'Base path'
            );
    }

    /**
     * Get the dumper name from the input object and tries to dump all sitemap
     * content.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->startCommand($output);

        $profileName = $input->getArgument('profile-name');
        $basepath = $input->getArgument('basepath');
        $sitemapProfile = $this
            ->container
            ->get('elcodi.sitemap_profile.' . $profileName);

        $sitemapProfile->dump($basepath);

        $this->finishCommand($output);
    }
}
