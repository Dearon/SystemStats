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

    public function it_should_return_the_file_string_unaltered_if_the_file_is_unknown()
    {
        $this->parse('/test/file', 'File String')->shouldReturn('File String');
    }
}
