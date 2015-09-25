<?php

namespace UrbanEtter\Hoi\Check;


class File
{
    private $filePath;

    public function __construct($config)
    {
        if (isset($config['file'])) {
            $this->filePath = $config['file'];
        } else {
            throw new \InvalidArgumentException("If you use the file checker, you need to specify the file in the step configuration");
        }
    }

    public function exists()
    {
        return is_file($this->filePath);
    }

    public function content()
    {
        if (!$this->exists()) {
            return false;
        }
        return file_get_contents($this->filePath);
    }

    public function contains($text)
    {
        if (!$this->exists()) {
            return false;
        }
        return strpos($this->content(), $text) !== false;
    }
}