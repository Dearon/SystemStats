<?php

namespace SystemStats;

interface MemoryInterface
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
