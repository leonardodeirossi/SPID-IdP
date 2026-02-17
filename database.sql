-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Feb 17, 2026 alle 10:49
-- Versione del server: 8.0.30
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_aanmelden`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `token_id` int NOT NULL,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(4000) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_authorization_codes`
--

CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `redirect_uri` varchar(2000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(4000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_token` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_challenge` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_challenge_method` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `client_secret` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `redirect_uri` varchar(2000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grant_types` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `scope` varchar(4000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('google-oauth2-playground', 'e4bb9cf4599818ef57caa7b5c8e9a4be', 'https://developers.google.com/oauthplayground', NULL, NULL, NULL),
('spid-test-sp', '58b9581086fd99ccd567c4c3ec79dd09', 'https://aanmelden.altervista.org/spid-test/callback.php', NULL, NULL, NULL),
('1636faf6-042b-11f1-a8c5-04421a23da50', 'ce0b0c4edcc25441e87a2babf799ae87', 'http://localhost:8080/api/v1/spid/callback', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_jwt`
--

CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `public_key` varchar(2000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_public_keys`
--

CREATE TABLE `oauth_public_keys` (
  `client_id` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `public_key` varchar(2000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `private_key` varchar(2000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `encryption_algorithm` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'RS256'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(4000) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `scope` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `oauth_users`
--

CREATE TABLE `oauth_users` (
  `username` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT NULL,
  `scope` varchar(4000) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `spid_relayparty`
--

CREATE TABLE `spid_relayparty` (
  `relayPartyId` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `relayPartyName` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `requiredSpidAuthLevel` int NOT NULL,
  `contactEmail` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contactTelephone` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `allowMinorAccess` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `spid_relayparty`
--

INSERT INTO `spid_relayparty` (`relayPartyId`, `relayPartyName`, `requiredSpidAuthLevel`, `contactEmail`, `contactTelephone`, `allowMinorAccess`) VALUES
('1636faf6-042b-11f1-a8c5-04421a23da50', 'EcoTn', 1, NULL, NULL, 0),
('google-oauth2-playground', 'Google OAuth 2.0 Playground', 1, NULL, NULL, 1),
('spid-test-sp', 'App di test SPID', 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `spid_user`
--

CREATE TABLE `spid_user` (
  `spidCode` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `familyName` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `placeOfBirth` varchar(4) COLLATE utf8mb4_general_ci NOT NULL,
  `countyOfBirth` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_general_ci NOT NULL,
  `companyName` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registeredOffice` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fiscalNumber` varchar(22) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'TINIT-<CF>',
  `ivaCode` varchar(17) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'VATIT-<PIVA>',
  `idCard` varchar(128) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `spid_user`
--

INSERT INTO `spid_user` (`spidCode`, `name`, `familyName`, `placeOfBirth`, `countyOfBirth`, `dateOfBirth`, `gender`, `companyName`, `registeredOffice`, `fiscalNumber`, `ivaCode`, `idCard`) VALUES
('ABCD1TR381TN1', 'MARCO ANDREA', 'ROSSI', 'L378', 'IT', '1970-01-01', 'M', NULL, NULL, 'TINIT-RSSMRC99A01L378X', NULL, '-'),
('CDEF8TR381TN8', 'CHIARA ANNA', 'LORENZI', 'L378', 'IT', '1970-01-01', 'F', NULL, NULL, 'TINIT-LRNCHR92H52L378S', NULL, '-'),
('EFGH2TR381TN2', 'GIULIA MARIA', 'BERTOLINI', 'L378', 'IT', '1970-01-01', 'F', NULL, NULL, 'TINIT-BRTGLM98B41L378Y', NULL, '-'),
('GHIJ9TR381TN9', 'ANDREA PAOLO', 'MARCHI', 'L378', 'IT', '1970-01-01', 'M', NULL, NULL, 'TINIT-MRCNDR91I23L378R', NULL, '-'),
('IJKL3TR381TN3', 'LUCA PAOLO', 'FONTANA', 'L378', 'IT', '1970-01-01', 'M', NULL, NULL, 'TINIT-FNTLCP97C12L378Z', NULL, '-'),
('KLMN0TR381TN0', 'VALENTINA SOFIA', 'BOSCHI', 'L378', 'IT', '1970-01-01', 'F', NULL, NULL, 'TINIT-BSCVLN90L64L378Q', NULL, '-'),
('MNOP4TR381TN4', 'SARA ELENA', 'ZANONI', 'L378', 'IT', '1970-01-01', 'F', NULL, NULL, 'TINIT-ZNNSRE96D53L378W', NULL, '-'),
('QRST5TR381TN5', 'DAVIDE LUCA', 'PIRAN', 'L378', 'IT', '1970-01-01', 'M', NULL, NULL, 'TINIT-PRNDVD95E21L378V', NULL, '-'),
('UVWX6TR381TN6', 'ELISA MARTA', 'RINALDI', 'L378', 'IT', '1970-01-01', 'F', NULL, NULL, 'TINIT-RNLELS94F45L378U', NULL, '-'),
('YZAB7TR381TN7', 'MATTEO SIMONE', 'GIOVANNINI', 'L378', 'IT', '1970-01-01', 'M', NULL, NULL, 'TINIT-GVNMTT93G11L378T', NULL, '-');

-- --------------------------------------------------------

--
-- Struttura della tabella `spid_user_contacts`
--

CREATE TABLE `spid_user_contacts` (
  `spidCode` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `mobilePhone` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `domicileStreetAddress` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `domicilePostalCode` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `domicileMunicipality` varchar(4) COLLATE utf8mb4_general_ci NOT NULL,
  `domicileProvince` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `domicileNation` varchar(3) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ITA',
  `expirationDate` timestamp NOT NULL,
  `digitalAddress` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `spid_user_contacts`
--

INSERT INTO `spid_user_contacts` (`spidCode`, `mobilePhone`, `email`, `domicileStreetAddress`, `domicilePostalCode`, `domicileMunicipality`, `domicileProvince`, `address`, `domicileNation`, `expirationDate`, `digitalAddress`) VALUES
('ABCD1TR381TN1', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Verdi 12', 'ITA', '2026-02-16 13:19:15', NULL),
('CDEF8TR381TN8', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Fersina 14', 'ITA', '2026-02-16 13:31:04', NULL),
('EFGH2TR381TN2', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Manci 5', 'ITA', '2026-02-16 13:21:55', NULL),
('GHIJ9TR381TN9', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Solteri 22', 'ITA', '2026-02-16 13:32:08', NULL),
('IJKL3TR381TN3', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Brennero 44', 'ITA', '2026-02-16 13:23:48', NULL),
('KLMN0TR381TN0', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Giusti 3', 'ITA', '2026-02-16 13:33:14', NULL),
('MNOP4TR381TN4', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Milano 18', 'ITA', '2026-02-16 13:24:58', NULL),
('QRST5TR381TN5', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Grazioli 9', 'ITA', '2026-02-16 13:26:16', NULL),
('UVWX6TR381TN6', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Degasperi 30', 'ITA', '2026-02-16 13:27:26', NULL),
('YZAB7TR381TN7', '-', 'mail@example.org', 'Via', '38122', 'L378', 'TN', 'Vittorio Veneto 7', 'ITA', '2026-02-16 13:29:49', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `spid_user_credentials`
--

CREATE TABLE `spid_user_credentials` (
  `spidCode` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `loginName` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `loginPassword` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastPasswordChange` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isMinorAccount` tinyint(1) NOT NULL DEFAULT '0',
  `parentSpidCode` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `spid_user_credentials`
--

INSERT INTO `spid_user_credentials` (`spidCode`, `loginName`, `loginPassword`, `lastPasswordChange`, `isMinorAccount`, `parentSpidCode`) VALUES
('ABCD1TR381TN1', 'RSSMRC99A01L378X', '$2y$10$HZXJkF3lixV0LQl1NUtXEuwglfE1dXWSzr9mQ5NE.ApByA5OkcWpS', '2025-09-17 05:04:52', 0, NULL),
('CDEF8TR381TN8', 'LRNCHR92H52L378S', '$2y$10$QPB769a3VcE9AwvKHeB6EOvz8w7gaocl8los7jSKb4j8fbNA4O.Ea', '2025-09-17 05:04:52', 0, NULL),
('EFGH2TR381TN2', 'BRTGLM98B41L378Y', '$2y$10$K.V.vQhh5D3BIon9ZHjyDu7q7JieCALqu83K05HPzeGxTghsuWzgy', '2025-09-17 05:04:52', 0, NULL),
('GHIJ9TR381TN9', 'MRCNDR91I23L378R', '$2y$10$1acj4U1ewJU0s7dxrlOYX.w2rS/.FpwpCqfZcVDVaL8YE94HVu0xO', '2025-09-17 05:04:52', 0, NULL),
('IJKL3TR381TN3', 'FNTLCP97C12L378Z', '$2y$10$rs5Y1OETvZMxpRaXQBs1ZeFHFIEXTeFdG0Cs/2jtcFFPoJWpgYOd6', '2025-09-17 05:04:52', 0, NULL),
('KLMN0TR381TN0', 'BSCVLN90L64L378Q', '$2y$10$w9knXoq0NuMPvP8Ppe57oO5daZ61VDTG58TRBNWzgCl3EgOvmITsy', '2025-09-17 05:04:52', 0, NULL),
('MNOP4TR381TN4', 'FNTLCP97C12L378Z', '$2y$10$9A1zYLSLPvL0kRDeVIisSupkhDgY7dAdC7jJd/1sen6J5n9UCzh4G', '2025-09-17 05:04:52', 0, NULL),
('QRST5TR381TN5', 'PRNDVD95E21L378V', '$2y$10$htK5mCbbRyJCVgKnjgefEeJzE.pafwkHtYXh4o3AAOPJ7g5LFf7O2', '2025-09-17 05:04:52', 0, NULL),
('UVWX6TR381TN6', 'RNLELS94F45L378U', '$2y$10$It9p.pE1zmV7xgbE5yAv7ekqMmqxjiMMhHFxYxpPjI2LEQiKjBuWi', '2026-02-16 13:27:57', 0, NULL),
('YZAB7TR381TN7', 'GVNMTT93G11L378T', '$2y$10$vwFIIrI51PK3/29mFPr/W.et7ffBtjMtjxoCNhVMuQXkVaTuAT8ou', '2026-02-16 13:30:07', 0, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indici per le tabelle `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`authorization_code`);

--
-- Indici per le tabelle `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indici per le tabelle `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`);

--
-- Indici per le tabelle `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`scope`);

--
-- Indici per le tabelle `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `spid_relayparty`
--
ALTER TABLE `spid_relayparty`
  ADD PRIMARY KEY (`relayPartyId`);

--
-- Indici per le tabelle `spid_user`
--
ALTER TABLE `spid_user`
  ADD PRIMARY KEY (`spidCode`);

--
-- Indici per le tabelle `spid_user_contacts`
--
ALTER TABLE `spid_user_contacts`
  ADD PRIMARY KEY (`spidCode`);

--
-- Indici per le tabelle `spid_user_credentials`
--
ALTER TABLE `spid_user_credentials`
  ADD PRIMARY KEY (`spidCode`),
  ADD KEY `parentSpidCode` (`parentSpidCode`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  MODIFY `token_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `spid_user_contacts`
--
ALTER TABLE `spid_user_contacts`
  ADD CONSTRAINT `user_contacts_ibfk_1` FOREIGN KEY (`spidCode`) REFERENCES `spid_user` (`spidCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `spid_user_credentials`
--
ALTER TABLE `spid_user_credentials`
  ADD CONSTRAINT `user_credentials_ibfk_1` FOREIGN KEY (`spidCode`) REFERENCES `spid_user` (`spidCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_credentials_ibfk_2` FOREIGN KEY (`parentSpidCode`) REFERENCES `spid_user` (`spidCode`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
