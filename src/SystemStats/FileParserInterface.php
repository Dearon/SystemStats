<?php namespace SystemStats;

interface FileParserInterface
{
    /**
     * @return mixed
     */
    public function parse($filename, $file);
}
