<?php namespace SystemStats\Linux;

use SystemStats\FileReader;
use SystemStats\UptimeInterface;

class Uptime implements UptimeInterface
{
    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * @var int
     */
    private $uptime;

    /**
     * @var int
     */
    private $idletime;

    /**
     * @param FileReader $fileReader
     */
    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
        list($this->uptime, $this->idletime) = $this->fileReader->read('/proc/uptime');
    }

    /**
     * @return int
     */
    public function getUptime()
    {
        return (double) $this->uptime;
    }

    /**
     * @return int
     */
    public function getIdletime()
    {
        return (double) $this->idletime;
    }
}
