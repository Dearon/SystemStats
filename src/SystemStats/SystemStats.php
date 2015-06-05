<?php

namespace SystemStats;

use RuntimeException;
use SystemStats\Linux\Memory;
use SystemStats\FileReader;

class SystemStats
{
    /**
     * @var array
     */
    private $mapper = [
        'Linux' => [
            'memory' => Memory::class,
        ],
    ];

    /**
     * @var MemoryUsageInterface
     */
    private $memory;

    /**
     * @param string $os
     *
     * @throws RuntimeException
     */
    public function __construct($os = PHP_OS)
    {
        $fileReader = new FileReader;

        if (!in_array($os, array_keys($this->mapper))) {
            throw new RuntimeException('OS ('.$os.') Not Implemented.');
        }

        $os = $this->mapper[$os];

        $this->memory = new $os['memory']($fileReader);
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
}
