<?php namespace SystemStats\Linux;

use SystemStats\MemoryInterface;
use SystemStats\FileReader;

class Memory implements MemoryInterface
{
    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * @var array
     */
    private $meminfo = [];

    /**
     * @var array
     */
    private $vmstat = [];

    /**
     * @param $fileReader
     */
    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
        $this->meminfo = $this->fileReader->read('/proc/meminfo');
        $this->vmstat = $this->fileReader->read('/proc/vmstat');
    }

    /**
     * @return array
     */
    public function getVirtualMemory()
    {
        $total = $this->meminfo['MemTotal'];
        $free = $this->meminfo['MemFree'];
        $available = $this->meminfo['MemFree'] + $this->meminfo['Buffers'] + $this->meminfo['Cached'];

        return [
            'total' => $total,
            'available' => $available,
            'used' => $total - $free,
            'percent_used' => $this->calculatePercentage($total - $available, $total),
            'percent_available' => $this->calculatePercentage($available, $total),
        ];
    }

    /**
     * @return array
     */
    public function getSwapMemory()
    {
        $total = $this->meminfo['SwapTotal'];
        $free = $this->meminfo['SwapFree'];
        $used = $total - $free;

        return [
            'total' => $total,
            'used' => $used,
            'free' => $free,
            'percent_used' => $this->calculatePercentage($used, $total),
            'percent_free' => $this->calculatePercentage($free, $total),
            'swapped_in' => $this->vmstat['pswpin'],
            'swapped_out' => $this->vmstat['pswpout'],
        ];
    }

    /**
     * @param $amount
     * @param $total
     * @param int $round
     *
     * @return float
     */
    private function calculatePercentage($amount, $total, $round = 1)
    {
        if ($total == 0) {
            return (float) number_format(0, $round);
        }

        return (float) number_format($amount / $total * 100, $round);
    }
}
