<?php namespace spec\SystemStats\Linux;

use PhpSpec\ObjectBehavior;
use SystemStats\FileReader;

class MemorySpec extends ObjectBehavior
{
    public function let()
    {
        $fileReader = new FileReader;
        $this->beConstructedWith($fileReader);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\Linux\Memory');
    }

    public function it_can_get_the_virtual_memory()
    {
        $this->getVirtualMemory()->shouldHaveKey('total');
    }

    public function it_can_get_the_swap_memory()
    {
        $this->getSwapMemory()->shouldHaveKey('total');
    }
}
