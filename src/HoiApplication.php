<?php

namespace UrbanEtter\Hoi;


use Symfony\Component\Console\Application;

class HoiApplication extends Application
{
    public function registerSteps()
    {
        $this->add(new Step());
    }

}