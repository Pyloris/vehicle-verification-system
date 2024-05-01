<?php   // index.php
require_once "./vendor/autoload.php";

use sirJuni\Framework\Application\Application;

// require_once __DIR__ . "\\App\\routes.php";

$app = new Application();
$app->handle();
?>