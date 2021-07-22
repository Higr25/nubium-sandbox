<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

final class RouterFactory {

    use Nette\StaticClass;

    public static function createRouter(): RouteList {
        $router = new RouteList;
        
        $router->addRoute('', 'Post:default');
        $router->addRoute('/register', 'User:register');
        $router->addRoute('/login', 'User:login');
        $router->addRoute('/logout', 'User:logout');
        $router->addRoute('/password', 'User:password');
        
        return $router;
    }

}
