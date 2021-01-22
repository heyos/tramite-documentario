-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2021 a las 11:06:08
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tramite_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_sistema`
--

CREATE TABLE `configuracion_sistema` (
  `id_configuracion` int(11) NOT NULL,
  `temas` enum('theme-default','theme-adminflare','theme-asphalt','theme-dust','theme-fresh','theme-frost','theme-purple-hills','theme-silver','theme-white','theme-clean') NOT NULL DEFAULT 'theme-default',
  `vista_menu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion_sistema`
--

INSERT INTO `configuracion_sistema` (`id_configuracion`, `temas`, `vista_menu`) VALUES
(2, 'theme-default', 'menu_lateral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_persona_juridica`
--

CREATE TABLE `contacto_persona_juridica` (
  `id` int(11) NOT NULL,
  `nIdPersona` int(11) DEFAULT NULL,
  `nIdPersona_ref` int(11) DEFAULT NULL,
  `cCargo` varchar(20) DEFAULT NULL,
  `nIdDireccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contacto_persona_juridica`
--

INSERT INTO `contacto_persona_juridica` (`id`, `nIdPersona`, `nIdPersona_ref`, `cCargo`, `nIdDireccion`) VALUES
(13, 17, 15, '300', 12),
(14, 18, 15, '300', 12),
(15, 19, 15, '298', 12),
(16, 18, 15, '298', 15),
(17, 19, 15, '300', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_menu`
--

CREATE TABLE `detalle_menu` (
  `id_detalle_m` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `mantenimiento` enum('0','1') NOT NULL DEFAULT '0',
  `acceso` enum('0','1') NOT NULL DEFAULT '0',
  `id_rol` int(11) NOT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_menu`
--

INSERT INTO `detalle_menu` (`id_detalle_m`, `id_menu`, `mantenimiento`, `acceso`, `id_rol`, `borrado`) VALUES
(129, 67, '1', '1', 3, '0'),
(130, 66, '1', '0', 1, '0'),
(131, 14, '1', '1', 1, '0'),
(132, 16, '1', '1', 1, '0'),
(133, 67, '1', '0', 1, '0'),
(134, 7, '1', '1', 1, '0'),
(135, 68, '0', '0', 1, '0'),
(136, 69, '0', '0', 1, '0'),
(137, 70, '1', '1', 1, '0'),
(138, 71, '1', '1', 1, '0'),
(139, 72, '1', '1', 1, '0'),
(140, 73, '1', '1', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_sub_m`
--

CREATE TABLE `detalle_sub_m` (
  `id_detalle_s` int(11) NOT NULL,
  `id_sub_menu` int(11) NOT NULL,
  `acceso` enum('1','0') NOT NULL DEFAULT '1',
  `id_rol` int(11) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_sub_m`
--

INSERT INTO `detalle_sub_m` (`id_detalle_s`, `id_sub_menu`, `acceso`, `id_rol`, `borrado`) VALUES
(209, 16, '1', 1, '0'),
(210, 12, '1', 1, '0'),
(211, 19, '1', 1, '0'),
(212, 54, '1', 1, '0'),
(213, 21, '1', 1, '0'),
(214, 126, '1', 1, '0'),
(215, 51, '1', 1, '0'),
(216, 52, '1', 1, '0'),
(217, 127, '1', 1, '0'),
(218, 128, '1', 1, '0'),
(219, 129, '1', 1, '0'),
(220, 131, '1', 1, '0'),
(221, 130, '1', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id` int(11) NOT NULL,
  `nIdPersona` int(11) DEFAULT NULL,
  `nIdComuna` int(11) DEFAULT NULL,
  `cDirEnt` varchar(50) DEFAULT NULL,
  `xNumDir` char(15) DEFAULT NULL,
  `cPais` int(11) DEFAULT NULL,
  `xTelEnt1` varchar(15) DEFAULT NULL,
  `xTelEnt2` varchar(15) DEFAULT NULL,
  `xEmail` varchar(40) DEFAULT NULL,
  `xFaxEnt` varchar(15) DEFAULT NULL,
  `xNomFaena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id`, `nIdPersona`, `nIdComuna`, `cDirEnt`, `xNumDir`, `cPais`, `xTelEnt1`, `xTelEnt2`, `xEmail`, `xFaxEnt`, `xNomFaena`) VALUES
(11, 15, 264, 'Jr Alfonso Ugarte', '200', 286, '943194241', '', 'asaasasa@gmail.c', '', 'Faena 1'),
(12, 15, 264, 'Jr San jose', '203', 288, '', '', '', '', 'Faena 3'),
(13, 17, 264, 'qqqqq', '130', 286, '', '', '', '', 'Faena 4'),
(14, 17, 264, 'xxxx', '120', 286, '', '', '', '', 'xxxx'),
(15, 15, 264, 'Jr Bolognesi', '200', 286, '', '', 'aaaaa@g.com', '', 'Faena 4'),
(16, 17, 268, 'prueba', '125', 288, '', '', '', '', 'Faena 5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` bigint(20) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `tipodocumento_id` int(11) NOT NULL,
  `lista_usuarios_firma` text NOT NULL,
  `ruta_file` text DEFAULT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `usuario_modifica` varchar(100) DEFAULT NULL,
  `fecha_modifica` int(11) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_usuario`
--

CREATE TABLE `documento_usuario` (
  `id` bigint(20) NOT NULL,
  `documento_id` bigint(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `usuario_modifica` varchar(100) DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `actividad_economica` varchar(60) NOT NULL,
  `propietario` varchar(60) NOT NULL,
  `foto` text NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre`, `telefono`, `actividad_economica`, `propietario`, `foto`, `direccion`) VALUES
(3, 'Medinort', '', 'centro medico', 'HR Developer Group', 'empresa_141.jpg', 'Jr Bolognesi 441');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `file_js`
--

CREATE TABLE `file_js` (
  `id_file` int(11) NOT NULL,
  `file` text NOT NULL,
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `file_js`
--

INSERT INTO `file_js` (`id_file`, `file`, `sistema`, `borrado`) VALUES
(1, 'mainJsRolUsuario.js', '1', '0'),
(3, 'mainJsUsuario.js', '1', '0'),
(5, 'mainJsOrdenarMenu.js', '1', '0'),
(6, 'mainJsOrdenarSubmenu.js', '1', '0'),
(7, 'mainJsPermisosUsuario.js', '1', '0'),
(9, 'mainJsEmpresa.js', '1', '0'),
(10, 'mainJsMenu.js', '1', '0'),
(24, 'mainJsTablaLogica.js', '0', '0'),
(25, 'mainJsIngresarDatos.js', '0', '0'),
(26, 'mainJsCliente.js', '0', '0'),
(27, 'mainJsPaciente.js', '0', '0'),
(28, 'mainJsTipoDocumento.js', '0', '0'),
(29, 'mainJsTipoExamen.js', '0', '0'),
(30, 'mainJsDocumentos.js', '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `js_menu_asociado`
--

CREATE TABLE `js_menu_asociado` (
  `id_js` int(11) NOT NULL,
  `id_file` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_sub_menu` int(11) DEFAULT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `js_menu_asociado`
--

INSERT INTO `js_menu_asociado` (`id_js`, `id_file`, `id_menu`, `id_sub_menu`, `borrado`) VALUES
(27, 1, NULL, 16, '0'),
(28, 3, NULL, 19, '0'),
(71, 3, NULL, 12, '0'),
(72, 5, NULL, 51, '0'),
(73, 6, NULL, 52, '0'),
(74, 7, NULL, 54, '0'),
(75, 9, NULL, 21, '0'),
(106, 9, NULL, 126, '0'),
(111, 24, 66, NULL, '0'),
(113, 25, 67, NULL, '0'),
(114, 26, 68, NULL, '0'),
(115, 27, 69, NULL, '0'),
(116, 26, NULL, 127, '0'),
(117, 27, NULL, 128, '0'),
(118, 28, NULL, 129, '0'),
(119, 29, NULL, 131, '0'),
(120, 30, NULL, 130, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `icono` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `descripcion`, `icono`, `url`, `orden`, `visible`, `sistema`, `borrado`) VALUES
(7, 'Configuracion', 'fa fa-cog', '#', 10, '1', '1', '0'),
(14, 'Usuarios', 'fas fa-users', '#', 9, '1', '1', '0'),
(16, 'Menu No visibles', 'far fa-eye-slash', '#', 11, '0', '1', '0'),
(66, 'Tabla Logica', 'fa fa-sitemap', 'tabla_logica', 7, '1', '0', '0'),
(67, 'Ingresar Datos En Tabla', 'fas fa-file-signature', 'ingresar_datos', 8, '1', '0', '0'),
(68, 'Mantenedor De Clientes', 'fa fa-user', 'cliente', 5, '1', '0', '0'),
(69, 'Mantenedor De Pacientes', 'fa fa-user', 'paciente', 6, '1', '0', '0'),
(70, 'Mantenedor', 'fa fa-bars', '#', 1, '1', '0', '0'),
(71, 'Bandeja De Entrada', 'far fa-folder-open', 'bandeja_de_entrada', 2, '1', '0', '0'),
(72, 'Gestion De Documentos', 'far fa-folder', '#', 3, '1', '0', '0'),
(73, 'Asignacion De Firmas', 'fas fa-file-signature', 'asignacion_de_firmas', 4, '1', '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nRutPer` varchar(100) DEFAULT '',
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
  `deleted` enum('0','1') DEFAULT '0',
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `usuario_modifica` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nRutPer`, `xNombre`, `xApePat`, `xApeMat`, `cSexo`, `dFecNac`, `xRazSoc`, `xTipoPer`, `cPais`, `xActEco`, `cTipCar`, `deleted`, `fecha_crea`, `fecha_modifica`, `usuario_crea`, `usuario_modifica`) VALUES
(15, '12.872.741-8', NULL, NULL, NULL, NULL, NULL, 'HR Cody', 'j', 286, 'Desarrollo', NULL, '0', NULL, NULL, NULL, NULL),
(17, '12.872.741-8', 'heyller', 'reyes', 'aranda', 'M', '1990-02-17', NULL, 'n', NULL, '', 300, '0', NULL, NULL, NULL, NULL),
(18, '5.345.382-1', 'Carlos', 'Sanchez', 'Perez', 'M', NULL, NULL, 'n', NULL, '', 298, '0', NULL, NULL, NULL, NULL),
(19, '15.764.719-9', 'Santos', 'Sandoval', 'Ramirez', 'M', '1970-01-01', NULL, 'n', NULL, '', 298, '0', NULL, NULL, NULL, NULL),
(20, '18.326.824-4', NULL, NULL, NULL, NULL, NULL, 'Servicios Generales', 'j', 286, 'aaaaaaaaaa', NULL, '0', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `id_rol` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `mostrar_inicio` enum('0','1') NOT NULL DEFAULT '0',
  `notificar` varchar(100) NOT NULL,
  `page_inicio` varchar(60) NOT NULL DEFAULT 'inicio',
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`id_rol`, `descripcion`, `mostrar_inicio`, `notificar`, `page_inicio`, `borrado`) VALUES
(1, 'Admin', '1', '', 'inicio', '0'),
(2, 'Vendedor', '0', '', 'inicio', '0'),
(3, 'Editor', '0', '', 'ingresar_datos', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `sistema` enum('1','0') NOT NULL DEFAULT '0',
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sub_menu`
--

INSERT INTO `sub_menu` (`id_sub_menu`, `descripcion`, `url`, `id_menu`, `orden`, `sistema`, `borrado`) VALUES
(12, 'Registrar Usuarios', 'registrar_usuarios', 14, 2, '1', '0'),
(16, 'Rol Usuario', 'rol_usuario', 14, 1, '1', '0'),
(19, 'Buscar Usuarios', 'buscar_usuarios', 14, 3, '1', '0'),
(21, 'Empresa', 'empresa', 7, 1, '1', '0'),
(51, 'Ordenar Menu', 'ordenar_menu', 7, 3, '1', '0'),
(52, 'Ordenar Submenu', 'ordenar_submenu', 7, 4, '1', '0'),
(54, 'Permisos Usuario', 'permisos_usuario', 16, 0, '1', '0'),
(126, 'Configurar Sistema', 'configurar_sistema', 7, 2, '1', '0'),
(127, 'Clientes', 'clientes', 70, 1, '0', '0'),
(128, 'Pacientes', 'pacientes', 70, 2, '0', '0'),
(129, 'Tipo Documento', 'tipo_documento', 70, 4, '0', '0'),
(130, 'Crear Documentos', 'crear_documentos', 72, 0, '0', '0'),
(131, 'Tipo Examen', 'tipo_examen', 70, 3, '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_logica`
--

CREATE TABLE `tabla_logica` (
  `id_tbl` int(11) NOT NULL,
  `cidtabla` text NOT NULL,
  `xidelem` text NOT NULL,
  `xvalor1` text NOT NULL,
  `xvalor2` text NOT NULL,
  `nvalor1` double NOT NULL,
  `nvalor2` double NOT NULL,
  `validar_campos` text DEFAULT NULL,
  `columnas` text DEFAULT NULL,
  `tipo` enum('T','V') NOT NULL COMMENT 'T:tabla, V:value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_logica`
--

INSERT INTO `tabla_logica` (`id_tbl`, `cidtabla`, `xidelem`, `xvalor1`, `xvalor2`, `nvalor1`, `nvalor2`, `validar_campos`, `columnas`, `tipo`) VALUES
(223, 'COMUNAS', 'TAB_DESC', 'COMUNAS', '', 0, 0, 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(224, 'COMUNAS', 'TAB_ID', 'Codigo', '', 1, 0, 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(225, 'COMUNAS', 'TAB_X1', 'Nombre Largo Comuna', 'Nom Comuna', 1, 0, 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(226, 'COMUNAS', 'TAB_X2', 'Nombre Corto Comuna', 'Nom Comuna', 1, 0, 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(227, 'COMUNAS', 'TAB_N1', 'Ciudad', '', 1, 0, 'numerico', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(228, 'COMUNAS', 'TAB_N2', '', '', 0, 0, 'string', 'Codigo - Nombre Largo Comuna - Nombre Corto Comuna - Ciudad', 'T'),
(229, 'GENERO', 'TAB_DESC', 'GENERO', '', 0, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(230, 'GENERO', 'TAB_ID', 'Codigo', '', 1, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(231, 'GENERO', 'TAB_X1', 'Nombre', '', 1, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(232, 'GENERO', 'TAB_X2', 'Nombre Corto', '', 1, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(233, 'GENERO', 'TAB_N1', '', '', 0, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(234, 'GENERO', 'TAB_N2', '', '', 0, 0, 'string', 'Codigo - Nombre - Nombre Corto', 'T'),
(263, 'COMUNAS', '001', '001', '', 0, 0, '001@TAB_ID@COMUNAS', 'Codigo@TAB_ID', 'V'),
(264, 'COMUNAS', '001', 'Santiago', '', 0, 0, 'Santiago@TAB_X1@COMUNAS', 'Nombre Largo Comuna@TAB_X1', 'V'),
(265, 'COMUNAS', '001', 'San', '', 0, 0, 'San@TAB_X2@COMUNAS', 'Nombre Corto Comuna@TAB_X2', 'V'),
(266, 'COMUNAS', '001', '001', '', 0, 0, '001@TAB_N1@COMUNAS', 'Ciudad@TAB_N1', 'V'),
(267, 'COMUNAS', '002', '002', '', 0, 0, '002@TAB_ID@COMUNAS', 'Codigo@TAB_ID', 'V'),
(268, 'COMUNAS', '002', 'La Colmena', '', 0, 0, 'La Colmena@TAB_X1@COMUNAS', 'Nombre Largo Comuna@TAB_X1', 'V'),
(269, 'COMUNAS', '002', 'Col', '', 0, 0, 'Col@TAB_X2@COMUNAS', 'Nombre Corto Comuna@TAB_X2', 'V'),
(270, 'COMUNAS', '001', '', '', 0, 0, '@COMUNAS', 'Campo Extra@TAB_N2', 'V'),
(271, 'COMUNAS', '002', '002', '', 0, 0, '002@TAB_N1@COMUNAS', 'Ciudad@TAB_N1', 'V'),
(272, 'COMUNAS', '002', '', '', 0, 0, '@COMUNAS', 'Campo Extra@TAB_N2', 'V'),
(273, 'GENERO', '001', '001', '', 0, 0, '001@TAB_ID@GENERO', 'Codigo@TAB_ID', 'V'),
(274, 'GENERO', '001', 'Masculino', '', 0, 0, 'Masculino@TAB_X1@GENERO', 'Nombre@TAB_X1', 'V'),
(275, 'GENERO', '001', 'M', '', 0, 0, 'M@TAB_X2@GENERO', 'Nombre Corto@TAB_X2', 'V'),
(276, 'GENERO', '002', '002', '', 0, 0, '002@TAB_ID@GENERO', 'Codigo@TAB_ID', 'V'),
(277, 'GENERO', '002', 'Femenino', '', 0, 0, 'Femenino@TAB_X1@GENERO', 'Nombre@TAB_X1', 'V'),
(278, 'GENERO', '002', 'F', '', 0, 0, 'F@TAB_X2@GENERO', 'Nombre Corto@TAB_X2', 'V'),
(279, 'PAIS', 'TAB_DESC', 'PAIS', '', 0, 0, 'string', 'Codigo - Nombre', 'T'),
(280, 'PAIS', 'TAB_ID', 'Codigo', '', 1, 0, 'string', 'Codigo - Nombre', 'T'),
(281, 'PAIS', 'TAB_X1', 'Nombre', '', 1, 0, 'string', 'Codigo - Nombre', 'T'),
(282, 'PAIS', 'TAB_X2', '', '', 0, 0, 'string', 'Codigo - Nombre', 'T'),
(283, 'PAIS', 'TAB_N1', '', '', 0, 0, 'numerico', 'Codigo - Nombre', 'T'),
(284, 'PAIS', 'TAB_N2', '', '', 0, 0, 'numerico', 'Codigo - Nombre', 'T'),
(285, 'PAIS', '001', '001', '', 0, 0, '001@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V'),
(286, 'PAIS', '001', 'Peru', '', 0, 0, 'Peru@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V'),
(287, 'PAIS', '002', '002', '', 0, 0, '002@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V'),
(288, 'PAIS', '002', 'Chile', '', 0, 0, 'Chile@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V'),
(289, 'PAIS', '003', '003', '', 0, 0, '003@TAB_ID@PAIS', 'Codigo@TAB_ID', 'V'),
(290, 'PAIS', '003', 'Argentina', '', 0, 0, 'Argentina@TAB_X1@PAIS', 'Nombre@TAB_X1', 'V'),
(291, 'CARGO', 'TAB_DESC', 'CARGO', '', 0, 0, 'string', 'Codigo - Nombre', 'T'),
(292, 'CARGO', 'TAB_ID', 'Codigo', '', 1, 0, 'string', 'Codigo - Nombre', 'T'),
(293, 'CARGO', 'TAB_X1', 'Nombre', '', 1, 0, 'string', 'Codigo - Nombre', 'T'),
(294, 'CARGO', 'TAB_X2', '', '', 0, 0, 'string', 'Codigo - Nombre', 'T'),
(295, 'CARGO', 'TAB_N1', '', '', 0, 0, 'numerico', 'Codigo - Nombre', 'T'),
(296, 'CARGO', 'TAB_N2', '', '', 0, 0, 'numerico', 'Codigo - Nombre', 'T'),
(297, 'CARGO', '001', '001', '', 0, 0, '001@TAB_ID@CARGO', 'Codigo@TAB_ID', 'V'),
(298, 'CARGO', '001', 'Administrador', '', 0, 0, 'Administrador@TAB_X1@CARGO', 'Nombre@TAB_X1', 'V'),
(299, 'CARGO', '002', '002', '', 0, 0, '002@TAB_ID@CARGO', 'Codigo@TAB_ID', 'V'),
(300, 'CARGO', '002', 'Ingeniero', '', 0, 0, 'Ingeniero@TAB_X1@CARGO', 'Nombre@TAB_X1', 'V');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento_rolusuario`
--

CREATE TABLE `tipodocumento_rolusuario` (
  `id` bigint(20) NOT NULL,
  `rolUsuario_id` int(11) NOT NULL,
  `tipoDocumento_id` int(11) NOT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `usuario_modifica` varchar(100) DEFAULT '',
  `deleted` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipodocumento_rolusuario`
--

INSERT INTO `tipodocumento_rolusuario` (`id`, `rolUsuario_id`, `tipoDocumento_id`, `fecha_crea`, `fecha_modifica`, `usuario_crea`, `usuario_modifica`, `deleted`) VALUES
(1, 1, 2, NULL, NULL, NULL, NULL, '1'),
(2, 1, 3, NULL, NULL, NULL, NULL, '1'),
(3, 3, 3, NULL, NULL, NULL, NULL, '0'),
(4, 3, 2, NULL, NULL, NULL, NULL, '1'),
(5, 1, 2, NULL, NULL, NULL, NULL, '1'),
(6, 2, 2, NULL, NULL, NULL, NULL, '1'),
(7, 1, 2, NULL, NULL, NULL, NULL, '1'),
(8, 2, 2, NULL, NULL, NULL, NULL, '1'),
(9, 3, 2, NULL, NULL, NULL, NULL, '1'),
(10, 1, 2, NULL, NULL, NULL, '', '1'),
(11, 2, 2, NULL, NULL, NULL, '', '1'),
(12, 3, 2, NULL, NULL, NULL, '', '1'),
(13, 1, 2, NULL, NULL, NULL, '', '1'),
(14, 2, 2, NULL, NULL, NULL, '', '1'),
(15, 3, 2, NULL, NULL, NULL, '', '1'),
(16, 1, 2, NULL, NULL, NULL, '', '1'),
(17, 3, 2, NULL, NULL, NULL, '', '1'),
(18, 1, 2, NULL, NULL, NULL, '', '1'),
(19, 2, 2, NULL, NULL, NULL, '', '1'),
(20, 2, 2, NULL, NULL, NULL, '', '1'),
(21, 3, 2, NULL, NULL, NULL, '', '1'),
(22, 1, 2, NULL, NULL, NULL, '', '1'),
(23, 2, 2, NULL, NULL, NULL, '', '1'),
(24, 3, 2, NULL, NULL, NULL, '', '1'),
(25, 1, 2, NULL, NULL, NULL, '', '1'),
(26, 3, 2, NULL, NULL, NULL, '', '1'),
(27, 1, 2, NULL, NULL, NULL, '', '1'),
(28, 2, 2, NULL, NULL, NULL, '', '1'),
(29, 1, 3, NULL, NULL, NULL, '', '0'),
(30, 3, 2, NULL, NULL, NULL, '', '0'),
(31, 1, 2, NULL, NULL, NULL, '', '0'),
(32, 2, 2, NULL, NULL, NULL, '', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `usuario_crea` varchar(100) DEFAULT NULL,
  `usuario_modifica` varchar(100) DEFAULT '',
  `deleted` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `descripcion`, `fecha_crea`, `fecha_modifica`, `usuario_crea`, `usuario_modifica`, `deleted`) VALUES
(1, 'Carta poder', NULL, NULL, NULL, NULL, '1'),
(2, 'Radiografia', NULL, NULL, NULL, NULL, '0'),
(3, 'Receta medica', NULL, NULL, NULL, NULL, '0'),
(4, 'Receta', NULL, NULL, NULL, NULL, '1'),
(5, 'aaaaaaaaa', NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `num_tel` varchar(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `intentos` int(11) NOT NULL,
  `borrado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `dni`, `nombres`, `apellidos`, `num_tel`, `id_rol`, `username`, `password`, `intentos`, `borrado`) VALUES
(4, '99999999', 'Heyller', 'Reyes Aranda', '', 1, 'hreyes', '$2a$07$6JI262/2JA73J2K74J5J4uY2g1uZ4W/L66ZESY0AEQInCw90KOyvq', 0, '0'),
(13, '99999998', 'User', 'User', '', 3, 'editor', '$2a$07$DKDK954D2B/9J9KE0KC3K.LU5ztiTihfEXtAJdA5brnYQFtYC6QlG', 0, '0'),
(14, '99999999', 'Guillermo', 'Villalobos', '', 1, 'gvillalobos', '$2a$07$6JI262/2JA73J2K74J5J4uY2g1uZ4W/L66ZESY0AEQInCw90KOyvq', 0, '0'),
(15, '99999999', 'Miguel', 'Lazarte', '', 1, 'admin', '$2a$07$6JI262/2JA73J2K74J5J4uY2g1uZ4W/L66ZESY0AEQInCw90KOyvq', 0, '0'),
(16, '99999998', 'Juan', 'Cabrera', '', 3, 'jcabrera', '$2a$07$DKDK954D2B/9J9KE0KC3K.LU5ztiTihfEXtAJdA5brnYQFtYC6QlG', 0, '0'),
(17, '99999998', 'Carlos', 'Angulo', '', 3, 'cangulo', '$2a$07$DKDK954D2B/9J9KE0KC3K.LU5ztiTihfEXtAJdA5brnYQFtYC6QlG', 0, '0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `contacto_persona_juridica`
--
ALTER TABLE `contacto_persona_juridica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_menu`
--
ALTER TABLE `detalle_menu`
  ADD PRIMARY KEY (`id_detalle_m`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `detalle_sub_m`
--
ALTER TABLE `detalle_sub_m`
  ADD PRIMARY KEY (`id_detalle_s`),
  ADD KEY `id_sub_menu` (`id_sub_menu`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `documento_usuario`
--
ALTER TABLE `documento_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documento_id` (`documento_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `file_js`
--
ALTER TABLE `file_js`
  ADD PRIMARY KEY (`id_file`);

--
-- Indices de la tabla `js_menu_asociado`
--
ALTER TABLE `js_menu_asociado`
  ADD PRIMARY KEY (`id_js`),
  ADD KEY `id_menu` (`id_menu`) USING BTREE,
  ADD KEY `id_sub_menu` (`id_sub_menu`),
  ADD KEY `id_file` (`id_file`) USING BTREE;

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `tabla_logica`
--
ALTER TABLE `tabla_logica`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indices de la tabla `tipodocumento_rolusuario`
--
ALTER TABLE `tipodocumento_rolusuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rolUsuario_id` (`rolUsuario_id`),
  ADD KEY `tipoDocumento_id` (`tipoDocumento_id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contacto_persona_juridica`
--
ALTER TABLE `contacto_persona_juridica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_menu`
--
ALTER TABLE `detalle_menu`
  MODIFY `id_detalle_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `detalle_sub_m`
--
ALTER TABLE `detalle_sub_m`
  MODIFY `id_detalle_s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento_usuario`
--
ALTER TABLE `documento_usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `file_js`
--
ALTER TABLE `file_js`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `js_menu_asociado`
--
ALTER TABLE `js_menu_asociado`
  MODIFY `id_js` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `tabla_logica`
--
ALTER TABLE `tabla_logica`
  MODIFY `id_tbl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `tipodocumento_rolusuario`
--
ALTER TABLE `tipodocumento_rolusuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_menu`
--
ALTER TABLE `detalle_menu`
  ADD CONSTRAINT `detalle_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_menu_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_sub_m`
--
ALTER TABLE `detalle_sub_m`
  ADD CONSTRAINT `detalle_sub_m_ibfk_1` FOREIGN KEY (`id_sub_menu`) REFERENCES `sub_menu` (`id_sub_menu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_sub_m_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `persona` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `persona` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documento_usuario`
--
ALTER TABLE `documento_usuario`
  ADD CONSTRAINT `documento_usuario_ibfk_1` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documento_usuario_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `js_menu_asociado`
--
ALTER TABLE `js_menu_asociado`
  ADD CONSTRAINT `js_menu_asociado_ibfk_1` FOREIGN KEY (`id_file`) REFERENCES `file_js` (`id_file`) ON UPDATE CASCADE,
  ADD CONSTRAINT `js_menu_asociado_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `js_menu_asociado_ibfk_3` FOREIGN KEY (`id_sub_menu`) REFERENCES `sub_menu` (`id_sub_menu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD CONSTRAINT `sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipodocumento_rolusuario`
--
ALTER TABLE `tipodocumento_rolusuario`
  ADD CONSTRAINT `tipodocumento_rolusuario_ibfk_1` FOREIGN KEY (`rolUsuario_id`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tipodocumento_rolusuario_ibfk_2` FOREIGN KEY (`tipoDocumento_id`) REFERENCES `tipo_documento` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol_usuario` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
