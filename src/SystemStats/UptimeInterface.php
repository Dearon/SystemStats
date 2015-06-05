<?php namespace SystemStats;

interface UptimeInterface
{
    /**
     * @return int
     */
    public function getUptime();

    /**
     * @return int
     */
    public function getIdletime();
}
