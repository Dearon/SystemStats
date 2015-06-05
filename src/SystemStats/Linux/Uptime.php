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

        $this->readUptime();
    }

    /**
     * @return int
     */
    public function getUptime()
    {
        return $this->uptime;
    }

    /**
     * @return int
     */
    public function getIdletime()
    {
        return $this->idletime;
    }

    /**
     *
     */
    private function readUptime()
    {
        list($this->uptime, $this->idletime) = array_map(function ($value) {
            return (int) $value;
        }, explode(" ", file_get_contents("/proc/uptime")));
    }
}
