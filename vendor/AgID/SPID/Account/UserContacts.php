<?php

namespace AgID\SPID\Account;

use AgID\SPID\Helpers\Environment;

class UserContacts
{
    private string $spidCode;
    private string $mobilePhone;
    private string $email;
    private string $domicileStreetAddress;
    private string $domicilePostalCode;
    private string $domicileMunicipality;
    private string $domicileProvince;
    private string $address;
    private string $domicileNation;
    private string $expirationDate;
    private string|null $digitalAddress;

    private Environment $env;

    public function __construct(string $spidCode, Environment $env)
    {
        $this->spidCode = $spidCode;
        $this->env = $env;

        $userContacts = $this->getUserContacts();
        if (!$userContacts) {
        }

        $this->mobilePhone = $userContacts["mobilePhone"];
        $this->email = $userContacts["email"];
        $this->domicileStreetAddress = $userContacts["domicileStreetAddress"];
        $this->domicilePostalCode = $userContacts["domicilePostalCode"];
        $this->domicileMunicipality = $userContacts["domicileMunicipality"];
        $this->domicileProvince = $userContacts["domicileProvince"];
        $this->address = $userContacts["address"];
        $this->domicileNation = $userContacts["domicileNation"];
        $this->expirationDate = $userContacts["expirationDate"];
        $this->digitalAddress = ($userContacts["digitalAddress"] != "") ? $userContacts["digitalAddress"] : null;
    }

    private function getUserContacts(): array|null
    {
        $result = $this->env->getDatabase()->executeQuery("SELECT * FROM spid_user_contacts WHERE spidCode = '" . $this->spidCode . "'");
        if (!$result) {
            return null;
        }

        return mysqli_fetch_assoc($result);
    }

    public function __serialize(): array
    {
        return [
            "spidCode" => $this->spidCode,
            "mobilePhone" => $this->mobilePhone,
            "email" => $this->email,
            "domicileStreetAddress" => $this->domicileStreetAddress,
            "domicilePostalCode" => $this->domicilePostalCode,
            "domicileMunicipality" => $this->domicileMunicipality,
            "domicileProvince" => $this->domicileProvince,
            "address" => $this->address,
            "domicileNation" => $this->domicileNation,
            "expirationDate" => $this->expirationDate,
            "digitalAddress" => $this->digitalAddress
        ];
    }
}
