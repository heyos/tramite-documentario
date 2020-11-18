/*
Navicat MySQL Data Transfer

Source Server         : local-PC
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : table_on_table

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-01-29 14:39:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `configuracion_sistema`
-- ----------------------------
DROP TABLE IF EXISTS `configuracion_sistema`;
CREATE TABLE `configuracion_sistema` (
  `id_configuracion` int(11) NOT NULL AUTO_INCREMENT,
  `temas` enum('theme-default','theme-adminflare','theme-asphalt','theme-dust','theme-fresh','theme-frost','theme-purple-hills','theme-silver','theme-white','theme-clean') NOT NULL DEFAULT 'theme-default',
  `vista_menu` varchar(15) NOT NULL,
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configuracion_sistema
-- ----------------------------
INSERT INTO `configuracion_sistema` VALUES ('2', 'theme-default', 'menu_lateral');

-- ----------------------------
-- Table structure for `contacto_persona_juridica`
-- ----------------------------
DROP TABLE IF EXISTS `contacto_persona_juridica`;
CREATE TABLE `contacto_persona_juridica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nIdPersona` int(11) DEFAULT NULL,
  `nIdPersona_ref` int(11) DEFAULT NULL,
  `cCargo` varchar(20) DEFAULT NULL,
  `nIdDireccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacto_persona_juridica
-- ----------------------------
INSERT INTO `contacto_persona_juridica` VALUES ('13', '17', '15', '300', '12');
INSERT INTO `contacto_persona_juridica` VALUES ('14', '18', '15', '300', '12');
INSERT INTO `contacto_persona_juridica` VALUES ('15', '19', '15', '298', '12');
INSERT INTO `contacto_persona_juridica` VALUES ('16', '18', '15', '298', '15');
INSERT INTO `contacto_persona_juridica` VALUES ('17', '19', '15', '300', '15');

-- ----------------------------
-- Table structure for `detalle_menu`
-- ----------------------------
DROP TABLE IF EXISTS `detalle_menu`;
CREATE TABLE `detalle_menu` (
  `id_detalle_m` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `mantenimiento` enum('0','1') NOT NULL DEFAULT '0',
  `acceso` enum('0','1') NOT NULL DEFAULT '0',
  `id_rol` int(11) NOT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_detalle_m`),
  KEY `id_menu` (`id_menu`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `detalle_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_menu_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of detalle_menu
-- ----------------------------
INSERT INTO `detalle_menu` VALUES ('129', '67', '1', '1', '3', '0');
INSERT INTO `detalle_menu` VALUES ('130', '66', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('131', '14', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('132', '16', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('133', '67', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('134', '7', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('135', '68', '1', '1', '1', '0');
INSERT INTO `detalle_menu` VALUES ('136', '69', '1', '1', '1', '0');

-- ----------------------------
-- Table structure for `detalle_sub_m`
-- ----------------------------
DROP TABLE IF EXISTS `detalle_sub_m`;
CREATE TABLE `detalle_sub_m` (
  `id_detalle_s` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub_menu` int(11) NOT NULL,
  `acceso` enum('1','0') NOT NULL DEFAULT '1',
  `id_rol` int(11) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_detalle_s`),
  KEY `id_sub_menu` (`id_sub_menu`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `detalle_sub_m_ibfk_1` FOREIGN KEY (`id_sub_menu`) REFERENCES `sub_menu` (`id_sub_menu`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_sub_m_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of detalle_sub_m
-- ----------------------------
INSERT INTO `detalle_sub_m` VALUES ('209', '16', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('210', '12', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('211', '19', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('212', '54', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('213', '21', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('214', '126', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('215', '51', '1', '1', '0');
INSERT INTO `detalle_sub_m` VALUES ('216', '52', '1', '1', '0');

-- ----------------------------
-- Table structure for `direccion`
-- ----------------------------
DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nIdPersona` int(11) DEFAULT NULL,
  `nIdComuna` int(11) DEFAULT NULL,
  `cDirEnt` varchar(50) DEFAULT NULL,
  `xNumDir` char(15) DEFAULT NULL,
  `cPais` int(11) DEFAULT NULL,
  `xTelEnt1` varchar(15) DEFAULT NULL,
  `xTelEnt2` varchar(15) DEFAULT NULL,
  `xEmail` varchar(40) DEFAULT NULL,
  `xFaxEnt` varchar(15) DEFAULT NULL,
  `xNomFaena` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of direccion
-- ----------------------------
INSERT INTO `direccion` VALUES ('11', '15', '264', 'Jr Alfonso Ugarte', '200', '286', '943194241', '', 'asaasasa@gmail.c', '', 'Faena 1');
INSERT INTO `direccion` VALUES ('12', '15', '264', 'Jr San jose', '203', '288', '', '', '', '', 'Faena 3');
INSERT INTO `direccion` VALUES ('13', '17', '264', 'qqqqq', '130', '286', '', '', '', '', 'Faena 4');
INSERT INTO `direccion` VALUES ('14', '17', '264', 'xxxx', '120', '286', '', '', '', '', 'xxxx');
INSERT INTO `direccion` VALUES ('15', '15', '264', 'Jr Bolognesi', '200', '286', '', '', 'aaaaa@g.com', '', 'Faena 4');
INSERT INTO `direccion` VALUES ('16', '17', '268', 'prueba', '125', '288', '', '', '', '', 'Faena 5');

-- ----------------------------
-- Table structure for `empresa`
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `actividad_economica` varchar(60) NOT NULL,
  `propietario` varchar(60) NOT NULL,
  `foto` text NOT NULL,
  `direccion` text NOT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresa
-- ----------------------------
INSERT INTO `empresa` VALUES ('3', 'HR Menu Manager', '', 'restaurante', 'HR Developer Group', 'empresa_141.jpg', 'Jr Bolognesi 441');

-- ----------------------------
-- Table structure for `file_js`
-- ----------------------------
DROP TABLE IF EXISTS `file_js`;
CREATE TABLE `file_js` (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file_js
-- ----------------------------
INSERT INTO `file_js` VALUES ('1', 'mainJsRolUsuario.js', '1', '0');
INSERT INTO `file_js` VALUES ('3', 'mainJsUsuario.js', '1', '0');
INSERT INTO `file_js` VALUES ('5', 'mainJsOrdenarMenu.js', '1', '0');
INSERT INTO `file_js` VALUES ('6', 'mainJsOrdenarSubmenu.js', '1', '0');
INSERT INTO `file_js` VALUES ('7', 'mainJsPermisosUsuario.js', '1', '0');
INSERT INTO `file_js` VALUES ('9', 'mainJsEmpresa.js', '1', '0');
INSERT INTO `file_js` VALUES ('10', 'mainJsMenu.js', '1', '0');
INSERT INTO `file_js` VALUES ('24', 'mainJsTablaLogica.js', '0', '0');
INSERT INTO `file_js` VALUES ('25', 'mainJsIngresarDatos.js', '0', '0');
INSERT INTO `file_js` VALUES ('26', 'mainJsCliente.js', '0', '0');
INSERT INTO `file_js` VALUES ('27', 'mainJsPaciente.js', '0', '0');

-- ----------------------------
-- Table structure for `js_menu_asociado`
-- ----------------------------
DROP TABLE IF EXISTS `js_menu_asociado`;
CREATE TABLE `js_menu_asociado` (
  `id_js` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_sub_menu` int(11) DEFAULT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_js`),
  KEY `id_menu` (`id_menu`) USING BTREE,
  KEY `id_sub_menu` (`id_sub_menu`),
  KEY `id_file` (`id_file`) USING BTREE,
  CONSTRAINT `js_menu_asociado_ibfk_1` FOREIGN KEY (`id_file`) REFERENCES `file_js` (`id_file`) ON UPDATE CASCADE,
  CONSTRAINT `js_menu_asociado_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE,
  CONSTRAINT `js_menu_asociado_ibfk_3` FOREIGN KEY (`id_sub_menu`) REFERENCES `sub_menu` (`id_sub_menu`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of js_menu_asociado
-- ----------------------------
INSERT INTO `js_menu_asociado` VALUES ('27', '1', null, '16', '0');
INSERT INTO `js_menu_asociado` VALUES ('28', '3', null, '19', '0');
INSERT INTO `js_menu_asociado` VALUES ('71', '3', null, '12', '0');
INSERT INTO `js_menu_asociado` VALUES ('72', '5', null, '51', '0');
INSERT INTO `js_menu_asociado` VALUES ('73', '6', null, '52', '0');
INSERT INTO `js_menu_asociado` VALUES ('74', '7', null, '54', '0');
INSERT INTO `js_menu_asociado` VALUES ('75', '9', null, '21', '0');
INSERT INTO `js_menu_asociado` VALUES ('106', '9', null, '126', '0');
INSERT INTO `js_menu_asociado` VALUES ('111', '24', '66', null, '0');
INSERT INTO `js_menu_asociado` VALUES ('113', '25', '67', null, '0');
INSERT INTO `js_menu_asociado` VALUES ('114', '26', '68', null, '0');
INSERT INTO `js_menu_asociado` VALUES ('115', '27', '69', null, '0');

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `icono` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('7', 'Configuracion', 'fa fa-cog', '#', '4', '1', '1', '0');
INSERT INTO `menu` VALUES ('14', 'Usuarios', 'fas fa-users', '#', '3', '1', '1', '0');
INSERT INTO `menu` VALUES ('16', 'Menu No visibles', 'far fa-eye-slash', '#', '5', '0', '1', '0');
INSERT INTO `menu` VALUES ('66', 'Tabla Logica', 'fa fa-sitemap', 'tabla_logica', '1', '1', '0', '0');
INSERT INTO `menu` VALUES ('67', 'Ingresar Datos En Tabla', 'fas fa-file-signature', 'ingresar_datos', '2', '1', '0', '0');
INSERT INTO `menu` VALUES ('68', 'Mantenedor De Clientes', 'fa fa-user', 'cliente', '0', '1', '0', '0');
INSERT INTO `menu` VALUES ('69', 'Mantenedor De Pacientes', 'fa fa-user', 'paciente', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for `persona`
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nRutPer` varchar(11) DEFAULT NULL,
  `xNombre` varchar(40) DEFAULT NULL,
  `xApePat` varchar(40) DEFAULT NULL,
  `xApeMat` varchar(40) DEFAULT NULL,
  `cSexo` varchar(1) DEFAULT NULL,
  `dFecNac` date DEFAULT NULL,
  `xRazSoc` varchar(30) DEFAULT '',
  `xTipoPer` varchar(1) DEFAULT NULL,
  `cPais` int(11) DEFAULT NULL,
  `xActEco` varchar(10) DEFAULT '',
  `cTipCar` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of persona
-- ----------------------------
INSERT INTO `persona` VALUES ('15', '12872741-8', null, null, null, null, null, 'HR Coyd', 'j', '286', 'Desarrollo', null);
INSERT INTO `persona` VALUES ('17', '12872741-8', 'heyller', 'reyes', 'aranda', 'M', '1990-02-17', null, 'n', null, '', '300');
INSERT INTO `persona` VALUES ('18', '17108095-9', 'Carlos', 'Sanchez', 'Perez', 'M', null, null, 'n', null, '', '298');
INSERT INTO `persona` VALUES ('19', '12460579-2', 'Santos', 'Sandoval', 'Ramirez', 'M', '1970-01-01', null, 'n', null, '', '298');

-- ----------------------------
-- Table structure for `rol_usuario`
-- ----------------------------
DROP TABLE IF EXISTS `rol_usuario`;
CREATE TABLE `rol_usuario` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `mostrar_inicio` enum('0','1') NOT NULL DEFAULT '0',
  `notificar` varchar(100) NOT NULL,
  `page_inicio` varchar(60) NOT NULL DEFAULT 'inicio',
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rol_usuario
-- ----------------------------
INSERT INTO `rol_usuario` VALUES ('1', 'Admin', '1', '', 'inicio', '0');
INSERT INTO `rol_usuario` VALUES ('2', 'Vendedor', '0', '', 'inicio', '0');
INSERT INTO `rol_usuario` VALUES ('3', 'Editor', '0', '', 'ingresar_datos', '0');

-- ----------------------------
-- Table structure for `sub_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sub_menu`;
CREATE TABLE `sub_menu` (
  `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_sub_menu`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sub_menu
-- ----------------------------
INSERT INTO `sub_menu` VALUES ('12', 'Registrar Usuarios', 'registrar_usuarios', '14', '2', '1', '0');
INSERT INTO `sub_menu` VALUES ('16', 'Rol Usuario', 'rol_usuario', '14', '1', '1', '0');
INSERT INTO `sub_menu` VALUES ('19', 'Buscar Usuarios', 'buscar_usuarios', '14', '3', '1', '0');
INSERT INTO `sub_menu` VALUES ('21', 'Empresa', 'empresa', '7', '1', '1', '0');
INSERT INTO `sub_menu` VALUES ('51', 'Ordenar Menu', 'ordenar_menu', '7', '3', '1', '0');
INSERT INTO `sub_menu` VALUES ('52', 'Ordenar Submenu', 'ordenar_submenu', '7', '4', '1', '0');
INSERT INTO `sub_menu` VALUES ('54', 'Permisos Usuario', 'permisos_usuario', '16', '0', '1', '0');
INSERT INTO `sub_menu` VALUES ('126', 'Configurar Sistema', 'configurar_sistema', '7', '2', '1', '0');

-- ----------------------------
-- Table structure for `tabla_logica`
-- ----------------------------
DROP TABLE IF EXISTS `tabla_logica`;
CREATE TABLE `tabla_logica` (
  `id_tbl` int(11) NOT NULL AUTO_INCREMENT,
  `cidtabla` text NOT NULL,
  `xidelem` text NOT NULL,
  `xvalor1` text NOT NULL,
  `xvalor2` text NOT NULL,
  `nvalor1` double NOT NULL,
  `nvalor2` double NOT NULL,
  `validar_campos` text DEFAULT NULL,
  `columnas` text DEFAULT NULL,
  `tipo` enum('T','V') NOT NULL COMMENT 'T:tabla, V:value',
  PRIMARY KEY (`id_tbl`)
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tabla_logica
-- ----------------------------
INSERT INTO `tabla_logica` VALUES ('223', 'COMUNAS', 'TAB_DESC', 'COMUNAS', '', '0', '0', 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('224', 'COMUNAS', 'TAB_ID', 'Codigo', '', '1', '0', 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('225', 'COMUNAS', 'TAB_X1', 'Nombre Largo Comuna', 'Nom Comuna', '1', '0', 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('226', 'COMUNAS', 'TAB_X2', 'Nombre Corto Comuna', 'Nom Comuna', '1', '0', 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('227', 'COMUNAS', 'TAB_N1', 'Ciudad', '', '1', '0', 'numerico', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('228', 'COMUNAS', 'TAB_N2', '', '', '0', '0', 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T');
INSERT INTO `tabla_logica` VALUES ('229', 'GENERO', 'TAB_DESC', 'GENERO', '', '0', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('230', 'GENERO', 'TAB_ID', 'Codigo', '', '1', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('231', 'GENERO', 'TAB_X1', 'Nombre', '', '1', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('232', 'GENERO', 'TAB_X2', 'Nombre Corto', '', '1', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('233', 'GENERO', 'TAB_N1', '', '', '0', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('234', 'GENERO', 'TAB_N2', '', '', '0', '0', 'string', 'Codigo - Nombre - Nombre Corto', 'T');
INSERT INTO `tabla_logica` VALUES ('263', 'COMUNAS', '001', '001', '', '0', '0', '001@TAB_ID@COMUNAS', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('264', 'COMUNAS', '001', 'Santiago', '', '0', '0', 'Santiago@TAB_X1@COMUNAS', 'Nombre Largo Comuna@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('265', 'COMUNAS', '001', 'San', '', '0', '0', 'San@TAB_X2@COMUNAS', 'Nombre Corto Comuna@TAB_X2', 'V');
INSERT INTO `tabla_logica` VALUES ('266', 'COMUNAS', '001', '001', '', '0', '0', '001@TAB_N1@COMUNAS', 'Ciudad@TAB_N1', 'V');
INSERT INTO `tabla_logica` VALUES ('267', 'COMUNAS', '002', '002', '', '0', '0', '002@TAB_ID@COMUNAS', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('268', 'COMUNAS', '002', 'La Colmena', '', '0', '0', 'La Colmena@TAB_X1@COMUNAS', 'Nombre Largo Comuna@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('269', 'COMUNAS', '002', 'Col', '', '0', '0', 'Col@TAB_X2@COMUNAS', 'Nombre Corto Comuna@TAB_X2', 'V');
INSERT INTO `tabla_logica` VALUES ('270', 'COMUNAS', '001', '', '', '0', '0', '@COMUNAS', 'Campo Extra@TAB_N2', 'V');
INSERT INTO `tabla_logica` VALUES ('271', 'COMUNAS', '002', '002', '', '0', '0', '002@TAB_N1@COMUNAS', 'Ciudad@TAB_N1', 'V');
INSERT INTO `tabla_logica` VALUES ('272', 'COMUNAS', '002', '', '', '0', '0', '@COMUNAS', 'Campo Extra@TAB_N2', 'V');
INSERT INTO `tabla_logica` VALUES ('273', 'GENERO', '001', '001', '', '0', '0', '001@TAB_ID@GENERO', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('274', 'GENERO', '001', 'Masculino', '', '0', '0', 'Masculino@TAB_X1@GENERO', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('275', 'GENERO', '001', 'M', '', '0', '0', 'M@TAB_X2@GENERO', 'Nombre Corto@TAB_X2', 'V');
INSERT INTO `tabla_logica` VALUES ('276', 'GENERO', '002', '002', '', '0', '0', '002@TAB_ID@GENERO', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('277', 'GENERO', '002', 'Femenino', '', '0', '0', 'Femenino@TAB_X1@GENERO', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('278', 'GENERO', '002', 'F', '', '0', '0', 'F@TAB_X2@GENERO', 'Nombre Corto@TAB_X2', 'V');
INSERT INTO `tabla_logica` VALUES ('279', 'PAIS', 'TAB_DESC', 'PAIS', '', '0', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('280', 'PAIS', 'TAB_ID', 'Codigo', '', '1', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('281', 'PAIS', 'TAB_X1', 'Nombre', '', '1', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('282', 'PAIS', 'TAB_X2', '', '', '0', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('283', 'PAIS', 'TAB_N1', '', '', '0', '0', 'numerico', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('284', 'PAIS', 'TAB_N2', '', '', '0', '0', 'numerico', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('285', 'PAIS', '001', '001', '', '0', '0', '001@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('286', 'PAIS', '001', 'Peru', '', '0', '0', 'Peru@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('287', 'PAIS', '002', '002', '', '0', '0', '002@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('288', 'PAIS', '002', 'Chile', '', '0', '0', 'Chile@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('289', 'PAIS', '003', '003', '', '0', '0', '003@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('290', 'PAIS', '003', 'Argentina', '', '0', '0', 'Argentina@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('291', 'CARGO', 'TAB_DESC', 'CARGO', '', '0', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('292', 'CARGO', 'TAB_ID', 'Codigo', '', '1', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('293', 'CARGO', 'TAB_X1', 'Nombre', '', '1', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('294', 'CARGO', 'TAB_X2', '', '', '0', '0', 'string', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('295', 'CARGO', 'TAB_N1', '', '', '0', '0', 'numerico', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('296', 'CARGO', 'TAB_N2', '', '', '0', '0', 'numerico', 'Codigo - Nombre', 'T');
INSERT INTO `tabla_logica` VALUES ('297', 'CARGO', '001', '001', '', '0', '0', '001@TAB_ID@CARGO', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('298', 'CARGO', '001', 'Administrador', '', '0', '0', 'Administrador@TAB_X1@CARGO', 'Nombre@TAB_X1', 'V');
INSERT INTO `tabla_logica` VALUES ('299', 'CARGO', '002', '002', '', '0', '0', '002@TAB_ID@CARGO', 'Codigo@TAB_ID', 'V');
INSERT INTO `tabla_logica` VALUES ('300', 'CARGO', '002', 'Ingeniero', '', '0', '0', 'Ingeniero@TAB_X1@CARGO', 'Nombre@TAB_X1', 'V');

-- ----------------------------
-- Table structure for `usuario`
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `num_tel` varchar(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `intentos` int(11) NOT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('4', '99999999', 'Admin', 'Admin', '', '1', 'admin', '$2a$07$6JI262/2JA73J2K74J5J4uY2g1uZ4W/L66ZESY0AEQInCw90KOyvq', '0', '0');
INSERT INTO `usuario` VALUES ('13', '99999998', 'User', 'User', '', '3', 'editor', '$2a$07$DKDK954D2B/9J9KE0KC3K.LU5ztiTihfEXtAJdA5brnYQFtYC6QlG', '0', '0');
