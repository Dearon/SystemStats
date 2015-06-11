<?php

namespace SystemStats\Linux;

use SystemStats\FileParserInterface;

class FileParser implements FileParserInterface
{
    /**
     * @var array
     */
    private $files = [
        '/proc/meminfo' => [
            'delimited_with_key' => ':',
            'format' => [
                '*' => 'trim|number|kB'
            ]
        ],
        '/proc/vmstat' => [
            'delimited_with_key' => ' ',
            'format' => [
                'pswpin' => 'trim|number|kB',
                'pswpout' => 'trim|number|kB'
            ]
        ],
        '/proc/uptime' => [
            'delimited' => ' '
        ],
     ];

    /**
     * @param string $filename
     * @param array $file
     *
     * @return array
     */
    public function parse($filename, $file)
    {
        if (isset($this->files[$filename])) {
            if (isset($this->files[$filename]['delimited'])) {
                $file = $this->delimited($file, $this->files[$filename]['delimited']);
            }

            if (isset($this->files[$filename]['delimited_with_key'])) {
                $file = $this->delimitedWithKey($file, $this->files[$filename]['delimited_with_key']);
            }

            if (isset($this->files[$filename]['format'])) {
                $file = $this->format($file, $this->files[$filename]['format']);
            }
        }

        return $file;
    }

    /**
     * @param array $file
     * @param string $delimiter
     *
     * @return array
     */
    private function delimited($file, $delimiter)
    {
        return array_reduce(explode(PHP_EOL, $file), function ($carry, $item) use ($delimiter) {
            $carry = array_merge($carry, explode($delimiter, $item));
            return $carry;
        }, []);
    }

    /**
     * @param array $file
     * @param string $delimiter
     *
     * @return array
     */
    private function delimitedWithKey($file, $delimiter)
    {
        return array_reduce(explode(PHP_EOL, $file), function ($carry, $item) use ($delimiter) {
            if (empty($item) or ! strpos($item, $delimiter)) return $carry;

            list($key, $value) = explode($delimiter, $item);
            $carry[trim($key)] = trim($value);
            return $carry;
        }, []);
    }

    /**
     * @param array $file
     * @param array $options
     *
     * @return array
     */
    private function format($file, $options)
    {
        foreach ($file as $key => &$value) {
            if (isset($options['*'])) {
                $option = explode('|', $options['*']);
            } elseif (isset($options[$key])) {
                $option = explode('|', $options[$key]);
            } else {
                $option = [];
            }

            foreach ($option as $op) {
                switch($op) {
                    case 'trim':
                        $value = trim($value);
                        break;
                    case 'number':
                        $value = (int) $value;
                        break;
                    case 'kB':
                        $value = $value * 1024;
                }
            }
        }

        return $file;
    }
}
