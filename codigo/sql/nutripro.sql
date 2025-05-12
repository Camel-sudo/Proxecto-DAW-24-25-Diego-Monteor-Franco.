-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2025 a las 15:41:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutripro`
--
CREATE DATABASE nutripro;
USE nutripro;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

CREATE TABLE `alimento` (
  `id_alimento` int(11) NOT NULL,
  `calorieking_id` varchar(50) DEFAULT NULL COMMENT 'ID externo',
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `porcion_estandar` varchar(50) DEFAULT NULL,
  `calorias` decimal(10,2) DEFAULT NULL,
  `proteinas` decimal(10,2) DEFAULT NULL,
  `carbohidratos` decimal(10,2) DEFAULT NULL,
  `grasas` decimal(10,2) DEFAULT NULL,
  `fibra` decimal(10,2) DEFAULT NULL,
  `sodio` decimal(10,2) DEFAULT NULL,
  `ultima_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_nutricionista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `macros_objetivo`
--

CREATE TABLE `macros_objetivo` (
  `id_objetivo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_nutricionista` int(11) DEFAULT NULL,
  `proteinas_porcentaje` decimal(5,2) NOT NULL,
  `carbohidratos_porcentaje` decimal(5,2) NOT NULL,
  `grasas_porcentaje` decimal(5,2) NOT NULL,
  `fecha_establecido` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nutricionista`
--

CREATE TABLE `nutricionista` (
  `id_nutricionista` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_alimento`
--

CREATE TABLE `registro_alimento` (
  `id_registro_alimento` int(11) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `id_alimento` int(11) DEFAULT NULL,
  `calorieking_id` varchar(50) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `momento_dia` enum('desayuno','media_mañana','almuerzo','merienda','cena','postre') NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `calorias` decimal(10,2) DEFAULT NULL,
  `proteinas` decimal(10,2) DEFAULT NULL,
  `carbohidratos` decimal(10,2) DEFAULT NULL,
  `grasas` decimal(10,2) DEFAULT NULL,
  `es_recomendacion` tinyint(1) DEFAULT 0,
  `consumido` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `registro_alimento`
--
DELIMITER $$
CREATE TRIGGER `after_registro_alimento_delete` AFTER DELETE ON `registro_alimento` FOR EACH ROW BEGIN
    UPDATE registro_diario rd
    SET rd.calorias_consumidas = rd.calorias_consumidas - OLD.calorias,
        rd.proteinas_consumidas = rd.proteinas_consumidas - OLD.proteinas,
        rd.carbohidratos_consumidas = rd.carbohidratos_consumidas - OLD.carbohidratos,
        rd.grasas_consumidas = rd.grasas_consumidas - OLD.grasas
    WHERE rd.id_registro = OLD.id_registro;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_registro_alimento_insert` AFTER INSERT ON `registro_alimento` FOR EACH ROW BEGIN
    UPDATE registro_diario rd
    SET rd.calorias_consumidas = rd.calorias_consumidas + NEW.calorias,
        rd.proteinas_consumidas = rd.proteinas_consumidas + NEW.proteinas,
        rd.carbohidratos_consumidas = rd.carbohidratos_consumidas + NEW.carbohidratos,
        rd.grasas_consumidas = rd.grasas_consumidas + NEW.grasas
    WHERE rd.id_registro = NEW.id_registro;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_registro_alimento_update` AFTER UPDATE ON `registro_alimento` FOR EACH ROW BEGIN
    UPDATE registro_diario rd
    SET rd.calorias_consumidas = rd.calorias_consumidas - OLD.calorias + NEW.calorias,
        rd.proteinas_consumidas = rd.proteinas_consumidas - OLD.proteinas + NEW.proteinas,
        rd.carbohidratos_consumidas = rd.carbohidratos_consumidas - OLD.carbohidratos + NEW.carbohidratos,
        rd.grasas_consumidas = rd.grasas_consumidas - OLD.grasas + NEW.grasas
    WHERE rd.id_registro = NEW.id_registro;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_diario`
--

CREATE TABLE `registro_diario` (
  `id_registro` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_nutricionista` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `calorias_objetivo` decimal(10,2) DEFAULT NULL,
  `proteinas_objetivo` decimal(10,2) DEFAULT NULL,
  `carbohidratos_objetivo` decimal(10,2) DEFAULT NULL,
  `grasas_objetivo` decimal(10,2) DEFAULT NULL,
  `calorias_consumidas` decimal(10,2) DEFAULT 0.00,
  `proteinas_consumidas` decimal(10,2) DEFAULT 0.00,
  `carbohidratos_consumidas` decimal(10,2) DEFAULT 0.00,
  `grasas_consumidas` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña_hash` varchar(255) NOT NULL,
  `tipo_usuario` enum('base','premium','nutricionista') NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `altura` decimal(5,2) DEFAULT NULL COMMENT 'cm',
  `peso` decimal(5,2) DEFAULT NULL COMMENT 'kg',
  `edad` int(11) DEFAULT NULL,
  `sexo` enum('masculino','femenino','otro') DEFAULT NULL,
  `actividad_fisica` enum('sedentario','ligera','moderada','intensa','muy_intensa') DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `metabolismo_basal` decimal(10,2) DEFAULT NULL COMMENT 'kcal/día'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimento`
--
ALTER TABLE `alimento`
  ADD PRIMARY KEY (`id_alimento`),
  ADD UNIQUE KEY `calorieking_id` (`calorieking_id`),
  ADD KEY `nombre` (`nombre`),
  ADD KEY `calorieking_id_2` (`calorieking_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_nutricionista` (`id_nutricionista`);

--
-- Indices de la tabla `macros_objetivo`
--
ALTER TABLE `macros_objetivo`
  ADD PRIMARY KEY (`id_objetivo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_nutricionista` (`id_nutricionista`);

--
-- Indices de la tabla `nutricionista`
--
ALTER TABLE `nutricionista`
  ADD PRIMARY KEY (`id_nutricionista`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `registro_alimento`
--
ALTER TABLE `registro_alimento`
  ADD PRIMARY KEY (`id_registro_alimento`),
  ADD KEY `id_registro` (`id_registro`),
  ADD KEY `id_alimento` (`id_alimento`),
  ADD KEY `momento_dia` (`momento_dia`),
  ADD KEY `es_recomendacion` (`es_recomendacion`);

--
-- Indices de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD PRIMARY KEY (`id_registro`),
  ADD UNIQUE KEY `id_cliente` (`id_cliente`,`fecha`,`tipo`),
  ADD KEY `id_nutricionista` (`id_nutricionista`),
  ADD KEY `fecha` (`fecha`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimento`
--
ALTER TABLE `alimento`
  MODIFY `id_alimento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `macros_objetivo`
--
ALTER TABLE `macros_objetivo`
  MODIFY `id_objetivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nutricionista`
--
ALTER TABLE `nutricionista`
  MODIFY `id_nutricionista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_alimento`
--
ALTER TABLE `registro_alimento`
  MODIFY `id_registro_alimento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`id_nutricionista`) REFERENCES `nutricionista` (`id_nutricionista`) ON DELETE SET NULL;

--
-- Filtros para la tabla `macros_objetivo`
--
ALTER TABLE `macros_objetivo`
  ADD CONSTRAINT `macros_objetivo_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `macros_objetivo_ibfk_2` FOREIGN KEY (`id_nutricionista`) REFERENCES `nutricionista` (`id_nutricionista`) ON DELETE SET NULL;

--
-- Filtros para la tabla `nutricionista`
--
ALTER TABLE `nutricionista`
  ADD CONSTRAINT `nutricionista_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_alimento`
--
ALTER TABLE `registro_alimento`
  ADD CONSTRAINT `registro_alimento_ibfk_1` FOREIGN KEY (`id_registro`) REFERENCES `registro_diario` (`id_registro`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_alimento_ibfk_2` FOREIGN KEY (`id_alimento`) REFERENCES `alimento` (`id_alimento`) ON DELETE SET NULL;

--
-- Filtros para la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD CONSTRAINT `registro_diario_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_diario_ibfk_2` FOREIGN KEY (`id_nutricionista`) REFERENCES `nutricionista` (`id_nutricionista`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
