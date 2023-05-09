-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-05-2023 a las 06:59:21
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `latitud` float NOT NULL,
  `longitud` float NOT NULL,
  `puntuacion` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_coords` (`latitud`,`longitud`)
) ;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`id`, `nombre`, `direccion`, `latitud`, `longitud`, `puntuacion`) VALUES
(1, 'Hostal The Golden Paradice', 'Av. Los Arquitectos, Ventanilla', -11.8297, -77.138, 5.4),
(2, 'Cosmopolitan Inn Hotel', 'Alfa, Ventanilla', -11.8741, -77.1283, 9.4),
(3, 'HOTEL BUNGALOW JATUM MAMA', 'Av. La Playa, Ventanilla', -11.8722, -77.1426, 2),
(4, 'Hotel Villa 24', '4WR9+MFR, Av. San Martín de Porres, Puente Piedra', -11.8583, -77.0813, 3.2),
(5, 'Hostal Mazel', 'Av. Neptuno, Ventanilla', -11.8819, -77.1285, 7.9),
(6, 'Hostal Sagitario', 'Mz, A. A. Caceres 17, Ventanilla', -11.8725, -77.1276, 7.4),
(7, 'Tigre II Hostal', 'avenida Júpiter, Mz A Lote 39-A, coopemar ventanilla, Lima', -11.8813, -77.1266, 1.8),
(8, 'Manantial Hotel No.003', 'Au. Panamericana Nte. 856, Puente Piedra', -11.8906, -77.0686, 0.2),
(9, 'Chicharronería Tungasuca', 'Pereda 241, Carabayllo', -11.8929, -77.0397, 2.3),
(10, 'Hotel Colinas', '4WHH+3PC, C, Puente Piedra', -11.8723, -77.0708, 0.4),
(11, 'CHAVIN HOTEL & RECEPCIONES', 'Av. José Saco Rojas 2078 Urb, Carabayllo', -11.8598, -77.0485, 3.4),
(12, 'Piscina Oasis', 'Puno 232, Carabayllo', -11.8941, -77.0264, 9.2),
(13, 'Hostal Las Ñustas', 'Aymi Túpac 151, Carabayllo', -11.8938, -77.044, 6),
(14, 'Albergues Tu Mundo', '4X59+849, Unanue, Carabayllo', -11.8917, -77.0321, 0.1),
(15, 'Hospedaje Puente Oro', 'C. - 3 - E, Carabayllo', -11.8554, -77.0636, 9.9),
(16, 'HOSTAL EL TORNILLO 3', '15316 COMAS', -11.927, -77.0649, 1.6),
(17, 'Hostal Grand Prix', 'Av. Universitaria 6251, Comas', -11.9493, -77.0606, 9.3),
(18, 'Suites El Parque', 'Calle Simón Grados Manzana LL - 1 Lote 13 Urbanización Villa del Norte Altura de la cuadra 54 de la, Av. Las Palmeras, Los Olivos', -11.9709, -77.074, 1.3),
(19, 'Ginebra Hotel & Suites', 'C. B Mz D Lt 54, Independencia', -11.9925, -77.0625, 4.6),
(20, 'Verona Hotel Baños Turcos', 'Av. Universitaria 4690, Los Olivos', -11.9649, -77.0725, 1.5),
(21, 'Hotel Wayra', 'Av. Universitaria 4295, San Martín de Porres', -11.9835, -77.0789, 0.2),
(22, 'QURPAWASI', 'Jirón José Carlos Mariategui 112, Barranco', -11.9935, -77.0556, 0.4),
(23, 'Hospedaje Huaca Palmeras', 'Los Helenios 4245, Los Olivos', -11.9846, -77.0732, 8.1),
(24, 'Hotel Hacienda Lima Norte', 'Lote D Av. trapiche, Au. Chillón - Trapiche 7, Comas', -11.9231, -77.0636, 7.1),
(25, 'D\' Richard Hotel', 'Los Silicios 5424, Cercado de Lima', -11.9692, -77.0633, 6.2),
(26, 'Hospedaje Celerina & Elio', 'Callao', -12.0014, -77.113, 6.9),
(27, 'Tupac Hostel- Lima Airport', 'Av. Angélica Gamarra 959, Los Olivos', -12.0066, -77.074, 2.3),
(28, 'Hostal Roma Suite II', 'Av. Naranjal 1701, San Martín de Porres', -11.9752, -77.0868, 5.7),
(29, 'Lima Airport Tampu B&B', 'Psje Piura Mz J lt 23 Urb', -11.998, -77.1184, 9.2),
(30, 'Tierras Viajeras Hostel', 'Av. Pacasmayo mz F, San Martín de Porres', -11.9981, -77.1076, 6),
(31, 'Residencial Suiza', 'Urb. Suiza Peruana Mz C Lote 12, Los Olivos', -11.9754, -77.0736, 1.8),
(32, 'Mama Backpackers Hostel', 'Av. Santiago Antunez de Mayolo 1389, Los Olivos', -11.9958, -77.0804, 4.5),
(33, 'Hostal Extasis', 'Av. los Alisos, San Martín de Porres', -11.9817, -77.0921, 4.1),
(34, 'Sumak Samana Wasi', 'Calle Los alisos Mz I lote 1, urbanización Las fresas, Callao / a 3 cuadras antes de \"Tottus Canta Callao, Av. Alejandro Bertello Bollati, Callao', -12.0022, -77.1111, 5.1),
(35, 'Casa Pillqu B&B', 'Jorge Colque 102, Callao', -11.9989, -77.1192, 0.5),
(36, 'Decameron El Pueblo', 'Carretera central KM 10.5 santa clara, Ate', -12.0341, -76.8818, 4.4),
(37, 'Hotel El Sol de Huachipa', 'Av circunvalacion lote 09 huachipa, 001, Lurigancho-Chosica', -12.017, -76.9173, 2.2),
(38, 'Hospedaje Roma Ñaña.', 'Urb. Alameda de Ñaña Mz.D, 33 primera etapa Lurigancho-Chosica Municipalidad Metropolitana de Lima LIMA', -11.9874, -76.834, 1.9),
(39, 'Gran Chimu Palace', 'Avenida José Carlos Mariátegui Mz.B Lt. 10-11 2da etapa Ate, Ent A Huaycan, Ate', -12.0019, -76.8375, 8.6),
(40, 'Gran hotel Santo Domingo de Guzman', 'X3HH+Q63, Lurigancho-Chosica', -12.0206, -76.922, 4.3),
(41, 'Hotel Killa P\' Unchay', '24 de Setiembre, Mz K Lote 7, Lurigancho-Chosica', -12.0028, -76.8659, 6.8),
(42, 'Queen', 'X3CG+932, Ate', -12.0291, -76.9249, 2.3),
(43, 'Conafovicer', 'Av. Nicolás Ayllón 7854, Ate', -12.0195, -76.8971, 8),
(44, 'HOSTAL \"IMPERIAL\"', 'Coop. 26 de Mayo Mz \"L\" Lt 1, Ate', -12.0249, -76.9217, 9.2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
