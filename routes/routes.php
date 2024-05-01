<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\Handler\Router;

// Include Controllers
require_once __DIR__ . "/../controllers/auth.php";
require_once __DIR__ . "/../controllers/home.php";

Router::add_route("GET", "/", [Home::class, 'getLanding']);
Router::add_route("GET", "/login", [Auth::class, 'getAuth']);
?>