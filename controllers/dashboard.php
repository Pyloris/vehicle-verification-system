<?php

require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;


class Dashboard {
    function getDashboard($request) {
        VIEW::init("dashboard/dashboard.html");
    }

    function getVehicles($request) {
        VIEW::init("dashboard/vehicle_list.html");
    }

    function addVehicles($request) {
        VIEW::init("dashboard/add_vehicle.html");
    }
}

?>