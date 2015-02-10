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

namespace Elcodi\Bundle\BambooBundle\Entity;

use Elcodi\Component\Page\Entity\Page as BasePage;

/**
 * Class Page
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Page extends BasePage
{
    /**
     * @var string
     *
     * Path for the layout template to render the page
     */
    protected $template;

    /**
     * Get current template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set current template
     *
     * @param string $template
     *
     * @return $this Self object
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }
}
