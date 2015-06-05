<?php namespace SystemStats;

interface MemoryUsage
{
    /**
     * @return array
     */
    public function getVirtualMemory();

    /**
     * @return mixed
     */
    public function getSwapMemory();
}
