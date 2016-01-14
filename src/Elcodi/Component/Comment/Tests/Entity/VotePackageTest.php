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

namespace Elcodi\Component\Comment\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\Entity\VotePackage;

/**
 * Class VotePackageTest.
 */
class VotePackageTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test VotePackage.
     *
     * @dataProvider dataVotes
     */
    public function testVotes(
        $nbVotesUp,
        $nbVotesDown,
        $nbVotes
    ) {
        $votes = [];
        for ($i = 0; $i < $nbVotesDown; ++$i) {
            $vote = $this->prophesize('Elcodi\Component\Comment\Entity\Interfaces\VoteInterface');
            $vote->getType()->willReturn(Vote::DOWN);
            $votes[] = $vote->reveal();
        }

        for ($i = 0; $i < $nbVotesUp; ++$i) {
            $vote = $this->prophesize('Elcodi\Component\Comment\Entity\Interfaces\VoteInterface');
            $vote->getType()->willReturn(Vote::UP);
            $votes[] = $vote->reveal();
        }

        $votePackage = VotePackage::create($votes);
        $this->assertEquals(
            $nbVotesDown,
            $votePackage->getNbDownVotes()
        );
        $this->assertEquals(
            $nbVotesUp,
            $votePackage->getNbUpVotes()
        );
        $this->assertEquals(
            $nbVotes,
            $votePackage->getNbVotes()
        );
    }

    /**
     * Data for testVotes.
     */
    public function dataVotes()
    {
        return [
            [1, 0, 1],
            [1, 1, 2],
            [0, 1, 1],
            [10, 10, 20],
        ];
    }
}
