/* SQL Manager Lite for MySQL                              5.7.2.52112 */
/* ------------------------------------------------------------------- */
/* Host     : localhost                                                */
/* Port     : 3306                                                     */
/* Database : lista_piosenek                                           */


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES 'utf8' */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `lista_piosenek`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `lista_piosenek`;

/* Structure for the `element_muzyczny` table :  */

CREATE TABLE `element_muzyczny` (
  `id_serial` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `ip` TEXT COLLATE utf8_general_ci,
  `nazwa` TEXT COLLATE utf8_general_ci,
  `rodzaj` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `dodajacy` TEXT COLLATE utf8_general_ci,
  `link_youtube` TEXT COLLATE utf8_general_ci,
  `tms` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY USING BTREE (`id_serial`)
) ENGINE=InnoDB
AUTO_INCREMENT=10 ROW_FORMAT=DYNAMIC CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

/* Structure for the `glosowania` table :  */

CREATE TABLE `glosowania` (
  `id_serial` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `ip` TEXT COLLATE utf8_general_ci,
  `geo_inf` TEXT COLLATE utf8_general_ci,
  `id_webstorage` TEXT COLLATE utf8_general_ci,
  `dodajacy` TEXT COLLATE utf8_general_ci,
  `rodzaj` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `web_browser` TEXT COLLATE utf8_general_ci,
  `tms` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_element_muzyczny` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY USING BTREE (`id_serial`)
) ENGINE=InnoDB
AUTO_INCREMENT=3 ROW_FORMAT=DYNAMIC CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;