
--
-- Base de données :  `cubefighter`
--

-- --------------------------------------------------------

--
-- Structure de la table `attaque`
--

DROP TABLE IF EXISTS `attaque`;
CREATE TABLE IF NOT EXISTS `attaque` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idAttaquant` int(10) UNSIGNED DEFAULT '0',
  `idAttaque` int(10) UNSIGNED DEFAULT '0',
  `bataillon` int(10) UNSIGNED DEFAULT '0',
  `forceExt` float DEFAULT '0',
  `forceInt` float DEFAULT '0',
  `soldatsRestants` int(10) UNSIGNED DEFAULT '0',
  `ress1Volees` int(10) UNSIGNED DEFAULT '0',
  `ress2Volees` int(10) UNSIGNED DEFAULT '0',
  `reliquesVolees` int(10) UNSIGNED DEFAULT '0',
  `reg_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `attaque`
--

INSERT INTO `attaque` (`id`, `idAttaquant`, `idAttaque`, `bataillon`, `forceExt`, `forceInt`, `soldatsRestants`, `ress1Volees`, `ress2Volees`, `reliquesVolees`, `reg_date`) VALUES
(1, 4, 2, 10, 67, 37.1, 9, 3150, 400, 0, '2016-05-02 18:57:47'),
(2, 2, 4, 20, 123, 115.84, 15, 4600, 3080, 0, '2016-05-02 19:10:15'),
(3, 4, 2, 6, 34.5, 111.44, 2, 0, 0, 0, '2016-05-02 19:27:35');

-- --------------------------------------------------------

--
-- Structure de la table `joueurmessage`
--

DROP TABLE IF EXISTS `joueurmessage`;
CREATE TABLE IF NOT EXISTS `joueurmessage` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idJoueurEnvoi` int(6) UNSIGNED DEFAULT NULL,
  `idJoueurRecue` int(6) UNSIGNED DEFAULT NULL,
  `sujet` varchar(100) NOT NULL,
  `texte` varchar(1000) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idJoueurEnvoi` (`idJoueurEnvoi`),
  KEY `idJoueurRecue` (`idJoueurRecue`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `joueurmessage`
--

INSERT INTO `joueurmessage` (`id`, `idJoueurEnvoi`, `idJoueurRecue`, `sujet`, `texte`, `date`) VALUES
(1, 5, 3, 'Tu vas manger la poussiÃ¨re', 'Je vais dÃ©truire ton village mon petit!', '2016-05-02 18:50:49'),
(2, 5, 4, 'J''arrive, prÃ©pare-toi!', 'Tu n''auras rien le temps de voir venir...!', '2016-05-02 18:53:01'),
(3, 4, 5, 'Je n''ai pas peur', 'Je pense que tu bluffes! Mais attaques-moi si tu l''oses, j''ai une armÃ©e pour te recevoir!', '2016-05-02 18:55:27'),
(4, 4, 4, '[Rapport de bataille nÂ°1]', 'Une attaque a Ã©tÃ© menÃ©e contre vous. Voici le rapport de cette bataille:\r\n            - Soldats ennemis tuÃ©s: 1\r\n            - Soldats du village restants: 1\r\n            - Mineurs restants: 0\r\n            - Citoyens restants: 200\r\n\r\n            - Reliques volÃ©es: 0\r\n            - Bois volÃ©: 3150\r\n            - Or volÃ©: 400\r\n\r\n            - Habitations dÃ©truites:0\r\n            - Casernes dÃ©truites:0\r\n            - Centres de formation dÃ©truits:0\r\n            - Granges dÃ©truites:1\r\n            - Banques dÃ©truites:0\r\n            ', '2016-05-02 18:57:57'),
(5, 5, 5, '[Rapport de bataille nÂ°1]', 'Vous avez menÃ© une bataille. Voici le rapport :\r\n            - Soldats du bataillon tuÃ©s: 1\r\n\r\n            - Reliques volÃ©es: 0\r\n            - Bois volÃ©: 3150\r\n            - Or volÃ©: 400\r\n\r\n            - Habitations dÃ©truites:0\r\n            - Casernes dÃ©truites:0\r\n            - Centres de formation dÃ©truits:0\r\n            - Granges dÃ©truites:1\r\n            - Banques dÃ©truites:0\r\n            ', '2016-05-02 18:58:07'),
(6, 5, 5, '[Rapport de bataille nÂ°2]', 'Une attaque a Ã©tÃ© menÃ©e contre vous. Voici le rapport de cette bataille:\r\n            - Soldats ennemis tuÃ©s: 5\r\n            - Soldats du village restants: 4\r\n            - Mineurs restants: 18\r\n            - Citoyens restants: 600\r\n\r\n            - Reliques volÃ©es: 0\r\n            - Bois volÃ©: 4600\r\n            - Or volÃ©: 3080\r\n\r\n            - Habitations dÃ©truites:1\r\n            - Casernes dÃ©truites:0\r\n            - Centres de formation dÃ©truits:0\r\n            - Granges dÃ©truites:1\r\n            - Banques dÃ©truites:3\r\n            ', '2016-05-02 19:10:25'),
(7, 4, 4, '[Rapport de bataille nÂ°2]', 'Vous avez menÃ© une bataille. Voici le rapport :\r\n            - Soldats du bataillon tuÃ©s: 5\r\n\r\n            - Reliques volÃ©es: 0\r\n            - Bois volÃ©: 4600\r\n            - Or volÃ©: 3080\r\n\r\n            - Habitations dÃ©truites:1\r\n            - Casernes dÃ©truites:0\r\n            - Centres de formation dÃ©truits:0\r\n            - Granges dÃ©truites:1\r\n            - Banques dÃ©truites:3\r\n            ', '2016-05-02 19:10:35');

-- --------------------------------------------------------

--
-- Structure de la table `listbatiments`
--

DROP TABLE IF EXISTS `listbatiments`;
CREATE TABLE IF NOT EXISTS `listbatiments` (
  `id_village` int(6) UNSIGNED NOT NULL,
  `id_batiment` int(6) UNSIGNED NOT NULL,
  `x` int(6) UNSIGNED NOT NULL,
  `y` int(6) UNSIGNED NOT NULL,
  `enConstruction` int(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `listbatiments`
--

INSERT INTO `listbatiments` (`id_village`, `id_batiment`, `x`, `y`, `enConstruction`) VALUES
(1, 1, 0, 0, 0),
(1, 5, 0, 2, 0),
(1, 6, 0, 4, 0),
(1, 1, 0, 1, 0),
(1, 2, 7, 7, 0),
(1, 2, 7, 6, 0),
(1, 2, 6, 7, 0),
(1, 3, 0, 6, 0),
(1, 2, 7, 5, 0),
(1, 1, 1, 0, 0),
(1, 2, 5, 7, 0),
(1, 2, 7, 4, 0),
(1, 2, 4, 7, 0),
(1, 2, 4, 4, 0),
(1, 2, 4, 3, 0),
(1, 2, 3, 4, 0),
(1, 2, 5, 2, 0),
(1, 2, 6, 2, 0),
(1, 2, 7, 3, 0),
(1, 2, 2, 5, 0),
(1, 2, 2, 6, 0),
(1, 2, 3, 7, 0),
(1, 4, 2, 2, 0),
(1, 5, 8, 0, 0),
(1, 5, 0, 8, 0),
(1, 5, 2, 0, 0),
(1, 6, 3, 0, 0),
(1, 6, 0, 3, 0),
(1, 6, 4, 0, 0),
(1, 3, 6, 0, 0),
(1, 6, 5, 0, 0),
(1, 6, 0, 5, 0),
(1, 1, 7, 0, 0),
(1, 1, 0, 7, 0),
(1, 1, 1, 8, 0),
(1, 1, 8, 1, 0),
(2, 1, 0, 0, 0),
(2, 5, 0, 2, 0),
(2, 6, 0, 4, 0),
(2, 1, 1, 0, 0),
(2, 5, 1, 2, 0),
(2, 2, 5, 8, 0),
(2, 5, 8, 3, 0),
(3, 1, 0, 0, 0),
(3, 6, 0, 4, 0),
(3, 6, 6, 0, 0),
(3, 1, 1, 0, 0),
(3, 5, 7, 8, 0),
(3, 2, 8, 3, 0),
(3, 1, 3, 0, 0),
(3, 6, 7, 0, 0),
(3, 4, 8, 6, 0),
(3, 6, 8, 0, 0),
(3, 5, 8, 8, 0),
(3, 1, 2, 0, 0),
(3, 1, 4, 8, 0),
(3, 5, 6, 7, 0),
(3, 6, 0, 5, 0),
(3, 1, 4, 7, 0),
(3, 5, 6, 8, 0),
(3, 5, 1, 1, 0),
(3, 6, 1, 5, 0),
(3, 5, 0, 1, 0),
(3, 5, 0, 2, 0),
(3, 6, 0, 3, 0),
(3, 5, 1, 2, 0),
(3, 6, 1, 3, 0),
(3, 6, 1, 4, 0),
(3, 3, 6, 3, 0),
(3, 5, 0, 6, 0),
(3, 5, 0, 7, 0),
(3, 6, 0, 8, 0),
(3, 5, 1, 6, 0),
(3, 5, 1, 7, 0),
(3, 6, 1, 8, 0),
(3, 1, 4, 0, 0),
(3, 2, 2, 1, 0),
(3, 6, 2, 8, 0),
(3, 5, 2, 7, 0),
(3, 5, 2, 2, 0),
(4, 1, 1, 0, 0),
(4, 2, 8, 5, 0),
(4, 1, 2, 0, 0),
(4, 3, 4, 4, 0),
(4, 5, 1, 2, 0),
(4, 5, 0, 6, 0),
(4, 1, 8, 0, 0),
(4, 1, 7, 0, 0),
(5, 6, 0, 4, 0),
(5, 5, 8, 8, 0),
(5, 1, 8, 0, 0),
(5, 1, 0, 8, 0),
(5, 6, 0, 0, 0),
(5, 1, 7, 0, 0),
(5, 3, 0, 7, 0),
(5, 6, 0, 3, 0),
(5, 6, 0, 1, 0),
(5, 6, 0, 2, 0),
(5, 6, 1, 0, 0),
(5, 6, 2, 0, 0),
(5, 6, 1, 2, 0),
(5, 6, 1, 4, 0),
(5, 6, 2, 2, 0),
(5, 6, 2, 1, 0),
(5, 6, 2, 4, 0),
(5, 6, 3, 2, 0),
(5, 6, 3, 4, 0),
(5, 6, 3, 3, 0),
(5, 5, 4, 5, 0),
(5, 5, 4, 6, 0),
(5, 5, 4, 7, 0),
(5, 5, 4, 8, 0),
(5, 5, 5, 5, 0),
(5, 5, 6, 6, 0),
(5, 5, 7, 5, 0),
(5, 5, 8, 5, 0),
(5, 5, 8, 6, 0),
(5, 5, 8, 7, 0),
(5, 1, 8, 1, 0),
(5, 3, 1, 8, 0),
(4, 6, 4, 4, 0),
(4, 6, 3, 4, 0),
(4, 6, 5, 4, 0),
(4, 6, 4, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `listvillages`
--

DROP TABLE IF EXISTS `listvillages`;
CREATE TABLE IF NOT EXISTS `listvillages` (
  `id_joueur` int(6) UNSIGNED NOT NULL,
  `nomVillage` varchar(100) NOT NULL,
  `id_village` int(6) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `listvillages`
--

INSERT INTO `listvillages` (`id_joueur`, `nomVillage`, `id_village`) VALUES
(1, 'CatCubeCity', 1),
(2, 'Le village de bobbinch', 3),
(4, 'Florence', 2),
(3, 'ForeverTower', 5),
(5, 'Gotham', 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `email`, `reg_date`) VALUES
(1, 'Elo123', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'elo@gmail.fr', '2016-05-02 18:23:12'),
(2, 'Bobbinch', 'b8489c3d1018dc378c6f2c1bf5bd8c69b16290e2', 'bob@yahoo.fr', '2016-05-02 18:28:13'),
(3, 'BM91', '7c6c3a7f7f7cecbde65992a8b8c4bfcb663210ea', 'bm91@msn.com', '2016-05-02 18:34:33'),
(4, 'Ezio', '8063360af5638b4e7947507e6df5d338b362b9d8', 'auditore@flo.it', '2016-05-02 18:37:43'),
(5, 'BaptMan', 'bfe54caa6d483cc3887dce9d1b8eb91408f1ea7a', 'sauveur@free.fr', '2016-05-02 18:48:36');

-- --------------------------------------------------------

--
-- Structure de la table `village`
--

DROP TABLE IF EXISTS `village`;
CREATE TABLE IF NOT EXISTS `village` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `citoyens` int(10) UNSIGNED DEFAULT '5',
  `soldats` int(10) UNSIGNED DEFAULT '0',
  `soldatDateDebut` timestamp NULL DEFAULT NULL,
  `mineurs` int(10) UNSIGNED DEFAULT '0',
  `mineurDateDebut` timestamp NULL DEFAULT NULL,
  `ress1` int(10) UNSIGNED DEFAULT '400',
  `ress2` int(10) UNSIGNED DEFAULT '200',
  `reliques` int(10) UNSIGNED DEFAULT '0',
  `reliqueDateDebut` timestamp NULL DEFAULT NULL,
  `casernes` int(10) UNSIGNED DEFAULT '0',
  `habitations` int(10) UNSIGNED DEFAULT '1',
  `centresFormation` int(10) UNSIGNED DEFAULT '0',
  `fabriques` int(10) UNSIGNED DEFAULT '0',
  `depots1` int(10) UNSIGNED DEFAULT '1',
  `depots2` int(10) UNSIGNED DEFAULT '1',
  `constrEnCours` int(10) UNSIGNED DEFAULT '0',
  `constrDateDebut` timestamp NULL DEFAULT NULL,
  `attaquePossible` tinyint(1) DEFAULT '1',
  `protected` timestamp NULL DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT NULL,
  `last_maj` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `village`
--

INSERT INTO `village` (`id`, `citoyens`, `soldats`, `soldatDateDebut`, `mineurs`, `mineurDateDebut`, `ress1`, `ress2`, `reliques`, `reliqueDateDebut`, `casernes`, `habitations`, `centresFormation`, `fabriques`, `depots1`, `depots2`, `constrEnCours`, `constrDateDebut`, `attaquePossible`, `protected`, `reg_date`, `last_maj`) VALUES
(1, 700, 21, NULL, 15, '2016-04-28 21:31:16', 20000, 6000, 3, NULL, 16, 7, 2, 1, 4, 6, 0, '2016-04-29 16:09:30', 1, NULL, '2016-04-28 20:25:22', '2016-05-02 18:26:50'),
(2, 200, 14, NULL, 0, NULL, 15000, 1000, 0, NULL, 1, 2, 0, 0, 3, 1, 0, '2016-05-02 18:59:18', 1, NULL, '2016-04-28 20:40:26', '2016-05-02 19:30:44'),
(3, 700, 15, NULL, 4, '2016-04-30 14:42:13', 70000, 12000, 6, NULL, 2, 7, 1, 1, 14, 12, 0, '2016-05-01 07:02:16', 1, NULL, '2016-04-28 21:09:20', '2016-05-02 18:39:23'),
(5, 400, 0, NULL, 2, '2016-04-29 21:38:21', 55000, 15000, 0, NULL, 0, 4, 2, 0, 11, 15, 0, '2016-04-29 21:57:25', 1, NULL, '2016-04-29 20:59:45', '2016-05-02 18:47:22'),
(4, 600, 6, NULL, 10, '2016-05-02 15:50:57', 15000, 4000, 2, NULL, 1, 6, 1, 1, 3, 4, 0, '2016-05-02 15:50:52', 1, NULL, '2016-05-01 19:50:28', '2016-05-02 19:29:59');
