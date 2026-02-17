<?php

use AgID\SPID\Account\User;
use AgID\SPID\Helpers\Environment;
use Bramus\Router\Router;

header("Content-Type: application/json");

require_once(__DIR__ . "/../vendor/autoload.php");

$claim_sets = [
    "attributes.spid.gov.it" => [
        "spidCode",
        "name",
        "familyName",
        "placeOfBirth",
        "countyOfBirth",
        "dateOfBirth",
        "gender",
        "companyName",
        "registeredOffice",
        "fiscalNumber",
        "ivaCode",
        "idCard",
        "mobilePhone",
        "email",
        "address",
        "domicileStreetAddress",
        "domicilePostalCode",
        "domicileMunicipality",
        "domicileProvince",
        "domicileNation",
        "expirationDate",
        "digitalAddress"
    ]
];

$router = new Router();

$router->set404(function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    header("Content-Type: application/problem+json");

    echo (json_encode([
        "type" => "https://" . $_SERVER["SERVER_NAME"] . "/spid/errors/404-not-found",
        "title" => "Resource not found",
        "status" => 404,
        "detail" => "The requested resource has not been found.",
        "instance" => $_SERVER["REQUEST_URI"]
    ]));

    die();
});

$router->get("/", function () {
    echo (json_encode([
        "status" => 200,
        "result" => null,
        "message" => "Hello, World!",
        "debug" => null
    ]));

    die();
});

$router->get("{claim_set}/{claim_name}", function ($claim_set, $claim_name) {
    global $claim_sets;
    require_once(__DIR__ . "/../server.php");

    $request = OAuth2\Request::createFromGlobals();
    $response = new OAuth2\Response();

    $env = new Environment();
    $user = new User($server->getAccessTokenData($request)["user_id"], $env);

    if ($claim_name == "*") {
        $claims = [];
        $scopes = explode(" ", $server->getAccessTokenData($request)["scope"]);

        foreach ($scopes as $scope) {
            $scope = str_replace("https://", "", $scope);
            $scope = explode("/", $scope);

            if (!key_exists($scope[0], $claims)) {
                $claims[$scope[0]] = [];
            }

            $claims[$scope[0]][$scope[1]] = $user->__serialize()[$scope[1]];
        }

        echo (json_encode([
            "status" => 200,
            "result" => $claims,
            "message" => "https://" . $claim_set . "/" . $claim_name,
            "debug" => null
        ]));

        die();
    }

    if (!key_exists($claim_set, $claim_sets)) {
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
        header("Content-Type: application/problem+json");

        echo (json_encode([
            "type" => "https://" . $_SERVER["SERVER_NAME"] . "/spid/errors/400-bad-request",
            "title" => "Invalid claim set",
            "status" => 404,
            "detail" => "The requested claim set is invalid or not available.",
            "instance" => $_SERVER["REQUEST_URI"]
        ]));

        die();
    }

    if (!in_array($claim_name, $claim_sets[$claim_set])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
        header("Content-Type: application/problem+json");

        echo (json_encode([
            "type" => "https://" . $_SERVER["SERVER_NAME"] . "/spid/errors/400-bad-request",
            "title" => "Invalid claim request",
            "status" => 404,
            "detail" => "The requested claim is invalid or not available.",
            "instance" => $_SERVER["REQUEST_URI"]
        ]));

        die();
    }

    if (!$server->verifyResourceRequest($request, $response, "https://" . $claim_set . "/" . $claim_name)) {
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
        header("Content-Type: application/problem+json");

        echo (json_encode([
            "type" => "https://" . $_SERVER["SERVER_NAME"] . "/spid/errors/401-unauthorized",
            "title" => "Unauthorized claim request",
            "status" => 401,
            "detail" => "The requested claim is not in your authorized scopes.",
            "instance" => $_SERVER["REQUEST_URI"]
        ]));

        die();
    }

    echo (json_encode([
        "status" => 200,
        "result" => [
            $claim_set => [
                $claim_name => $user->__serialize()[$claim_name]
            ]
        ],
        "message" => "https://" . $claim_set . "/" . $claim_name,
        "debug" => null
    ]));
});

$router->run();
