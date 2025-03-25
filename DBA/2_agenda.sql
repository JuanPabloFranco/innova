
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(8) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `estado` int(2) NOT NULL COMMENT 'pendiente (1) , finalizada (2), cancelada  (3)',
  `descripcion` text NOT NULL,
  `tipo_tarea` varchar(16) NOT NULL,
  `ubicacion` varchar(16) DEFAULT NULL,
  `descripcion_ubicacion` text,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);
COMMIT;


ALTER TABLE `tareas`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;COMMIT;

--
-- Estructura de tabla para la tabla `tareas_responsables`
--

CREATE TABLE `tareas_responsables` (
  `id` int(8) NOT NULL,
  `id_responsable` int(8) NOT NULL,
  `id_tarea` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tareas_responsables`
  ADD PRIMARY KEY (`id`);
COMMIT;


ALTER TABLE `tareas_responsables`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;COMMIT;

-- Se agrega el campo calendar a usuario
ALTER TABLE `usuarios` ADD `calendar` VARCHAR(32) NULL AFTER `menu`;