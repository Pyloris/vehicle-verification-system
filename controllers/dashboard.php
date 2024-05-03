<?php

require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Helper\HelperFuncs;

session_start();

// load the database
require_once __DIR__ . "/../models/models.php";


class Dashboard {
    function getDashboard($request) {
        $db = new DB();
        $context = [];

        $context['stat'] = $db->getStat($_SESSION['id']);

        VIEW::init("dashboard/dashboard.html", $context);
    }

    function getVehicles($request) {
        $db = new DB();
        $context = [];

        $context['vehicle_list'] = $db->getVehicleList($_SESSION['id']);
        
        VIEW::init("dashboard/vehicle_list.html", $context);
    }

    function addVehicles($request) {
        if ($request->method() == "POST") {
            $db = new DB();

            // if fields are set, save the single vehicle
            if ($request->formData("single") == "submit") {

                $number = $request->formData("vehicle_number");
                $owner = $request->formData("owner");

                if ($db->saveVehicle($_SESSION['id'], $number, $owner)) {
                    HelperFuncs::redirect("/add_vehicles?message=success");
                    return;
                }
                else {
                    HelperFuncs::redirect("/add_vehicles?message=failed");
                    return;
                }
            }

            else if ($request->formData("file") == "submit" and $request->fileError("csvFile") == UPLOAD_ERR_OK) {
                // Path to your CSV file
                $csvFile = $request->File("csvFile");

                // Validate the file type
                $allowedMimeTypes = ['text/csv', 'text/plain']; // Adjust as needed
                $allowedExtensions = ['csv']; // Adjust as needed

                // Get the MIME type of the file
                $mimeType = mime_content_type($csvFile);

                // Get the file extension
                $fileExtension = pathinfo($csvFile, PATHINFO_EXTENSION);

                // Check if the MIME type or file extension is allowed
                if (in_array($mimeType, $allowedMimeTypes) || in_array($fileExtension, $allowedExtensions)) {

                    $file = fopen($csvFile, 'r');

                    // Check if the file opened successfully
                    if ($file !== false) {
                        $saved = true;
                        // Loop through each line in the CSV file
                        while (($data = fgetcsv($file)) !== false) {
                            // $data is an array containing the CSV fields for the current row
                            $number = $data[0];
                            $owner = $data[1];

                            if ($db->saveVehicle($_SESSION['id'], $number, $owner)) {
                                continue;
                            }
                            else {
                                $saved = false;
                                break;
                            }
                        }
                        
                        // Close the file
                        fclose($file);
                    } else {
                        // Failed to open the file
                        echo "Failed to open $csvFile";
                    }
                } else {
                    // File type not allowed
                    echo "Invalid file type";
                }

                if ($saved) {
                    HelperFuncs::redirect("/add_vehicles?message=success");
                    return;
                }
                else {
                    HelperFuncs::redirect("/add_vehicles?message=failed");
                    return;
                }
            }
        }
        else if ($request->method() == "GET") {
            VIEW::init("dashboard/add_vehicle.html");
        }
    }
}

?>