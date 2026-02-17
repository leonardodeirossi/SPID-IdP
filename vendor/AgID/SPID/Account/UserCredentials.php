<?php

namespace AgID\SPID\Account;

use AgID\SPID\Helpers\Environment;

class UserCredentials
{
    private string $spidCode;
    private string $loginName;
    private string $loginPassword;
    private string|null $lastPasswordChange;
    private bool $isMinorAccount;
    private string|null $parentSpidCode;

    private Environment $env;

    public function __construct(string $spidCode, Environment $env)
    {
        $this->spidCode = $spidCode;
        $this->env = $env;

        $userCredentials = $this->getUserCredentials();

        $this->loginName = $userCredentials["loginName"];
        $this->loginPassword = $userCredentials["loginPassword"];
        $this->lastPasswordChange = ($userCredentials["lastPasswordChange"] != "") ? $userCredentials["lastPasswordChange"] : null;
        $this->isMinorAccount = ($userCredentials["isMinorAccount"] == "1");
        $this->parentSpidCode = ($userCredentials["parentSpidCode"] != "") ? $userCredentials["parentSpidCode"] : null;
    }

    private function getUserCredentials(): array|null
    {
        $result = $this->env->getDatabase()->executeQuery("SELECT * FROM spid_user_credentials WHERE spidCode = '" . $this->spidCode . "'");
        if (!$result) {
            return null;
        }

        return mysqli_fetch_assoc($result);
    }

    public function checkUserPassword(string $password): bool
    {
        return password_verify($password, $this->loginPassword);
    }

    public function __serialize(): array
    {
        return [
            "spidCode" => $this->spidCode,
            "loginName" => $this->loginName,
            "loginPassword" => $this->loginPassword,
            "lastPasswordChange" => $this->lastPasswordChange,
            "isMinorAccount" => $this->isMinorAccount,
            "parentSpidCode" => $this->parentSpidCode
        ];
    }
}
