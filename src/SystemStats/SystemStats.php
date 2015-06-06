<?php namespace SystemStats;

use RuntimeException;

class SystemStats
{
    /**
     * @var array
     */
    private $mapper = [
        'Linux' => [
            'fileParser' => \SystemStats\Linux\FileParser::class,
            'memory' => \SystemStats\Linux\Memory::class,
            'uptime' => \SystemStats\Linux\Uptime::class,
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
        if (! in_array($os, array_keys($this->mapper))) {
            throw new RuntimeException('OS (' . $os . ') Not Implemented.');
        }

        $os = $this->mapper[$os];

        $fileParser = new $os['fileParser'];
        $fileReader = new FileReader($fileParser);

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
     * @return int seconds
     */
    public function getUptime()
    {
        return $this->uptime->getUptime();
    }

    /**
     * @return int seconds
     */
    public function getIdletime()
    {
        return $this->uptime->getIdletime();
    }
}
