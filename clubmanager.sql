-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 09, 2026 alle 10:21
-- Versione del server: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versione PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clubmanager`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `allenamenti`
--

CREATE TABLE `allenamenti` (
  `id` int(11) NOT NULL,
  `squadra_id` int(11) NOT NULL,
  `campo_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL,
  `ricorrente` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `allenatori`
--

CREATE TABLE `allenatori` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `patentino` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `campi`
--

CREATE TABLE `campi` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipologia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`) VALUES
(5, 'Allievi'),
(3, 'Esordienti'),
(4, 'Giovanissimi'),
(6, 'Juniores'),
(1, 'Primi Calci'),
(2, 'Pulcini');

-- --------------------------------------------------------

--
-- Struttura della tabella `disponibilita_campi`
--

CREATE TABLE `disponibilita_campi` (
  `id` int(11) NOT NULL,
  `campo_id` int(11) NOT NULL,
  `giorno_settimana` enum('Lun','Mar','Mer','Gio','Ven','Sab','Dom') NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `documenti`
--

CREATE TABLE `documenti` (
  `id` int(11) NOT NULL,
  `giocatore_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `data_scadenza` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `giocatori`
--

CREATE TABLE `giocatori` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `anno_nascita` year(4) NOT NULL,
  `ruolo` varchar(50) DEFAULT NULL,
  `numero_maglia` int(11) DEFAULT NULL,
  `codice_fiscale` varchar(16) DEFAULT NULL,
  `contatto_genitore` varchar(100) DEFAULT NULL,
  `attivo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifiche`
--

CREATE TABLE `notifiche` (
  `id` int(11) NOT NULL,
  `messaggio` text NOT NULL,
  `data_notifica` date NOT NULL,
  `letto` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli`
--

CREATE TABLE `ruoli` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ruoli`
--

INSERT INTO `ruoli` (`id`, `nome`) VALUES
(2, 'Allenatore'),
(1, 'Amministratore'),
(3, 'Visualizzatore');

-- --------------------------------------------------------

--
-- Struttura della tabella `squadre`
--

CREATE TABLE `squadre` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `squadre_allenatori`
--

CREATE TABLE `squadre_allenatori` (
  `squadra_id` int(11) NOT NULL,
  `allenatore_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `squadre_giocatori`
--

CREATE TABLE `squadre_giocatori` (
  `squadra_id` int(11) NOT NULL,
  `giocatore_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `v_tesserati_categoria`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `v_tesserati_categoria` (
`categoria` varchar(50)
,`totale_tesserati` bigint(21)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `v_utilizzo_campi`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `v_utilizzo_campi` (
`campo` varchar(100)
,`data` date
,`numero_allenamenti` bigint(21)
);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `allenamenti`
--
ALTER TABLE `allenamenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `squadra_id` (`squadra_id`),
  ADD KEY `campo_id` (`campo_id`);

--
-- Indici per le tabelle `allenatori`
--
ALTER TABLE `allenatori`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `campi`
--
ALTER TABLE `campi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `disponibilita_campi`
--
ALTER TABLE `disponibilita_campi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campo_id` (`campo_id`);

--
-- Indici per le tabelle `documenti`
--
ALTER TABLE `documenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `giocatore_id` (`giocatore_id`);

--
-- Indici per le tabelle `giocatori`
--
ALTER TABLE `giocatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice_fiscale` (`codice_fiscale`);

--
-- Indici per le tabelle `notifiche`
--
ALTER TABLE `notifiche`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `ruoli`
--
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `squadre`
--
ALTER TABLE `squadre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indici per le tabelle `squadre_allenatori`
--
ALTER TABLE `squadre_allenatori`
  ADD PRIMARY KEY (`squadra_id`,`allenatore_id`),
  ADD KEY `allenatore_id` (`allenatore_id`);

--
-- Indici per le tabelle `squadre_giocatori`
--
ALTER TABLE `squadre_giocatori`
  ADD PRIMARY KEY (`squadra_id`,`giocatore_id`),
  ADD KEY `giocatore_id` (`giocatore_id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ruolo_id` (`ruolo_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `allenamenti`
--
ALTER TABLE `allenamenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `allenatori`
--
ALTER TABLE `allenatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `campi`
--
ALTER TABLE `campi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `disponibilita_campi`
--
ALTER TABLE `disponibilita_campi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `documenti`
--
ALTER TABLE `documenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `giocatori`
--
ALTER TABLE `giocatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notifiche`
--
ALTER TABLE `notifiche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ruoli`
--
ALTER TABLE `ruoli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `squadre`
--
ALTER TABLE `squadre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Struttura per vista `v_tesserati_categoria`
--
DROP TABLE IF EXISTS `v_tesserati_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_tesserati_categoria`  AS SELECT `c`.`nome` AS `categoria`, count(`g`.`id`) AS `totale_tesserati` FROM (((`categorie` `c` join `squadre` `s` on(`s`.`categoria_id` = `c`.`id`)) join `squadre_giocatori` `sg` on(`sg`.`squadra_id` = `s`.`id`)) join `giocatori` `g` on(`g`.`id` = `sg`.`giocatore_id`)) GROUP BY `c`.`nome` ;

-- --------------------------------------------------------

--
-- Struttura per vista `v_utilizzo_campi`
--
DROP TABLE IF EXISTS `v_utilizzo_campi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_utilizzo_campi`  AS SELECT `ca`.`nome` AS `campo`, `a`.`data` AS `data`, count(`a`.`id`) AS `numero_allenamenti` FROM (`allenamenti` `a` join `campi` `ca` on(`ca`.`id` = `a`.`campo_id`)) GROUP BY `ca`.`nome`, `a`.`data` ;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `allenamenti`
--
ALTER TABLE `allenamenti`
  ADD CONSTRAINT `allenamenti_ibfk_1` FOREIGN KEY (`squadra_id`) REFERENCES `squadre` (`id`),
  ADD CONSTRAINT `allenamenti_ibfk_2` FOREIGN KEY (`campo_id`) REFERENCES `campi` (`id`);

--
-- Limiti per la tabella `disponibilita_campi`
--
ALTER TABLE `disponibilita_campi`
  ADD CONSTRAINT `disponibilita_campi_ibfk_1` FOREIGN KEY (`campo_id`) REFERENCES `campi` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `documenti`
--
ALTER TABLE `documenti`
  ADD CONSTRAINT `documenti_ibfk_1` FOREIGN KEY (`giocatore_id`) REFERENCES `giocatori` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `squadre`
--
ALTER TABLE `squadre`
  ADD CONSTRAINT `squadre_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`);

--
-- Limiti per la tabella `squadre_allenatori`
--
ALTER TABLE `squadre_allenatori`
  ADD CONSTRAINT `squadre_allenatori_ibfk_1` FOREIGN KEY (`squadra_id`) REFERENCES `squadre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `squadre_allenatori_ibfk_2` FOREIGN KEY (`allenatore_id`) REFERENCES `allenatori` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `squadre_giocatori`
--
ALTER TABLE `squadre_giocatori`
  ADD CONSTRAINT `squadre_giocatori_ibfk_1` FOREIGN KEY (`squadra_id`) REFERENCES `squadre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `squadre_giocatori_ibfk_2` FOREIGN KEY (`giocatore_id`) REFERENCES `giocatori` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`ruolo_id`) REFERENCES `ruoli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
