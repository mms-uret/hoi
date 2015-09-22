<?php

namespace UrbanEtter\Hoi\Install;


use UrbanEtter\Hoi\InstallInterface;

class Shell implements InstallInterface
{
    public function install($config)
    {
        if (!isset($config["command"])) {
            throw new \InvalidArgumentException('Install type "shell" needs a "command"');
        }
        $cmd = escapeshellcmd($config["command"]);
        shell_exec($cmd);
    }
}