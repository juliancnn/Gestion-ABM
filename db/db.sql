-- MySQL Script generated by MySQL Workbench
-- 06/22/14 09:49:45
-- Model: New Model    Version: 1.0
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema abm
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `abm` ;
CREATE SCHEMA IF NOT EXISTS `abm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `abm` ;

-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_carrera` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_carrera` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(40) NOT NULL,
  `link_pagina` VARCHAR(200) NULL,
  `link_plan` VARCHAR(200) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_info` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_info` (
  `dni` INT UNSIGNED NOT NULL,
  `nombre` VARCHAR(20) NOT NULL,
  `apellido` VARCHAR(20) NOT NULL,
  `celular` VARCHAR(20) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `lastupdate` DATE NULL,
  `persona_carrera_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`dni`),
  INDEX `fk_persona_info_persona_carrera1_idx` (`persona_carrera_id` ASC),
  CONSTRAINT `fk_persona_info_persona_carrera1`
    FOREIGN KEY (`persona_carrera_id`)
    REFERENCES `abm`.`gestionABM_persona_carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_apunteca_lugar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_apunteca_lugar` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_apunteca_lugar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_apunteca_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_apunteca_estado` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_apunteca_estado` (
  `estado_id` INT NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`estado_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_apunteca_apunte`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_apunteca_apunte` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_apunteca_apunte` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo_estante` VARCHAR(10) NOT NULL,
  `codigo_numero` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `agregado` DATE NULL,
  `lugar` INT NOT NULL,
  `estado` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_apunteca_apunte_gestionABM_apunteca_lugar1_idx` (`lugar` ASC),
  INDEX `fk_gestionABM_apunteca_apunte_gestionABM_apunteca_estado1_idx` (`estado` ASC),
  CONSTRAINT `fk_gestionABM_apunteca_apunte_gestionABM_apunteca_lugar1`
    FOREIGN KEY (`lugar`)
    REFERENCES `abm`.`gestionABM_apunteca_lugar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gestionABM_apunteca_apunte_gestionABM_apunteca_estado1`
    FOREIGN KEY (`estado`)
    REFERENCES `abm`.`gestionABM_apunteca_estado` (`estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_apunteca_registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_apunteca_registro` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_apunteca_registro` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `retiro` INT NOT NULL,
  `cuando` DATETIME NULL,
  `observacion` TEXT NULL,
  `persona_id` INT UNSIGNED NOT NULL,
  `apunte_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_apunteca_registros_persona_info1_idx` (`persona_id` ASC),
  INDEX `fk_gestionABM_apunteca_registro_gestionABM_apunteca_apunte1_idx` (`apunte_id` ASC),
  CONSTRAINT `fk_registro_tiene_persona`
    FOREIGN KEY (`persona_id`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gestionABM_apunteca_registro_gestionABM_apunteca_apunte1`
    FOREIGN KEY (`apunte_id`)
    REFERENCES `abm`.`gestionABM_apunteca_apunte` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_cargo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_cargo` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_cargo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `observacion` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_tiene_cargo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_tiene_cargo` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_tiene_cargo` (
  `dni` INT UNSIGNED NOT NULL,
  `cargo_id` INT NOT NULL,
  `desde` DATE NOT NULL,
  `hasta` DATE NULL,
  `observacion` VARCHAR(200) NULL,
  PRIMARY KEY (`dni`, `cargo_id`),
  INDEX `fk_persona_info_has_persona_cargo_persona_cargo1_idx` (`cargo_id` ASC),
  INDEX `fk_persona_info_has_persona_cargo_persona_info1_idx` (`dni` ASC),
  CONSTRAINT `fk_dni_tiene_cargo`
    FOREIGN KEY (`dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cargo_de_dni`
    FOREIGN KEY (`cargo_id`)
    REFERENCES `abm`.`gestionABM_persona_cargo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_materia` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_materia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `materia` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_da_bolsa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_da_bolsa` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_da_bolsa` (
  `comentario` VARCHAR(200) NULL,
  `precio` INT NULL,
  `materia_id` INT UNSIGNED NOT NULL,
  `dni` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`materia_id`, `dni`),
  INDEX `fk_gestionABM_persona_da_bolsa_gestionABM_persona_info1_idx` (`dni` ASC),
  CONSTRAINT `fk_dni_da_materia`
    FOREIGN KEY (`materia_id`)
    REFERENCES `abm`.`gestionABM_persona_materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materia_de_dni`
    FOREIGN KEY (`dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_da_materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_da_materia` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_da_materia` (
  `comentario` VARCHAR(200) NULL,
  `materia_id` INT UNSIGNED NOT NULL,
  `dni` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`materia_id`, `dni`),
  INDEX `fk_gestionABM_persona_da_materia_gestionABM_persona_info1_idx` (`dni` ASC),
  CONSTRAINT `fk_dni_da_materia_abm`
    FOREIGN KEY (`materia_id`)
    REFERENCES `abm`.`gestionABM_persona_materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materia_de_dni_abm`
    FOREIGN KEY (`dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_referente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_referente` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_referente` (
  `dni` INT UNSIGNED NOT NULL,
  `adni` INT UNSIGNED NOT NULL,
  INDEX `fk_gestionABM_persona_referentes_gestionABM_persona_info1_idx` (`dni` ASC),
  INDEX `fk_gestionABM_persona_referentes_gestionABM_persona_info2_idx` (`adni` ASC),
  CONSTRAINT `fk_ref_dni`
    FOREIGN KEY (`dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ref_adni`
    FOREIGN KEY (`adni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_act_actividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_act_actividad` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_act_actividad` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `duracion` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_act_edicion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_act_edicion` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_act_edicion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `actividad_id` INT NOT NULL,
  `lugar` VARCHAR(45) NULL,
  `fecha` DATE NOT NULL,
  `hora` TIME NULL,
  `costo` INT NULL,
  `observacion` TEXT NULL,
  `resultado` TEXT NULL,
  `cupo` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_edicion_actividad1_idx` (`actividad_id` ASC),
  CONSTRAINT `fk_edicion_de_actividad`
    FOREIGN KEY (`actividad_id`)
    REFERENCES `abm`.`gestionABM_act_actividad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_act_persona_participa_edicion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_act_persona_participa_edicion` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_act_persona_participa_edicion` (
  `idInscripcion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuando` TIMESTAMP NULL,
  `confirmo` TINYINT(1) NOT NULL,
  `edicion_id` INT NOT NULL,
  `persona_dni` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idInscripcion`),
  INDEX `fk_gestionABM_act_persona_participa_edicion_gestionABM_act__idx` (`edicion_id` ASC),
  INDEX `fk_gestionABM_act_persona_participa_edicion_gestionABM_pers_idx` (`persona_dni` ASC),
  CONSTRAINT `fk_edicion_tiene_dni`
    FOREIGN KEY (`edicion_id`)
    REFERENCES `abm`.`gestionABM_act_edicion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dni_tiene_actividad`
    FOREIGN KEY (`persona_dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_dinero_tranf`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_dinero_tranf` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_dinero_tranf` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cuando` TIMESTAMP NULL,
  `consepto` VARCHAR(200) NULL,
  `de_persona` INT UNSIGNED NOT NULL,
  `a_persona` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_dinero_tranf_gestionABM_persona_info1_idx` (`de_persona` ASC),
  INDEX `fk_gestionABM_dinero_tranf_gestionABM_persona_info2_idx` (`a_persona` ASC),
  CONSTRAINT `fk_dinero_de_dni`
    FOREIGN KEY (`de_persona`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dinero_a_dni`
    FOREIGN KEY (`a_persona`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_ticket_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_ticket_estado` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_ticket_estado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_ticket_prioridad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_ticket_prioridad` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_ticket_prioridad` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `importancia` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_ticket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_ticket` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_ticket` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NOT NULL,
  `cuando` TIMESTAMP NULL,
  `responde` INT UNSIGNED NOT NULL,
  `ticket_respuesta` INT UNSIGNED NULL,
  `estado_id` INT NOT NULL,
  `prioridad_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ticket_persona_info1_idx` (`responde` ASC),
  INDEX `fk_ticket_ticket1_idx` (`ticket_respuesta` ASC),
  INDEX `fk_ticket_estado1_idx` (`estado_id` ASC),
  INDEX `fk_ticket_prioridad1_idx` (`prioridad_id` ASC),
  CONSTRAINT `fk_ticket_responde_dni`
    FOREIGN KEY (`responde`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_respuesta_ticket`
    FOREIGN KEY (`ticket_respuesta`)
    REFERENCES `abm`.`gestionABM_ticket` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_tiene_estado`
    FOREIGN KEY (`estado_id`)
    REFERENCES `abm`.`gestionABM_ticket_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_tiene_prioridad`
    FOREIGN KEY (`prioridad_id`)
    REFERENCES `abm`.`gestionABM_ticket_prioridad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_usuario` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_usuario` (
  `dni` INT UNSIGNED NOT NULL,
  `pass` VARCHAR(45) NOT NULL,
  `incorrecto` INT NULL DEFAULT 0,
  INDEX `fk_usuario_persona_info1_idx` (`dni` ASC),
  PRIMARY KEY (`dni`),
  CONSTRAINT `fk_usuario_dni`
    FOREIGN KEY (`dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_tiene_ticket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_tiene_ticket` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_tiene_ticket` (
  `persona_dni` INT UNSIGNED NOT NULL,
  `ticket_id` INT UNSIGNED NOT NULL,
  INDEX `fk_gestionABM_persona_tiene_ticket_gestionABM_persona_info1_idx` (`persona_dni` ASC),
  INDEX `fk_gestionABM_persona_tiene_ticket_gestionABM_ticket1_idx` (`ticket_id` ASC),
  PRIMARY KEY (`ticket_id`, `persona_dni`),
  CONSTRAINT `fk_dni_tiene_ticket`
    FOREIGN KEY (`persona_dni`)
    REFERENCES `abm`.`gestionABM_persona_info` (`dni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_de_dni`
    FOREIGN KEY (`ticket_id`)
    REFERENCES `abm`.`gestionABM_ticket` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_profe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_profe` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_profe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `lastupdate` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_profe_da_materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_profe_da_materia` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_profe_da_materia` (
  `profe_id` INT NOT NULL,
  `materia_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`profe_id`, `materia_id`),
  INDEX `fk_gestionABM_profe_daa_materia_gestionABM_persona_materia1_idx` (`materia_id` ASC),
  CONSTRAINT `fk_profe_da_materia`
    FOREIGN KEY (`profe_id`)
    REFERENCES `abm`.`gestionABM_profe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materia_de_profe`
    FOREIGN KEY (`materia_id`)
    REFERENCES `abm`.`gestionABM_persona_materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_profe_consulta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_profe_consulta` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_profe_consulta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dia` CHAR(1) NOT NULL COMMENT 'dia es:' /* comment truncated */ /*L Lunes
M Martes
X miercoles
J Jueves
V Viernes
S Sabado*/,
  `hora` TIME NOT NULL,
  `profe_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_profe_consulta_gestionABM_profe1_idx` (`profe_id` ASC),
  CONSTRAINT `f_profe_consulta`
    FOREIGN KEY (`profe_id`)
    REFERENCES `abm`.`gestionABM_profe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_atencionCEICiN`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_atencionCEICiN` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_atencionCEICiN` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `entra` TIME NOT NULL,
  `sale` TIME NOT NULL,
  `dni` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_atencionCEICiN_gestionABM_persona_info1_idx` (`dni` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_act_proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_act_proveedor` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_act_proveedor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `celular` VARCHAR(45) NULL,
  `mail` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `comentario` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_actividad_tiene_proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_actividad_tiene_proveedor` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_actividad_tiene_proveedor` (
  `actividad_id` INT NOT NULL,
  `proveedor_id` INT NOT NULL,
  PRIMARY KEY (`actividad_id`, `proveedor_id`),
  INDEX `fk_gestionABM_act_actividad_has_gestionABM_act_proveedores__idx` (`proveedor_id` ASC),
  INDEX `fk_gestionABM_act_actividad_has_gestionABM_act_proveedores__idx1` (`actividad_id` ASC),
  CONSTRAINT `fk_proveedor_de_actividad`
    FOREIGN KEY (`actividad_id`)
    REFERENCES `abm`.`gestionABM_act_actividad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_actividad_tiene_proveedor`
    FOREIGN KEY (`proveedor_id`)
    REFERENCES `abm`.`gestionABM_act_proveedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_dinero_flujo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_dinero_flujo` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_dinero_flujo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuando` TIMESTAMP NULL,
  `persona_id` INT UNSIGNED NOT NULL,
  `monto` INT UNSIGNED NOT NULL,
  `comentario` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_gestionABM_persona_info1_idx` (`persona_id` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_dinero_act`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_dinero_act` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_dinero_act` (
  `id` INT UNSIGNED NOT NULL,
  `persona_dni` INT UNSIGNED NOT NULL,
  `act_edicion_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gestionABM_act_pago_gestionABM_persona_info1_idx` (`persona_dni` ASC),
  INDEX `fk_gestionABM_act_pago_gestionABM_act_edicion1_idx` (`act_edicion_id` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_permis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_permis` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_permis` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `abm`.`gestionABM_persona_tiene_permiso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `abm`.`gestionABM_persona_tiene_permiso` ;

CREATE TABLE IF NOT EXISTS `abm`.`gestionABM_persona_tiene_permiso` (
  `permiso_id` INT NOT NULL,
  `dni` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`permiso_id`, `dni`),
  INDEX `fk_gestionABM_permisos_has_gestionABM_usuario_gestionABM_us_idx` (`dni` ASC),
  INDEX `fk_gestionABM_permisos_has_gestionABM_usuario_gestionABM_pe_idx` (`permiso_id` ASC))
ENGINE = MyISAM;

USE `abm`;

DELIMITER $$

USE `abm`$$
DROP TRIGGER IF EXISTS `abm`.`gestionABM_persona_info_BUPD` $$
USE `abm`$$
CREATE TRIGGER `gestionABM_persona_info_BUPD` BEFORE UPDATE ON `gestionABM_persona_info` FOR EACH ROW
begin
SET new.lastupdate = CURDATE();
end$$


USE `abm`$$
DROP TRIGGER IF EXISTS `abm`.`gestionABM_persona_info_BINS` $$
USE `abm`$$
CREATE TRIGGER `gestionABM_persona_info_BINS` BEFORE INSERT ON `gestionABM_persona_info` FOR EACH ROW
begin
SET new.lastupdate = CURDATE();
end$$


USE `abm`$$
DROP TRIGGER IF EXISTS `abm`.`gestionABM_apunteca_apunte_BINS` $$
USE `abm`$$
CREATE TRIGGER `gestionABM_apunteca_apunte_BINS` BEFORE INSERT ON `gestionABM_apunteca_apunte` FOR EACH ROW
begin
SET new.agregado = CURDATE();
end$$


USE `abm`$$
DROP TRIGGER IF EXISTS `abm`.`gestionABM_profe_BUPD` $$
USE `abm`$$
CREATE TRIGGER `gestionABM_profe_BUPD` BEFORE UPDATE ON `gestionABM_profe` FOR EACH ROW
SET new.lastupdate = CURDATE();$$


USE `abm`$$
DROP TRIGGER IF EXISTS `abm`.`gestionABM_profe_BINS` $$
USE `abm`$$
CREATE TRIGGER `gestionABM_profe_BINS` BEFORE INSERT ON `gestionABM_profe` FOR EACH ROW
SET new.lastupdate = CURDATE();$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
