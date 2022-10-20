-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 10 juil. 2021 à 23:20
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `coach_appointment`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_table`
--

DROP TABLE IF EXISTS `admin_table`;
CREATE TABLE IF NOT EXISTS `admin_table` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sallesport_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sallesport_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sallesport_contact_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sallesport_logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email_address`, `admin_password`, `admin_name`, `sallesport_name`, `sallesport_address`, `sallesport_contact_no`, `sallesport_logo`) VALUES
(1, 'ummto@gmail.com', 'password', 'Departement Informatique', 'Coach ME', 'Coach ME , Bastos , Tizi ouzou', '741287410', '../images/310577109.png');

-- --------------------------------------------------------

--
-- Structure de la table `appointment_table`
--

DROP TABLE IF EXISTS `appointment_table`;
CREATE TABLE IF NOT EXISTS `appointment_table` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `coach_schedule_id` int(11) NOT NULL,
  `appointment_number` int(11) NOT NULL,
  `reason_for_appointment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `appointment_time` time NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `client_come_into_sallesport` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
  `coach_comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `coach_id`, `client_id`, `coach_schedule_id`, `appointment_number`, `reason_for_appointment`, `appointment_time`, `status`, `client_come_into_sallesport`, `coach_comment`) VALUES
(1, 3, 4, 5, 1000, 'azdzadaz', '13:00:00', 'Cancel', 'No', ''),
(2, 1, 4, 2, 1001, 'Prise de masse ', '09:00:00', 'Booked', 'No', ''),
(3, 2, 4, 8, 1002, 'jkhgiuhiuhuoihopno', '09:30:00', 'Cancel', 'No', ''),
(4, 1, 4, 17, 1003, 'Perte de poid , renforcement musculaire', '16:20:00', 'Completed', 'Yes', 'Concentre toi sur ta nutrition, et pratique plus de cardio , tu as un gros potentiel.');

-- --------------------------------------------------------

--
-- Structure de la table `client_table`
--

DROP TABLE IF EXISTS `client_table`;
CREATE TABLE IF NOT EXISTS `client_table` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `client_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_date_of_birth` date NOT NULL,
  `client_gender` enum('Male','Female','Other') COLLATE utf8_unicode_ci NOT NULL,
  `client_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `client_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `client_maritial_status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `client_added_on` datetime NOT NULL,
  `client_verification_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verify` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client_table`
--

INSERT INTO `client_table` (`client_id`, `client_email_address`, `client_password`, `client_first_name`, `client_last_name`, `client_date_of_birth`, `client_gender`, `client_address`, `client_phone_no`, `client_maritial_status`, `client_added_on`, `client_verification_code`, `email_verify`) VALUES
(3, 'jacobmartin@gmail.com', 'password', 'Jacob', 'Martin', '2021-02-26', 'Male', 'Green view, 1025, NYC', '85745635210', 'Single', '2021-02-18 16:34:55', 'b1f3f8409f7687072adb1f1b7c22d4b0', 'Yes'),
(4, 'oliviabaker@gmail.com', 'password', 'Olivia', 'Baker', '2001-04-05', 'Female', 'Salle Tazrot , nouvelle ville ,Tizi ouzou', '7539518520', 'Single', '2021-02-19 18:28:23', '8902e16ef62a556a8e271c9930068fea', 'Yes'),

-- --------------------------------------------------------

--
-- Structure de la table `coach_schedule_table`
--

DROP TABLE IF EXISTS `coach_schedule_table`;
CREATE TABLE IF NOT EXISTS `coach_schedule_table` (
  `coach_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) NOT NULL,
  `coach_schedule_date` date NOT NULL,
  `coach_schedule_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') COLLATE utf8_unicode_ci NOT NULL,
  `coach_schedule_start_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `coach_schedule_end_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `average_consulting_time` int(5) NOT NULL,
  `coach_schedule_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`coach_schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `coach_schedule_table`
--

INSERT INTO `coach_schedule_table` (`coach_schedule_id`, `coach_id`, `coach_schedule_date`, `coach_schedule_day`, `coach_schedule_start_time`, `coach_schedule_end_time`, `average_consulting_time`, `coach_schedule_status`) VALUES
(2, 1, '2021-07-19', 'Friday', '09:00', '14:00', 55, 'Active'),
(3, 2, '2021-07-19', 'Friday', '09:00', '12:00', 30, 'Active'),
(4, 5, '2021-07-19', 'Friday', '10:00', '14:00', 50, 'Active'),
(5, 3, '2021-07-19', 'Friday', '13:00', '17:00', 35, 'Active'),
(6, 4, '2021-07-19', 'Friday', '15:00', '18:00', 35, 'Active'),
(7, 5, '2021-07-22', 'Monday', '18:00', '20:00', 75, 'Active'),
(8, 2, '2021-07-24', 'Wednesday', '09:30', '12:30', 40, 'Active'),
(9, 5, '2021-07-24', 'Wednesday', '11:00', '15:00', 65, 'Active'),
(10, 1, '2021-07-24', 'Wednesday', '12:00', '15:00', 30, 'Active'),
(11, 3, '2021-02-24', 'Wednesday', '14:00', '17:00', 50, 'Active'),
(12, 4, '2021-02-24', 'Wednesday', '16:00', '20:00', 45, 'Active'),
(13, 6, '2021-02-24', 'Wednesday', '15:30', '18:30', 60, 'Active'),
(14, 6, '2021-02-25', 'Thursday', '10:00', '13:30', 40, 'Active'),
(15, 5, '2021-07-15', 'Thursday', '10:00', '14:00', 30, 'Active'),
(16, 7, '2021-07-13', 'Tuesday', '08:30', '10:30', 30, 'Active'),
(17, 1, '2021-07-10', 'Saturday', '16:20', '17:20', 30, 'Active');

-- --------------------------------------------------------

--
-- Structure de la table `coach_table`
--

DROP TABLE IF EXISTS `coach_table`;
CREATE TABLE IF NOT EXISTS `coach_table` (
  `coach_id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `coach_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `coach_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `coach_profile_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `coach_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `coach_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `coach_date_of_birth` date NOT NULL,
  `coach_degree` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `coach_expert_in` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `coach_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `coach_added_on` datetime NOT NULL,
  PRIMARY KEY (`coach_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `coach_table`
--

INSERT INTO `coach_table` (`coach_id`, `coach_email_address`, `coach_password`, `coach_name`, `coach_profile_image`, `coach_phone_no`, `coach_address`, `coach_date_of_birth`, `coach_degree`, `coach_expert_in`, `coach_status`, `coach_added_on`) VALUES
(1, 'himeuramayas@gmail.com', 'password', 'Himeur Amayas', '../images/1515691155.jpg', '7539518520', 'Genisider , nouvelle ville , tizi ouzou', '1985-10-29', 'Le BPJEPS et le STAPS', 'Bodybuilder', 'Active', '2021-02-15 17:04:59'),
(2, 'bentayebamine@gmail.com', 'password', 'Bentayeb Amine', '../images/2127095816.jpg', '753852963', 'EPLF , nouvelle ville , Tizi ouzou', '1982-08-10', 'La liscence STAPS', 'Calisthenics', 'Active', '2021-02-18 15:00:32'),
(3, 'mesbahleticia@gmail.com', 'password', 'Mesbah Leticia', '../images/1688904768.jpg', '7417417410', 'Les 600,nouvelle ville , Tizi ouzou', '1989-04-03', 'Le diplome de kinesitherapeute et STAPS', 'Nutrisionniste', 'Active', '2021-02-18 15:05:02'),
(4, 'idirwalid@gmail.com', 'password', 'Mesbah Leticia', '../images/1956673987.jpg', '8523698520', 'Lotissement Salhi , Tizi ouzou', '1984-06-11', 'La liscence STAPS et BPJEPS', 'Nutrisionniste', 'Active', '2021-02-18 15:08:24'),
(5, 'lahcenerayane@gmail.com', 'password', 'Lahcene Rayane', '../images/1994566981.jpg', '9635852025', 'rdjaouna , Tizi ouzou', '1988-03-03', 'La liscence STAPS', 'Bodybuilder', 'Active', '2021-02-18 15:15:23'),
(6, 'berchichenazim@gmail.com', 'password', 'Berchiche Nazim', '../images/1501914992.jpg', '8523697410', 'Hemki , Nouvelle ville , Tizi Ouzou', '1989-03-01', 'La liscence STAPS', 'Crossfit', 'Active', '2021-02-23 17:26:16');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT,
  `nom_contact` varchar(255) NOT NULL,
  `prenom_contact` varchar(255) NOT NULL,
  `email_contact` varchar(255) NOT NULL,
  `sujet_contact` varchar(255) NOT NULL,
  `message_contact` text NOT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom_contact`, `prenom_contact`, `email_contact`, `sujet_contact`, `message_contact`) VALUES
(1, 'mayas', 'amayas', 'adazda@live', 'pleinte', 'azdazdazdopkazop^kdpoazkdpoakzdokzaopdkazpodkaz');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`) VALUES
(1, 'Halteres 2Kg', 'halteres2kg.jpeg', '800'),
(2, 'Halteres 5kg', 'halteres5kg.jpeg', '1800'),
(3, 'Tapis bleu', 'tapisBleu.jpeg', '2500'),
(4, 'Tapis Noir', 'tapisNoir.jpeg', '2500'),
(5, 'Shaker', 'shaker.jpeg', '750'),
(6, 'Whey Gold', 'wheyGold.jpeg', '12000'),
(7, '', 'wheyHydro.jpeg', '13000'),
(8, 'BCAA', 'bcaa.jpeg', '6000');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
