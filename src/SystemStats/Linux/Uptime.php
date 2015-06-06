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
        $this->uptime = $this->fileReader->read('/proc/uptime');
    }

    /**
     * @return int
     */
    public function getUptime()
    {
        return $this->uptime[0];
    }

    /**
     * @return int
     */
    public function getIdletime()
    {
        return $this->uptime[1];
    }
}
