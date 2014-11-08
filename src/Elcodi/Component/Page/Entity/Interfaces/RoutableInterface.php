<?php
namespace Elcodi\Component\Page\Entity\Interfaces;

/**
 * Interface RoutableInterface
 */
interface RoutableInterface
{
    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     */
    public function setPath($path);
}