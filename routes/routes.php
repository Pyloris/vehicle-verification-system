<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\Handler\Router;

// Include Controllers
require_once __DIR__ . "/../controllers/auth.php";
require_once __DIR__ . "/../controllers/home.php";
require_once __DIR__ . "/../controllers/verifier.php";
require_once __DIR__ . "/../controllers/dashboard.php";

Router::add_route("GET", "/", [Home::class, 'getLanding']);
Router::add_route("GET", "/dashboard", [Dashboard::class, 'getDashboard']);
Router::add_route("GET", "/vehicle_list", [Dashboard::class, 'getVehicles']);
Router::add_route("GET", "/add_vehicles", [Dashboard::class, 'addVehicles']);

Router::add_route("GET", "/login", [Auth::class, 'getAuth']);

Router::add_route(["POST", "GET"], "/ocr", [Verifier::class, 'verifyImage']);
?>