<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;

class Booting {

    public static function boot(): Configurator {
        $configurator = new Configurator;
                
        $configurator->enableTracy(__DIR__ . '/../log');
        
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        
        $configurator->setDebugMode(true);
        \Tracy\Debugger::$productionMode = false;
        
        $configurator->setTimeZone('Europe/Prague');
        $configurator->setTempDirectory(__DIR__ . '/../temp');
        
        $configurator->createRobotLoader()
                ->addDirectory(__DIR__)
                ->register();

        $configurator->addConfig(__DIR__ . '/config/common.neon');
        $configurator->addConfig(__DIR__ . '/config/local.neon');

        $configurator->enableTracy();
        
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

        return $configurator;
    }

}
