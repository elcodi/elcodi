<?php
namespace Elcodi\Component\Page\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Page\Entity\Page;

/**
 * Class PageFactory
 */
class PageFactory extends AbstractFactory
{

    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return Page Empty entity
     */
    public function create()
    {
        /**
         * @var Page $page
         */
        $classNamespace = $this->getEntityNamespace();
        $page = new $classNamespace();
        $page
            ->setPath("");

        return $page;
    }
}
 