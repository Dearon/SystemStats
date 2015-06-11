<?php

namespace spec\SystemStats\Linux;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SystemStats\FileReader;
use SystemStats\Linux\FileParser;

class UptimeSpec extends ObjectBehavior
{
    public function let(FileReader $reader)
    {
        $fileParser = new FileParser;
        $uptime = file_get_contents(__DIR__ . '/../../../fixtures/linux/uptime');
        $reader->read('/proc/uptime')->willReturn($fileParser->parse('/proc/uptime', $uptime));
        $this->beConstructedWith($reader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\Linux\Uptime');
    }

    function it_can_get_the_uptime()
    {
        $this->getUptime()->shouldEqual(19987.46);
    }

    function it_can_get_the_idletime()
    {
        $this->getIdletime()->shouldEqual(19945.34);
    }
}
