ALTER TABLE `empresas` ADD `logo` VARCHAR(255) NULL AFTER `estado`;

CREATE TABLE `innova`.`sedes_empresa` ( `id` INT NOT NULL AUTO_INCREMENT , `id_empresa` INT(4) NOT NULL , `nombre_sede` VARCHAR(64) NOT NULL , `direccion` VARCHAR(255) NULL , `id_municipio` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;