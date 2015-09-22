<?php

namespace UrbanEtter\Hoi\Check;


class Executable
{
    public function exists($file)
    {
        $cmd = "which " . escapeshellarg($file);
        $result = shell_exec($cmd);
        return (strlen(trim($result)) > 0);
    }
}