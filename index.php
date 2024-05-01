<?php
require_once "./vendor/autoload.php";

use sirJuni\Framework\Application\Application;
use sirJuni\Framework\View\VIEW;

// Set up the VIEW
VIEW::set_path(__DIR__ . "/templates");

// import all configuration
require_once "./config.php";

// import all the routes
require_once "./routes/routes.php";


$app = new Application();
$app->handle();
?>