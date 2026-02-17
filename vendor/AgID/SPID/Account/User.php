<?php

namespace AgID\SPID\Account;

use AgID\SPID\Helpers\Environment;

class User
{
    private string $spidCode;
    private string $name;
    private string $familyName;
    private string $placeOfBirth;
    private string $countyOfBirth;
    private string $dateOfBirth;
    private string $gender;
    private string $companyName;
    private string $registeredOffice;
    private string $fiscalNumber;
    private string $ivaCode;
    private string $idCard;

    private UserContacts $userContacts;
    private UserCredentials $userCredentials;

    private Environment $env;

    public function __construct(string $spidCode, Environment $env)
    {
        $this->spidCode = $spidCode;
        $this->env = $env;

        $this->userContacts = new UserContacts($spidCode, $env);
        $this->userCredentials = new UserCredentials($spidCode, $env);

        // $userData = $this->getUserData();
    }

    private function getUserData(): array|null
    {
        $result = $this->env->getDatabase()->executeQuery("SELECT * FROM spid_user WHERE spidCode = '" . $this->spidCode . "'");
        if (!$result || mysqli_num_rows($result) == 0) {
            return null;
        }
        
        $userData = mysqli_fetch_assoc($result);
        foreach ($this->getUserContacts()->__serialize() as $key => $value) {
        	$userData[$key] = $value;
        }
        
        foreach ($this->getUserCredentials()->__serialize() as $key => $value) {
        	$userData[$key] = $value;
        }

        return $userData;
    }

    public static function getUserByLoginName(string $loginName, Environment $env): User|null
    {
        $result = $env->getDatabase()->executeQuery("SELECT spidCode FROM spid_user_credentials WHERE loginName = '" . $loginName . "'");
        if (!$result || mysqli_num_rows($result) == 0) {
            return null;
        }

        $spidCode = mysqli_fetch_assoc($result)["spidCode"];
        return new User($spidCode, $env);
    }

    public function getUserContacts(): UserContacts
    {
        return $this->userContacts;
    }

    public function getUserCredentials(): UserCredentials
    {
        return $this->userCredentials;
    }

    public function __serialize(): array
    {
        return $this->getUserData();
    }
}
