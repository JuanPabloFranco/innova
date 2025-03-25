CREATE TABLE `equipos` (`id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`),`tipo_equipo` VARCHAR(16) NOT NULL , `ubicacion` VARCHAR(128) NOT NULL , `id_sede` INT(4) NOT NULL , `serial` VARCHAR(64) NULL , `referencia` VARCHAR(64) NULL , `procesador` VARCHAR(32) NULL , `ram` VARCHAR(16) NULL , `disco_duro` VARCHAR(64) NULL , `sistema_operativo` VARCHAR(64) NULL , `teclado` VARCHAR(128) NULL , `mouse` VARCHAR(128) NULL , `monitor` VARCHAR(128) NULL , `office` VARCHAR(64) NULL , `pad_mouse` INT(1) NULL , `tipo_impresora` VARCHAR(128) NULL , `codigo_maquina` VARCHAR(16) NOT NULL , `persona_a_cargo` VARCHAR(128) NOT NULL , `estado` INT(1) NULL , `estado_general` INT(2) NOT NULL , `observaciones` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `innova`.`equipo_mantenimiento` ( `id` INT NOT NULL AUTO_INCREMENT , `fecha` DATE NOT NULL , `tipo` INT(2) NOT NULL , `descripcion` TEXT NOT NULL , `realizado_por` VARCHAR(128) NOT NULL , `observaciones` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `equipo_mantenimiento` ADD `id_equipo` INT NOT NULL AFTER `observaciones`;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Equipos', NULL, 1, 1, 'equipos');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 10, 1, 1, 1, 1);

CREATE TABLE `innova`.`tipo_mantenimiento` ( `id` INT NOT NULL AUTO_INCREMENT , `nombre_tipo` VARCHAR(64) NOT NULL , `descripcion` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;