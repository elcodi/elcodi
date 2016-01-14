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

namespace Elcodi\Component\Rule\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface RuleInterface.
 */
interface RuleInterface extends IdentifiableInterface
{
    /**
     * Sets name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets expression.
     *
     * @param string $expression Expression
     *
     * @return $this Self object
     */
    public function setExpression($expression);

    /**
     * Get expression.
     *
     * @return string Expression
     */
    public function getExpression();
}
