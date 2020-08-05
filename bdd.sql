-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 05 août 2020 à 11:50
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `udemy_animaux`
--

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `animal_id` int(11) NOT NULL,
  `animal_name` varchar(250) NOT NULL,
  `animal_description` text NOT NULL,
  `animal_picture_small` varchar(250) NOT NULL,
  `animal_picture_large` varchar(250) NOT NULL,
  `family_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`animal_id`, `animal_name`, `animal_description`, `animal_picture_small`, `animal_picture_large`, `family_id`) VALUES
(1, 'Singe', 'Les singes sont des mammifères de l\'ordre des primates, généralement arboricoles, à la face souvent glabre et caractérisés par un encéphale développé et de longs membres terminés par des doigts.', 'singe-640x426.jpg', 'singe-1920x1280.jpg', 1),
(2, 'Ours', 'L’ours brun (Ursus arctos) est une espèce d’ours qui peut atteindre des masses de 130 à 700 kg. Le grizzli, l’ours kodiak et l’ours brun mexicain sont des sous-espèces nord-américaines de l’ours brun, l\'Ours brun d\'Europe la principale sous-espèce eurasienne avec de multiples autres sous-espèces comme l\'Ours Isabelle.', 'ours-640x426.jpg', 'ours-1920x1280.jpg', 1),
(3, 'Piranha', 'Les piranhas se regroupent en bancs pour attaquer une proie plus grosse qu\'eux. Ils n\'en restent pas moins souvent solitaires, quelle que soit leur taille. Leur longueur moyenne est d\'environ 15 à 25 cm ; ils peuvent cependant être plus grand.', 'piranha-640x426.jpg', 'piranha-1920x1280.jpg', 3),
(4, 'Python royal', 'Espèce de serpent de la famille des Pythonidae.', 'python-640x426.jpg', 'python-1920x1280.jpg', 2),
(5, 'Lion', 'Le lion (Panthera leo) est une espèce de mammifères carnivores de la famille des félidés.', 'lion-640x426.jpg', 'lion-1920x1280.jpg', 1),
(6, 'girafe', 'La girafe (nom scientifique : Giraffa camelopardalis) est un mammifère. ', 'girafe-640x426.jpg', 'girafe-1920x1280.jpg', 1),
(7, 'Boa', 'Le mot boa est un terme du vocabulaire qui désigne plusieurs espèces de serpents carnivores constricteurs.', 'boa-640x426.jpg', 'boa-1920x1280.jpg', 2),
(8, 'Baleine', 'Les baleines sont des mammifères marins de l\'ordre des cétacés, comme les dauphins.', 'baleine-640x426.jpg', 'baleine-1920x1280.jpg', 1),
(9, 'Requin', 'Les requins, squales ou sélachimorphes forment un super-ordre de poissons cartilagineux.', 'requin-640x426.jpg', 'requin-1920x1280.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `animal_continent`
--

CREATE TABLE `animal_continent` (
  `animal_id` int(11) NOT NULL,
  `continent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animal_continent`
--

INSERT INTO `animal_continent` (`animal_id`, `continent_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(3, 3),
(3, 5),
(4, 3),
(4, 5),
(5, 3),
(6, 3),
(7, 3),
(7, 5),
(8, 4),
(9, 2),
(9, 5);

-- --------------------------------------------------------

--
-- Structure de la table `continent`
--

CREATE TABLE `continent` (
  `continent_id` int(11) NOT NULL,
  `continent_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `continent`
--

INSERT INTO `continent` (`continent_id`, `continent_name`) VALUES
(1, 'Europe'),
(2, 'Asie'),
(3, 'Afrique'),
(4, 'Océanie'),
(5, 'Amériques');

-- --------------------------------------------------------

--
-- Structure de la table `family`
--

CREATE TABLE `family` (
  `family_id` int(11) NOT NULL,
  `family_name` varchar(250) NOT NULL,
  `family_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `family`
--

INSERT INTO `family` (`family_id`, `family_name`, `family_description`) VALUES
(1, 'mamifères', 'Animaux vertébrés nourrissant leurs petits avec du lait'),
(2, 'reptile', 'Animaux vertébrés qui rampent.'),
(3, 'poissons', 'Animaux invertébrés du monde aquatique.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animal_id`),
  ADD KEY `FK_ANIMAL_FAMILY` (`family_id`);

--
-- Index pour la table `animal_continent`
--
ALTER TABLE `animal_continent`
  ADD PRIMARY KEY (`animal_id`,`continent_id`),
  ADD KEY `FK_CONTINENT_ANIMAL_CONTINENT` (`continent_id`);

--
-- Index pour la table `continent`
--
ALTER TABLE `continent`
  ADD PRIMARY KEY (`continent_id`);

--
-- Index pour la table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`family_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `continent`
--
ALTER TABLE `continent`
  MODIFY `continent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `family`
--
ALTER TABLE `family`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `FK_ANIMAL_FAMILY` FOREIGN KEY (`family_id`) REFERENCES `family` (`family_id`);

--
-- Contraintes pour la table `animal_continent`
--
ALTER TABLE `animal_continent`
  ADD CONSTRAINT `FK_ANIMAL_ANIMAL_CONTINENT` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`animal_id`),
  ADD CONSTRAINT `FK_CONTINENT_ANIMAL_CONTINENT` FOREIGN KEY (`continent_id`) REFERENCES `continent` (`continent_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
