-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 mai 2024 à 11:06
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eco_cook`
--

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

DROP TABLE IF EXISTS `etapes`;
CREATE TABLE IF NOT EXISTS `etapes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `recette_id` int DEFAULT NULL,
  `num_etape` int DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `recette_id` (`recette_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=274 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom`) VALUES
(1, 'Ail'),
(2, 'Oignon'),
(3, 'Tomate'),
(4, 'Carotte'),
(5, 'Céleri'),
(6, 'Poivron vert'),
(7, 'Poivron rouge'),
(8, 'Chou'),
(9, 'Brocoli'),
(10, 'Chou-fleur'),
(11, 'Épinard'),
(12, 'Laitue'),
(13, 'Pomme de terre'),
(14, 'Patate douce'),
(15, 'Courgette'),
(16, 'Aubergine'),
(17, 'Concombre'),
(18, 'Avocat'),
(19, 'Champignons'),
(20, 'Citron'),
(21, 'Lime'),
(22, 'Orange'),
(23, 'Banane'),
(24, 'Pomme'),
(25, 'Poire'),
(26, 'Pêche'),
(27, 'Mangue'),
(28, 'Framboise'),
(29, 'Fraise'),
(30, 'Myrtille'),
(31, 'Kiwi'),
(32, 'Noix'),
(33, 'Amande'),
(34, 'Cacahuète'),
(35, 'Pistache'),
(36, 'Lait'),
(37, 'Beurre'),
(38, 'Crème'),
(39, 'Fromage'),
(40, 'Œuf'),
(41, 'Boeuf'),
(42, 'Porc'),
(43, 'Poulet'),
(44, 'Dinde'),
(45, 'Saumon'),
(46, 'Truite'),
(47, 'Thon'),
(48, 'Crevette'),
(49, 'Moule'),
(50, 'Huile olive'),
(51, 'Vinaigre'),
(52, 'Sel'),
(53, 'Poivre'),
(54, 'Basilic'),
(55, 'Persil'),
(56, 'Coriandre'),
(57, 'Romarin'),
(58, 'Thym'),
(59, 'Cannelle'),
(60, 'Muscade'),
(61, 'Gingembre'),
(62, 'Curcuma'),
(63, 'Cumin'),
(64, 'Paprika'),
(65, 'Safran'),
(66, 'Piment'),
(67, 'Miel'),
(68, 'Sucre'),
(69, 'Farine'),
(70, 'Levure'),
(71, 'Bicarbonate de soude'),
(72, 'Chocolat'),
(73, 'Vanille'),
(74, 'Artichaut'),
(75, 'Asperge'),
(76, 'Bette à carde'),
(77, 'Radis'),
(78, 'Endive'),
(79, 'Fenouil'),
(80, 'Haricot vert'),
(81, 'Pois chiche'),
(82, 'Lentille'),
(83, 'Quinoa'),
(84, 'Boulgour'),
(85, 'Sarrasin'),
(86, 'Tofu'),
(87, 'Tempeh'),
(88, 'Seitan'),
(89, 'Agneau'),
(90, 'Veau'),
(91, 'Canard'),
(92, 'Gibier à poil'),
(93, 'Gibier à plume'),
(94, 'Foie'),
(95, 'Coquille Saint-Jacques'),
(96, 'Calmar'),
(97, 'Poulpe'),
(98, 'Crabe'),
(99, 'Homard'),
(100, 'Escargot'),
(101, 'Huile de noix de coco'),
(102, 'Huile de sésame'),
(103, 'Vinaigre balsamique'),
(104, 'Vinaigre de cidre'),
(105, 'Sauce soja'),
(106, 'Sauce Worcestershire'),
(107, 'Tahini'),
(108, 'Moutarde'),
(109, 'Ketchup'),
(110, 'Mayonnaise'),
(111, 'Sauce barbecue'),
(112, 'Sauce hoisin'),
(113, 'Lait de coco'),
(114, 'Crème de soja'),
(115, 'Lait amande'),
(116, 'Lait de riz'),
(117, 'Lait avoine'),
(118, 'Fromage de chèvre'),
(119, 'Fromage bleu'),
(120, 'Mozzarella'),
(121, 'Parmesan'),
(122, 'Gruyère'),
(123, 'Emmental'),
(124, 'Camembert'),
(125, 'Brie'),
(126, 'Ricotta'),
(127, 'Gorgonzola'),
(128, 'Aneth'),
(129, 'Ciboulette'),
(130, 'Estragon'),
(131, 'Laurier'),
(132, 'Marjolaine'),
(133, 'Sauge'),
(134, 'Curry en poudre'),
(135, 'Cardamome'),
(136, 'Clou de girofle'),
(137, 'Anis étoilé'),
(138, 'Graines de fenouil'),
(139, 'Graines de coriandre'),
(140, 'Graines de moutarde'),
(141, 'Graines de sésame'),
(142, 'Graines de pavot'),
(143, 'Graines de tournesol'),
(144, 'Graines de chia'),
(145, 'Graines de lin'),
(146, 'Graines de nigelle'),
(147, 'Sirop érable'),
(148, 'Sirop agave'),
(149, 'Sucre de canne'),
(150, 'Sucre glace'),
(151, 'Sucre brun'),
(152, 'Mélasse'),
(153, 'Maïzena'),
(154, 'Fécule de pomme de terre'),
(155, 'Pâte de tomate'),
(156, 'Extrait de malt'),
(157, 'Semoule'),
(158, 'Couscous'),
(159, 'Riz basmati'),
(160, 'Riz jasmin'),
(161, 'Riz arborio'),
(162, 'Riz sauvage'),
(163, 'Riz noir'),
(164, 'Raifort'),
(165, 'Wasabi'),
(166, 'Algues'),
(167, 'Nori'),
(168, 'Wakame'),
(169, 'Kombu'),
(170, 'Taro'),
(171, 'Yucca'),
(172, 'Plantain'),
(173, 'Arrow-root'),
(174, 'Pois mange-tout'),
(175, 'Haricot mungo'),
(176, 'Soja vert'),
(177, 'Soja noir'),
(178, 'Soja jaune'),
(179, 'Fève'),
(180, 'Pois cassés'),
(181, 'Rutabaga'),
(182, 'Navet'),
(183, 'Panais'),
(184, 'Salsifis'),
(185, 'Igname'),
(186, 'Chayote'),
(187, 'Malanga'),
(188, 'Topinambour'),
(189, 'Fruits de la passion'),
(190, 'Durian'),
(191, 'Papaye'),
(192, 'Ramboutan'),
(193, 'Litchi'),
(194, 'Kumquat'),
(195, 'Fruit du dragon'),
(196, 'Tamarin'),
(197, 'Jicama'),
(198, 'Coing'),
(199, 'Figues'),
(200, 'Datte'),
(201, 'Prune'),
(202, 'Abricot'),
(203, 'Nectarine'),
(204, 'Cassis'),
(205, 'Groseille'),
(206, 'Canneberge'),
(207, 'Arachide'),
(208, 'Noix de cajou'),
(209, 'Noix de macadamia'),
(210, 'Noix du Brésil'),
(211, 'Noix de pécan'),
(212, 'Noix de coco'),
(213, 'Huile arachide'),
(214, 'Huile de canola'),
(215, 'Huile avocat'),
(216, 'Huile de graines de raisin'),
(217, 'Sauce teriyaki'),
(218, 'Sauce ponzu'),
(219, 'Sauce chili'),
(220, 'Sauce sriracha'),
(221, 'Sauce harissa'),
(222, 'Miso'),
(223, 'Doufu fermenté'),
(224, 'Kimchi'),
(225, 'Choucroute'),
(226, 'Tempeh fermenté'),
(227, 'Kéfir'),
(228, 'Lait fermenté'),
(229, 'Yogourt'),
(230, 'Skyr'),
(231, 'Ghee'),
(232, 'Paneer'),
(233, 'Feta'),
(234, 'Halloumi'),
(235, 'Pecorino'),
(236, 'Roquefort'),
(237, 'Stilton'),
(238, 'Munster'),
(239, 'Livarot'),
(240, 'Taleggio'),
(241, 'Burrata'),
(242, 'Stracciatella'),
(243, 'Mozzarella di bufala'),
(244, 'Ail noir'),
(245, 'Chou kale'),
(246, 'Micro-pousses'),
(247, 'Herbes de Provence'),
(248, 'Za atar'),
(249, 'Sumac'),
(250, 'Ras el hanout'),
(251, 'Garam masala'),
(252, 'Tandoori masala'),
(253, 'Berbéré'),
(254, 'Baharat'),
(255, 'Poivre de Sichuan'),
(256, 'Poivre blanc'),
(257, 'Poivre vert'),
(258, 'Fleur de sel'),
(259, 'Sel rose de Himalaya'),
(260, 'Sel fumé'),
(261, 'Sucre de coco'),
(262, 'Sucre de palme'),
(263, 'Agar-agar'),
(264, 'Gélatine'),
(265, 'Pectine'),
(266, 'Gluten de blé vital'),
(267, 'Seitan'),
(268, 'Levure nutritionnelle'),
(269, 'Maltodextrine'),
(270, 'Dextrose'),
(271, 'Sorbitol'),
(272, 'Xylitol'),
(273, 'Stevia');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `recette_id` int DEFAULT NULL,
  `url_photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recette_id` (`recette_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id`, `recette_id`, `url_photo`) VALUES
(1, 2, 'uploads/EcoCook.png'),
(2, 3, 'uploads/Capture d\'écran 2023-09-14 134410.png');

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

DROP TABLE IF EXISTS `recettes`;
CREATE TABLE IF NOT EXISTS `recettes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) DEFAULT NULL,
  `description` text,
  `temps_preparation` int DEFAULT NULL,
  `temps_cuisson` int DEFAULT NULL,
  `nombre_personnes` int DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`id`, `titre`, `description`, `temps_preparation`, `temps_cuisson`, `nombre_personnes`, `date_ajout`, `utilisateur_id`) VALUES
(1, 'dzdz', 'zdzd', 10, 4, 4, '2024-05-11 03:07:24', 1),
(2, 'trgzgz', 'fzfz', 40, 10, 4, '2024-05-11 03:20:49', 1),
(3, 'prout', '\'\'g\'grf', 20, 4, 4, '2024-05-27 12:57:44', 1);

-- --------------------------------------------------------

--
-- Structure de la table `recette_ingredients`
--

DROP TABLE IF EXISTS `recette_ingredients`;
CREATE TABLE IF NOT EXISTS `recette_ingredients` (
  `recette_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  `quantite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`recette_id`,`ingredient_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_util` int NOT NULL AUTO_INCREMENT,
  `mail_util` varchar(100) NOT NULL,
  `mdp_util` varchar(255) NOT NULL,
  `pseudo_util` varchar(50) NOT NULL,
  PRIMARY KEY (`id_util`),
  UNIQUE KEY `mail_util` (`mail_util`),
  UNIQUE KEY `pseudo_util` (`pseudo_util`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_util`, `mail_util`, `mdp_util`, `pseudo_util`) VALUES
(2, 'test@gmail.com', '$2y$10$3qAUaHcbuxkXKAD1o8MEpOSBI/0ATEr6exIKOaleTonGt4F0sPuYW', 'Test1'),
(3, 'admin@gmail.com', '$2y$10$oDqyxAwwEHAL0NyJ8R9gR.5.zX4tKp/bwP.KxgBFIOtjoe2umFiHG', 'admin'),
(4, 're@gmail.com', '$2y$10$L07E0j4xggXIUpdx6ilgmOBg7y2GoM/17zj.EA5.Z.jfFgop6urRy', 're'),
(5, 'stepanmereniuk@gmail.com', '$2y$10$pUQv0R/LzGuKZyFohZbifuC67sViXYQpin24iAedkIeVjl2EISWzy', 'stepan'),
(6, 'sabrina@gmail.com', '$2y$10$K.m4G6Lf7b4GMCgRek0/weLLWzRyzY68sjt2PaLhLKe/K6BaBpx56', 'sabrina'),
(7, 'julienmadignier@gmail.com', '$2y$10$XfB7vfvtQ73cCznQUX7eUe6kjJIoqA.3yWJVEqLGevV0j4tArJ0qO', 'Julien'),
(8, 'durantpierre432@gmail.com', '$2y$10$O5kwMgxd6dP.7HyRQUnOQujZUCnRXoqYJyuwzfFlzg5TN6ty0/2yu', 'Pierre');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
