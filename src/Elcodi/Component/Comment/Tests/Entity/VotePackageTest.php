<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Comment\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\Entity\VotePackage;

class VotePackageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider votePackagesProvider
     */
    public function testGetNbDownVotes(array $votes, $upVotes, $downVotes, $nbVotes)
    {
        $votePackage = VotePackage::create($votes);

        $this->assertSame($downVotes, $votePackage->getNbDownVotes());
    }

    /**
     * @dataProvider votePackagesProvider
     */
    public function testGetNbUpVotes(array $votes, $upVotes, $downVotes, $nbVotes)
    {
        $votePackage = VotePackage::create($votes);

        $this->assertSame($upVotes, $votePackage->getNbUpVotes());
    }

    /**
     * @dataProvider votePackagesProvider
     */
    public function testGetNbVotes(array $votes, $upVotes, $downVotes, $nbVotes)
    {
        $votePackage = VotePackage::create($votes);

        $this->assertSame($nbVotes, $votePackage->getNbVotes());
    }

    /**
     * @dataProvider votePackagesProvider
     */
    public function testCreate(array $votes)
    {
        $votePackage = VotePackage::create($votes);

        $this->assertInstanceOf('Elcodi\Component\Comment\Entity\VotePackage', $votePackage);
    }

    /**
     * @return array
     */
    public function votePackagesProvider()
    {
        $upVote = new Vote();
        $upVote->setType(Vote::UP);

        $downVote = new Vote();
        $upVote->setType(Vote::DOWN);

        return [
            [[$upVote], 1, 0, 1],
            [[$downVote], 0, 1, 1],
            [[$upVote, $downVote], 1, 1, 2],
        ];
    }
}
