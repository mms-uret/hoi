<?php

namespace UrbanEtter\Hoi\Check;


class Homebrew
{
    public function installed($formula)
    {
        $cmd = "brew ls | grep " . escapeshellarg($formula);
        $result = shell_exec($cmd);
        return (strlen(trim($result)) > 0);
    }
}