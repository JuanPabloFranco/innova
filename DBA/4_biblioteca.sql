CREATE TABLE `archivo` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(128) NOT NULL,
    `descripcion` TEXT NULL,
    `id_categoria` INT(2) NOT NULL,
    `tipo` VARCHAR(32) NOT NULL,
    `fecha_creacion` DATE NOT NULL,
    `id_autor` INT NOT NULL,
    `privacidad` VARCHAR(16) NOT NULL,
    `id_cargo` INT(2) NULL,
    `id_sede` INT(2) NULL,
    `id_usuario` INT NULL,
    `archivo` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `categoria_archivo` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `categoria_archivo`
ADD
    `estado` INT(2) NOT NULL
AFTER
    `nombre`;

ALTER TABLE
    `archivo`
ADD
    `estado` INT(2) NOT NULL
AFTER
    `nombre`;