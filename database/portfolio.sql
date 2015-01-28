-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 14 mrt 2014 om 10:30
-- Serverversie: 5.6.12-log
-- PHP-versie: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `portfolio`
--
CREATE DATABASE IF NOT EXISTS `portfolio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `portfolio`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `idBlog` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(100) NOT NULL,
  `inhoud` longtext NOT NULL,
  `datum` datetime NOT NULL,
  `Gebruikers_idGebruikers` int(11) NOT NULL,
  `status_idstatus` int(11) NOT NULL,
  PRIMARY KEY (`idBlog`),
  KEY `fk_Blog_Gebruikers1_idx` (`Gebruikers_idGebruikers`),
  KEY `fk_Blog_status1_idx` (`status_idstatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden uitgevoerd voor tabel `blog`
--

INSERT INTO `blog` (`idBlog`, `titel`, `inhoud`, `datum`, `Gebruikers_idGebruikers`, `status_idstatus`) VALUES
(1, 'Test', 'Test', '2014-03-04 00:00:00', 1, 1),
(2, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.\r\n\r\nEtiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia.', '2014-03-04 00:00:00', 1, 1),
(4, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia.', '2014-03-12 17:20:30', 1, 1),
(5, 'Error 404', 'JASKLDNAJXNZXJKBBASDASDZXCKJZXCLJIADO', '2014-03-12 19:50:16', 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `documenten`
--

CREATE TABLE IF NOT EXISTS `documenten` (
  `idDocumenten` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `mimetype` varchar(45) NOT NULL,
  `directory` varchar(45) NOT NULL,
  `Projecten_idProjecten` int(11) DEFAULT NULL,
  `Onderdelen_idOnderdelen` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDocumenten`),
  KEY `fk_Documenten_Onderdelen1_idx` (`Onderdelen_idOnderdelen`),
  KEY `fk_Documenten_Projecten1_idx` (`Projecten_idProjecten`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `idGebruikers` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `reset_ww` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `Groep_idGroep` int(11) NOT NULL,
  `geb_datum` int(11) NOT NULL,
  `beschrijving` longtext,
  PRIMARY KEY (`idGebruikers`),
  KEY `fk_Gebruikers_Groep_idx` (`Groep_idGroep`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`idGebruikers`, `naam`, `username`, `password`, `reset_ww`, `email`, `Groep_idGroep`, `geb_datum`, `beschrijving`) VALUES
(1, 'Liam Boer', 'Liam', '9f4257a2b5d50978b7f7b415c960e87e63e937e0', NULL, 'liam_boer@hotmail.com', 2, 855792000, 'Liam\r\n'),
(2, 'Jaap B.', 'Jaapq', 'f10e2821bbbea527ea02200352313bc059445190', NULL, 'asdz@asd', 1, 0, 'qq'),
(3, 'Sjaak ', 'Sjaak', 'f10e2821bbbea527ea02200352313bc059445190', NULL, 'sjaak@sjaak', 1, 0, ''),
(5, 'qweqwe', 'weqweqe', '356a192b7913b04c54574d18c28d46e6395428ab', NULL, 'qwe@qwe', 1, 0, '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groep`
--

CREATE TABLE IF NOT EXISTS `groep` (
  `idGroep` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`idGroep`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `groep`
--

INSERT INTO `groep` (`idGroep`, `naam`) VALUES
(1, 'Gebruiker'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `onderdelen`
--

CREATE TABLE IF NOT EXISTS `onderdelen` (
  `idOnderdelen` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `begin` date NOT NULL,
  `eind` date NOT NULL,
  `beschrijving` longtext NOT NULL,
  `Projecten_idProjecten` int(11) NOT NULL,
  PRIMARY KEY (`idOnderdelen`),
  KEY `fk_Onderdelen_Projecten1_idx` (`Projecten_idProjecten`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pagina`
--

CREATE TABLE IF NOT EXISTS `pagina` (
  `paginaid` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `bestand` varchar(45) NOT NULL,
  PRIMARY KEY (`paginaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden uitgevoerd voor tabel `pagina`
--

INSERT INTO `pagina` (`paginaid`, `naam`, `bestand`) VALUES
(1, 'Content', 'content.php'),
(2, 'registratie', 'registratie.php'),
(3, 'Login', 'login.php'),
(4, 'Logout', 'logout.php'),
(5, 'Admin Gebruikers', 'admin_gebruikers.php'),
(6, 'Admin Blog', 'admin_blog.php'),
(7, 'Blog', 'blog.php'),
(8, 'Project', 'project.php'),
(9, 'Admin Project', 'admin_project.php');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projecten`
--

CREATE TABLE IF NOT EXISTS `projecten` (
  `idProjecten` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `inhoud` longtext NOT NULL,
  `Gebruikers_idGebruikers` int(11) NOT NULL,
  PRIMARY KEY (`idProjecten`),
  KEY `fk_Projecten_Gebruikers1_idx` (`Gebruikers_idGebruikers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `projecten`
--

INSERT INTO `projecten` (`idProjecten`, `naam`, `startdate`, `enddate`, `inhoud`, `Gebruikers_idGebruikers`) VALUES
(2, 'Portfolio', '2014-03-01', '2014-03-05', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 1),
(6, 'Bla', '2014-03-14', '2014-03-14', 'Bla', 1),
(7, 'Project ', '2014-03-14', '2014-03-14', 'Project 3', 1),
(9, '111', '1111-11-11', '1111-11-11', '1111', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reacties`
--

CREATE TABLE IF NOT EXISTS `reacties` (
  `idReacties` int(11) NOT NULL AUTO_INCREMENT,
  `inhoud` longtext NOT NULL,
  `datum` datetime NOT NULL,
  `Gebruikers_idGebruikers` int(11) NOT NULL,
  `Blog_idBlog` int(11) NOT NULL,
  PRIMARY KEY (`idReacties`),
  KEY `fk_Reacties_Blog1_idx` (`Blog_idBlog`),
  KEY `fk_Reacties_Gebruikers1_idx` (`Gebruikers_idGebruikers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `reacties`
--

INSERT INTO `reacties` (`idReacties`, `inhoud`, `datum`, `Gebruikers_idGebruikers`, `Blog_idBlog`) VALUES
(1, 'asd', '2014-03-12 12:21:34', 1, 1),
(2, 'Ja', '2014-03-12 12:31:17', 1, 2),
(9, 'Test Reactie HUEHUE', '2014-03-12 17:20:48', 1, 4),
(10, '&#12541;&#3900;&#3720;&#1604;&#860;&#3720;&#3901;&#65417; raise your dongers &#12541;&#3900;&#3720;&#1604;&#860;&#3720;&#3901;&#65417;', '2014-03-12 17:21:08', 1, 2),
(11, '&#12541;&#3900;&#3720;&#1604;&#860;&#3720;&#3901;&#65417; raise your dongers &#12541;&#3900;&#3720;&#1604;&#860;&#3720;&#3901;&#65417;', '2014-03-12 17:21:19', 1, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `idstatus` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`idstatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `status`
--

INSERT INTO `status` (`idstatus`, `naam`) VALUES
(1, 'Zichtbaar'),
(2, 'Niet zichtbaar');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`Gebruikers_idGebruikers`) REFERENCES `gebruikers` (`idGebruikers`),
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`status_idstatus`) REFERENCES `status` (`idstatus`);

--
-- Beperkingen voor tabel `documenten`
--
ALTER TABLE `documenten`
  ADD CONSTRAINT `documenten_ibfk_1` FOREIGN KEY (`Onderdelen_idOnderdelen`) REFERENCES `onderdelen` (`idOnderdelen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documenten_ibfk_2` FOREIGN KEY (`Projecten_idProjecten`) REFERENCES `projecten` (`idProjecten`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD CONSTRAINT `gebruikers_ibfk_1` FOREIGN KEY (`Groep_idGroep`) REFERENCES `groep` (`idGroep`);

--
-- Beperkingen voor tabel `onderdelen`
--
ALTER TABLE `onderdelen`
  ADD CONSTRAINT `onderdelen_ibfk_1` FOREIGN KEY (`Projecten_idProjecten`) REFERENCES `projecten` (`idProjecten`);

--
-- Beperkingen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD CONSTRAINT `projecten_ibfk_1` FOREIGN KEY (`Gebruikers_idGebruikers`) REFERENCES `gebruikers` (`idGebruikers`);

--
-- Beperkingen voor tabel `reacties`
--
ALTER TABLE `reacties`
  ADD CONSTRAINT `reacties_ibfk_1` FOREIGN KEY (`Blog_idBlog`) REFERENCES `blog` (`idBlog`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reacties_ibfk_2` FOREIGN KEY (`Gebruikers_idGebruikers`) REFERENCES `gebruikers` (`idGebruikers`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
