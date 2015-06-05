<?php

namespace spec\SystemStats\Linux;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MemorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\Linux\Memory');
    }

    function it_can_get_the_virtual_memory()
    {
        $this->getVirtualMemory()->shouldHaveKey('total');
    }

    function it_can_get_the_swap_memory()
    {
        $this->getSwapMemory()->shouldHaveKey('total');
    }
}
