<?php

namespace AgID\SPID\Entity;

use AgID\SPID\Helpers\Environment;

class RelayParty
{
    private string $relayPartyId;
    private string $relayPartyName;
    private int $requiredSpidAuthLevel;
    private string|null $contactEmail;
    private string|null $contactTelephone;
    private bool $allowMinorAccess;

    private Environment $env;

    public function __construct(string $relayPartyId, Environment $env)
    {
        $this->relayPartyId = $relayPartyId;
        $this->env = $env;

        $relayPartyData = $this->getRelayPartyData();
        if ($relayPartyData == null) {
        }

        $this->relayPartyName = $relayPartyData["relayPartyName"];
        $this->requiredSpidAuthLevel = intval($relayPartyData["requiredSpidAuthLevel"]);

        $this->contactEmail = ($relayPartyData["contactEmail"] != "") ? $relayPartyData["contactEmail"] : null;
        $this->contactTelephone = ($relayPartyData["contactTelephone"] != "") ? $relayPartyData["contactTelephone"] : null;

        $this->allowMinorAccess = ($relayPartyData["allowMinorAccess"] == "1");
    }

    private function getRelayPartyData(): array|null
    {
        $relayPartyData = $this->env->getDatabase()->executeQuery("SELECT * FROM spid_relayparty WHERE relayPartyId = '" . $this->relayPartyId . "'");
        if (!$relayPartyData) {
            return null;
        }

        return mysqli_fetch_assoc($relayPartyData);
    }

    public function __serialize(): array
    {
        return [
            "relayPartyId" => $this->relayPartyId,
            "relayPartyName" => $this->relayPartyName,
            "requiredSpidAuthLevel" => $this->requiredSpidAuthLevel,
            "contactEmail" => $this->contactEmail,
            "contactTelephone" => $this->contactTelephone,
            "allowMinorAccess" => $this->allowMinorAccess
        ];
    }
}
