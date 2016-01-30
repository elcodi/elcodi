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

namespace Elcodi\Component\Core\Entity\Traits;

/**
 * trait for add Entity valid interval.
 */
trait ValidIntervalTrait
{
    /**
     * @var \DateTime
     *
     * valid from
     */
    protected $validFrom;

    /**
     * @var \DateTime
     *
     * Valid to
     */
    protected $validTo;

    /**
     * Set valid from.
     *
     * @param \DateTime $validFrom Valid from
     *
     * @return $this Self object
     */
    public function setValidFrom(\DateTime $validFrom)
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    /**
     * Get valid from.
     *
     * @return \DateTime
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Set valid to.
     *
     * @param \DateTime $validTo Valid to
     *
     * @return $this Self object
     */
    public function setValidTo(\DateTime $validTo = null)
    {
        $this->validTo = $validTo;

        return $this;
    }

    /**
     * Get valid to.
     *
     * @return \DateTime Valid to
     */
    public function getValidTo()
    {
        return $this->validTo;
    }
}
