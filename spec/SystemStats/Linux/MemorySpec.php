<?php namespace spec\SystemStats\Linux;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SystemStats\FileReader;
use SystemStats\Linux\FileParser;

class MemorySpec extends ObjectBehavior
{
    public function let(FileReader $reader)
    {
        $fileParser = new FileParser;
        $meminfo = file_get_contents(__DIR__ . '/../../../fixtures/linux/meminfo');
        $vmstat = file_get_contents(__DIR__ . '/../../../fixtures/linux/vmstat');
        $reader->read('/proc/meminfo')->willReturn($fileParser->parse('/proc/meminfo', $meminfo));
        $reader->read('/proc/vmstat')->willReturn($fileParser->parse('/proc/vmstat', $vmstat));
        $this->beConstructedWith($reader);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\Linux\Memory');
    }

    public function it_can_get_the_virtual_memory()
    {
        $this->getVirtualMemory()->shouldHaveKeyWithValue('total', 513843200);
        $this->getVirtualMemory()->shouldHaveKeyWithValue('available', 397877248);
        $this->getVirtualMemory()->shouldHaveKeyWithValue('used', 115965952);
        $this->getVirtualMemory()->shouldHaveKeyWithValue('percent_used', 22.6);
        $this->getVirtualMemory()->shouldHaveKeyWithValue('percent_available', 77.4);
    }

    public function it_can_get_the_swap_memory()
    {
        $this->getSwapMemory()->shouldHaveKeyWithValue('total', 1048576);
        $this->getSwapMemory()->shouldHaveKeyWithValue('used', 524288);
        $this->getSwapMemory()->shouldHaveKeyWithValue('free', 524288);
        $this->getSwapMemory()->shouldHaveKeyWithValue('percent_used', 50.0);
        $this->getSwapMemory()->shouldHaveKeyWithValue('percent_free', 50.0);
        $this->getSwapMemory()->shouldHaveKeyWithValue('swapped_in', 1048576);
        $this->getSwapMemory()->shouldHaveKeyWithValue('swapped_out', 524288);
    }
}
