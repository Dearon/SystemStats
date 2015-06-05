<?php namespace spec\SystemStats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SystemStatsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\SystemStats');
    }

    public function it_should_not_accept_a_os_without_implementation()
    {
        $this->shouldThrow(new \RuntimeException("OS (BSD) Not Implemented."))->during('__construct', array('BSD'));
    }
}
