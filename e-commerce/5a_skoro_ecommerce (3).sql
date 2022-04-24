-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 18, 2022 alle 20:00
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5a_skoro_ecommerce`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articoli`
--

CREATE TABLE `articoli` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `DescShort` varchar(256) NOT NULL,
  `DescLong` text NOT NULL,
  `QuantitaDisp` int(11) NOT NULL,
  `Prezzo` float NOT NULL,
  `Venditore` varchar(64) NOT NULL,
  `sconto` int(2) NOT NULL DEFAULT 0,
  `Categorie` set('New','Hot Deals','Electronics','House','Motors','Top Selling') NOT NULL DEFAULT 'New',
  `stelle` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`ID`, `Nome`, `DescShort`, `DescLong`, `QuantitaDisp`, `Prezzo`, `Venditore`, `sconto`, `Categorie`, `stelle`) VALUES
(1, 'login', 'Schreenshot della pagina di login ', 'questa preziosa immagine rappresenta la pagina di login di una misteriosa applicazione e starà a te scoprire che applicazione è', 3, 100, 'SKamazon', 0, 'Electronics', 0),
(2, 'Computer x1000', 'Computer di una marca non meglio specifica', 'questo potentissimo computer di cui non si sa la marca è super op.', 0, 10000, 'SKamazon', 20, 'New,Top Selling', 3),
(3, 'Cuffie Gaming', 'Delle cuffie over 9000', 'Cuffie adatte alle più svariate ore di gioco', 8, 20000, 'SKamazon', 10, 'New', 5),
(4, 'Falso MacBook', 'Un MacBook abbastanza falso, ma ha OSx', 'non c\'è nulla da dire a parte che siete dei poveracci', 5, 350, 'SKamazon', 0, 'New', 2),
(5, 'Ipad tarocco', 'Come si puo vedere non esprime molta fiducia, ma vi assicuro che fa il suo lavoro', 'Un Ipad un po molto tarocco, ma tranquilli con il suo enorme processore mai sentito fa un ottimo lavoro', 10, 50, 'SKamazon', 0, 'New,Hot Deals', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `ID` int(11) NOT NULL,
  `IdUtente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`ID`, `IdUtente`) VALUES
(2, NULL),
(3, NULL),
(12, NULL),
(13, NULL),
(14, NULL),
(15, NULL),
(16, NULL),
(17, NULL),
(18, NULL),
(19, NULL),
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `ID` int(11) NOT NULL,
  `IdArticolo` int(11) NOT NULL,
  `IdUtente` int(11) NOT NULL,
  `AcquistoVerificato` tinyint(1) NOT NULL DEFAULT 0,
  `nome` varchar(32) NOT NULL,
  `testo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `contiene`
--

CREATE TABLE `contiene` (
  `ID` int(11) NOT NULL,
  `IdArticolo` int(11) NOT NULL,
  `IdCarrello` int(11) NOT NULL,
  `quantita` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `contiene`
--

INSERT INTO `contiene` (`ID`, `IdArticolo`, `IdCarrello`, `quantita`) VALUES
(1, 1, 19, 1),
(2, 2, 19, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `imgsrc`
--

CREATE TABLE `imgsrc` (
  `ID` int(11) NOT NULL,
  `IDarticolo` int(11) NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `imgsrc`
--

INSERT INTO `imgsrc` (`ID`, `IDarticolo`, `source`) VALUES
(1, 2, 'product01.png'),
(2, 2, 'product03.png'),
(3, 3, 'product02.png'),
(4, 3, 'product05.png'),
(5, 1, 'Login.png'),
(6, 4, 'shop01.png'),
(7, 4, 'product03.png'),
(8, 5, 'product04.png'),
(9, 5, 'product07.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzo`
--

CREATE TABLE `indirizzo` (
  `ID` int(11) NOT NULL,
  `IdUtente` int(11) NOT NULL,
  `stato` varchar(64) NOT NULL,
  `provincia` varchar(64) NOT NULL,
  `citta` varchar(64) NOT NULL,
  `via` varchar(64) NOT NULL,
  `civico` int(5) NOT NULL,
  `cap` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `ID` int(11) NOT NULL,
  `IdCarrello` int(11) NOT NULL,
  `DataAcquisto` date NOT NULL,
  `OraAcquisto` time NOT NULL,
  `Prezzo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `ID` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `imgsrc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`ID`, `username`, `password`, `nome`, `cognome`, `admin`, `imgsrc`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', 1, '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Id` (`IdUtente`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idutentecarrello` (`IdUtente`),
  ADD KEY `idarticolo` (`IdArticolo`);

--
-- Indici per le tabelle `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IdArticolocontiene` (`IdArticolo`),
  ADD KEY `IDcarrello` (`IdCarrello`);

--
-- Indici per le tabelle `imgsrc`
--
ALTER TABLE `imgsrc`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idarticlo` (`IDarticolo`);

--
-- Indici per le tabelle `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDutenteIND` (`IdUtente`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDcarrelloORD` (`IdCarrello`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articoli`
--
ALTER TABLE `articoli`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `carrello`
--
ALTER TABLE `carrello`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `contiene`
--
ALTER TABLE `contiene`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `imgsrc`
--
ALTER TABLE `imgsrc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `indirizzo`
--
ALTER TABLE `indirizzo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `Id` FOREIGN KEY (`IdUtente`) REFERENCES `utente` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `idarticolo` FOREIGN KEY (`IdArticolo`) REFERENCES `articoli` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `idutentecarrello` FOREIGN KEY (`IdUtente`) REFERENCES `utente` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `IDcarrello` FOREIGN KEY (`IdCarrello`) REFERENCES `carrello` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdArticolocontiene` FOREIGN KEY (`IdArticolo`) REFERENCES `articoli` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `imgsrc`
--
ALTER TABLE `imgsrc`
  ADD CONSTRAINT `idarticlo` FOREIGN KEY (`IDarticolo`) REFERENCES `articoli` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD CONSTRAINT `IDutenteIND` FOREIGN KEY (`IdUtente`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `IDcarrelloORD` FOREIGN KEY (`IdCarrello`) REFERENCES `carrello` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
