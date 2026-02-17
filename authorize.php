<?php

use AgID\SPID\Account\User;
use AgID\SPID\Entity\RelayParty;
use AgID\SPID\Helpers\Environment;

require_once(__DIR__ . "/server.php");

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

$env = new Environment();

if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $relayParty = new RelayParty($_POST["client_id"], $env);

    if (!key_exists("spid_required_authlevel", $_POST) || !key_exists("nome_utente", $_POST) || !key_exists("password", $_POST)) {
        require_once(__DIR__ . "/web/login.php");
        die();
    }

    $spid_required_authlevel = intval($_POST["spid_required_authlevel"]);

    $nome_utente = mysqli_real_escape_string($env->getDatabase()->getConnection(), $_POST["nome_utente"]);
    $password = mysqli_real_escape_string($env->getDatabase()->getConnection(), $_POST["password"]);

    $user = User::getUserByLoginName($nome_utente, $env);
    if ($user == null) {
        $_SESSION["SPIDError"] = "INVALID_USER";

        require_once(__DIR__ . "/web/login.php");
        die();
    }

    if (!$user->getUserCredentials()->checkUserPassword($password)) {
        $_SESSION["SPIDError"] = "INVALID_PASSWORD";

        require_once(__DIR__ . "/web/login.php");
        die();
    }

    if ($user->getUserCredentials()->__serialize()["isMinorAccount"] && !$relayParty->__serialize()["allowMinorAccess"]) {
        $_SESSION["SPIDError"] = "MINOR_ACCOUNT_NOT_ALLOWED";

        require_once(__DIR__ . "/web/login.php");
        die();
    }

    if (key_exists("is_authorized", $_POST) && $_POST["is_authorized"] == "1") {
        mail(
            $user->getUserContacts()->__serialize()["email"],
            "DemoIDP - Nuovo accesso tramite SPID",
            "
            <html>
                <head>
                    <title>DemoIDP - Nuovo accesso tramite SPID</title>
                </head>

                <body>
                    <p>
                        Gentile <b>" . $user->__serialize()["name"] . " " . $user->__serialize()["familyName"] . "</b>,
                        <br>
                        &egrave; stata utilizzata la tua identit&agrave; SPID per accedere al servizio <b>" . $relayParty->__serialize()["relayPartyName"] . "</b>.
                    </p>

                    <p>
                        Dettagli sull'accesso:
                        
                        <ul>
                            <li>Indirizzo IP: " .  $_SERVER["REMOTE_ADDR"] . "</li>
                            <li>User agent: " . $_SERVER["HTTP_USER_AGENT"] . "</li>
                            <li>Timestamp: " . date("Y-m-d H:i:s") . "</li>
                        </ul>
                    </p>

                    <br><br><br><br><br><br>
                </body>

            </html>
            ",
            [
                "From" => "DemoIDP SPID <aanmelden@altervista.org>",
                "MIME-Version" => "1.0",
                "Content-Type" => "text/html; charset=UTF-8"
            ]
        );

        if ($user->getUserCredentials()->__serialize()["isMinorAccount"]) {
            $parentUser = new User($user->getUserCredentials()->__serialize()["parentSpidCode"], $env);

            mail(
                $parentUser->getUserContacts()->__serialize()["email"],
                "DemoIDP - Nuovo accesso tramite SPID",
                "
                <html>
                    <head>
                        <title>DemoIDP - Nuovo accesso tramite SPID</title>
                    </head>

                    <body>
                        <p>
                            Gentile <b>" . $parentUser->__serialize()["name"] . " " . $parentUser->__serialize()["familyName"] . "</b>,
                            <br>
                            l'account del minore " . $user->__serialize()["name"] . " " . $user->__serialize()["familyName"] . " &egrave; stato utilizzato per accedere a <b>" . $relayParty->__serialize()["relayPartyName"] . "</b>.
                        </p>

                        <p>
                            Dettagli sull'accesso:
                            
                            <ul>
                                <li>Indirizzo IP: " .  $_SERVER["REMOTE_ADDR"] . "</li>
                                <li>User agent: " . $_SERVER["HTTP_USER_AGENT"] . "</li>
                                <li>Timestamp: " . date("Y-m-d H:i:s") . "</li>
                            </ul>
                        </p>

                        <br><br><br><br><br><br>
                    </body>

                </html>
                ",
                [
                    "From" => "DemoIDP SPID <aanmelden@altervista.org>",
                    "MIME-Version" => "1.0",
                    "Content-Type" => "text/html; charset=UTF-8"
                ]
            );
        }

        $server->handleAuthorizeRequest($request, $response, true, $user->__serialize()["spidCode"]);
        $response->send();
    } else {
        if (key_exists("is_authorized", $_POST) && $_POST["is_authorized"] == "0") {
            $_SESSION["SPIDError"] = "AUTH_NOT_GRANTED_BY_USER";

            require_once(__DIR__ . "/web/login.php");
            die();
        } else {
            require_once(__DIR__ . "/web/consent.php");
            die();
        }
    }
} else {
    require_once(__DIR__ . "/web/login.php");
}
