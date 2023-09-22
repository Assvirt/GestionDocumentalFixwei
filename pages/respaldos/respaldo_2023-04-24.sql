SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--
-- Database: `fixwei`
--




CREATE TABLE `actas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreActa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `proceso` int(11) NOT NULL,
  `ubicacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaCierre` datetime DEFAULT NULL,
  `quienCita` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `quienCitaID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `quienElabora` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `quienElaboraID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `aprobacionCompromisos` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `compromisos` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `compromisosID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `convocado` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `convocadoID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `asistente` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `asistenteID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `nombreConvocadoEXT` longtext COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoEmpresaCovEXT` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `nombreEmpresa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cargoConvocadoEXT` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `permisosActa` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `publico` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `responsablesActa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `acta` text COLLATE utf8_spanish_ci NOT NULL,
  `compromiso` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsableCompromiso` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsableID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fechaEntrega` datetime DEFAULT NULL,
  `entregarA` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `entregarAID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `aprobarActa` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienAprueba` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienApruebaId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado` varchar(15) COLLATE utf8_spanish_ci DEFAULT 'Pendiente',
  `comentario` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `finalizada` int(1) NOT NULL DEFAULT 0,
  `notificacionAct` int(11) DEFAULT NULL,
  `actaCargada` int(1) DEFAULT 0,
  `rutaArchivo` varchar(350) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoOculto` tinyint(1) DEFAULT NULL COMMENT 'Este campo es para no mostrar las actas en actividades',
  `idEncabezado` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEncabezadoPlantilla` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `actasplantilla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `acta` text COLLATE utf8_spanish_ci NOT NULL,
  `idEncabezado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `actividades` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iformulario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `titulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` varchar(600) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `agenda` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `hora` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tipoPersonal` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `personal` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tematica` varchar(10000) COLLATE utf8_spanish_ci NOT NULL,
  `asunto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(10000) COLLATE utf8_spanish_ci NOT NULL,
  `sitio` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `agendaetiqueta` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `etiqueta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `titulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `subtitulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `cargos` (
  `id_cargos` int(2) NOT NULL AUTO_INCREMENT,
  `nombreCargos` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcionCargos` varchar(10000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `jefeInmediatoCargos` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivelCargo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_cargos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `cargosasociados` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombreCargos` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `centrocostos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `prefijo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idCentroTrabajo` int(11) NOT NULL,
  `persona` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `centrodetrabajo` (
  `id_centrodetrabajo` int(3) NOT NULL AUTO_INCREMENT,
  `prefijoCentrodeTrabajo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombreCentrodeTrabajo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cargosAsociados` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `estilo` int(11) DEFAULT NULL,
  `cargosAsociadoss` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id_centrodetrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `chat` (
  `chatid` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userid` int(11) NOT NULL,
  `reciever_userid` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  PRIMARY KEY (`chatid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `chat_login_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_typing` enum('no','yes') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `chat_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `current_session` int(11) NOT NULL,
  `online` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `chathistorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de` int(11) DEFAULT NULL,
  `para` int(11) DEFAULT NULL,
  `mensaje` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `cliente` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nit` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `img` longblob DEFAULT NULL,
  `telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `administrador` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `passautoriza` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `hora` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ip` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `sesion` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registroIP` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO cliente VALUES
("1","Servicios y Soluciones Integrales ASSVIRT SAS","900856013-4","ˇÿˇ‡\0JFIF\0\0`\0`\0\0ˇ·Exif\0\0MM\0*\0\0\0\0;\0\0\0\0\0\0Jái\0\0\0\0\0\0fúù\0\0\0\08\0\0ﬁÍ\0\0\0\0\0\0>\0\0\0\0Í\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Mayra Liceth Rodriguez Mora\0\0ê\0\0\0\0\0\0¥ê\0\0\0\0\0\0»íë\0\0\0\072\0\0íí\0\0\0\072\0\0Í\0\0\0\0\0®\0\0\0\0Í\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\02021:07:31 12:48:26\02021:07:31 12:48:26\0\0\0M\0a\0y\0r\0a\0 \0L\0i\0c\0e\0t\0h\0 \0R\0o\0d\0r\0i\0g\0u\0e\0z\0 \0M\0o\0r\0a\0\0\0ˇ·.http://ns.adobe.com/xap/1.0/\0<?xpacket begin=\'Ôªø\' id=\'W5M0MpCehiHzreSzNTczkc9d\'?>\n<x:xmpmeta xmlns:x=\"adobe:ns:meta/\"><rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"><rdf:Description rdf:about=\"uuid:faf5bdd5-ba3d-11da-ad31-d33d75182f1b\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\"/><rdf:Description rdf:about=\"uuid:faf5bdd5-ba3d-11da-ad31-d33d75182f1b\" xmlns:xmp=\"http://ns.adobe.com/xap/1.0/\"><xmp:CreateDate>2021-07-31T12:48:26.719</xmp:CreateDate></rdf:Description><rdf:Description rdf:about=\"uuid:faf5bdd5-ba3d-11da-ad31-d33d75182f1b\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\"><dc:creator><rdf:Seq xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"><rdf:li>Mayra Liceth Rodriguez Mora</rdf:li></rdf:Seq>\n			</dc:creator></rdf:Description></rdf:RDF></x:xmpmeta>\n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                                                                                                    \n                            <?xpacket end=\'w\'?>ˇ€\0C\0\n\n		\n\'!%\".\"%()+,+ /3/*2\'*+*ˇ€\0C\n	\n***************************************************ˇ¿\0\0â\0|\"\0ˇƒ\0\0\0\0\0\0\0\0\0\0\0	\nˇƒ\0µ\0\0\0}\0!1AQa\"q2Åë°#B±¡R—$3brÇ	\n%&\'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyzÉÑÖÜáàâäíìîïñóòôö¢£§•¶ß®©™≤≥¥µ∂∑∏π∫¬√ƒ≈∆«»… “”‘’÷◊ÿŸ⁄·‚„‰ÂÊÁËÈÍÒÚÛÙıˆ˜¯˘˙ˇƒ\0\0\0\0\0\0\0\0	\nˇƒ\0µ\0\0w\0!1AQaq\"2ÅBë°±¡	#3Rbr—\n$4·%Ò&\'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyzÇÉÑÖÜáàâäíìîïñóòôö¢£§•¶ß®©™≤≥¥µ∂∑∏π∫¬√ƒ≈∆«»… “”‘’÷◊ÿŸ⁄‚„‰ÂÊÁËÈÍÚÛÙıˆ˜¯˘˙ˇ⁄\0\0\0?\0Ò˙(¢Ω3†(¢ä\0(¢ä\0+¢_Éo¸i≠≠ùêÚ‡èÊππaÚ¬û§‘~é£„-m4˝50øziÿ|∞ßv5Èzï‡ïb¯m∂=»N5-IzÃﬂ≈ñ˛Ô©¸D•mõ0<w“◊O”ÜΩ‡õØÌM?wq±∑¥º}âÁ⁄º÷Ωé}/Z¯5™G©ÈSˇ\0mxnÏÓ‘»«£+¿9Œ·ÎY6-é••¯˝#IóÊ∫¥^^ÕªÒ˝ﬂÂÙ©åªâ3ÃË¢ä‘†¢ä(\0¢ä(\0¢ä(\0¢ä(\0≠Ø\n¯[QÒ~πõ•Gócô%oª˜f5Üº5©xØZáL“!2K!˘ò˝ÿ◊ª1Ïzñ£sá`Oáø‘ﬁj◊\'f£©G’õ∫Éÿ˛ü\\‘JV—	∞‘.ìNé?Üˇ\0î‹]LvÍZöıëøàn\0Ó{t≥™Y¸<“·?˙oào0öÜ°À?ÚÕ=ˇ\0ó÷çV˛œ·nëˇ\0«Ñ‹_¯™¯øæån0ì¸	ÔÌ¯ö[[KÑ÷5Ωóæ1‘µΩ≥ùﬂe¯õﬂ‘˙;öÀ˙ı$ —ı}{·n®⁄\'ç¨ÁE‘ìtˆ“ÍCut=2;ä“∫¥ø¯e®G‚ØM˝´·=C˝lY‹°O8ÌÏﬂùTœè¨ºag\'Ö˛$øõ√ñ¥‘é7€H{ÈÔ¯:2÷˜Z¯=‚4}rÌ/_gròÁåˇ\0vÍ?˝t›ÔÁ˘Äœx\'N◊Ùc„/á¿Àdˇ\05Óûø~’ªê==øïÂ’Ïw÷7o\"Òü√ÀèÌﬁØÉÔ,`ıGá°ÌT|[‡˝7≈∫#x«¿Â1ªP”Ô€∑rß”ÎU[}ÜôÂTQ”≠©AEPEPZ~˛£‚}j/HÄÕq1«˚(;≥¿Tz.ã‚^3I∑kã©€j™éû§û¿w5ÎWsEÚÕ<‡q˝°‚ÕCﬁ^B2b\'¯”˙u52ï¥[â±oÓ#U≤x·7˛\"Ω¬_ﬂƒ9V=QOl~Ç°‘Ø,æi°ËR-ˇ\0ãÔîª¥æœª¯ﬂıÓ{SØnl˛h∆∆…“ˇ\0∆zÇf‚‡|ˇ\0eÿ{ˇ\0>¥Õ+Kµ¯i§x–}Øƒóπí∆¬SñF<˘èÔŒ}æµèıÍ@∫vügüE_x•VÛ≈W‡Ωùãù∆ˇ\0˚˙˛UÂ∆±{Øj”Í:§Ì=ÃÌπ›èË=IÆÎ∫áàıâµ=Z·ßπò‰ì—G``=+:∂åm´‹¥ÇΩ;¡û9”ım|„ÒÁiíù∂∑Õ˜Ï€∑>û˝æïÊ4SîS@’œVéms‡øà⁄Œ˘©·Õ@rΩbπå˜ÉWo¨.<<>>¯gpn¥+Éõõ^æNz£Øßlˆ¨oxˆ∆ÁKˇ\0ÑG«´ˆ≠oññÂÏ€±Æ?ï[c≠¸Ò(F©·ΩCßÒEsÌËÒ¨¨ÔÁ˘í?ƒ˛”<u†…‚ˇ\0E∂tµ%~¸m›îwı„≠y98<ˆ;˝:O¥æ\\tß9ª≥ò=U◊˚ø †ÒÜtœâæ+<+ß›©i+˜∑wdÛ˙˝i∆VÙv<éäR\n± ‡É⁄íµ(*≈Öî⁄ñ£mcjûÊUä0Ã\0,«ì”ìUÍ[[yÆÓ·∑¥ç•ûg	 À3Äæh⁄/˛>õÜ¸7n˜û/’ê,óI>XnãØ˘&°ökOÉöCñxÔ¸m®¶]…ﬁ-3¸Îπ—uh<9ßË⁄/çµK_¯JdÅ÷“ÊX√5†e¬Ü”ﬁ∏ÿº-√ÎÀﬂ|H∏MORÛÿÿ[o‹n$Ì!œoÂ\\…ﬂ¯s2ûã•[xMˇ\0Ñﬂ«€ÆıÀ¬d∞∞òÂÀûwæzJË<;Óœ‚ßá‡Òoâµ√}z“nXÿçVFP™;\0x∑ä<Q©xª\\óT’Âﬂ#à>ÏKŸTzW“ü£3|”„\\nu∏QüS#”©x∆˝A›+ò?†|!ˇ\0A{Ø˚˙ïáow¬”|C∏Á€ÓŸMéÚ\'WRI22∞˝˛uÖ\'Ï˘‚ÊïÿKaÇƒèﬂ¨_Ö∑“xg‚›å7fkIH<ÂùŸ⁄WΩÃﬂà~O¯‚ÁFµi$ÖB<,ˇ\0yÉ\0ûEzuÔ¿}2ﬂ¿RÍq]]I,|Ò#i}ª±˝+S‚◊ÑŒØÒG¬§yK«˚<ƒv∞~?ïzUÆπk®¯èVÚ®aL¸˝· n?Œ¶U*hNN« ˇ\0¸!çºiïtÚGj∞º”<x(¯ÒZÙΩBóàn˛ÎÊmK√[U<ŸŒÈ-$#9R;è•m¸––|Q‚Î©ójŸÃmû0†ó?¶⁄ØÍáZÒF•©1œ⁄n]‘ˇ\0≥û?LVüöË=ŸËR√≠¸Òw⁄|ÉSÊ°˜X—\\F{¡±ﬂΩ_Ω“…¢¯ÖñFkbﬂÈzr¥ıBÉ™˚~\"πœx˙;6øã°mC√◊gf¬75≥˜ìø^xØD∂—,æŸÍ:˚]‹Í	x‚++U ©S»2v»ı•+ßÆˇ\0ò=c„É§Æìß¯Ü‚5—µ˝AóX˘∑ûÌ«›>ø„^A^ΩÒÉ√–Í6~9ÜÍ[v‘—Kÿ_6%^?ÄﬁﬂèzÚ“ü¬8Ï¯&ñﬁ‚9≠‰hÂçÉ#°√+êAı¶Uã∆”ı+k»„éV∑ïe ªëäú·áq«\"¨£È/YZ¯ØF–µèàZ}™ÎàƒiÌ3ÑkÃ©eÔœ8?÷πãøßä5Kﬂ|W≤èN∏iâ±ºEÏƒ˝—ûÎÔﬂΩWÒÒwEáƒûπí-sMåç/Ã˚†s∫/OÛﬁ´Èö∆ùÒWJ_x¡ñÀƒ÷†•ñ¢Î¥ G?øØ¯◊2]_¸1ôÁû1nß‡Ωi¨u$‹çÛApÉ‰ô}A˛ïÙg¡«h˛\nÿ:2≠¡–˘è^mßÍbì·◊≈àY\"C∂«PoΩnz)›}‡høÒwå~i—¯[ÏZu∆ú°Õ≠ÎDÁœGbŸ»`3Ûtß;Õrı◊Cêó‚œéVgƒw  |©ˇ\0ƒ◊+°:j…®ªñ∏YÑ≈˚ñŒsUôãπc‘ú“VÍ)lUè∂¨ñœ_∞—ıô;DÇ‚œ›/R&5‚~Òü˚EÍR4ü∏‘⁄[UÁèóîˇ\0–1¯◊-¢¸lÒ.Ö·ò4K[{	 Ç#I,n\\/‘0}+à“ı{≠\']∂’≠X}™⁄q:Åœ>’Ñi5{ê¢}YÒ{_	|<Ò£hæ\\˜ A9Â•ê¡¸œ·_\"ÄI\0ì–Wu„?ãZˇ\0é4hÙΩN(-÷a1˚22ñ À9≠ﬂ¯gL6âç<s˘èÕ¶iç˜•~Œ√¸zu™Çˆq◊qØujM·èÈﬂt8º_„D∫úÉvô¶∑ﬁŸÿv˛üZÎ|1‚]F«√˜æ$¯£u”5IUÌ4È¢sû\n©Ë†cèl◊=anu9%¯ëÒIø––ÁO”èIH˚™ˇ\0ÛÍjÖùû°Ò_]∏Ò?ãg˛ŒÕÜsŒ’TÚÕ=œsRıﬂ˙ÚBﬂrø∆m#Zº’óƒˇ\0m˛‘–Ó‘}éxG…vBOØzÚ⁄Ó> |Ao<ZVâˆálFÀ[H∆›‡‰;}ká≠†öçôk`¢ä*ÜhËZÓ£·Ω^KG∏k{òNCå;Ç;ÉÈ^ß©Èzg≈≠%µÔ\n¢X¯¢ŸC^X+cœ«Ò\'øˇ\0™ºnØh˙≈˛É™C®È7ose]OË}GµL£}V‚hı-[∞¯ã§è¯Ìæ«Æ€f;JE√n¡\'Ú˜˙”ÙÕM¥£/√Øä–1≤\'mùÛõs¸,≠›}=:Qye¶¸b—õU—R;⁄&nmÌ[∞?â}ˇ\0˝^ıÖØŸxÔMˇ\0Ñ/‚6⁄≠π1ÿjR.q±Û˛O÷≤˛Ω	8è¯QN®!∫≈≈úﬂ5µ‰|§´€Ë}´òØc”ı9¸/4û\0¯ßnn4yxµª<˘>éç˝ﬂÂ\\Gé¸{‡ÕIrﬂj”.>{Kÿ˘Y∞>çÌZF]”9:(ØR?É4ÌEˇ\0Ñ€«Éeå_5çã}ÎßÏH=Ω‚xÎRíHmÿwÉº\'¶xGE_¯ˆ<†˘¥›5æı√ˆb=?˝f¥¨-Oân•¯âÒ:O\'FÄÊ √˛{cÓ¢Øu˛J[;gÒ•‘ﬁ<¯ë/ÿ¸;eˇ\0ñ]<Ï}‘Q‹z˙ö£Zß∆O5’„exWLÎ¸)C∞Ï\\Å◊µcÆÏëˆj?¸E.≥ØÀ˝ó·]7í3µcåˆ‹GS⁄πˇ\0à~>è^1hûãÏ>∞˘-‡Aè7∆ﬂ˝ÁR¸AÒÌæßoÜ¸\'ÿ¸;eÚ¢Ø‡è‚ooˇ\0]yı\\c’ç ¢ä+BÇä(†ä(†zfßy£Í0ﬂÈ∑osnI‡É^±4o∆mﬁX,ZåÌ#Ã∞Éµo@˛!Ô¸æï„ïgN‘nÙùBÌ:wÇÊí!¡¶Qæ´q4zÆÅ‚KOÿ|LWÇÓÚÏµ	W@„ÄÆOÛ©,µØ^K‡oâﬂ]«ΩœﬁÉ“DoOQ‘TÉ˚/„VêOÓtÔZG˛Í^®˛øÀÈU4¡™Z∑Ä>\'ƒÒyOÂZ_J1%¨ù\0b{{÷_◊¸1%€OÖ∫/Éıü¯£RÜÔ√ñÿñ¡clΩ·<™ëÌ˙˝)m-¶¯É}/å¸rˇ\0Ÿæ”„⁄◊†êà£Ú…Ô–{2œ·é©kx—xÔRÚ¸%†Êhe2|≥ÜÁ=ÒœßA÷™K.ßÒãƒqÈöRe¯WKˆ€1è‚n≈»Ë;~t∑÷ˇ\00çS„/âÇ«ç+¬∫XÂèÀè–πïdx˚«VóI·_ØŸ|?iÚñ^ÌáVc‹:ó«ﬁ8≤èMP˚>álvÕ2◊l:í{èÁ^oZF7’ç ¢ä+BÇä(†ä(†ä(†ä(†	ÏÔ.4˚»Æ¨¶x\'âÉ$àpT◊ÆAs•|g—÷“Ù≈ß¯ ÷<C7›K’°˜˛U„ï-µÃ÷w1‹Z —MGCÇ§w¶Qø®ö=N“|o„K€Írœ¶é‰‹ô∏Æz±˛.>ÌK„üXiz?¸!~>VóÀwvú5€˜Á”˘˝*øà>2kZÁÑb“ims\"ÏæºãáπQ¬èn:◊ú‘®∂Óƒóp¢ä+BÇä(†ä(†ä(†ä(†ä(†ä(†ä(†ä(†ä(†ä(†ˇŸ","(57)1 69854122","Cl 6 25 46","ASSVIRT","900856013C","900856013","mayra.rmora@gmail.com","123","2022-11-16 12:49:44 PM","\n    IP address (usando get_client_ip_env function) es 190.145.111.177\n    <br>\n    IP address (usando get_client_ip_server function) es 190.145.111.177\n    <br>\n    <br>\n    El nombre del servidor es: fixwei.com<hr> \n    Vienes procedente de la p√É¬°gina: https://fixwei.com/plataforma/pages/cliente<hr> \n    Te has conectado usando el puerto: 22637<hr> \n    El agente de usuario de tu navegador es: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 OPR/92.0.0.0\n    ","No","NULL");




CREATE TABLE `codificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codificacion` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(10) CHARACTER SET latin1 NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;






CREATE TABLE `comentariosolicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `comentario` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `comnetariosrevision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `idDocumento` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `notificar` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `notificarQuien` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `lider` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `compromisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idActa` int(11) NOT NULL,
  `compromiso` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `responsableCompromiso` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `responsableID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fechaEntrega` datetime NOT NULL,
  `entregarA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `entregarAID` longtext COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(12) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Pendiente',
  `rutaCompromiso` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `historia` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `compromisosindividuales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_compromiso` int(11) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `estado` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `responsableId` int(11) NOT NULL,
  `rutaAvance` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `comunicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `activos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `comunicacioninterna` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(2) NOT NULL,
  `comentario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `archivo` longblob NOT NULL,
  `fecha` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `comunicacioninternaver` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `idComunicacionInterna` int(3) NOT NULL,
  `comentario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `conectadousuario` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estadoUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `consecutivodocumento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consecutivo` int(11) DEFAULT NULL,
  `estado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO consecutivodocumento VALUES
("2","1","registrado");




CREATE TABLE `consecutivooc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caracter` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `aplicado` int(11) DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `controlcambioregistros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  `comentario` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `controlcambios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `idRespaldo` int(11) DEFAULT NULL COMMENT 'id documento para validar la eliminaci√≥n',
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUsuarioB` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `rol` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tipoSolicitud` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `controlcambioscompromisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCompromiso` int(11) DEFAULT NULL,
  `comentario` varchar(350) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `historia` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `controlcambiosflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(50) DEFAULT NULL,
  `informacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `comentarioAnterior` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `controlcambiosparametrizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `informacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO controlcambiosparametrizacion VALUES
("1","<table cellspacing=\"0\" style=\"border-collapse:collapse; width:721px\">\n	<tbody>\n		<tr>\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; height:39px; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; white-space:normal; width:239px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n		</tr>\n		<tr>\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; height:60px; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; white-space:normal; width:239px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n		</tr>\n		<tr>\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; height:60px; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; white-space:normal; width:241px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; white-space:normal; width:239px\"><span style=\"font-size:15px\"><span style=\"color:black\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></span></td>\n		</tr>\n	</tbody>\n</table>\n");




CREATE TABLE `correos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO correos VALUES
("3","mayra.rmora@hotmail.com"),
("5","mayra.rmora@gmail.com"),
("6","comercial@assvirt.com"),
("7","soporte@assvirt.com"),
("9","m.a.a.r.92@hotmail.com"),
("10","juanrinconaxl926@gmail.com");




CREATE TABLE `ctrabajouusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'la cedula',
  `idCtrabajo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `definicion` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombreN` int(100) DEFAULT NULL,
  `definicion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fuente` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `departamentos` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;


INSERT INTO departamentos VALUES
("5","Antioquia"),
("8","Atlantico"),
("11","Bogota"),
("13","Bolivar"),
("15","Boyaca"),
("17","Caldas"),
("18","Caqueta"),
("19","Cauca"),
("20","Cesar"),
("23","Cordoba"),
("25","Cundinamarca"),
("27","Choco"),
("41","Huila"),
("44","La Guajira"),
("47","Magdalena"),
("50","Meta"),
("52","Nari√±o"),
("54","N. De Santander"),
("63","Quindio"),
("66","Risaralda"),
("68","Santander"),
("70","Sucre"),
("73","Tolima"),
("76","Valle Del Cauca"),
("81","Arauca"),
("85","Casanare"),
("86","Putumayo"),
("88","San Andres"),
("91","Amazonas"),
("94","Guainia"),
("95","Guaviare"),
("97","Vaupes"),
("99","Vichada");




CREATE TABLE `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoCodificacion` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `consecutivo` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `nombres` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `proceso` int(11) DEFAULT NULL,
  `tipo_documento` int(11) DEFAULT NULL,
  `norma` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metodo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `htmlDoc` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `elabora` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `revisa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `aprueba` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `elaboraElimanar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `revisaElimanar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `apruebaElimanar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `elaboraActualizar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `revisaActualizar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `apruebaActualizar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `documento_externo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `definiciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `archivo_gestion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `archivo_central` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `archivo_historico` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `disposicion_documental` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable_disposicion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `aprovacion_registro` tinyint(1) DEFAULT NULL,
  `usuario_aprovacion_reg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'usuario que aprueba el registro',
  `aprobado_elabora` int(1) DEFAULT 0,
  `aprobado_revisa` int(1) DEFAULT 0,
  `aprobado_aprueba` int(11) DEFAULT 0,
  `aprobado_elabora_e` int(1) DEFAULT 0,
  `aprobado_revisa_e` int(1) DEFAULT 0,
  `aprobado_aprueba_e` int(1) DEFAULT 0,
  `aprobado_elabora_a` int(11) DEFAULT 0,
  `aprobado_revisa_a` int(11) DEFAULT 0,
  `aprobado_aprueba_a` int(11) DEFAULT 0,
  `estado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoElimina` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoActualiza` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reinicia_elabora` int(1) DEFAULT NULL,
  `ajusta_elabora` int(1) DEFAULT NULL,
  `cierra_elabora` int(1) DEFAULT NULL,
  `reinicia_revisa` int(1) DEFAULT NULL,
  `ajusta_revisa` int(1) DEFAULT NULL,
  `cierra_revisa` int(1) DEFAULT NULL,
  `reinicia_aprueba` int(1) DEFAULT NULL,
  `ajusta_aprueba` int(1) DEFAULT NULL,
  `cierra_aprueba` int(1) DEFAULT NULL,
  `control_cambios` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `flujo` varchar(14) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mesesRevision` int(11) DEFAULT NULL,
  `obsoleto` int(1) DEFAULT 0,
  `vigente` int(11) DEFAULT 0,
  `id_solicitud` int(11) NOT NULL,
  `id_solicitudRespaldo` int(50) DEFAULT NULL COMMENT 'Este se usa como respaldo de una solicitud de eliminaci√≥n cuando es cerrada',
  `nombrePDF` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreOtro` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadoCreado` tinyint(1) NOT NULL,
  `usuarioElabora` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuarioRevisa` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'id del usuario que toma la revision del documenrto',
  `revisado` int(11) NOT NULL DEFAULT 0,
  `ultimaFechaRevision` date DEFAULT NULL,
  `usuarioAprueba` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idAnterior` int(11) DEFAULT NULL COMMENT 'Aca guardo el id del documento en su version anterior',
  `asumeFlujo` int(11) DEFAULT NULL,
  `fechaAprobado` datetime DEFAULT NULL,
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  `plataformaHRevisa` int(2) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma quien revisa',
  `plataformaHAprueba` int(2) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma quien aprueba',
  `pre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `divulgacion` text COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Corresponde al campo para almacenar el archivo para la corresponidente divulgacion',
  `revisionDocumentalCorreo` int(11) DEFAULT NULL COMMENT 'Este se activa despu√©s de haber enviado el correo desde la revisi√≥n de un documento',
  `nombreProceso` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreTipoD` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `normaNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `externoNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `definicionNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `disposicionNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `elaboraNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `revisaNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `apruebaNombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentoarchivotemporal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otro` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `pdf` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitud` int(11) DEFAULT NULL,
  `tipodocumento` text COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'este campo se usa para validar el documento del tipo de documento',
  `actas` text COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Control de documentos para actas',
  `indicadores` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `proveedor` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentodatostemporales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solicitud` int(11) DEFAULT NULL,
  `definicion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `externo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `responsable` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentodatostemporalesactas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quienCita` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienCitaId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `quienElabora` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienElaboraId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `aprobacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienAprobacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienAprobacionId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `publico` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienPublico` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `quienPublicoId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentoexterno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `ruta` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentoexternotipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `documentorevision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quien` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `encabezado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `encabezado` longtext COLLATE utf8_spanish_ci NOT NULL,
  `principal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `evaluacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `encabezado` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `evaluacionmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEvaluacion` int(11) DEFAULT NULL,
  `material` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `evaluacionprueba` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `idEvaluacion` int(11) DEFAULT NULL,
  `tipoPregunta` int(11) DEFAULT NULL,
  `pregunta` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pregunta1` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto1` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `pregunta2` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto2` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `pregunta3` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto3` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `pregunta4` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto4` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `pregunta5` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correcto5` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `puntajeCalificacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `evaluacionrelacional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEvaluacion` int(11) DEFAULT NULL,
  `pregunta` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `relacionar` int(11) DEFAULT NULL,
  `informacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoPregunta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `evaluacionrespuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEvaluacion` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idPregunta` int(11) DEFAULT NULL,
  `tipoPregunta` int(11) DEFAULT NULL,
  `respuesta1` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta2` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta3` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta4` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta5` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta6` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta7` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta8` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta9` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta10` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta11` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO evaluacionrespuesta VALUES
("1","1","13","1","1","Respondiendo a la pregunta abierta","","","","","","","","","",""),
("2","1","13","2","2","No","","","","","","","","","",""),
("3","1","13","3","3","","on","on","","","","","","","","");




CREATE TABLE `formularios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFormulario` varchar(40) CHARACTER SET latin1 NOT NULL,
  `orden` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `modulo` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO formularios VALUES
("1","usuarios","1","Usuarios","Garantiza la creaci√≥n de cada usuario que hace parte del sistema","config"),
("2","gruposDis","2","Grupos de distribuci√≥n","Garantiza las estructura jerargica de una empresa\n","config"),
("11","centroCostos","10","Centro de costos","Garantiza la estandarizaci√≥n de los centros de costos que hacen parte de una compa√±√≠a\n","config"),
("4","cargos","3","Cargos","Define los cargos que hacen parte de una compa√±√≠a\n","config"),
("5","centroTrabajo","4","Centro de Trabajos","Garantiza la creaci√≥n de uno o mas centros de trabajo cuando aplique","config"),
("6","procesos","5","Procesos","Define los procesos que hacen parte de la cadena de suministro\n","config"),
("7","macroprocesos","6","Macroprocesos","Define los macroprocesos que hacen parte de una compa√±√≠a\n","config"),
("8","definicion","7","Definici√≥n","Garantiza la totalidad de las definiciones para los documentos objetos de creaci√≥n\n","config"),
("9","codificacion","8","Codificaci√≥n","Gestione la codificaci√≥n documental de acuerdo a los protocolos establecidos para tal fin\n","config"),
("10","normativa","9","Normatividad","Garantiza la creaci√≥n de las diversas normas que riguen una compa√±√≠a\n","config"),
("12","tipoDocumento","11","Tipo de documento","Garantiza la parametrizaci√≥n de los diferentes tipos de documentos\n","config"),
("15","listadoMaestro","3","Listado Maestro","Evidencia la totalidad de los documentos creados en el sistema\n","gestionDoc"),
("16","solicitudDocumentos","1","Solicitud de documentos","Permite solicitar la creaci√≥n de un documento en el sistema\n","gestionDoc"),
("17","actas","1","Actas","Permite gestionar las actas de las reuniones sostenidas por miembros de una compa√±√≠a con otros y/o personas externas","actas"),
("18","creacionDoc","2","Creaci√≥n documental","Garantiza la creaci√≥n de un documento por tipo y procesos\n","gestionDoc"),
("19","documentoEx","6","Documento Externo","Gestiona los documentos externos que hacen parte de los procesos de una compa√±√≠a\n","gestionDoc"),
("20","documentosObs","7","Documentos Obsoletos","Gestiona los documentos obsoletos hasta su disposici√≥n documental\n","gestionDoc"),
("21","politicas","1","Solicitar inscripci√≥n y aprobaci√≥n de proveedor","Garantiza la creaci√≥n de uno o mas proveedores de una compa√±√≠a","compras"),
("22","proveedores","2","Proveedores","Garantiza la creaci√≥n de uno o mas proveedores de una compa√±√≠a","compras"),
("23","solicitudCom","3","Solicitud de Compra","Permite gestionar las solicitudes de compra por cualquier miembro de la compa√±√≠a","compras"),
("24","ordenCom","4","Orden de Compra","Permite gestionar una orden de compra a uno o varios proveedores","compras"),
("25","presupuesto","5","Presupuesto","Permites gestionar los presupuestos de compra por proceso","compras"),
("26","repositorio","4","Repositorio","Garantiza el almacenamiento de informaci√≥n documentada y/o documentos externos","Repositorio"),
("27","revisionDoc","5","Revisi√≥n Documental","Garantiza la revisi√≥n de los documentos de acuerdo al tiempo definido en la creaci√≥n ","gestionDoc"),
("28","indicadores","1","Indicador","Permite gestionar los indicadores de gesti√≥n por proceso","indi"),
("29","comunicaciones","12","Comunicaciones","Controla los privilegios para la publicaci√≥n de comunicaciones internas","config"),
("31","informes","6","Informes","Informes de compras","compras"),
("32","aprobacionOC","7","Aprobaci√≥n Orden de Compra","Con el fin de aprobar la orden de compra antes de su notificaci√≥n al proveedor","compras"),
("33","entradasSalidas","8","Entradas y salidas orden de compra","Este permiso es para realizar todo el proceso de entradas y salidas de las ordenes de compra y de sus productos","compras"),
("34","divulgar","6","Divulgaci√≥n de documentos","Divulgaci√≥n de documentos","gestionDoc"),
("35","proveedoresActivos","9","Proveedores Activos","Garantiza la creaci√≥n de uno o mas proveedores activos de una compa√±√≠a","compras");




CREATE TABLE `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(10000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;






CREATE TABLE `grupoucargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `idCargo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `grupouccosto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `idcCosto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `grupouctrabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL COMMENT 'id tabla grupo ',
  `idcTrabajo` int(11) NOT NULL COMMENT 'id tabla centrodetrabajo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `grupouusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `idUsuario` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;






CREATE TABLE `indicadores` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `quienCrea` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoIndicador` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `radioIndicador` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `resposableIndicador` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `desdeMostrar` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `sentido` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `proceso` int(30) DEFAULT NULL,
  `norma` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `frecuencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clasificacion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `radioCalculo` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsableCalculo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `radioVisualizar` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `autorizadoVisualizar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `radioEditar` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `autorizadoEditar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `formula` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `terminar` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `terminar2` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `alimentado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `restrincion` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `plataformaH` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresformula` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `idVariable` int(100) DEFAULT NULL,
  `idIndicador` int(100) DEFAULT NULL,
  `parteFormula` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresgestionar` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `idIndicador` int(100) DEFAULT NULL,
  `quienCrea` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreG` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `soporte` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mes` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `anoPresente` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `alimentado` int(100) DEFAULT NULL,
  `analisis` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `datosFormula` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresmetas` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `idIndicador` int(30) DEFAULT NULL,
  `quienCrea` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `metas` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `unidad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `metaActual` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `anoPresente` int(50) DEFAULT NULL,
  `zp` int(70) DEFAULT NULL,
  `za` int(70) DEFAULT NULL,
  `zc` int(70) DEFAULT NULL,
  `ze` int(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadorestipo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresunidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresvariables` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `variables` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreVariable` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcionVariable` varchar(1500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `simbolo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `unidad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Cuando la variable es serie √∫nica',
  `idIndicador` int(11) DEFAULT NULL COMMENT 'Id indicacores',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `indicadoresvariablesasociadas` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `idIndicador` int(30) DEFAULT NULL,
  `idVariable` int(30) DEFAULT NULL,
  `quienCrea` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` varchar(50) DEFAULT NULL COMMENT 'para mostrar si est√° en l√≠nea o desconectado',
  `cc` varchar(50) DEFAULT NULL COMMENT 'se guarda la cc del usuario para validar su chat',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL,
  PRIMARY KEY (`login_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `macroproceso` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estilo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `lido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `para` int(50) DEFAULT NULL,
  `user` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `archivo` longblob DEFAULT NULL,
  `fecha` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `incoming_msg_id` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `outgoing_msg_id` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `msg` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `lectura` int(11) DEFAULT NULL,
  `documento` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreDocumento` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `municipios` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `departamento_id` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departamento_id` (`departamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99774 DEFAULT CHARSET=utf8mb4;


INSERT INTO municipios VALUES
("5001","Medell√≠n","5"),
("5002","Abejorral","5"),
("5004","Abriaqui","5"),
("5021","Alejandria","5"),
("5030","Amaga","5"),
("5031","Amalfi","5"),
("5034","Andes","5"),
("5036","Angelopolis","5"),
("5038","Angostura","5"),
("5040","Anori","5"),
("5042","Santafe De Antioquia","5"),
("5044","Anza","5"),
("5045","Apartado","5"),
("5051","Arboletes","5"),
("5055","Argelia","5"),
("5059","Armenia","5"),
("5079","Barbosa","5"),
("5086","Belmira","5"),
("5088","Bello","5"),
("5091","Betania","5"),
("5093","Betulia","5"),
("5101","Ciudad Bolivar","5"),
("5107","Brice√±o","5"),
("5113","Buritica","5"),
("5120","Caceres","5"),
("5125","Caicedo","5"),
("5129","Caldas","5"),
("5134","Campamento","5"),
("5138","Ca√±asgordas","5"),
("5142","Caracoli","5"),
("5145","Caramanta","5"),
("5147","Carepa","5"),
("5148","El Carmen De Viboral","5"),
("5150","Carolina","5"),
("5154","Caucasia","5"),
("5172","Chigorodo","5"),
("5190","Cisneros","5"),
("5197","Cocorna","5"),
("5206","Concepcion","5"),
("5209","Concordia","5"),
("5212","Copacabana","5"),
("5234","Dabeiba","5"),
("5237","Don Matias","5"),
("5240","Ebejico","5"),
("5250","El Bagre","5"),
("5264","Entrerrios","5"),
("5266","Envigado","5"),
("5282","Fredonia","5"),
("5284","Frontino","5"),
("5306","Giraldo","5"),
("5308","Girardota","5"),
("5310","Gomez Plata","5"),
("5313","Granada","5"),
("5315","Guadalupe","5"),
("5318","Guarne","5"),
("5321","Guatape","5"),
("5347","Heliconia","5"),
("5353","Hispania","5"),
("5360","Itagui","5"),
("5361","Ituango","5"),
("5364","Jardin","5"),
("5368","Jerico","5"),
("5376","La Ceja","5"),
("5380","La Estrella","5"),
("5390","La Pintada","5"),
("5400","La Union","5"),
("5411","Liborina","5"),
("5425","Maceo","5"),
("5440","Marinilla","5"),
("5467","Montebello","5"),
("5475","Murindo","5"),
("5480","Mutata","5"),
("5483","Nari√±o","5"),
("5490","Necocli","5"),
("5495","Nechi","5"),
("5501","Olaya","5"),
("5541","Pe√∞ol","5"),
("5543","Peque","5"),
("5576","Pueblorrico","5"),
("5579","Puerto Berrio","5"),
("5585","Puerto Nare","5"),
("5591","Puerto Triunfo","5"),
("5604","Remedios","5"),
("5607","Retiro","5"),
("5615","Rionegro","5"),
("5628","Sabanalarga","5"),
("5631","Sabaneta","5"),
("5642","Salgar","5"),
("5647","San Andres De Cuerquia","5"),
("5649","San Carlos","5"),
("5652","San Francisco","5"),
("5656","San Jeronimo","5"),
("5658","San Jose De La Monta√±a","5"),
("5659","San Juan De Uraba","5"),
("5660","San Luis","5"),
("5664","San Pedro","5"),
("5665","San Pedro De Uraba","5"),
("5667","San Rafael","5"),
("5670","San Roque","5"),
("5674","San Vicente","5");
INSERT INTO municipios VALUES
("5679","Santa Barbara","5"),
("5686","Santa Rosa De Osos","5"),
("5690","Santo Domingo","5"),
("5697","El Santuario","5"),
("5736","Segovia","5"),
("5756","Sonson","5"),
("5761","Sopetran","5"),
("5789","Tamesis","5"),
("5790","Taraza","5"),
("5792","Tarso","5"),
("5809","Titiribi","5"),
("5819","Toledo","5"),
("5837","Turbo","5"),
("5842","Uramita","5"),
("5847","Urrao","5"),
("5854","Valdivia","5"),
("5856","Valparaiso","5"),
("5858","Vegachi","5"),
("5861","Venecia","5"),
("5873","Vigia Del Fuerte","5"),
("5885","Yali","5"),
("5887","Yarumal","5"),
("5890","Yolombo","5"),
("5893","Yondo","5"),
("5895","Zaragoza","5"),
("8001","Barranquilla","8"),
("8078","Baranoa","8"),
("8137","Campo De La Cruz","8"),
("8141","Candelaria","8"),
("8296","Galapa","8"),
("8372","Juan De Acosta","8"),
("8421","Luruaco","8"),
("8433","Malambo","8"),
("8436","Manati","8"),
("8520","Palmar De Varela","8"),
("8549","Piojo","8"),
("8558","Polonuevo","8"),
("8560","Ponedera","8"),
("8573","Puerto Colombia","8"),
("8606","Repelon","8"),
("8634","Sabanagrande","8"),
("8638","Sabanalarga","8"),
("8675","Santa Lucia","8"),
("8685","Santo Tomas","8"),
("8758","Soledad","8"),
("8770","Suan","8"),
("8832","Tubara","8"),
("8849","Usiacuri","8"),
("11001","Bogota, D.C.","11"),
("13001","Cartagena","13"),
("13006","Achi","13"),
("13030","Altos Del Rosario","13"),
("13042","Arenal","13"),
("13052","Arjona","13"),
("13062","Arroyohondo","13"),
("13074","Barranco De Loba","13"),
("13140","Calamar","13"),
("13160","Cantagallo","13"),
("13188","Cicuco","13"),
("13212","Cordoba","13"),
("13222","Clemencia","13"),
("13244","El Carmen De Bolivar","13"),
("13248","El Guamo","13"),
("13268","El Pe√±on","13"),
("13300","Hatillo De Loba","13"),
("13430","Magangue","13"),
("13433","Mahates","13"),
("13440","Margarita","13"),
("13442","Maria La Baja","13"),
("13458","Montecristo","13"),
("13468","Mompos","13"),
("13473","Morales","13"),
("13490","Norosi","13"),
("13549","Pinillos","13"),
("13580","Regidor","13"),
("13600","Rio Viejo","13"),
("13620","San Cristobal","13"),
("13647","San Estanislao","13"),
("13650","San Fernando","13"),
("13654","San Jacinto","13"),
("13655","San Jacinto Del Cauca","13"),
("13657","San Juan Nepomuceno","13"),
("13667","San Martin De Loba","13"),
("13670","San Pablo","13"),
("13673","Santa Catalina","13"),
("13683","Santa Rosa","13"),
("13688","Santa Rosa Del Sur","13"),
("13744","Simiti","13"),
("13760","Soplaviento","13"),
("13780","Talaigua Nuevo","13"),
("13810","Tiquisio","13"),
("13836","Turbaco","13"),
("13838","Turbana","13"),
("13873","Villanueva","13"),
("13894","Zambrano","13"),
("15001","Tunja","15"),
("15022","Almeida","15"),
("15047","Aquitania","15"),
("15051","Arcabuco","15"),
("15087","Belen","15");
INSERT INTO municipios VALUES
("15090","Berbeo","15"),
("15092","Beteitiva","15"),
("15097","Boavita","15"),
("15104","Boyaca","15"),
("15106","Brice√±o","15"),
("15109","Buenavista","15"),
("15114","Busbanza","15"),
("15131","Caldas","15"),
("15135","Campohermoso","15"),
("15162","Cerinza","15"),
("15172","Chinavita","15"),
("15176","Chiquinquira","15"),
("15180","Chiscas","15"),
("15183","Chita","15"),
("15185","Chitaraque","15"),
("15187","Chivata","15"),
("15189","Cienega","15"),
("15204","Combita","15"),
("15212","Coper","15"),
("15215","Corrales","15"),
("15218","Covarachia","15"),
("15223","Cubara","15"),
("15224","Cucaita","15"),
("15226","Cuitiva","15"),
("15232","Chiquiza","15"),
("15236","Chivor","15"),
("15238","Duitama","15"),
("15244","El Cocuy","15"),
("15248","El Espino","15"),
("15272","Firavitoba","15"),
("15276","Floresta","15"),
("15293","Gachantiva","15"),
("15296","Gameza","15"),
("15299","Garagoa","15"),
("15317","Guacamayas","15"),
("15322","Guateque","15"),
("15325","Guayata","15"),
("15332","Gsican","15"),
("15362","Iza","15"),
("15367","Jenesano","15"),
("15368","Jerico","15"),
("15377","Labranzagrande","15"),
("15380","La Capilla","15"),
("15401","La Victoria","15"),
("15403","La Uvita","15"),
("15407","Villa De Leyva","15"),
("15425","Macanal","15"),
("15442","Maripi","15"),
("15455","Miraflores","15"),
("15464","Mongua","15"),
("15466","Mongui","15"),
("15469","Moniquira","15"),
("15476","Motavita","15"),
("15480","Muzo","15"),
("15491","Nobsa","15"),
("15494","Nuevo Colon","15"),
("15500","Oicata","15"),
("15507","Otanche","15"),
("15511","Pachavita","15"),
("15514","Paez","15"),
("15516","Paipa","15"),
("15518","Pajarito","15"),
("15522","Panqueba","15"),
("15531","Pauna","15"),
("15533","Paya","15"),
("15537","Paz De Rio","15"),
("15542","Pesca","15"),
("15550","Pisba","15"),
("15572","Puerto Boyaca","15"),
("15580","Quipama","15"),
("15599","Ramiriqui","15"),
("15600","Raquira","15"),
("15621","Rondon","15"),
("15632","Saboya","15"),
("15638","Sachica","15"),
("15646","Samaca","15"),
("15660","San Eduardo","15"),
("15664","San Jose De Pare","15"),
("15667","San Luis De Gaceno","15"),
("15673","San Mateo","15"),
("15676","San Miguel De Sema","15"),
("15681","San Pablo De Borbur","15"),
("15686","Santana","15"),
("15690","Santa Maria","15"),
("15693","Santa Rosa De Viterbo","15"),
("15696","Santa Sofia","15"),
("15720","Sativanorte","15"),
("15723","Sativasur","15"),
("15740","Siachoque","15"),
("15753","Soata","15"),
("15755","Socota","15"),
("15757","Socha","15"),
("15759","Sogamoso","15"),
("15761","Somondoco","15"),
("15762","Sora","15"),
("15763","Sotaquira","15"),
("15764","Soraca","15"),
("15774","Susacon","15"),
("15776","Sutamarchan","15"),
("15778","Sutatenza","15");
INSERT INTO municipios VALUES
("15790","Tasco","15"),
("15798","Tenza","15"),
("15804","Tibana","15"),
("15806","Tibasosa","15"),
("15808","Tinjaca","15"),
("15810","Tipacoque","15"),
("15814","Toca","15"),
("15816","Togsi","15"),
("15820","Topaga","15"),
("15822","Tota","15"),
("15832","Tunungua","15"),
("15835","Turmeque","15"),
("15837","Tuta","15"),
("15839","Tutaza","15"),
("15842","Umbita","15"),
("15861","Ventaquemada","15"),
("15879","Viracacha","15"),
("15897","Zetaquira","15"),
("17001","Manizales","17"),
("17013","Aguadas","17"),
("17042","Anserma","17"),
("17050","Aranzazu","17"),
("17088","Belalcazar","17"),
("17174","Chinchina","17"),
("17272","Filadelfia","17"),
("17380","La Dorada","17"),
("17388","La Merced","17"),
("17433","Manzanares","17"),
("17442","Marmato","17"),
("17444","Marquetalia","17"),
("17446","Marulanda","17"),
("17486","Neira","17"),
("17495","Norcasia","17"),
("17513","Pacora","17"),
("17524","Palestina","17"),
("17541","Pensilvania","17"),
("17614","Riosucio","17"),
("17616","Risaralda","17"),
("17653","Salamina","17"),
("17662","Samana","17"),
("17665","San Jose","17"),
("17777","Supia","17"),
("17867","Victoria","17"),
("17873","Villamaria","17"),
("17877","Viterbo","17"),
("18001","Florencia","18"),
("18029","Albania","18"),
("18094","Belen De Los Andaquies","18"),
("18150","Cartagena Del Chaira","18"),
("18205","Curillo","18"),
("18247","El Doncello","18"),
("18256","El Paujil","18"),
("18410","La Monta√±ita","18"),
("18460","Milan","18"),
("18479","Morelia","18"),
("18592","Puerto Rico","18"),
("18610","San Jose Del Fragua","18"),
("18753","San Vicente Del Caguan","18"),
("18756","Solano","18"),
("18785","Solita","18"),
("18860","Valparaiso","18"),
("19001","Popayan","19"),
("19022","Almaguer","19"),
("19050","Argelia","19"),
("19075","Balboa","19"),
("19100","Bolivar","19"),
("19110","Buenos Aires","19"),
("19130","Cajibio","19"),
("19137","Caldono","19"),
("19142","Caloto","19"),
("19212","Corinto","19"),
("19256","El Tambo","19"),
("19290","Florencia","19"),
("19300","Guachene","19"),
("19318","Guapi","19"),
("19355","Inza","19"),
("19364","Jambalo","19"),
("19392","La Sierra","19"),
("19397","La Vega","19"),
("19418","Lopez","19"),
("19450","Mercaderes","19"),
("19455","Miranda","19"),
("19473","Morales","19"),
("19513","Padilla","19"),
("19517","Paez","19"),
("19532","Patia","19"),
("19533","Piamonte","19"),
("19548","Piendamo","19"),
("19573","Puerto Tejada","19"),
("19585","Purace","19"),
("19622","Rosas","19"),
("19693","San Sebastian","19"),
("19698","Santander De Quilichao","19"),
("19701","Santa Rosa","19"),
("19743","Silvia","19"),
("19760","Sotara","19"),
("19780","Suarez","19"),
("19785","Sucre","19"),
("19807","Timbio","19"),
("19809","Timbiqui","19");
INSERT INTO municipios VALUES
("19821","Toribio","19"),
("19824","Totoro","19"),
("19845","Villa Rica","19"),
("20001","Valledupar","20"),
("20011","Aguachica","20"),
("20013","Agustin Codazzi","20"),
("20032","Astrea","20"),
("20045","Becerril","20"),
("20060","Bosconia","20"),
("20175","Chimichagua","20"),
("20178","Chiriguana","20"),
("20228","Curumani","20"),
("20238","El Copey","20"),
("20250","El Paso","20"),
("20295","Gamarra","20"),
("20310","Gonzalez","20"),
("20383","La Gloria","20"),
("20400","La Jagua De Ibirico","20"),
("20443","Manaure","20"),
("20517","Pailitas","20"),
("20550","Pelaya","20"),
("20570","Pueblo Bello","20"),
("20614","Rio De Oro","20"),
("20621","La Paz","20"),
("20710","San Alberto","20"),
("20750","San Diego","20"),
("20770","San Martin","20"),
("20787","Tamalameque","20"),
("23001","Monteria","23"),
("23068","Ayapel","23"),
("23079","Buenavista","23"),
("23090","Canalete","23"),
("23162","Cerete","23"),
("23168","Chima","23"),
("23182","Chinu","23"),
("23189","Cienaga De Oro","23"),
("23300","Cotorra","23"),
("23350","La Apartada","23"),
("23417","Lorica","23"),
("23419","Los Cordobas","23"),
("23464","Momil","23"),
("23466","Montelibano","23"),
("23500","Mo√±itos","23"),
("23555","Planeta Rica","23"),
("23570","Pueblo Nuevo","23"),
("23574","Puerto Escondido","23"),
("23580","Puerto Libertador","23"),
("23586","Purisima","23"),
("23660","Sahagun","23"),
("23670","San Andres Sotavento","23"),
("23672","San Antero","23"),
("23675","San Bernardo Del Viento","23"),
("23678","San Carlos","23"),
("23686","San Pelayo","23"),
("23807","Tierralta","23"),
("23855","Valencia","23"),
("25001","Agua De Dios","25"),
("25019","Alban","25"),
("25035","Anapoima","25"),
("25040","Anolaima","25"),
("25053","Arbelaez","25"),
("25086","Beltran","25"),
("25095","Bituima","25"),
("25099","Bojaca","25"),
("25120","Cabrera","25"),
("25123","Cachipay","25"),
("25126","Cajica","25"),
("25148","Caparrapi","25"),
("25151","Caqueza","25"),
("25154","Carmen De Carupa","25"),
("25168","Chaguani","25"),
("25175","Chia","25"),
("25178","Chipaque","25"),
("25181","Choachi","25"),
("25183","Choconta","25"),
("25200","Cogua","25"),
("25214","Cota","25"),
("25224","Cucunuba","25"),
("25245","El Colegio","25"),
("25258","El Pe√±on","25"),
("25260","El Rosal","25"),
("25269","Facatativa","25"),
("25279","Fomeque","25"),
("25281","Fosca","25"),
("25286","Funza","25"),
("25288","Fuquene","25"),
("25290","Fusagasuga","25"),
("25293","Gachala","25"),
("25295","Gachancipa","25"),
("25297","Gacheta","25"),
("25299","Gama","25"),
("25307","Girardot","25"),
("25312","Granada","25"),
("25317","Guacheta","25"),
("25320","Guaduas","25"),
("25322","Guasca","25"),
("25324","Guataqui","25"),
("25326","Guatavita","25"),
("25328","Guayabal De Siquima","25"),
("25335","Guayabetal","25");
INSERT INTO municipios VALUES
("25339","Gutierrez","25"),
("25368","Jerusalen","25"),
("25372","Junin","25"),
("25377","La Calera","25"),
("25386","La Mesa","25"),
("25394","La Palma","25"),
("25398","La Pe√±a","25"),
("25402","La Vega","25"),
("25407","Lenguazaque","25"),
("25426","Macheta","25"),
("25430","Madrid","25"),
("25436","Manta","25"),
("25438","Medina","25"),
("25473","Mosquera","25"),
("25483","Nari√±o","25"),
("25486","Nemocon","25"),
("25488","Nilo","25"),
("25489","Nimaima","25"),
("25491","Nocaima","25"),
("25506","Venecia","25"),
("25513","Pacho","25"),
("25518","Paime","25"),
("25524","Pandi","25"),
("25530","Paratebueno","25"),
("25535","Pasca","25"),
("25572","Puerto Salgar","25"),
("25580","Puli","25"),
("25592","Quebradanegra","25"),
("25594","Quetame","25"),
("25596","Quipile","25"),
("25599","Apulo","25"),
("25612","Ricaurte","25"),
("25645","San Antonio Del Tequendama","25"),
("25649","San Bernardo","25"),
("25653","San Cayetano","25"),
("25658","San Francisco","25"),
("25662","San Juan De Rio Seco","25"),
("25718","Sasaima","25"),
("25736","Sesquile","25"),
("25740","Sibate","25"),
("25743","Silvania","25"),
("25745","Simijaca","25"),
("25754","Soacha","25"),
("25758","Sopo","25"),
("25769","Subachoque","25"),
("25772","Suesca","25"),
("25777","Supata","25"),
("25779","Susa","25"),
("25781","Sutatausa","25"),
("25785","Tabio","25"),
("25793","Tausa","25"),
("25797","Tena","25"),
("25799","Tenjo","25"),
("25805","Tibacuy","25"),
("25807","Tibirita","25"),
("25815","Tocaima","25"),
("25817","Tocancipa","25"),
("25823","Topaipi","25"),
("25839","Ubala","25"),
("25841","Ubaque","25"),
("25843","Villa De San Diego De Ubate","25"),
("25845","Une","25"),
("25851","Utica","25"),
("25862","Vergara","25"),
("25867","Viani","25"),
("25871","Villagomez","25"),
("25873","Villapinzon","25"),
("25875","Villeta","25"),
("25878","Viota","25"),
("25885","Yacopi","25"),
("25898","Zipacon","25"),
("25899","Zipaquira","25"),
("27001","Quibdo","27"),
("27006","Acandi","27"),
("27025","Alto Baudo","27"),
("27050","Atrato","27"),
("27073","Bagado","27"),
("27075","Bahia Solano","27"),
("27077","Bajo Baudo","27"),
("27099","Bojaya","27"),
("27135","El Canton Del San Pablo","27"),
("27150","Carmen Del Darien","27"),
("27160","Certegui","27"),
("27205","Condoto","27"),
("27245","El Carmen De Atrato","27"),
("27250","El Litoral Del San Juan","27"),
("27361","Istmina","27"),
("27372","Jurado","27"),
("27413","Lloro","27"),
("27425","Medio Atrato","27"),
("27430","Medio Baudo","27"),
("27450","Medio San Juan","27"),
("27491","Novita","27"),
("27495","Nuqui","27"),
("27580","Rio Iro","27"),
("27600","Rio Quito","27"),
("27615","Riosucio","27"),
("27660","San Jose Del Palmar","27"),
("27745","Sipi","27"),
("27787","Tado","27");
INSERT INTO municipios VALUES
("27800","Unguia","27"),
("27810","Union Panamericana","27"),
("41001","Neiva","41"),
("41006","Acevedo","41"),
("41013","Agrado","41"),
("41016","Aipe","41"),
("41020","Algeciras","41"),
("41026","Altamira","41"),
("41078","Baraya","41"),
("41132","Campoalegre","41"),
("41206","Colombia","41"),
("41244","Elias","41"),
("41298","Garzon","41"),
("41306","Gigante","41"),
("41319","Guadalupe","41"),
("41349","Hobo","41"),
("41357","Iquira","41"),
("41359","Isnos","41"),
("41378","La Argentina","41"),
("41396","La Plata","41"),
("41483","Nataga","41"),
("41503","Oporapa","41"),
("41518","Paicol","41"),
("41524","Palermo","41"),
("41530","Palestina","41"),
("41548","Pital","41"),
("41551","Pitalito","41"),
("41615","Rivera","41"),
("41660","Saladoblanco","41"),
("41668","San Agustin","41"),
("41676","Santa Maria","41"),
("41770","Suaza","41"),
("41791","Tarqui","41"),
("41797","Tesalia","41"),
("41799","Tello","41"),
("41801","Teruel","41"),
("41807","Timana","41"),
("41872","Villavieja","41"),
("41885","Yaguara","41"),
("44001","Riohacha","44"),
("44035","Albania","44"),
("44078","Barrancas","44"),
("44090","Dibulla","44"),
("44098","Distraccion","44"),
("44110","El Molino","44"),
("44279","Fonseca","44"),
("44378","Hatonuevo","44"),
("44420","La Jagua Del Pilar","44"),
("44430","Maicao","44"),
("44560","Manaure","44"),
("44650","San Juan Del Cesar","44"),
("44847","Uribia","44"),
("44855","Urumita","44"),
("44874","Villanueva","44"),
("47001","Santa Marta","47"),
("47030","Algarrobo","47"),
("47053","Aracataca","47"),
("47058","Ariguani","47"),
("47161","Cerro San Antonio","47"),
("47170","Chibolo","47"),
("47189","Cienaga","47"),
("47205","Concordia","47"),
("47245","El Banco","47"),
("47258","El Pi√±on","47"),
("47268","El Reten","47"),
("47288","Fundacion","47"),
("47318","Guamal","47"),
("47460","Nueva Granada","47"),
("47541","Pedraza","47"),
("47545","Piji√±o Del Carmen","47"),
("47551","Pivijay","47"),
("47555","Plato","47"),
("47570","Puebloviejo","47"),
("47605","Remolino","47"),
("47660","Sabanas De San Angel","47"),
("47675","Salamina","47"),
("47692","San Sebastian De Buenavista","47"),
("47703","San Zenon","47"),
("47707","Santa Ana","47"),
("47720","Santa Barbara De Pinto","47"),
("47745","Sitionuevo","47"),
("47798","Tenerife","47"),
("47960","Zapayan","47"),
("47980","Zona Bananera","47"),
("50001","Villavicencio","50"),
("50006","Acacias","50"),
("50110","Barranca De Upia","50"),
("50124","Cabuyaro","50"),
("50150","Castilla La Nueva","50"),
("50223","Cubarral","50"),
("50226","Cumaral","50"),
("50245","El Calvario","50"),
("50251","El Castillo","50"),
("50270","El Dorado","50"),
("50287","Fuente De Oro","50"),
("50313","Granada","50"),
("50318","Guamal","50"),
("50325","Mapiripan","50"),
("50330","Mesetas","50"),
("50350","La Macarena","50");
INSERT INTO municipios VALUES
("50370","Uribe","50"),
("50400","Lejanias","50"),
("50450","Puerto Concordia","50"),
("50568","Puerto Gaitan","50"),
("50573","Puerto Lopez","50"),
("50577","Puerto Lleras","50"),
("50590","Puerto Rico","50"),
("50606","Restrepo","50"),
("50680","San Carlos De Guaroa","50"),
("50683","San Juan De Arama","50"),
("50686","San Juanito","50"),
("50689","San Martin","50"),
("50711","Vistahermosa","50"),
("52001","Pasto","52"),
("52019","Alban","52"),
("52022","Aldana","52"),
("52036","Ancuya","52"),
("52051","Arboleda","52"),
("52079","Barbacoas","52"),
("52083","Belen","52"),
("52110","Buesaco","52"),
("52203","Colon","52"),
("52207","Consaca","52"),
("52210","Contadero","52"),
("52215","Cordoba","52"),
("52224","Cuaspud","52"),
("52227","Cumbal","52"),
("52233","Cumbitara","52"),
("52240","Chachagsi","52"),
("52250","El Charco","52"),
("52254","El Pe√±ol","52"),
("52256","El Rosario","52"),
("52258","El Tablon De Gomez","52"),
("52260","El Tambo","52"),
("52287","Funes","52"),
("52317","Guachucal","52"),
("52320","Guaitarilla","52"),
("52323","Gualmatan","52"),
("52352","Iles","52"),
("52354","Imues","52"),
("52356","Ipiales","52"),
("52378","La Cruz","52"),
("52381","La Florida","52"),
("52385","La Llanada","52"),
("52390","La Tola","52"),
("52399","La Union","52"),
("52405","Leiva","52"),
("52411","Linares","52"),
("52418","Los Andes","52"),
("52427","Magsi","52"),
("52435","Mallama","52"),
("52473","Mosquera","52"),
("52480","Nari√±o","52"),
("52490","Olaya Herrera","52"),
("52506","Ospina","52"),
("52520","Francisco Pizarro","52"),
("52540","Policarpa","52"),
("52560","Potosi","52"),
("52565","Providencia","52"),
("52573","Puerres","52"),
("52585","Pupiales","52"),
("52612","Ricaurte","52"),
("52621","Roberto Payan","52"),
("52678","Samaniego","52"),
("52683","Sandona","52"),
("52685","San Bernardo","52"),
("52687","San Lorenzo","52"),
("52693","San Pablo","52"),
("52694","San Pedro De Cartago","52"),
("52696","Santa Barbara","52"),
("52699","Santacruz","52"),
("52720","Sapuyes","52"),
("52786","Taminango","52"),
("52788","Tangua","52"),
("52835","San Andres De Tumaco","52"),
("52838","Tuquerres","52"),
("52885","Yacuanquer","52"),
("54001","Cucuta","54"),
("54003","Abrego","54"),
("54051","Arboledas","54"),
("54099","Bochalema","54"),
("54109","Bucarasica","54"),
("54125","Cacota","54"),
("54128","Cachira","54"),
("54172","Chinacota","54"),
("54174","Chitaga","54"),
("54206","Convencion","54"),
("54223","Cucutilla","54"),
("54239","Durania","54"),
("54245","El Carmen","54"),
("54250","El Tarra","54"),
("54261","El Zulia","54"),
("54313","Gramalote","54"),
("54344","Hacari","54"),
("54347","Herran","54"),
("54377","Labateca","54"),
("54385","La Esperanza","54"),
("54398","La Playa","54"),
("54405","Los Patios","54"),
("54418","Lourdes","54");
INSERT INTO municipios VALUES
("54480","Mutiscua","54"),
("54498","Oca√±a","54"),
("54518","Pamplona","54"),
("54520","Pamplonita","54"),
("54553","Puerto Santander","54"),
("54599","Ragonvalia","54"),
("54660","Salazar","54"),
("54670","San Calixto","54"),
("54673","San Cayetano","54"),
("54680","Santiago","54"),
("54720","Sardinata","54"),
("54743","Silos","54"),
("54800","Teorama","54"),
("54810","Tibu","54"),
("54820","Toledo","54"),
("54871","Villa Caro","54"),
("54874","Villa Del Rosario","54"),
("63001","Armenia","63"),
("63111","Buenavista","63"),
("63130","Calarca","63"),
("63190","Circasia","63"),
("63212","Cordoba","63"),
("63272","Filandia","63"),
("63302","Genova","63"),
("63401","La Tebaida","63"),
("63470","Montenegro","63"),
("63548","Pijao","63"),
("63594","Quimbaya","63"),
("63690","Salento","63"),
("66001","Pereira","66"),
("66045","Apia","66"),
("66075","Balboa","66"),
("66088","Belen De Umbria","66"),
("66170","Dosquebradas","66"),
("66318","Guatica","66"),
("66383","La Celia","66"),
("66400","La Virginia","66"),
("66440","Marsella","66"),
("66456","Mistrato","66"),
("66572","Pueblo Rico","66"),
("66594","Quinchia","66"),
("66682","Santa Rosa De Cabal","66"),
("66687","Santuario","66"),
("68001","Bucaramanga","68"),
("68013","Aguada","68"),
("68020","Albania","68"),
("68051","Aratoca","68"),
("68077","Barbosa","68"),
("68079","Barichara","68"),
("68081","Barrancabermeja","68"),
("68092","Betulia","68"),
("68101","Bolivar","68"),
("68121","Cabrera","68"),
("68132","California","68"),
("68147","Capitanejo","68"),
("68152","Carcasi","68"),
("68160","Cepita","68"),
("68162","Cerrito","68"),
("68167","Charala","68"),
("68169","Charta","68"),
("68176","Chima","68"),
("68179","Chipata","68"),
("68190","Cimitarra","68"),
("68207","Concepcion","68"),
("68209","Confines","68"),
("68211","Contratacion","68"),
("68217","Coromoro","68"),
("68229","Curiti","68"),
("68235","El Carmen De Chucuri","68"),
("68245","El Guacamayo","68"),
("68250","El Pe√±on","68"),
("68255","El Playon","68"),
("68264","Encino","68"),
("68266","Enciso","68"),
("68271","Florian","68"),
("68276","Floridablanca","68"),
("68296","Galan","68"),
("68298","Gambita","68"),
("68307","Giron","68"),
("68318","Guaca","68"),
("68320","Guadalupe","68"),
("68322","Guapota","68"),
("68324","Guavata","68"),
("68327","Gsepsa","68"),
("68344","Hato","68"),
("68368","Jesus Maria","68"),
("68370","Jordan","68"),
("68377","La Belleza","68"),
("68385","Landazuri","68"),
("68397","La Paz","68"),
("68406","Lebrija","68"),
("68418","Los Santos","68"),
("68425","Macaravita","68"),
("68432","Malaga","68"),
("68444","Matanza","68"),
("68464","Mogotes","68"),
("68468","Molagavita","68"),
("68498","Ocamonte","68"),
("68500","Oiba","68"),
("68502","Onzaga","68");
INSERT INTO municipios VALUES
("68522","Palmar","68"),
("68524","Palmas Del Socorro","68"),
("68533","Paramo","68"),
("68547","Piedecuesta","68"),
("68549","Pinchote","68"),
("68572","Puente Nacional","68"),
("68573","Puerto Parra","68"),
("68575","Puerto Wilches","68"),
("68615","Rionegro","68"),
("68655","Sabana De Torres","68"),
("68669","San Andres","68"),
("68673","San Benito","68"),
("68679","San Gil","68"),
("68682","San Joaquin","68"),
("68684","San Jose De Miranda","68"),
("68686","San Miguel","68"),
("68689","San Vicente De Chucuri","68"),
("68705","Santa Barbara","68"),
("68720","Santa Helena Del Opon","68"),
("68745","Simacota","68"),
("68755","Socorro","68"),
("68770","Suaita","68"),
("68773","Sucre","68"),
("68780","Surata","68"),
("68820","Tona","68"),
("68855","Valle De San Jose","68"),
("68861","Velez","68"),
("68867","Vetas","68"),
("68872","Villanueva","68"),
("68895","Zapatoca","68"),
("70001","Sincelejo","70"),
("70110","Buenavista","70"),
("70124","Caimito","70"),
("70204","Coloso","70"),
("70215","Corozal","70"),
("70221","Cove√±as","70"),
("70230","Chalan","70"),
("70233","El Roble","70"),
("70235","Galeras","70"),
("70265","Guaranda","70"),
("70400","La Union","70"),
("70418","Los Palmitos","70"),
("70429","Majagual","70"),
("70473","Morroa","70"),
("70508","Ovejas","70"),
("70523","Palmito","70"),
("70670","Sampues","70"),
("70678","San Benito Abad","70"),
("70702","San Juan De Betulia","70"),
("70708","San Marcos","70"),
("70713","San Onofre","70"),
("70717","San Pedro","70"),
("70742","San Luis De Since","70"),
("70771","Sucre","70"),
("70820","Santiago De Tolu","70"),
("70823","Tolu Viejo","70"),
("73001","Ibague","73"),
("73024","Alpujarra","73"),
("73026","Alvarado","73"),
("73030","Ambalema","73"),
("73043","Anzoategui","73"),
("73055","Armero","73"),
("73067","Ataco","73"),
("73124","Cajamarca","73"),
("73148","Carmen De Apicala","73"),
("73152","Casabianca","73"),
("73168","Chaparral","73"),
("73200","Coello","73"),
("73217","Coyaima","73"),
("73226","Cunday","73"),
("73236","Dolores","73"),
("73268","Espinal","73"),
("73270","Falan","73"),
("73275","Flandes","73"),
("73283","Fresno","73"),
("73319","Guamo","73"),
("73347","Herveo","73"),
("73349","Honda","73"),
("73352","Icononzo","73"),
("73408","Lerida","73"),
("73411","Libano","73"),
("73443","Mariquita","73"),
("73449","Melgar","73"),
("73461","Murillo","73"),
("73483","Natagaima","73"),
("73504","Ortega","73"),
("73520","Palocabildo","73"),
("73547","Piedras","73"),
("73555","Planadas","73"),
("73563","Prado","73"),
("73585","Purificacion","73"),
("73616","Rioblanco","73"),
("73622","Roncesvalles","73"),
("73624","Rovira","73"),
("73671","Salda√±a","73"),
("73675","San Antonio","73"),
("73678","San Luis","73"),
("73686","Santa Isabel","73"),
("73770","Suarez","73"),
("73854","Valle De San Juan","73");
INSERT INTO municipios VALUES
("73861","Venadillo","73"),
("73870","Villahermosa","73"),
("73873","Villarrica","73"),
("76001","Cali","76"),
("76020","Alcala","76"),
("76036","Andalucia","76"),
("76041","Ansermanuevo","76"),
("76054","Argelia","76"),
("76100","Bolivar","76"),
("76109","Buenaventura","76"),
("76111","Guadalajara De Buga","76"),
("76113","Bugalagrande","76"),
("76122","Caicedonia","76"),
("76126","Calima","76"),
("76130","Candelaria","76"),
("76147","Cartago","76"),
("76233","Dagua","76"),
("76243","El Aguila","76"),
("76246","El Cairo","76"),
("76248","El Cerrito","76"),
("76250","El Dovio","76"),
("76275","Florida","76"),
("76306","Ginebra","76"),
("76318","Guacari","76"),
("76364","Jamundi","76"),
("76377","La Cumbre","76"),
("76400","La Union","76"),
("76403","La Victoria","76"),
("76497","Obando","76"),
("76520","Palmira","76"),
("76563","Pradera","76"),
("76606","Restrepo","76"),
("76616","Riofrio","76"),
("76622","Roldanillo","76"),
("76670","San Pedro","76"),
("76736","Sevilla","76"),
("76823","Toro","76"),
("76828","Trujillo","76"),
("76834","Tulua","76"),
("76845","Ulloa","76"),
("76863","Versalles","76"),
("76869","Vijes","76"),
("76890","Yotoco","76"),
("76892","Yumbo","76"),
("76895","Zarzal","76"),
("81001","Arauca","81"),
("81065","Arauquita","81"),
("81220","Cravo Norte","81"),
("81300","Fortul","81"),
("81591","Puerto Rondon","81"),
("81736","Saravena","81"),
("81794","Tame","81"),
("85001","Yopal","85"),
("85010","Aguazul","85"),
("85015","Chameza","85"),
("85125","Hato Corozal","85"),
("85136","La Salina","85"),
("85139","Mani","85"),
("85162","Monterrey","85"),
("85225","Nunchia","85"),
("85230","Orocue","85"),
("85250","Paz De Ariporo","85"),
("85263","Pore","85"),
("85279","Recetor","85"),
("85300","Sabanalarga","85"),
("85315","Sacama","85"),
("85325","San Luis De Palenque","85"),
("85400","Tamara","85"),
("85410","Tauramena","85"),
("85430","Trinidad","85"),
("85440","Villanueva","85"),
("86001","Mocoa","86"),
("86219","Colon","86"),
("86320","Orito","86"),
("86568","Puerto Asis","86"),
("86569","Puerto Caicedo","86"),
("86571","Puerto Guzman","86"),
("86573","Leguizamo","86"),
("86749","Sibundoy","86"),
("86755","San Francisco","86"),
("86757","San Miguel","86"),
("86760","Santiago","86"),
("86865","Valle Del Guamuez","86"),
("86885","Villagarzon","86"),
("88001","San Andres","88"),
("88564","Providencia","88"),
("91001","Leticia","91"),
("91263","El Encanto","91"),
("91405","La Chorrera","91"),
("91407","La Pedrera","91"),
("91430","La Victoria","91"),
("91460","Miriti - Parana","91"),
("91530","Puerto Alegria","91"),
("91536","Puerto Arica","91"),
("91540","Puerto Nari√±o","91"),
("91669","Puerto Santander","91"),
("91798","Tarapaca","91"),
("94001","Inirida","94"),
("94343","Barranco Minas","94"),
("94663","Mapiripana","94");
INSERT INTO municipios VALUES
("94883","San Felipe","94"),
("94884","Puerto Colombia","94"),
("94885","La Guadalupe","94"),
("94886","Cacahual","94"),
("94887","Pana Pana","94"),
("94888","Morichal","94"),
("95001","San Jose Del Guaviare","95"),
("95015","Calamar","95"),
("95025","El Retorno","95"),
("95200","Miraflores","95"),
("97001","Mitu","97"),
("97161","Caruru","97"),
("97511","Pacoa","97"),
("97666","Taraira","97"),
("97777","Papunaua","97"),
("97889","Yavarate","97"),
("99001","Puerto Carre√±o","99"),
("99524","La Primavera","99"),
("99624","Santa Rosalia","99"),
("99773","Cumaribo","99");




CREATE TABLE `nivelcargo` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nivelCargo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `prioridad` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `normatividad` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `abreviatura` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `ruta` text DEFAULT NULL COMMENT 'Este campo se usa para los documentos',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `notificaciones` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` int(2) NOT NULL,
  `plataforma` int(2) NOT NULL,
  `formulario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `numeralnorma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numeral` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `idNorma` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;






CREATE TABLE `perfiles` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `estadoUsuario` varchar(12) NOT NULL,
  `nomPerfil` varchar(50) NOT NULL,
  `cedul` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `estadoPerfiles` varchar(10) NOT NULL,
  `estadoBloqueado` varchar(10) NOT NULL,
  `time_login` varchar(20) NOT NULL,
  `time_logout` varchar(20) NOT NULL,
  `ciudad` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `formulario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `listar` tinyint(3) NOT NULL,
  `crear` tinyint(3) NOT NULL,
  `editar` tinyint(3) NOT NULL,
  `eliminar` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `permisoscliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso1` int(11) DEFAULT NULL,
  `permiso2` int(11) DEFAULT NULL,
  `permiso3` int(11) DEFAULT NULL,
  `permiso4` int(11) DEFAULT NULL,
  `permiso5` int(11) DEFAULT NULL,
  `permiso6` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO permisoscliente VALUES
("1","Fixwei","1","1","1","1","1","1"),
("2","Rms","1","0","0","0","0","0");




CREATE TABLE `permisosnotificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `formulario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plataforma` tinyint(3) NOT NULL,
  `correo` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `photo` (
  `photoid` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(150) NOT NULL,
  PRIMARY KEY (`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `politicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoAprobador` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `aprobador` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `minimo` int(200) NOT NULL,
  `maximo` int(200) NOT NULL,
  `color` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `presupuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `totalPresupuesto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalEjecutado` int(100) NOT NULL,
  `tipoResponsable` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `responsable` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `periodo` int(6) NOT NULL,
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `presupuestogestionar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPresupuesto` int(50) NOT NULL,
  `tipo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `totalPresupuesto` int(100) DEFAULT NULL,
  `totalEjecutado` int(100) NOT NULL,
  `tipoProcesoCosto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `procesoCosto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tipoCostoGasto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CostoGastoGrupo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `CostoGastoSubgrupo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tipoResponsable` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `responsable` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `participacion` int(6) NOT NULL,
  `avance` int(11) NOT NULL,
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `presupuestogrupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGC` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreSGC` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `modulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idPresupesto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `presupuestogruposgastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGC` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreSGC` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `modulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idPresupesto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `procesos` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(10000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `duenoProceso` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `prefijo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `macroproceso` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `importacion` int(2) DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedordocumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `idCarpeta` int(50) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `soporte` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filas` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal` int(11) DEFAULT NULL,
  `indicativo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedordocumentoscarpetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCarpeta` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `idProveedor` varchar(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nit` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nitDigito` int(50) DEFAULT NULL COMMENT 'Digito del nit',
  `razonSocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigoCiiu` int(50) DEFAULT NULL COMMENT 'codigo ciiu',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo` int(4) DEFAULT NULL,
  `ciudad` int(100) DEFAULT NULL,
  `direccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `criticidad` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `terminoPago` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frecuenciaActualizacion` int(3) DEFAULT NULL,
  `frecuenciaActualizacionD` int(3) DEFAULT NULL,
  `tiempoEvaluacion` int(3) DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personaNJ` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipoproveedor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bloqueo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aprobador` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `realizador` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notificacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `movil` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creacion` date DEFAULT NULL,
  `bloqueoCarpeta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedorescontrolcambio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `proveedorescriticidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `proveedoresgrupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductoempaque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductogrupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sub` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductoidentificador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sub` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductomedida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductosubgrupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedoresproductotiempo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sub` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedorestipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `proveedorestipoimpuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedorpoliticas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `politica` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO proveedorpoliticas VALUES
("1","Pol√≠ticas 2022");




CREATE TABLE `proveedorproductos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `identificador` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `presentacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `presentacionb` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaExpedicion` date DEFAULT NULL,
  `imagen` longblob DEFAULT NULL,
  `importacion` int(2) DEFAULT NULL,
  `codigo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impuesto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `codigoG` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Este es un auto incrementable para el grupo y subgrupo ',
  `proveedor` int(11) DEFAULT NULL,
  `inventario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipoProducto` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempoServicio` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'id de los tipo de servicios',
  `cantidadTiempoServicio` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ingreso n√∫merico de los servicios',
  `documentos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `proveedorproductosdocumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `upload_time` varchar(255) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `proveedorsubcarpetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `ruta` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `filas` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL,
  `indicativo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `idDocumento` int(11) DEFAULT NULL,
  `idProceso` int(11) DEFAULT NULL,
  `idTipoDocumento` int(11) DEFAULT NULL,
  `idCentroTrabajo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `idResponsable` int(10) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `html` longtext COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreDocumento` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `carpeta` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaAprobacion` datetime DEFAULT NULL,
  `aprobador` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `aprobadorID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ver` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `verID` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `estado` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `repositorioarchivosolicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idRepositorio` int(11) DEFAULT NULL,
  `motivo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitante` int(11) DEFAULT NULL,
  `motivoRechazoAprobacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `repositoriocarpeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ruta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `visualizar` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `visualizarID` longtext COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `repositoriocarpetasolicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idRepositorio` int(11) DEFAULT NULL,
  `motivo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitante` int(11) DEFAULT NULL,
  `motivoRechazoAprobacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `repositorioregistro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `idProceso` int(11) DEFAULT NULL,
  `idTipoDoc` int(11) DEFAULT NULL,
  `idCentroTrabajo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ruta` longtext COLLATE utf8_spanish_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `visualizar` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `visualizarID` longtext COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `realiza` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `response_list` (
  `id` int(11) NOT NULL,
  `form_code` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `responses` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `rl_id` int(30) NOT NULL,
  `meta_field` text COLLATE utf8_spanish_ci NOT NULL,
  `meta_value` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero1` int(11) DEFAULT NULL,
  `numero2` int(11) DEFAULT NULL,
  `operacion` varchar(50) DEFAULT NULL,
  `resultado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `seguridaddelete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registro` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `intentos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO seguridaddelete VALUES
("1","Miguel","1016050102","m.a.a.r.92@hotmail.com","","proceso","El usuario Miguel  realiza solicitud de eliminaci√≥n de datos a la fecha 2022-11-16 12:33:00 PM\n            <br><br><br>\n            IP address (usando get_client_ip_env function) es 190.145.111.177\n            <br>\n            IP address (usando get_client_ip_server function) es 190.145.111.177\n            <br>\n            <br>\n            El nombre del servidor es: fixwei.com<hr> \n            Vienes procedente de la p√°gina: https://fixwei.com/plataforma/pages/cliente<hr> \n            Te has conectado usando el puerto: 59422<hr> \n            El agente de usuario de tu navegador es: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 OPR/92.0.0.0\n            ","0"),
("2","Mayra","1121876697","mayra.rmora@gmail.com","","proceso","El usuario Mayra  realiza solicitud de eliminaci√≥n de datos a la fecha 2022-07-6 06:20:43 PM\n            <br><br><br>\n            IP address (usando get_client_ip_env function) es 190.145.111.177\n            <br>\n            IP address (usando get_client_ip_server function) es 190.145.111.177\n            <br>\n            <br>\n            El nombre del servidor es: fixwei.com<hr> \n            Vienes procedente de la p√°gina: https://fixwei.com/plataforma/pages/cliente<hr> \n            Te has conectado usando el puerto: 53033<hr> \n            El agente de usuario de tu navegador es: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n            ","0");




CREATE TABLE `solicitudalistamiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costos` int(100) DEFAULT NULL,
  `unitario` int(100) DEFAULT NULL,
  `impuesto` int(50) DEFAULT NULL,
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcompra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechaSolicitud` date NOT NULL,
  `contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipoCompra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `centroTrabajo` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `centroCosto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `proceso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrato` text COLLATE utf8_spanish_ci NOT NULL,
  `observacion` text COLLATE utf8_spanish_ci NOT NULL,
  `TipoBS` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `archivo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `archivo2` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `archivo3` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUsuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  `ruta` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta2` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta3` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta4` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta5` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable` int(11) DEFAULT NULL COMMENT 'Corressponde a la persona que rechazo la solicitud',
  `motivo` text COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Corresponde a la justificacion de porque se rechazo',
  `tiempo` int(11) NOT NULL,
  `tipoSolicitud` int(50) DEFAULT NULL,
  `modificacion` int(11) DEFAULT NULL COMMENT 'Corresponde a cada vez que el comprador ingresa al alistamiento de productos se activa esta opcion',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcompracomentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUsuario` int(100) DEFAULT NULL,
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `rol` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcomprador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `proveedor` int(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `correo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `total` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `aprobador` int(11) DEFAULT NULL,
  `estadoAprobador` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaActivada` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcompradortemporal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `proveedor` int(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `correo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `total` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `aprobador` int(11) DEFAULT NULL,
  `estadoAprobador` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaActivada` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcompraflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `idSolicitud` int(11) DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcomprasolicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudcompratipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoFrecuencia` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `frecuencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `solicitudcompraurgencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipoFrecuencia` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `frecuencia` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `solicituddocumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quienSolicita` varchar(50) NOT NULL,
  `tipoSolicitud` int(11) NOT NULL,
  `tipoDocumento` int(11) NOT NULL,
  `proceso` int(11) NOT NULL,
  `tpdG` text DEFAULT NULL,
  `procesoG` text DEFAULT NULL,
  `nombreEncargado` varchar(100) DEFAULT NULL,
  `encargadoAprobar` int(11) NOT NULL,
  `nombreDocumento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombreDocumento2` text NOT NULL,
  `nombreSalvar` text DEFAULT NULL COMMENT 'Este nombre se usa para la validacion de solicitudes existentes',
  `estado` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'campo para estados de revision del documento',
  `solicitud` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `fechaCierre` date DEFAULT NULL,
  `tiempoRespuesta` int(11) DEFAULT NULL,
  `documento` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `comentarios` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'comentarios de seguimiento',
  `plataformaH` int(11) DEFAULT NULL COMMENT 'Almacena la notificaci√≥n activa de plataforma',
  `rechazoSolicitud` int(2) DEFAULT NULL COMMENT 'Cuando la solicitud es rechazada, se guarda TRUE para quitar la notificaci√≥n',
  `QuienAprueba` varchar(70) DEFAULT NULL,
  `docVigente` int(11) DEFAULT NULL,
  `regresa` int(11) DEFAULT NULL,
  `cambioCargo` text DEFAULT NULL COMMENT 'Este campo se crea √∫nicamente cuando se cambia el cargo del usuario',
  `asignacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `solicitudentradasalidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costos` int(100) DEFAULT NULL,
  `unitario` int(100) DEFAULT NULL,
  `impuesto` int(50) DEFAULT NULL,
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `solicitudentradasalidasestado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) DEFAULT NULL,
  `observacion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `tabla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `tablita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registro1` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `registro2` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `tiempo` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `tiempo` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `tipodocumento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `prefijo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicial` int(11) DEFAULT NULL,
  `ruta` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO tipodocumento VALUES
("1","datos","dd","info","1","ruta");




CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `upload_time` varchar(255) NOT NULL,
  `idSolicitudCompra` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `fname` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lname` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `img` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clave` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET latin1 NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cargo` varchar(100) CHARACTER SET latin1 NOT NULL,
  `lider` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` longblob DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `proceso` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arl` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eps` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afp` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idCentroTrabajo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estadoAnulado` tinyint(1) DEFAULT NULL,
  `estadoEliminado` tinyint(1) DEFAULT NULL,
  `estadoUsuario` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'para el chat',
  `contadorSesion` int(2) DEFAULT NULL,
  `mensaje` int(255) DEFAULT NULL,
  `ipSolicitante` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sesionIP` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcionPermiso` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estadoPermiso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correos` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `usuarioeliminado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quienelimina` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idUsuario` int(10) NOT NULL,
  `nombres` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clave` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET latin1 NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cargo` varchar(100) CHARACTER SET latin1 NOT NULL,
  `lider` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` longblob DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `proceso` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arl` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eps` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afp` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idCentroCostos` int(11) DEFAULT NULL,
  `idCentroTrabajo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(200) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `horario` datetime NOT NULL,
  `limite` datetime NOT NULL,
  `blocks` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `versionamiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProceso` int(11) NOT NULL,
  `idTipoDocumento` int(11) NOT NULL,
  `versionInicial` int(11) NOT NULL,
  `consecutivoInicial` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;






/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;