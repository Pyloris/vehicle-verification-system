<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

class Auth {
    function getAuth($request) {
        VIEW::init("orgAuth.html");
    }

    function postLogin($request) {
        return;
    }

    function postSignup($request) {
        return;
    }
}

?>