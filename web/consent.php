<?php

use AgID\SPID\Entity\RelayParty;
use AgID\SPID\Helpers\Environment;

require_once(__DIR__ . "/../server.php");
$request = OAuth2\Request::createFromGlobals();

$env = new Environment();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_REQUEST["client_id"];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, ["spid_required_authlevel"])) {
            $request->query[$key] = $value;
        }
    }
} else {
    $client_id = $request->query["client_id"];
}

$relayParty = new RelayParty($client_id, $env);

$scopes = [
    "https://attributes.spid.gov.it/spidCode" => "Codice identificativo",
    "https://attributes.spid.gov.it/name" => "Nome",
    "https://attributes.spid.gov.it/familyName" => "Cognome",
    "https://attributes.spid.gov.it/placeOfBirth" => "Comune di nascita",
    "https://attributes.spid.gov.it/countyOfBirth" => "Stato di nascita",
    "https://attributes.spid.gov.it/dateOfBirth" => "Data di nascita",
    "https://attributes.spid.gov.it/gender" => "Sesso",
    "https://attributes.spid.gov.it/companyName" => "Nome azienda",
    "https://attributes.spid.gov.it/registeredOffice" => "Indirizzo registrato azienda",
    "https://attributes.spid.gov.it/fiscalNumber" => "Codice fiscale",
    "https://attributes.spid.gov.it/ivaCode" => "Partita IVA",
    "https://attributes.spid.gov.it/idCard" => "Carta di identit&agrave;",
    "https://attributes.spid.gov.it/mobilePhone" => "Numero di telefono",
    "https://attributes.spid.gov.it/email" => "Indirizzo e-mail",
    "https://attributes.spid.gov.it/address" => "Indirizzo di residenza",
    "https://attributes.spid.gov.it/domicileStreetAddress" => "Indirizzo di residenza (tipo)",
    "https://attributes.spid.gov.it/domicilePostalCode" => "Codice di avviamento postale (CAP)",
    "https://attributes.spid.gov.it/domicileMunicipality" => "Comune di residenza",
    "https://attributes.spid.gov.it/domicileProvince" => "Provincia di residenza",
    "https://attributes.spid.gov.it/domicileNation" => "Stato di residenza",
    "https://attributes.spid.gov.it/expirationDate" => "Data di scadenza",
    "https://attributes.spid.gov.it/digitalAddress" => "Indirizzo PEC"
];
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="it"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="it"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="it"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="it"><!--<![endif]-->

<head>
    <title>SPID</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="57x57" href="/spid/assets/img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/spid/assets/img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/spid/assets/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/spid/assets/img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/spid/assets/img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/spid/assets/img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/spid/assets/img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/spid/assets/img/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/spid/assets/img/favicon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/spid/assets/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/spid/assets/img/favicon/android-chrome-192x192.png" sizes="192x192">
    <link rel="manifest" href="/spid/assets/img/favicon/manifest.json">
    <link rel="mask-icon" href="/spid/assets/img/favicon/safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/spid/assets/img/favicon/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="/spid/assets/css/main.min.css" />
    <!--[if lt IE 9]>
    <script src="/spid/assets//spid/assets/js/selectivizr.min.js"></script>
    <script src="/spid/assets//spid/assets/js/respond.min.js"></script>
    <script src="/spid/assets//spid/assets/js/rem.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="outer">
        <div id="contain-all">
            <div class="inner">
                <div class="grid spacer-top-1">
                    <div class="width-one-whole spid-logo"><img src="/spid/assets/img/spid-level1-logo-bb.svg" onerror="this.src='/spid/assets/img/spid-level1-logo-bb.png'; this.onerror=null;" alt="SPID 1" /></div>
                </div>

                <div class="grid spacer-top-1">
                    <div class="width-one-whole pa-title"><?php echo ($relayParty->__serialize()["relayPartyName"]); ?></div>
                </div>

                <div class="grid spacer-top-1">
                    <div class="width-one-whole"><span class="spid-hr"></span></div>
                </div>

                <div class="grid spacer-top-1">
                    <div class="width-one-whole pa-message">Per accedere al servizio richiesto è necessario l'utilizzo dei seguenti dati personali:</div>
                </div>

                <!-- SPID LOGIN FORM * begin * -->
                <form name="spid-login" id="spid-login" action="/spid/authorize.php" method="post" class="grid">
                    <input type="hidden" name="spid_required_authlevel" value="<?php echo ($relayParty->__serialize()["requiredSpidAuthLevel"]); ?>">
                    <input type="hidden" name="is_authorized" value="1">

                    <?php foreach ($request->query as $key => $value) { ?>
                        <input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($value); ?>">
                    <?php } ?>

                    <div class="width-one-whole">
                        <div class="width-one-whole pa-message">
                            <ul>
                                <?php foreach (explode(" ", $request->query["scope"]) as $scope) { ?>
                                    <li><?php echo ($scopes[$scope]); ?></li>
                                <?php } ?>
                            </ul>
                        </div>

                        <button type="submit" class="italia-it-button italia-it-button-size-m button-spid spacer-top-3">
                            <span class="italia-it-button-icon"><img src="/spid/assets/img/spid-ico-circle-bb.svg" onerror="this.src='/spid/assets/img/spid-ico-circle-bb.png'; this.onerror=null;" alt="" /></span>
                            <span class="italia-it-button-text">Autorizza</span>
                        </button>
                    </div>
                </form>

                <!-- SPID LOGIN FORM * end * -->
                <div class="grid spacer-top-1">
                    <div class="width-one-whole push-right spid-link">
                        <form id="spid-login2" action="/spid/authorize.php" method="post">
                            <input type="hidden" name="spid_required_authlevel" value="<?php echo ($relayParty->__serialize()["requiredSpidAuthLevel"]); ?>">
                            <input type="hidden" name="is_authorized" value="0">

                            <?php foreach ($request->query as $key => $value) { ?>
                                <input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($value); ?>">
                            <?php } ?>

                            <a href="#" onclick="$('#spid-login2').submit();">
                                Annulla
                                <img class="open-link" src="/spid/assets/img/open-link.svg" onerror="this.src='/spid/assets/img/open-link.png'; this.onerror=null;" alt="Si apre una nuova pagina" />
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="header">
        <div id="header-inner">
            <img id="idp-logo" src="/spid/assets/img/idp-logo-demo.svg" onerror="this.src='/spid/assets/img/idp-logo-demo.png'; this.onerror=null;" alt="IDP Demo" />
        </div>
    </div>
    <div id="footer">
        <div id="footer-inner">
            <a href="http://www.spid.gov.it/check" target="blank_"><img id="spid-agid-logo" src="/spid/assets/img/spid-agid-logo-bb.svg" onerror="this.src='/spid/assets/img/spid-agid-logo-bb.png'; this.onerror=null;" alt="SPID - AgID Agenzia per l'Italia Digitale - Check" /></a>
        </div>
    </div>
    <script src="/spid/assets/js/jquery.min.js"></script>
</body>

</html>