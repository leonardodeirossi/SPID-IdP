<?php
/*
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
    "https://attributes.spid.gov.it/expirationDate" => "Data di scadenza",
    "https://attributes.spid.gov.it/digitalAddress" => "Indirizzo PEC"
];
*/

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
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Test SPID DemoIDP</title>
</head>

<body>
    <h1>Test SPID DemoIDP</h1>
    <hr>

    <form method="POST" action="redirect.php">
        <p>Seleziona gli scope da richiedere all'IdP:</p>

        <?php $i = 0; ?>
        <?php foreach ($scopes as $scope => $scope_desc) { ?>
            <input type="checkbox" id="scope_<?php echo ($i); ?>" name="scope[]" value="<?php echo ($scope); ?>">
            <label for="scope_<?php echo ($i); ?>"><?php echo ($scope_desc . " (" . $scope . ")"); ?></label>

            <br>

            <?php $i++; ?>
        <?php } ?>

        <br>

        <button type="submit">
            Richiedi autorizzazione
        </button>
    </form>
</body>

</html>