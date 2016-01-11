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

namespace Elcodi\Component\Page;

/**
 * Class ElcodiPageTypes.
 */
final class ElcodiPageTypes
{
    /**
     * Page type regular.
     *
     * Used in footer
     */
    const TYPE_REGULAR = 1;

    /**
     * Page type blog post.
     *
     * Used in blog
     */
    const TYPE_BLOG_POST = 2;

    /**
     * Page type email.
     *
     * Used to send emails
     */
    const TYPE_EMAIL = 3;
}
