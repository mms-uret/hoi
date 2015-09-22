<?php

namespace UrbanEtter\Hoi;


use Symfony\Component\Console\Application;

class HoiApplication extends Application
{
    public function registerSteps()
    {
        $path = __DIR__ . '/../hoi.json';
        $steps = file_get_contents($path);
        $steps = json_decode($steps, true);

        foreach ($steps as $name => $config) {
            $step = new Step($name, $config);
            $this->add($step);
        }
    }


}