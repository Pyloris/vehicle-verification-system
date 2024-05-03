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
            $dataUri = $request->formData("image");
            // $binaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataUri));
            $binaryData = base64_decode((explode(",",$dataUri))[1]);

            $client = new Client();

            $headers = [
            'X-RapidAPI-Key' => X_RAPID_KEY,
            'X-RapidAPI-Host' => X_RAPID_HOST
            ];
            $options = [
            'multipart' => [
                [
                'name' => 'image',
                // 'contents' => Psr7\Utils::tryFopen($request->File("image"), 'r'),
                'contents' => $binaryData,
                'filename' => 'image.jpeg',
                // 'headers'  => [
                //     'Content-Type' => '<Content-type header>'
                // ]
                ]
            ]];
            $request = new Psr7\Request('POST', API_URL, $headers);
            $res = $client->sendAsync($request, $options)->wait();

            $resp = json_encode($res->getBody()->getContents());
            echo $resp;
            // if ($resp['errorCode'] == 404) {
            //     http_response_code(404);
            //     exit();
            // }
            // else if ($resp['status'] == TRUE) {
            //     echo json_encode($resp);
            //     exit();
            // }
            // else {
            //     http_response_code(404);
            // }
        }

        else if ($request->method() == "GET") {
            $context = [];

            $context['orgs'] = [
                'ICSC',
                'SP',
                'PS',
                'LLS'
            ];

            VIEW::init("ocr.html", $context);
        }
    }
}


?>