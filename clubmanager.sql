-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 14, 2026 alle 19:09
-- Versione del server: 10.11.14-MariaDB-0ubuntu0.24.04.1
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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `societa_id` int(11) NOT NULL DEFAULT 1
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
  `societa_id` int(11) NOT NULL DEFAULT 1,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `anno_nascita` year(4) NOT NULL,
  `ruolo` varchar(50) DEFAULT NULL,
  `numero_maglia` int(11) DEFAULT NULL,
  `codice_fiscale` varchar(16) DEFAULT NULL,
  `contatto_genitore` varchar(100) DEFAULT NULL,
  `scadenza_visita` date DEFAULT NULL,
  `piede_preferito` enum('Destro','Sinistro','Ambidestro') DEFAULT NULL,
  `goal` int(11) DEFAULT 0,
  `assist` int(11) DEFAULT 0,
  `minuti_giocati` int(11) DEFAULT 0,
  `attivo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `giocatori`
--

INSERT INTO `giocatori` (`id`, `societa_id`, `nome`, `cognome`, `anno_nascita`, `ruolo`, `numero_maglia`, `codice_fiscale`, `contatto_genitore`, `scadenza_visita`, `piede_preferito`, `goal`, `assist`, `minuti_giocati`, `attivo`, `created_at`) VALUES
(1, 1, 'stiven', 'kurtu', '2007', 'Attaccante', 18, '4264535678784685', '3519098539', '2222-02-22', 'Destro', 0, 0, 0, 0, '2026-02-02 08:46:25'),
(3, 1, 'alberto', 'gerosa', '2007', 'Attaccante', 9, '34857573878', '3573457467564716', '2027-12-05', 'Destro', 0, 0, 0, 0, '2026-02-02 08:56:41'),
(4, 1, 'andrew', 'bertullus', '2007', 'Centrocampista', 8, 'wervaervaerbgatr', '342163663636', '1000-01-11', 'Ambidestro', 0, 0, 0, 0, '2026-02-06 09:47:18'),
(5, 1, 'giorgio magdy aziz faltass', 'barsoum', '2007', 'Attaccante', 10, 'fgmchgm xhgm,hjd', '342163663636', '4555-03-02', 'Sinistro', 0, 0, 0, 0, '2026-02-06 09:50:28'),
(6, 1, 'LEO', 'TRESCA', '2008', 'Attaccante', 10, '3223YRF8EF48GRG8', 'tresca.leonardo.studente@itispaleocapa.it', '1991-12-22', 'Destro', 0, 0, 0, 0, '2026-03-06 12:05:13');

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
-- Struttura della tabella `permessi`
--

CREATE TABLE `permessi` (
  `id` int(11) NOT NULL,
  `codice` varchar(100) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `permessi`
--

INSERT INTO `permessi` (`id`, `codice`, `descrizione`) VALUES
(1, 'gestione_utenti', 'Gestione utenti'),
(2, 'gestione_permessi', 'Gestione ruoli e permessi'),
(3, 'crea_allenamento', 'Creazione allenamenti'),
(4, 'modifica_allenamento', 'Modifica allenamenti'),
(5, 'elimina_allenamento', 'Eliminazione allenamenti'),
(6, 'visualizza_dati', 'Visualizzazione dati');

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
(4, 'Super Amministratore'),
(3, 'Visualizzatore');

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli_permessi`
--

CREATE TABLE `ruoli_permessi` (
  `ruolo_id` int(11) NOT NULL,
  `permesso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ruoli_permessi`
--

INSERT INTO `ruoli_permessi` (`ruolo_id`, `permesso_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 3),
(2, 4),
(2, 6),
(3, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `societa`
--

CREATE TABLE `societa` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `partita_iva` varchar(20) DEFAULT NULL,
  `attiva` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `societa`
--

INSERT INTO `societa` (`id`, `nome`, `partita_iva`, `attiva`, `created_at`) VALUES
(1, 'paleocapa', NULL, 1, '2026-04-10 08:30:40');

-- --------------------------------------------------------

--
-- Struttura della tabella `squadre`
--

CREATE TABLE `squadre` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `societa_id` int(11) NOT NULL DEFAULT 1
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
  `societa_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `email`, `password`, `ruolo_id`, `societa_id`, `created_at`) VALUES
(36, 'LEONARDO', 'tresca10@gmail.com', '$2y$10$kmnFORou/kB6OKGAY/dtzOdZXdF5hLpBYwsffN7.NqahkXqHfgjZq', 1, NULL, '2026-05-12 17:46:34'),
(37, 'alberto', 'alberto@alpesto.it', '$2y$10$0KPSX/rJsmeFWLc56cn0P.xkwoa7iRFGDJOgzCXw7q1k0AqDbn4Iq', 1, NULL, '2026-05-14 09:23:30');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista_allenatori_squadre`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista_allenatori_squadre` (
`allenatore_id` int(11)
,`nome` varchar(100)
,`email` varchar(100)
,`telefono` varchar(30)
,`patentino` varchar(50)
,`squadra_id` int(11)
,`squadra` varchar(100)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista_calendario_allenamenti`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista_calendario_allenamenti` (
`allenamento_id` int(11)
,`data` date
,`ora_inizio` time
,`ora_fine` time
,`squadra` varchar(100)
,`campo` varchar(100)
,`categoria` varchar(50)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista_documenti_in_scadenza`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista_documenti_in_scadenza` (
`documento_id` int(11)
,`nome` varchar(100)
,`cognome` varchar(100)
,`tipo` varchar(50)
,`data_scadenza` date
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista_giocatori_per_categoria`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista_giocatori_per_categoria` (
`categoria` varchar(50)
,`totale_giocatori` bigint(21)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista_giocatori_squadre`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista_giocatori_squadre` (
`giocatore_id` int(11)
,`nome` varchar(100)
,`cognome` varchar(100)
,`anno_nascita` year(4)
,`ruolo` varchar(50)
,`numero_maglia` int(11)
,`attivo` tinyint(1)
,`squadra_id` int(11)
,`squadra` varchar(100)
,`categoria` varchar(50)
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
  ADD UNIQUE KEY `codice_fiscale` (`codice_fiscale`),
  ADD KEY `fk_giocatori_societa` (`societa_id`);

--
-- Indici per le tabelle `notifiche`
--
ALTER TABLE `notifiche`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `permessi`
--
ALTER TABLE `permessi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice` (`codice`);

--
-- Indici per le tabelle `ruoli`
--
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `ruoli_permessi`
--
ALTER TABLE `ruoli_permessi`
  ADD PRIMARY KEY (`ruolo_id`,`permesso_id`),
  ADD KEY `permesso_id` (`permesso_id`);

--
-- Indici per le tabelle `societa`
--
ALTER TABLE `societa`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `ruolo_id` (`ruolo_id`),
  ADD KEY `fk_utenti_societa` (`societa_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `notifiche`
--
ALTER TABLE `notifiche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `permessi`
--
ALTER TABLE `permessi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `ruoli`
--
ALTER TABLE `ruoli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `societa`
--
ALTER TABLE `societa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `squadre`
--
ALTER TABLE `squadre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

-- --------------------------------------------------------

--
-- Struttura per vista `vista_allenatori_squadre`
--
DROP TABLE IF EXISTS `vista_allenatori_squadre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `vista_allenatori_squadre`  AS SELECT `a`.`id` AS `allenatore_id`, `a`.`nome` AS `nome`, `a`.`email` AS `email`, `a`.`telefono` AS `telefono`, `a`.`patentino` AS `patentino`, `s`.`id` AS `squadra_id`, `s`.`nome` AS `squadra` FROM ((`allenatori` `a` left join `squadre_allenatori` `sa` on(`a`.`id` = `sa`.`allenatore_id`)) left join `squadre` `s` on(`sa`.`squadra_id` = `s`.`id`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `vista_calendario_allenamenti`
--
DROP TABLE IF EXISTS `vista_calendario_allenamenti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `vista_calendario_allenamenti`  AS SELECT `a`.`id` AS `allenamento_id`, `a`.`data` AS `data`, `a`.`ora_inizio` AS `ora_inizio`, `a`.`ora_fine` AS `ora_fine`, `s`.`nome` AS `squadra`, `c`.`nome` AS `campo`, `cat`.`nome` AS `categoria` FROM (((`allenamenti` `a` join `squadre` `s` on(`a`.`squadra_id` = `s`.`id`)) join `categorie` `cat` on(`s`.`categoria_id` = `cat`.`id`)) join `campi` `c` on(`a`.`campo_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `vista_documenti_in_scadenza`
--
DROP TABLE IF EXISTS `vista_documenti_in_scadenza`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `vista_documenti_in_scadenza`  AS SELECT `d`.`id` AS `documento_id`, `g`.`nome` AS `nome`, `g`.`cognome` AS `cognome`, `d`.`tipo` AS `tipo`, `d`.`data_scadenza` AS `data_scadenza` FROM (`documenti` `d` join `giocatori` `g` on(`d`.`giocatore_id` = `g`.`id`)) WHERE `d`.`data_scadenza` is not null AND `d`.`data_scadenza` <= curdate() + interval 30 day ;

-- --------------------------------------------------------

--
-- Struttura per vista `vista_giocatori_per_categoria`
--
DROP TABLE IF EXISTS `vista_giocatori_per_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `vista_giocatori_per_categoria`  AS SELECT `c`.`nome` AS `categoria`, count(`sg`.`giocatore_id`) AS `totale_giocatori` FROM ((`categorie` `c` left join `squadre` `s` on(`c`.`id` = `s`.`categoria_id`)) left join `squadre_giocatori` `sg` on(`s`.`id` = `sg`.`squadra_id`)) GROUP BY `c`.`nome` ;

-- --------------------------------------------------------

--
-- Struttura per vista `vista_giocatori_squadre`
--
DROP TABLE IF EXISTS `vista_giocatori_squadre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utente_phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `vista_giocatori_squadre`  AS SELECT `g`.`id` AS `giocatore_id`, `g`.`nome` AS `nome`, `g`.`cognome` AS `cognome`, `g`.`anno_nascita` AS `anno_nascita`, `g`.`ruolo` AS `ruolo`, `g`.`numero_maglia` AS `numero_maglia`, `g`.`attivo` AS `attivo`, `s`.`id` AS `squadra_id`, `s`.`nome` AS `squadra`, `c`.`nome` AS `categoria` FROM (((`giocatori` `g` left join `squadre_giocatori` `sg` on(`g`.`id` = `sg`.`giocatore_id`)) left join `squadre` `s` on(`sg`.`squadra_id` = `s`.`id`)) left join `categorie` `c` on(`s`.`categoria_id` = `c`.`id`)) ;

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
-- Limiti per la tabella `giocatori`
--
ALTER TABLE `giocatori`
  ADD CONSTRAINT `fk_giocatori_societa` FOREIGN KEY (`societa_id`) REFERENCES `societa` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `ruoli_permessi`
--
ALTER TABLE `ruoli_permessi`
  ADD CONSTRAINT `ruoli_permessi_ibfk_1` FOREIGN KEY (`ruolo_id`) REFERENCES `ruoli` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ruoli_permessi_ibfk_2` FOREIGN KEY (`permesso_id`) REFERENCES `permessi` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_utenti_societa` FOREIGN KEY (`societa_id`) REFERENCES `societa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`ruolo_id`) REFERENCES `ruoli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
