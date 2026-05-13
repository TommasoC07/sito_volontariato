-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 13, 2026 alle 09:53
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sito_volontariato`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `donazione`
--

CREATE TABLE `donazione` (
  `id` int(11) NOT NULL,
  `importo` decimal(10,2) DEFAULT NULL,
  `data_donazione` date NOT NULL DEFAULT current_timestamp(),
  `id_utente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `donazione`
--

INSERT INTO `donazione` (`id`, `importo`, `data_donazione`, `id_utente`) VALUES
(1, 13.00, '2026-05-06', 3),
(2, 20.00, '2026-05-06', NULL),
(4, 10.50, '2026-05-13', 3),
(5, 5.00, '2026-05-13', NULL),
(6, 15.00, '2026-05-13', 3),
(7, 23.00, '2026-05-13', 3),
(8, 5.00, '2026-05-13', 16);

--
-- Trigger `donazione`
--
DELIMITER $$
CREATE TRIGGER `controllo_importo` BEFORE INSERT ON `donazione` FOR EACH ROW BEGIN
    IF NEW.importo < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Importo non valido';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `cognome` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `ruolo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `email`, `passkey`, `ruolo`) VALUES
(1, 'tommy', 'consy', 'consi@gmail.com', '$2y$10$wyx2VoBflQtDIzpkWmkJ5eSRpcvJAkZikyAla1/bvRrXmZjo9aR32', 'admin'),
(3, 'michelangelo', 'moretti', 'minty@gmail.com', '$2y$10$9sPzS6zHHERywR2fNqXy.unslWSWDR/GbI9K9evlVwKrday7itjOu', 'user'),
(16, 'a', 'a', 'a@a.a', '$2y$10$y5DHUzPRYoyGRVibgbga7.kxrxL1biUAl1QRE515zdGiu1oK0o10y', 'user');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `donazione`
--
ALTER TABLE `donazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donazione_utente` (`id_utente`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `donazione`
--
ALTER TABLE `donazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `donazione`
--
ALTER TABLE `donazione`
  ADD CONSTRAINT `fk_donazione_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
