<?php

namespace UrbanEtter\Hoi\Install;


use UrbanEtter\Hoi\InstallInterface;

class FileManipulation implements InstallInterface
{

    public function install($config)
    {
        if (isset($config['file'])) {
            $filePath = $config['file'];
        } else {
            throw new \InvalidArgumentException("If you use the file manipulation install type, you need to specify the file in the step configuration");
        }

        if (isset($config["append"])) {
            $content = $config["append"];
            file_put_contents($filePath, $content, FILE_APPEND);
            $result = "Added '" . $content . "' to '" . $filePath . "'";
        } else {
            throw new \InvalidArgumentException("Install type 'file-manipulation', but no manipulation specified.");
        }

        return $result;
    }
}