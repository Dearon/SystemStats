<?php namespace SystemStats;

use SystemStats\FileParserInterface;

class FileReader
{
    /*
     * @var object
     */
    private $fileParser;

    /**
     * @param FileParser $fileParser
     */
    public function __construct(FileParserInterface $fileParser)
    {
        $this->fileParser = $fileParser;
    }

    /**
     * @param $filename
     * @param $delimiter
     * @param callable $valueFormatter
     * @return mixed
     */
    public function read($filename)
    {
        if (empty($filename)) {
            throw new \InvalidArgumentException('Filename needed');
        }

        if (! is_file($filename)) {
            throw new \InvalidArgumentException('File does not exist');
        }

        $file = trim(file_get_contents($filename));
        return $this->fileParser->parse($filename, $file);
    }
}
