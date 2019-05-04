-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Maj 2019, 19:02
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ident_app`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ident`
--

CREATE TABLE `ident` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `name_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lastname` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `madeby` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `zone` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1250 COLLATE=cp1250_polish_ci;

--
-- Zrzut danych tabeli `ident`
--

INSERT INTO `ident` (`id`, `name`, `name_2`, `lastname`, `madeby`, `type`, `zone`) VALUES
(38, 'sdagdfs', 'dfsbg', 'xzvx', 'Tomek', 'strefowy', 'strefa 2'),
(39, 'asdgdfsg', 'hrthr', 'hrtyhrtdf', 'Tomek', 'gastro', ''),
(40, 'gsghgfh', 'yjtyjt', 'gfjghfjghj', 'Tomek', 'bezstrefowy', ''),
(41, 'deghdrfsegh', '', '', 'Tomek', 'wjazdowy', ''),
(42, 'gregre', 'dgdsf', 'xbvcb', 'Tomek', 'strefowy', 'strefa 3'),
(43, 'enej', 'enej', 'fgdf', 'Tomek', 'strefowy', 'strefa 2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `idents`
--
-- Błąd odczytu struktury tabeli ident_app.idents: #1932 - Table 'ident_app.idents' doesn't exist in engine
-- Błąd odczytu danych dla tabeli ident_app.idents: #1064 - Something is wrong in your syntax obok 'FROM `ident_app`.`idents`' w linii 1

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ident_type`
--

CREATE TABLE `ident_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `background` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `type_2` varchar(25) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT 'Identyfikator bezstrefowy',
  `comment` varchar(160) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `madeby` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1250 COLLATE=cp1250_polish_ci;

--
-- Zrzut danych tabeli `ident_type`
--

INSERT INTO `ident_type` (`id`, `type`, `background`, `type_2`, `comment`, `madeby`) VALUES
(1, 'bezstrefowy', 'ident_backgrounds/Przechwytywanie.PNG', 'Identyfikator bezstrefowy', '', 'Tomek'),
(2, 'strefowy', 'ident_backgrounds/Przechwytywanie.PNG', 'Identyfikator strefowy', '', 'Tomek'),
(3, 'wjazdowy', 'ident_backgrounds/Przechwytywanie.PNG', 'WjazdÃ³wka', '', 'Tomek'),
(4, 'asdfasf', 'ident_backgrounds/Przechwytywanie.PNG', '', 'dshfdgh', ''),
(5, 'gastro', 'ident_backgrounds/Przechwytywanie.PNG', 'Identyfikator bezstrefowy', '', 'Tomek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`) VALUES
(1, 'admin', 'admin123', 'admin@admin.pl'),
(2, 'Asia', '$2y$10$ELvs2r3P5lQdrx1BB40qpu2dFaoSoxTIOhTtJtO1ye7K9Ysf4q6sq', 'asia@asia.pl'),
(3, 'Tomek', '$2y$10$Jw9rZfWMN/OODgcbLkLnHOdSwPLk..j/QTu5.aPQQt9XN0i4gwJ16', 'tomek@tomek.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zone`
--

CREATE TABLE `zone` (
  `id` int(11) NOT NULL,
  `zone` varchar(20) COLLATE cp1250_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1250 COLLATE=cp1250_polish_ci;

--
-- Zrzut danych tabeli `zone`
--

INSERT INTO `zone` (`id`, `zone`) VALUES
(1, 'strefa 1'),
(2, 'strefa 2'),
(3, 'strefa 3'),
(4, 'strefa 4'),
(6, 'strefa 51');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ident`
--
ALTER TABLE `ident`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ident_type`
--
ALTER TABLE `ident_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `ident`
--
ALTER TABLE `ident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT dla tabeli `ident_type`
--
ALTER TABLE `ident_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
