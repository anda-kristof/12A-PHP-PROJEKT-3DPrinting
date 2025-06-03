-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jún 03. 04:11
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

DROP DATABASE IF EXISTS `12a_3dprinting`;
CREATE DATABASE IF NOT EXISTS `12a_3dprinting` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `12a_3dprinting`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
START TRANSACTION;

--
-- Tábla szerkezet ehhez a táblához `users`
--
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `materials`
--
CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `density` float NOT NULL,
  `img` varchar(155) NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `printer_types`
--
CREATE TABLE `printer_types` (
  `printer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `printer_type_name` varchar(255) NOT NULL,
  `printing_speed` float NOT NULL COMMENT 'mm^3/s',
  `plate_length` float NOT NULL,
  `plate_height` float NOT NULL,
  `plate_width` float NOT NULL,
  `compatible_materials` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`printer_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `printers`
--
CREATE TABLE `printers` (
  `printer_id` int(11) NOT NULL AUTO_INCREMENT,
  `printer_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `printer_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`printer_id`),
  KEY `printer_type_id` (`printer_type_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `models`
--
CREATE TABLE `models` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `volume_mm` float NOT NULL,
  `max_size_mm` float NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `recommended_material` varchar(255) NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `filaments`
--
CREATE TABLE `filaments` (
  `filament_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filament_grams` float NOT NULL,
  PRIMARY KEY (`filament_id`),
  KEY `material_id` (`material_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tábla szerkezet ehhez a táblához `jobs`
--
CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `printer_id` int(11) NOT NULL,
  `filament_id` int(11) NOT NULL,
  `starts_time` datetime NOT NULL,
  `print_time` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `grams` float NOT NULL,
  `model_id` int(11) NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `user_id` (`user_id`),
  KEY `printer_id` (`printer_id`),
  KEY `filament_id` (`filament_id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Adatok beillesztése a táblákba
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`) VALUES
(1, 'alice', 'hashpass1', 'alice@example.com'),
(2, 'bob', 'hashpass2', 'bob@example.com'),
(3, 'carol', 'hashpass3', 'carol@example.com'),
(5, 'misimóki', 'mogyi2', 'misimokus@gmail.com');

INSERT INTO `materials` (`material_id`, `name`, `color`, `density`, `img`) VALUES
(1, 'PLA', 'white', 1.24, 'pla_white.png'),
(2, 'ABS', 'black', 1.04, 'abs_black.png'),
(3, 'PETG', 'blue', 1.27, 'petg_blue.png'),
(4, 'TPU', 'red', 1.21, 'tpu_red.png'),
(5, 'Nylon', 'grey', 1.15, 'nylon_grey.png'),
(6, 'PLA', 'emerald green', 1.23, 'pla_emerald.png'),
(7, 'PLA', 'gold', 1.24, 'pla_gold.png'),
(8, 'TPU', 'copper', 1.21, 'tpu_copper.png'),
(9, 'TPU', 'orange', 1.21, 'tpu_orange.png'),
(10, 'TPU', 'red', 1.21, 'tpu_red.png'),
(11, 'TPU', 'yellow', 1.21, 'tpu_yellow.png');

INSERT INTO `printer_types` (`printer_type_id`, `printer_type_name`, `printing_speed`, `plate_length`, `plate_height`, `plate_width`, `compatible_materials`, `img`) VALUES
(1, 'Prusa i3', 15, 250, 210, 210, 'PLA,ABS,PETG', 'prusa.png'),
(2, 'Ender 3', 10, 220, 250, 220, 'PLA,ABS', 'ender3.png'),
(3, 'Anycubic Mega', 12, 210, 210, 205, 'PLA,PETG,TPU', 'anycubic.png'),
(4, 'BambuLab A1', 25, 256, 256, 256, 'PLA,ABS,PETG,TPU,PA,C,PC', 'bambua1.png'),
(5, 'BambuLab P1S', 20, 256, 256, 256, 'PLA,ABS,PETG,TPU,PA,C,PC', 'bambup1s.png'),
(6, 'Prusa XL', 24, 360, 360, 360, 'PLA,ABS,PETG,ASA,PC,PP,PA,Flex', 'prusaxl.png'),
(7, 'Creality CR-10 Max', 24, 450, 470, 450, 'PLA,ABS,PETG,TPU', 'cr10max.png'),
(8, 'Artillery Sidewinder X2', 22, 400, 400, 400, 'PLA,PETG,TPU', 'sidewinderx2.png');

INSERT INTO `printers` (`printer_id`, `printer_type_id`, `user_id`, `printer_name`, `status`, `job_id`) VALUES
(2, 2, 2, 'Ender #1', 'printing', 0),
(3, 3, 3, 'Mega #1', 'idle', 0),
(23, 4, 5, 'a', 'idle', 0),
(26, 1, 1, 'mano', 'idle', 0),
(28, 7, 1, 'CR-10 Max #1', 'idle', 0),
(29, 8, 1, 'Office Homie', 'idle', 0);

INSERT INTO `models` (`model_id`, `user_id`, `name`, `volume_mm`, `max_size_mm`, `description`, `img`, `recommended_material`) VALUES
(1, 1, 'Chess Pawn', 1200, 45, 'A simple chess pawn.', 'pawn.png', 'PLA'),
(2, 2, 'Phone Stand', 3000, 100, 'Desk phone stand.', 'stand.png', 'PETG'),
(3, 1, 'Keychain', 350, 30, 'Small keychain with logo.', 'keychain.png', 'ABS'),
(4, 3, 'Spool Holder', 2400, 120, 'Filament spool holder.', 'spoolholder.png', 'PETG'),
(5, 2, 'Flexible Toy', 800, 55, 'A toy made from flexible TPU.', 'flexitoy.png', 'TPU'),
(7, 1, 'egér', 400, 80, 'csk egy egér', 'sample.png', 'PLA'),
(8, 1, 'Szobor - Sárkány', 18500, 320, 'Nagy, részletes sárkány szobor. Kiemelkedő részletesség, ajánlott PLA vagy PETG.', 'dragon_statue.png', 'PLA, PETG'),
(9, 2, 'Versenyautó váz', 24000, 400, 'RC autó váz, tartós, merev szerkezetű. ABS vagy PETG alapanyag ajánlott.', 'racecar_body.png', 'ABS, PETG'),
(10, 3, 'Szerszámtartó doboz', 12000, 250, 'Erős, nagy szerszámtartó, több rekesszel.', 'toolbox_large.png', 'PETG'),
(11, 1, 'Ékszertartó állvány', 8000, 180, 'Elegáns ékszertartó állvány, csillogó anyagból.', 'jewelry_stand.png', 'PLA'),
(12, 2, 'Színes váza', 11000, 220, 'Dekoratív, nagy váza, áttetsző vagy színes anyagból.', 'vase_big.png', 'PETG, PLA'),
(13, 3, 'Flexi dinoszaurusz XL', 9500, 200, 'Mozgatható tagú, nagyobb flexi dino.', 'flexi_dino_xl.png', 'TPU, PLA'),
(14, 1, 'joystick tartó', 2111, 1111, 'asd', 'sample.png', 'PLA'),
(15, 1, 'Tengeralattjáró', 780000000, 80000, 'nagy', 'sample.png', 'VAS');

INSERT INTO `filaments` (`filament_id`, `material_id`, `user_id`, `filament_grams`) VALUES
(1, 1, 1, 21480),
(2, 2, 1, 399),
(3, 3, 2, 1000),
(4, 1, 2, 150),
(5, 4, 2, 120),
(6, 5, 3, 300),
(7, 3, 3, 250),
(8, 4, 3, 90),
(9, 4, 1, 109),
(10, 5, 1, 20),
(11, 2, 5, 90),
(12, 4, 5, 1999),
(13, 1, 5, 1996),
(14, 3, 5, 9974),
(15, 5, 5, 1),
(16, 6, 1, 300),
(17, 7, 1, 250),
(18, 8, 2, 180),
(19, 9, 3, 150),
(20, 10, 2, 220),
(21, 11, 3, 200),
(22, 8, 1, 100);

INSERT INTO `jobs` (`job_id`, `user_id`, `printer_id`, `filament_id`, `starts_time`, `print_time`, `status`, `grams`, `model_id`) VALUES
(2, 2, 2, 3, '2025-05-29 15:00:00', '02:00:00', 'printing', 50, 2),
(4, 3, 3, 7, '2025-05-27 11:20:00', '02:20:00', 'finished', 60, 4),
(5, 2, 2, 5, '2025-05-27 17:00:00', '00:55:00', 'queued', 30, 5),
(6, 3, 3, 6, '2025-05-26 09:00:00', '01:15:00', 'finished', 40, 4),
(7, 3, 3, 8, '2025-05-25 13:00:00', '01:00:00', 'printing', 12, 5),
(48, 5, 23, 11, '2025-06-03 01:04:53', '00:00:14', 'finished', 1.364, 3),
(49, 5, 23, 11, '2025-06-03 01:05:19', '00:00:14', 'finished', 1.364, 3),
(50, 5, 23, 11, '2025-06-03 01:11:21', '00:00:14', 'finished', 1.364, 3),
(51, 5, 23, 11, '2025-06-03 01:11:48', '00:00:14', 'finished', 1.364, 3),
(52, 5, 23, 11, '2025-06-03 01:12:02', '00:00:14', 'finished', 1.364, 3),
(53, 5, 23, 14, '2025-06-03 01:12:30', '00:02:00', 'finished', 4.81, 2),
(54, 5, 23, 14, '2025-06-03 01:15:54', '00:02:00', 'finished', 4.81, 2),
(55, 5, 23, 14, '2025-06-03 01:18:00', '00:02:00', 'finished', 4.81, 2),
(56, 5, 23, 11, '2025-06-03 01:18:37', '00:00:14', 'finished', 1.364, 3),
(57, 5, 23, 11, '2025-06-03 01:19:06', '00:00:14', 'finished', 1.364, 3),
(58, 5, 23, 11, '2025-06-03 01:22:39', '00:00:14', 'finished', 1.364, 3),
(59, 5, 23, 11, '2025-06-03 01:23:09', '00:00:14', 'finished', 1.364, 3),
(60, 5, 23, 11, '2025-06-03 01:26:41', '00:00:14', 'finished', 1.364, 3),
(73, 1, 28, 9, '2025-06-03 04:10:34', '00:00:33', 'finished', 1.968, 5);

--
-- Megkötések (FOREIGN KEY) a táblákhoz
--

ALTER TABLE `filaments`
  ADD CONSTRAINT `filaments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`),
  ADD CONSTRAINT `filaments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`filament_id`) REFERENCES `filaments` (`filament_id`),
  ADD CONSTRAINT `jobs_ibfk_4` FOREIGN KEY (`model_id`) REFERENCES `models` (`model_id`),
  ADD CONSTRAINT `jobs_ibfk_5` FOREIGN KEY (`printer_id`) REFERENCES `printers` (`printer_id`) ON DELETE CASCADE;

ALTER TABLE `models`
  ADD CONSTRAINT `models_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `printers`
  ADD CONSTRAINT `printers_ibfk_1` FOREIGN KEY (`printer_type_id`) REFERENCES `printer_types` (`printer_type_id`),
  ADD CONSTRAINT `printers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

COMMIT;