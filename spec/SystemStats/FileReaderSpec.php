<?php namespace spec\SystemStats;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SystemStats\Linux\FileParser;

class FileReaderSpec extends ObjectBehavior
{
    public function let()
    {
        $fileParser = new FileParser;
        $this->beConstructedWith($fileParser);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('SystemStats\FileReader');
    }

    public function it_requires_a_filename()
    {
        $this->shouldThrow(new \InvalidArgumentException("Filename needed"))->during('read', array('', ':', function ($value) { return $value; }));
    }

    public function it_requires_that_the_file_exists()
    {
        $this->shouldThrow(new \InvalidArgumentException("File does not exist"))->during('read', array('/no/file/here', ':', function ($value) { return $value; }));
    }
}
