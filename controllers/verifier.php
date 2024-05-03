<?php
require_once __DIR__ . "/../vendor/autoload.php";


// Load framework entities
use sirJuni\Framework\View\VIEW;


// Load Configuration
require_once __DIR__ . "/../config.php";


use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Verifier {
    function verifyImage($request) {

        if ($request->method() == "POST") {

            $client = new Client();
            $headers = [
            'X-RapidAPI-Key' => X_RAPID_KEY,
            'X-RapidAPI-Host' => X_RAPID_HOST
            ];
            $options = [
            'multipart' => [
                [
                'name' => 'image',
                'contents' => Psr7\Utils::tryFopen($request->File("image"), 'r'),
                'filename' => 'image.jpeg',
                // 'headers'  => [
                //     'Content-Type' => '<Content-type header>'
                // ]
                ]
            ]];
            $request = new Psr7\Request('POST', API_URL, $headers);
            $res = $client->sendAsync($request, $options)->wait();

            echo json_encode($res->getBody()->getContents());
        }

        else if ($request->method() == "GET") {
            VIEW::init("ocr.html");
        }
    }
}


?>