<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Middleware\Auth;

Auth::set_fallback_route("/login");

// Include Controllers
require_once __DIR__ . "/../controllers/auth.php";
require_once __DIR__ . "/../controllers/home.php";
require_once __DIR__ . "/../controllers/verifier.php";
require_once __DIR__ . "/../controllers/dashboard.php";

Router::add_route("GET", "/", [Home::class, 'getLanding']);
Router::add_route("GET", "/dashboard", [Dashboard::class, 'getDashboard'])->middleware(Auth::class);
Router::add_route("GET", "/vehicle_list", [Dashboard::class, 'getVehicles'])->middleware(Auth::class);
Router::add_route(["GET", "POST"], "/add_vehicles", [Dashboard::class, 'addVehicles'])->middleware(Auth::class);

Router::add_route(["GET", "POST"], "/login", [AuthC::class, 'handleLogin']);
Router::add_route("POST", "/signup", [AuthC::class, 'postSignup']);
Router::add_route("GET", "/logout", [AuthC::class, 'logout']);

Router::add_route(["POST", "GET"], "/ocr", [Verifier::class, 'verifyImage']);
?>