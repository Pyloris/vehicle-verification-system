<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

class Home {
    function getLanding($request) {
        VIEW::init("landing.html");
    }
}

?>