<?php
session_name("SPID_OAUTH2");
session_start();

define("DB_DSN", "mysql:dbname=my_aanmelden;host=localhost");
define("DB_USER", "aanmelden");
define("DB_PASSWORD", "v4l3");

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/vendor/autoload.php");
OAuth2\Autoloader::register();

$storage = new OAuth2\Storage\Pdo([
    "dsn" => DB_DSN,
    "username" => DB_USER,
    "password" => DB_PASSWORD
]);

$openid_key_storage = new OAuth2\Storage\Memory([
    'keys' => [
        "public_key"  => file_get_contents(__DIR__ . "/oidc-keys/public_key.pem", true),
        "private_key" => file_get_contents(__DIR__ . "/oidc-keys/private_key.pem", true),
    ]
]);

$scopes_util = new OAuth2\Scope(
    new OAuth2\Storage\Memory([
        "default_scope" => "https://attributes.spid.gov.it/spidCode",
        "supported_scopes" => [
            "https://attributes.spid.gov.it/spidCode",
            "https://attributes.spid.gov.it/name",
            "https://attributes.spid.gov.it/familyName",
            "https://attributes.spid.gov.it/placeOfBirth",
            "https://attributes.spid.gov.it/countyOfBirth",
            "https://attributes.spid.gov.it/dateOfBirth",
            "https://attributes.spid.gov.it/gender",
            "https://attributes.spid.gov.it/companyName",
            "https://attributes.spid.gov.it/registeredOffice",
            "https://attributes.spid.gov.it/fiscalNumber",
            "https://attributes.spid.gov.it/ivaCode",
            "https://attributes.spid.gov.it/idCard",
            "https://attributes.spid.gov.it/mobilePhone",
            "https://attributes.spid.gov.it/email",
            "https://attributes.spid.gov.it/address",
            "https://attributes.spid.gov.it/expirationDate",
            "https://attributes.spid.gov.it/digitalAddress",
            "https://attributes.spid.gov.it/domicileStreetAddress",
            "https://attributes.spid.gov.it/domicilePostalCode",
            "https://attributes.spid.gov.it/domicileMunicipality",
            "https://attributes.spid.gov.it/domicileProvince",
            "https://attributes.spid.gov.it/domicileNation"
        ]
    ])
);

$server = new OAuth2\Server($storage, [
    "use_jwt_access_tokens" => true,
    "use_openid_connect" => true,
    "issuer" => "https://aanmelden.altervista.org/spid/"
]);

$server->setScopeUtil($scopes_util);
$server->addStorage($openid_key_storage, "public_key");

$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

$server->setConfig("enforce_state", false);
