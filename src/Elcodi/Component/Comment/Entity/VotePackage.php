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
 */

namespace Elcodi\Component\Comment\Entity;

use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;

/**
 * Class VotePackage
 */
class VotePackage
{
    /**
     * @var integer
     *
     * Number of up votes
     */
    protected $nbUpVotes;

    /**
     * @var integer
     *
     * Number of down votes
     */
    protected $nbDownVotes;

    /**
     * @var integer
     *
     * Number of votes
     */
    protected $nbVotes;

    /**
     * Construct
     *
     * @param VoteInterface[]|null $votes Votes
     */
    protected function __construct(array $votes = null)
    {
        if (is_null($votes)) {
            return;
        }

        foreach ($votes as $vote) {

            if ($vote instanceof VoteInterface) {
                $this->nbVotes++;

                if (Vote::UP === $vote->getType()) {

                    $this->nbUpVotes++;
                } else {

                    $this->nbDownVotes++;
                }
            }
        }
    }

    /**
     * Get NbDownVotes
     *
     * @return int NbDownVotes
     */
    public function getNbDownVotes()
    {
        return $this->nbDownVotes;
    }

    /**
     * Get NbUpVotes
     *
     * @return int NbUpVotes
     */
    public function getNbUpVotes()
    {
        return $this->nbUpVotes;
    }

    /**
     * Get NbVotes
     *
     * @return int NbVotes
     */
    public function getNbVotes()
    {
        return $this->nbVotes;
    }

    /**
     * Static create
     *
     * @param VoteInterface[] $votes Votes
     *
     * @return $this VotePackage
     */
    public static function create(array $votes)
    {
        return new self($votes);
    }
}
