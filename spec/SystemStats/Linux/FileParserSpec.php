<?php

namespace spec\SystemStats\Linux;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileParserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\Linux\FileParser');
    }

    public function it_should_returns_the_content_of_a_file_when_it_does_not_have_any_special_instructions()
    {
        $file = file_get_contents(__FILE__);
        $this->parse(__FILE__, $file)->shouldStartWith('<?php');
    }

    public function it_should_be_able_to_parse_meminfo()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/meminfo');
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('MemTotal', 513843200);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('MemFree', 271544320);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('Buffers', 14143488);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('Cached', 112189440);
    }

    public function it_should_be_able_to_parse_malformed_meminfo()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/meminfo_malformed');
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('MemTotal', 513843200);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('MemFree', 271544320);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('Buffers', 14143488);
        $this->parse('/proc/meminfo', $file)->shouldHaveKeyWithValue('Cached', 112189440);
    }

    public function it_should_be_able_to_parse_vmstat()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/vmstat');
        $this->parse('/proc/vmstat', $file)->shouldHaveKeyWithValue('pswpin', 1048576);
        $this->parse('/proc/vmstat', $file)->shouldHaveKeyWithValue('pswpout', 524288);
    }

    public function it_should_be_able_to_parse_malformed_vmstat()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/vmstat_malformed');
        $this->parse('/proc/vmstat', $file)->shouldHaveKeyWithValue('pswpin', 1048576);
        $this->parse('/proc/vmstat', $file)->shouldHaveKeyWithValue('pswpout', 524288);
    }

    public function it_should_be_able_to_parse_uptime()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/uptime');
        $this->parse('/proc/uptime', $file)->shouldContain('19987.46');
        $this->parse('/proc/uptime', $file)->shouldContain('19945.34');
    }

    public function it_should_be_able_to_parse_malformed_uptime()
    {
        $file = file_get_contents(__DIR__ . '/../../../fixtures/linux/uptime_malformed');
        $this->parse('/proc/uptime', $file)->shouldContain('19987.46');
        $this->parse('/proc/uptime', $file)->shouldContain('19945.34');
    }
}
