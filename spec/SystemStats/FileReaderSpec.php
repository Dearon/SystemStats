<?php

namespace spec\SystemStats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\FileReader');
    }

    function it_requires_a_filename()
    {
        $this->shouldThrow(new \InvalidArgumentException("Filename needed"))->during('read', array('', ':', function ($value) { return $value; }));
    }

    function it_requires_that_the_file_exists()
    {
        $this->shouldThrow(new \InvalidArgumentException("File does not exist"))->during('read', array('/no/file/here', ':', function ($value) { return $value; }));
    }

    function it_requires_a_delimiter()
    {
        $this->shouldThrow(new \InvalidArgumentException("Delimiter needed"))->during('read', array(__DIR__ . '/FileReaderSpec.php', '', function ($value) { return $value; }));
    }

    function it_can_read_a_file()
    {
        $this->read(__DIR__ . '/../../fixtures/memtotal', ':', function ($value) { return $value; })->shouldHaveKey('MemTotal');
    }
}
