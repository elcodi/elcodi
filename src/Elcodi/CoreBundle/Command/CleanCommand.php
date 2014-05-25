<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */

namespace Elcodi\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CleanCommand
 */
class CleanCommand extends ContainerAwareCommand
{

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('elcodi:do')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getContainer()->get('kernel');
        $params = $this->getContainer()->getParameterBag()->all();
        $entities = [];
        $files = [];
        $factoryFiles = [];
        foreach ($params as $key => $param) {

            if ((strpos($key, 'elcodi.core') === 0) && strpos($key, '.repository.')) {

                $entities[$key] = $param;
            }
        }

        foreach ($entities as $key => $entity) {

            $bundlePath = $kernel->getBundles()['Elcodi' . explode('\\', $entity)[1]]->getPath();
            $file = $bundlePath . '/Resources/config/repositories.yml';
            list($_1, $_2, $bundleName, $_3, $entityName, $_4) = explode('.', $key);

            if (!isset($files[$file])) {

                $files[$file] = [];
            }

            $files[$file][] = [$bundleName, $entityName];
        }

        foreach ($files as $file => $factentities) {

            $data =
"services:

    #
    # Repositories
    #

";

            foreach ($factentities as $factentity) {

                $data .=
"    #
    # Repository for entity ".$factentity[1]."
    #
    elcodi.core.".$factentity[0].".repository.".$factentity[1].":
        class: %elcodi.core.".$factentity[0].".repository.".$factentity[1].".class%
        factory_service: elcodi.repository_provider
        factory_method: getRepositoryByEntityNamespace
        arguments:
            entity_namespace: %elcodi.core.".$factentity[0].".entity.".$factentity[1].".class%

    elcodi.repository.".$factentity[1].":
        alias: elcodi.core.".$factentity[0].".repository.".$factentity[1]."

";
            }

            $factoryFiles[$file] = $data;
        }

        // OK
        foreach ($factoryFiles as $path => $data) {
            file_put_contents($path, $data);
        }

        // Tests generations

        foreach ($entities as $key => $testentity) {
            $bundlePath = $kernel->getBundles()['Elcodi' . explode('\\', $testentity)[1]]->getPath();
            list($_a, $_b, $_c, $_d) = explode('\\', $testentity, 4);
            $fileName = $_d .'Test';
            $testFile = $bundlePath . '/Tests/Functional/Repository/' . $fileName . '.php';
            list($_1, $_2, $bu, $_3, $en, $_4) = explode('.', $key);

            $data =
"<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\\{$_b}\\Tests\\Functional\\Repository;

use Elcodi\\CoreBundle\\Tests\\WebTestCase;

/**
 * Class {$fileName}
 */
class {$fileName} extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.{$bu}.repository.{$en}',
            'elcodi.repository.{$en}',
        ];
    }

    /**
     * Test {$en} repository provider
     */
    public function testFactoryProvider()
    {
        \$this->assertInstanceOf(
            \$this->container->getParameter('elcodi.core.{$bu}.repository.{$en}.class'),
            \$this->container->get('elcodi.core.{$bu}.repository.{$en}')
        );
    }

    /**
     * Test {$en} repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        \$this->assertInstanceOf(
            \$this->container->getParameter('elcodi.core.{$bu}.repository.{$en}.class'),
            \$this->container->get('elcodi.repository.{$en}')
        );
    }
}
";

            @mkdir($bundlePath . '/Tests/Functional/Repository', 0755, true);
            file_put_contents($testFile, $data);
        }
    }

}
