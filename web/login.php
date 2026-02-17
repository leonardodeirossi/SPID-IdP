<?php

use AgID\SPID\Entity\RelayParty;
use AgID\SPID\Helpers\Environment;

require_once(__DIR__ . "/../server.php");
$request = OAuth2\Request::createFromGlobals();

$env = new Environment();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_REQUEST["client_id"];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, ["spid_required_authlevel", "nome_utente", "password", "is_authorized"])) {
            $request->query[$key] = $value;
        }
    }
} else {
    $client_id = $request->query["client_id"];
}

$relayParty = new RelayParty($client_id, $env);

$spidErrors = [
    "INVALID_USER" => "Utente non trovato nel sistema.",
    "INVALID_PASSWORD" => "Nome utente o password errati.",
    "MINOR_ACCOUNT_NOT_ALLOWED" => "L'accesso a " . $relayParty->__serialize()["relayPartyName"] . " non &egrave; consentito agli utenti minorenni.",
    "AUTH_NOT_GRANTED_BY_USER" => "Autorizzazione negata dall'utente."
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
    <script src="/spid/assets/js/selectivizr.min.js"></script>
    <script src="/spid/assets/js/respond.min.js"></script>
    <script src="/spid/assets/js/rem.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="outer">
        <div id="contain-all">
            <div class="inner">
                <div class="grid spacer-top-1">
                    <div class="width-one-whole spid-logo">
                        <img src="/spid/assets/img/spid-level1-logo-bb.svg" onerror="this.src='/spid/assets/img/spid-level1-logo-bb.png'; this.onerror=null;" alt="SPID 1" />
                    </div>
                </div>

                <div class="grid spacer-top-1">
                    <div class="width-one-whole pa-title"><?php echo ($relayParty->__serialize()["relayPartyName"]); ?></div>
                </div>

                <div class="grid spacer-top-1">
                    <div class="width-one-whole"><span class="spid-hr"></span></div>
                </div>

                <?php if (key_exists("SPIDError", $_SESSION) && $_SESSION["SPIDError"] != "") { ?>
                    <div class="grid">
                        <div class="width-one-whole">
                            <div class="alert alert-error" role="alert">
                                <div class="alert-body">
                                    <h3 class="alert-heading">Errore!</h3>
                                    <p class="alert-text"><?php echo ($spidErrors[$_SESSION["SPIDError"]]); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php unset($_SESSION["SPIDError"]); ?>
                <?php } ?>

                <!-- SPID LOGIN FORM * begin * -->
                <form name="spid-login" id="spid-login" action="/spid/authorize.php" method="post" class="grid">
                    <input type="hidden" name="spid_required_authlevel" value="<?php echo ($relayParty->__serialize()["requiredSpidAuthLevel"]); ?>">

                    <?php foreach ($request->query as $key => $value) { ?>
                        <input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($value); ?>">
                    <?php } ?>

                    <div class="width-one-whole">
                        <fieldset>
                            <div>
                                <label for="nome_utente" class="float-left label-bold">Nome utente</label>

                                <span class="forgot-link">
                                    <a href="#">
                                        Nome utente dimenticato?
                                        <img class="open-link" src="/spid/assets/img/open-link.svg" onerror="this.src='/spid/assets/img/open-link.png'; this.onerror=null;" alt="Si apre una nuova pagina" />
                                    </a>
                                </span>

                                <input id="nome_utente" name="nome_utente" type="text" class="input-error" required><span class="clear"></span>
                            </div>

                            <div>
                                <label for="password" class="float-left label-bold">Password</label>

                                <span class="forgot-link">
                                    <a href="#">
                                        Password dimenticata?
                                        <img class="open-link" src="/spid/assets/img/open-link.svg" onerror="this.src='/spid/assets/img/open-link.png'; this.onerror=null;" alt="Si apre una nuova pagina" />
                                    </a>
                                </span>

                                <input id="password" name="password" type="password" class="showpassword" required><span class="clear"></span>
                            </div>

                            <div class="push-right spacer-top-2">
                                <input id="showHide" type="checkbox" class="showpasswordcheckbox" />
                                <label class="showHideLabel" for="showHide">Mostra password</label>
                            </div>
                        </fieldset>

                        <button type="submit" class="italia-it-button italia-it-button-size-m button-spid spacer-top-1">
                            <span class="italia-it-button-icon"><img src="/spid/assets/img/spid-ico-circle-bb.svg" onerror="this.src='/spid/assets/img/spid-ico-circle-bb.png'; this.onerror=null;" alt="" /></span>
                            <span class="italia-it-button-text">Entra con SPID</span>
                        </button>
                    </div>
                </form>
                <!-- SPID LOGIN FORM * end * -->
                <div class="grid spacer-top-1">
                    <div class="width-one-half push-left spid-link">
                        <a href="#">
                            Non hai Spid? Registrati
                            <img class="open-link" src="/spid/assets/img/open-link.svg" onerror="this.src='/spid/assets/img/open-link.png'; this.onerror=null;" alt="Si apre una nuova pagina" />
                        </a>
                    </div>
                    <div class="width-one-half push-right spid-link">
                        <a href="#">
                            Annulla
                            <img class="open-link" src="/spid/assets/img/open-link.svg" onerror="this.src='/spid/assets/img/open-link.png'; this.onerror=null;" alt="Si apre una nuova pagina" />
                        </a>
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
    <script>
        $(function() {
            $(".showpassword").each(function(index, input) {
                var $input = $(input);
                $(".showpasswordcheckbox").click(function() {
                    var change = $(this).is(":checked") ? "text" : "password";
                    var rep = $("<input type='" + change + "' />")
                        .attr("id", $input.attr("id"))
                        .attr("name", $input.attr("name"))
                        .attr('class', $input.attr('class'))
                        .val($input.val())
                        .insertBefore($input);
                    $input.remove();
                    $input = rep;
                })
            });
        });
    </script>
</body>

</html>