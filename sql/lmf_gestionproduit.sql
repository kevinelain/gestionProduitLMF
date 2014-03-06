-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 05 Mars 2014 à 20:11
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `lmf_gestionproduit`
--
CREATE DATABASE IF NOT EXISTS `lmf_gestionproduit` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lmf_gestionproduit`;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE IF NOT EXISTS `fournisseur` (
  `FOU_ID` int(10) NOT NULL,
  `FOU_RAISONSOC` varchar(30) NOT NULL,
  `FOU_SIRET` varchar(14) NOT NULL,
  `FOU_TELEPHONE` varchar(10) NOT NULL,
  `FOU_NUMERORUE` int(3) NOT NULL,
  `FOU_NOMRUE` varchar(20) NOT NULL,
  `FOU_COPOS` varchar(5) NOT NULL,
  `FOU_VILLE` varchar(25) NOT NULL,
  PRIMARY KEY (`FOU_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`FOU_ID`, `FOU_RAISONSOC`, `FOU_SIRET`, `FOU_TELEPHONE`, `FOU_NUMERORUE`, `FOU_NOMRUE`, `FOU_COPOS`, `FOU_VILLE`) VALUES
(1, 'La Ferme Monsieur Seguin', '39982698100017', '231641929', 12, 'Rue de la Campagne', '56000', 'Kermadek'),
(2, 'Intermarché', '52147896321020', '231645050', 50, 'Route de Rouen', '14130', 'Pont L''Evêque'),
(3, 'Bricomarché', '45210256392101', '231646869', 14, 'Place Henri Lemarcha', '14130', 'Pont L''Evêque'),
(4, 'Ikéa', '45201236487412', '0234313738', 91, 'rue Jean Michel Jarr', '93215', 'Nowhere');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `PRO_ID` int(10) NOT NULL,
  `PRO_REF` varchar(20) NOT NULL,
  `PRO_NOM` varchar(50) NOT NULL,
  `PRO_PRIX` decimal(10,2) NOT NULL,
  `PRO_POIDS` decimal(15,3) NOT NULL,
  `PRO_DATE` date NOT NULL,
  `PRO_FOU` int(10) NOT NULL,
  PRIMARY KEY (`PRO_ID`),
  KEY `FK_PRODUIT_FOURNISSEUR` (`PRO_FOU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`PRO_ID`, `PRO_REF`, `PRO_NOM`, `PRO_PRIX`, `PRO_POIDS`, `PRO_DATE`, `PRO_FOU`) VALUES
(1, 'AA001', 'Farine', '12.19', '20.000', '2014-02-11', 1),
(2, 'AA002', 'Oeuf', '8.12', '1.000', '2014-02-26', 1),
(3, 'BB001', 'Tablette chocolat', '10.15', '14.120', '2014-02-27', 1),
(4, 'BB004', 'Jambon', '8.18', '5.210', '2014-02-24', 1),
(5, 'BB002', 'Jambon', '14.20', '5.210', '2014-03-01', 1),
(6, 'BB003', 'Jambon', '14.99', '5.210', '2014-02-26', 1),
(7, 'BB005', 'Jambon', '14.20', '5.210', '2014-02-26', 4),
(8, 'BB123', 'Ustensile cuisine - rouleau patisserie', '54.00', '0.200', '2014-03-03', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Use_Num` int(11) NOT NULL AUTO_INCREMENT,
  `Use_Nom` varchar(50) NOT NULL,
  `Use_Hash` char(128) NOT NULL,
  PRIMARY KEY (`Use_Num`),
  KEY `HASH_FK` (`Use_Hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`Use_Num`, `Use_Nom`, `Use_Hash`) VALUES
(1, 'root', '6779bcb1f994927795f01178c45b345a36cdabef683618d11e85489441482dd55ad241d920b466418c5b865a4f96aa0fd1cd76a206f66e58de650bb3d16a9806');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_PRODUIT_FOURNISSEUR` FOREIGN KEY (`PRO_FOU`) REFERENCES `fournisseur` (`FOU_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
