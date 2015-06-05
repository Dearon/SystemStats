<?php

namespace SystemStats;

class FileReader
{
    /**
     * @param $file
     * @param $delimiter
     * @param callable $valueFormatter
     *
     * @return array
     */
    public function read($filename, $delimiter, callable $valueFormatter)
    {
        if (empty($filename)) {
            throw new \InvalidArgumentException('Filename needed');
        }

        if (! is_file($filename)) {
            throw new \InvalidArgumentException('File does not exist');
        }

        if (empty($delimiter)) {
            throw new \InvalidArgumentException('Delimiter needed');
        }

        $file = file_get_contents($filename);

        return array_reduce(explode(PHP_EOL, trim($file)), function ($carry, $item) use ($delimiter, $valueFormatter) {
            list($key, $value) = explode($delimiter, $item);
            $carry[trim($key)] = $valueFormatter($value);
            return $carry;
        }, array());
    }
}
