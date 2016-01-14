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

namespace Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts;

use Doctrine\Common\DataFixtures\AbstractFixture as DoctrineAbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;

use Elcodi\Bundle\CoreBundle\Container\Traits\ContainerAccessorTrait;

/**
 * AbstractFixture class.
 */
abstract class AbstractFixture extends DoctrineAbstractFixture implements ContainerAwareInterface
{
    use ContainerAccessorTrait;

    /**
     * Set container.
     *
     * @param ContainerInterface $container Container
     *
     * @return $this Self object
     */
    public function setContainer(ContainerInterface $container = null)
    {
        self::$container = $container;

        return $this;
    }

    /**
     * Parse some content using a YAML parser.
     *
     * @param string $filePath File path
     *
     * @return mixed Value parsed
     */
    protected function parseYaml($filePath)
    {
        $yaml = new Parser();

        return $yaml->parse(file_get_contents($filePath));
    }
}
