<?php namespace SystemStats;

use RuntimeException;
use SystemStats\Linux\Memory;
use SystemStats\Linux\Uptime;

class SystemStats
{
    /**
     * @var array
     */
    private $mapper = [
        'Linux' => [
            'memory' => Memory::class,
            'uptime' => Uptime::class,
        ],
    ];

    /**
     * @var
     */
    private $memory;

    /**
     * @var
     */
    private $uptime;

    /**
     * @param string $os
     *
     * @throws RuntimeException
     */
    public function __construct($os = PHP_OS)
    {
        $fileReader = new FileReader;

        if (! in_array($os, array_keys($this->mapper))) {
            throw new RuntimeException('OS (' . $os . ') Not Implemented.');
        }

        $os = $this->mapper[$os];

        $this->memory = new $os['memory']($fileReader);
        $this->uptime = new $os['uptime']($fileReader);
    }

    /**
     * @return array
     */
    public function getVirtualMemory()
    {
        return $this->memory->getVirtualMemory();
    }

    /**
     * @return mixed
     */
    public function getSwapMemory()
    {
        return $this->memory->getSwapMemory();
    }

    /**
     * @return mixed
     */
    public function getUptime()
    {
        return $this->uptime->getUptime();
    }

    /**
     * @return mixed
     */
    public function getIdletime()
    {
        return $this->uptime->getIdletime();
    }
}
