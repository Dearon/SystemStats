<?php

namespace spec\SystemStats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SystemStatsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\SystemStats');
    }
}
