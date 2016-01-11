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

namespace Elcodi\Component\Comment\Entity;

use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;

/**
 * Class VotePackage.
 */
class VotePackage
{
    /**
     * @var int
     *
     * Number of up votes
     */
    protected $nbUpVotes = 0;

    /**
     * @var int
     *
     * Number of down votes
     */
    protected $nbDownVotes = 0;

    /**
     * @var int
     *
     * Number of votes
     */
    protected $nbVotes = 0;

    /**
     * Construct.
     *
     * @param VoteInterface[] $votes Votes
     */
    protected function __construct(array $votes = [])
    {
        foreach ($votes as $vote) {
            if ($vote instanceof VoteInterface) {
                ++$this->nbVotes;

                if (Vote::UP === $vote->getType()) {
                    ++$this->nbUpVotes;
                } else {
                    ++$this->nbDownVotes;
                }
            }
        }
    }

    /**
     * Get NbDownVotes.
     *
     * @return int NbDownVotes
     */
    public function getNbDownVotes()
    {
        return $this->nbDownVotes;
    }

    /**
     * Get NbUpVotes.
     *
     * @return int NbUpVotes
     */
    public function getNbUpVotes()
    {
        return $this->nbUpVotes;
    }

    /**
     * Get NbVotes.
     *
     * @return int NbVotes
     */
    public function getNbVotes()
    {
        return $this->nbVotes;
    }

    /**
     * Static create.
     *
     * @param VoteInterface[] $votes Votes
     *
     * @return $this VotePackage
     */
    public static function create(array $votes = [])
    {
        return new self($votes);
    }
}
