--
-- Estructura de tabla para la tabla `absentismo`
--

CREATE TABLE IF NOT EXISTS `absentismo` (
  `id` int(11) NOT NULL,
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `mes` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `numero` bigint(21) NOT NULL DEFAULT '0',
  `unidad` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `jefatura` text COLLATE latin1_spanish_ci,
  `tutoria` text COLLATE latin1_spanish_ci,
  `orientacion` text COLLATE latin1_spanish_ci,
  `serv_sociales` text COLLATE latin1_spanish_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadalumno`
--

CREATE TABLE IF NOT EXISTS `actividadalumno` (
  `id` int(10) NOT NULL,
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `cod_actividad` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` smallint(5) unsigned NOT NULL,
  `grupos` text COLLATE latin1_spanish_ci,
  `actividad` varchar(164) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `departamento` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `profesor` varchar(196) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `horario` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `hoy` date NOT NULL DEFAULT '0000-00-00',
  `confirmado` tinyint(1) NOT NULL DEFAULT '0',
  `justificacion` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actualizacion`
--

CREATE TABLE IF NOT EXISTS `actualizacion` (
  `id` int(11) NOT NULL,
  `modulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE IF NOT EXISTS `asignaturas` (
  `CODIGO` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `NOMBRE` varchar(96) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ABREV` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `CURSO` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ausencias`
--

CREATE TABLE IF NOT EXISTS `ausencias` (
  `id` int(11) NOT NULL,
  `profesor` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `inicio` date NOT NULL DEFAULT '0000-00-00',
  `fin` date NOT NULL DEFAULT '0000-00-00',
  `horas` int(11) NOT NULL DEFAULT '0',
  `tareas` text COLLATE latin1_spanish_ci NOT NULL,
  `ahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `archivo` varchar(186) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca`
--

CREATE TABLE IF NOT EXISTS `biblioteca` (
  `id` int(11) NOT NULL,
  `Autor` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Titulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Editorial` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ISBN` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `Tipo` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `anoEdicion` int(4) NOT NULL,
  `extension` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `serie` int(11) NOT NULL,
  `lugaredicion` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  `tipoEjemplar` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ubicacion` varchar(32) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca_lectores`
--

CREATE TABLE IF NOT EXISTS `biblioteca_lectores` (
  `id` int(11) NOT NULL,
  `Codigo` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `DNI` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  `Grupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE IF NOT EXISTS `calendario` (
  `id` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` longtext COLLATE latin1_spanish_ci NOT NULL,
  `fechaini` date DEFAULT NULL,
  `horaini` time DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `horafin` time DEFAULT NULL,
  `lugar` varchar(180) COLLATE latin1_spanish_ci NOT NULL,
  `departamento` text COLLATE latin1_spanish_ci,
  `profesores` text COLLATE latin1_spanish_ci,
  `unidades` text COLLATE latin1_spanish_ci,
  `asignaturas` text COLLATE latin1_spanish_ci,
  `fechareg` datetime NOT NULL,
  `profesorreg` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `observaciones` text COLLATE latin1_spanish_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_categorias`
--

CREATE TABLE IF NOT EXISTS `calendario_categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `profesor` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `color` char(7) COLLATE latin1_spanish_ci NOT NULL,
  `espublico` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE IF NOT EXISTS `calificaciones` (
  `codigo` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `abreviatura` varchar(4) COLLATE latin1_spanish_ci DEFAULT NULL,
  `orden` varchar(4) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `dni` varchar(9) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `cargo` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE IF NOT EXISTS `control` (
  `id` int(11) NOT NULL,
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `pass` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `correo` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convivencia`
--

CREATE TABLE IF NOT EXISTS `convivencia` (
  `id` int(11) NOT NULL,
  `claveal` int(8) NOT NULL DEFAULT '0',
  `dia` int(1) NOT NULL DEFAULT '0',
  `hora` int(1) NOT NULL DEFAULT '0',
  `trabajo` int(1) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `observaciones` text COLLATE latin1_spanish_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_profes`
--

CREATE TABLE IF NOT EXISTS `c_profes` (
  `id` int(11) NOT NULL,
  `pass` varchar(48) COLLATE latin1_spanish_ci DEFAULT NULL,
  `PROFESOR` varchar(48) COLLATE latin1_spanish_ci DEFAULT NULL,
  `dni` varchar(9) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `correo` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE IF NOT EXISTS `datos` (
  `id` int(4) NOT NULL DEFAULT '0',
  `nota` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `ponderacion` char(3) COLLATE latin1_spanish_ci DEFAULT NULL,
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `NOMBRE` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `DNI` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `DEPARTAMENTO` varchar(80) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `CARGO` varchar(5) COLLATE latin1_spanish_ci DEFAULT NULL,
  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FALTAS`
--

CREATE TABLE IF NOT EXISTS `FALTAS` (
  `id` int(11) NOT NULL,
  `CLAVEAL` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `UNIDAD` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `NC` tinyint(2) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `DIA` tinyint(1) NOT NULL DEFAULT '0',
  `HORA` tinyint(1) DEFAULT NULL,
  `PROFESOR` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `CODASI` varchar(5) COLLATE latin1_spanish_ci DEFAULT NULL,
  `FALTA` char(1) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FALUMNOS`
--

CREATE TABLE IF NOT EXISTS `FALUMNOS` (
  `CLAVEAL` char(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `NC` double DEFAULT NULL,
  `APELLIDOS` char(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  `NOMBRE` char(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `unidad` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FechCaduca`
--

CREATE TABLE IF NOT EXISTS `FechCaduca` (
  `id` int(11) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `dias` int(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fechoria`
--

CREATE TABLE IF NOT EXISTS `Fechoria` (
  `CLAVEAL` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `FECHA` date NOT NULL DEFAULT '0000-00-00',
  `ASUNTO` text COLLATE latin1_spanish_ci NOT NULL,
  `NOTAS` text COLLATE latin1_spanish_ci NOT NULL,
  `INFORMA` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `grave` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `medida` varchar(148) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `expulsion` tinyint(2) NOT NULL DEFAULT '0',
  `inicio` date DEFAULT '0000-00-00',
  `fin` date DEFAULT '0000-00-00',
  `tutoria` text COLLATE latin1_spanish_ci,
  `expulsionaula` tinyint(1) DEFAULT NULL,
  `enviado` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '1',
  `recibido` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0',
  `aula_conv` tinyint(1) DEFAULT '0',
  `inicio_aula` date DEFAULT NULL,
  `fin_aula` date DEFAULT NULL,
  `horas` int(11) DEFAULT '123456',
  `confirmado` tinyint(1) DEFAULT NULL,
  `tareas` char(2) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `festivos`
--

CREATE TABLE IF NOT EXISTS `festivos` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `nombre` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `docentes` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `ambito` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FTUTORES`
--

CREATE TABLE IF NOT EXISTS `FTUTORES` (
  `UNIDAD` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `TUTOR` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `observaciones1` text COLLATE latin1_spanish_ci NOT NULL,
  `observaciones2` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(4) NOT NULL,
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asignatura` int(6) NOT NULL DEFAULT '0',
  `curso` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `alumnos` varchar(124) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardias`
--

CREATE TABLE IF NOT EXISTS `guardias` (
  `id` int(11) NOT NULL,
  `profesor` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `profe_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dia` tinyint(1) NOT NULL DEFAULT '0',
  `hora` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_guardia` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hermanos`
--

CREATE TABLE IF NOT EXISTS `hermanos` (
  `telefono` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefonourgencia` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hermanos` bigint(21) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horw`
--

CREATE TABLE IF NOT EXISTS `horw` (
  `id` int(11) NOT NULL,
  `dia` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hora` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_asig` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asig` varchar(128) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `c_asig` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `prof` varchar(50) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_aula` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_grupo` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `clase` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horw_faltas`
--

CREATE TABLE IF NOT EXISTS `horw_faltas` (
  `id` int(11) NOT NULL DEFAULT '0',
  `dia` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hora` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_asig` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asig` varchar(128) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `c_asig` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `prof` varchar(50) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_aula` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_grupo` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `clase` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infotut_alumno`
--

CREATE TABLE IF NOT EXISTS `infotut_alumno` (
  `ID` smallint(5) unsigned zerofill NOT NULL,
  `CLAVEAL` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `APELLIDOS` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `NOMBRE` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `UNIDAD` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `F_ENTREV` date NOT NULL DEFAULT '0000-00-00',
  `TUTOR` varchar(40) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `FECHA_REGISTRO` date NOT NULL DEFAULT '0000-00-00',
  `valido` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infotut_profesor`
--

CREATE TABLE IF NOT EXISTS `infotut_profesor` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asignatura` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `informe` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervenciones_profesores`
--

CREATE TABLE IF NOT EXISTS `intervenciones_profesores` (
  `id` int(11) NOT NULL,
  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(60) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `causa` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `accion` varchar(200) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL,
  `clase` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `lugar` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `marca` varchar(32) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `modelo` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `serie` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `unidades` int(11) NOT NULL DEFAULT '0',
  `fecha` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `ahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `departamento` varchar(80) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_clases`
--

CREATE TABLE IF NOT EXISTS `inventario_clases` (
  `id` int(11) NOT NULL,
  `familia` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `clase` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `inventario_clases`
--

INSERT INTO `inventario_clases` (`id`, `familia`, `clase`) VALUES
(1, 'Mobiliario', 'Amarios'),
(3, 'Mobiliario', 'EstanterÌas'),
(5, 'Mobiliario', 'Sillas'),
(6, 'Mobiliario', 'Mesas'),
(7, 'Mobiliario', 'Pupitre'),
(8, 'Mobiliario', 'Mesas profesorado '),
(9, 'Mobiliario', 'Otras mesas'),
(10, 'Mobiliario', 'Ficheros y archivadores'),
(11, 'Mobiliario', 'Pizarras'),
(12, 'Mobiliario', 'Otros'),
(13, 'Inform·tica y comunicaciones', 'Ordenador'),
(14, 'Inform·tica y comunicaciones', 'Monitor'),
(15, 'Inform·tica y comunicaciones', 'Impresora'),
(16, 'Inform·tica y comunicaciones', 'Esc·ner'),
(17, 'Inform·tica y comunicaciones', 'Grabadoras de CD'),
(18, 'Inform·tica y comunicaciones', 'DVD'),
(19, 'Inform·tica y comunicaciones', 'Telefono'),
(20, 'Inform·tica y comunicaciones', 'Router'),
(21, 'Inform·tica y comunicaciones', 'Switch'),
(22, 'Inform·tica y comunicaciones', 'Otros'),
(23, 'Material Audiovisual', 'Proyector de diapositivas'),
(24, 'Material Audiovisual', 'Altavoces'),
(25, 'Material Audiovisual', 'Reproductor de video'),
(26, 'Material Audiovisual', 'Proyector de video'),
(27, 'Material Audiovisual', 'Reproductor de m˙sica'),
(28, 'Material Audiovisual', 'MicrÛfono'),
(29, 'Material Audiovisual', 'C·mara fotogr·fica'),
(30, 'Material Audiovisual', 'C·mara de VÌdeo'),
(31, 'Material Audiovisual', 'Otros'),
(32, 'Material de laboratorio, talleres y departamentos', 'Mapas y cartografÌa'),
(33, 'Material de laboratorio, talleres y departamentos', 'Material variado'),
(34, 'Material deportivo', 'PorterÌas'),
(35, 'Material deportivo', 'Canastas'),
(36, 'Material deportivo', 'Colchonetas'),
(37, 'Material deportivo', 'Vallas'),
(38, 'Material deportivo', 'Otros'),
(39, 'Material de papelerÌa y oficina', 'Varios'),
(40, 'BotiquÌn y material de farmacia', 'Varios'),
(41, 'Extintores y material de autoprotecciÛn', 'Normales'),
(42, 'Extintores y material de autoprotecciÛn', 'Polvo seco (CO2)'),
(43, 'Extintores y material de autoprotecciÛn', 'Otros'),
(44, 'Equipos de seguridad', 'C·maras'),
(45, 'Equipos de seguridad', 'Sensores'),
(46, 'Equipos de seguridad', 'Sirenas y timbres'),
(47, 'Equipos de seguridad', 'Otros'),
(48, 'Otros', 'Varios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_lugares`
--

CREATE TABLE IF NOT EXISTS `inventario_lugares` (
  `id` int(11) NOT NULL,
  `lugar` varchar(64) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `inventario_lugares`
--

INSERT INTO `inventario_lugares` (`id`, `lugar`) VALUES
(1, 'Aulas planta baja ed. Antiguo.'),
(2, 'Aulas 1√Ç¬™ planta ed. Antiguo'),
(3, 'Aulas 2√Ç¬™ planta ed. Antiguo'),
(4, 'Aulas mÛdulo bachillerato '),
(5, 'Aulas mÛdulo nuevo'),
(6, 'Audiovisuales 1'),
(7, 'Audiovisuales 2'),
(8, 'Biblioteca'),
(9, 'Bar - CafeterÌa'),
(10, 'Laboratorio o Taller de Especialidad'),
(11, 'Gimnasio'),
(12, 'Carrito N√Ç¬∫'),
(13, 'Departamento'),
(14, 'Despacho'),
(15, 'Aseos'),
(16, 'Zona Patios'),
(17, 'Almacen'),
(18, 'Otros'),
(19, 'ConserjerÌa'),
(20, 'ConserjerÌa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listafechorias`
--

CREATE TABLE IF NOT EXISTS `listafechorias` (
  `ID` int(4) NOT NULL,
  `fechoria` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `medidas` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `medidas2` mediumtext COLLATE latin1_spanish_ci,
  `tipo` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `listafechorias`
--

INSERT INTO `listafechorias` (`ID`, `fechoria`, `medidas`, `medidas2`, `tipo`) VALUES
(2, 'La falta de puntualidad en la entrada a clase', 'AmonestaciÛn oral', 'El alumno siempre entrar· en el aula. Caso de ser reincidente, se contactar· con la familia y se le comunicar· al tutor', 'leve'),
(4, 'La falta de asistencia a clase', 'Llamada telefÛnica. ComunicaciÛn escrita', 'Se contactar· con la familia para comunicar el hecho (telÈfono o SMS) GrabaciÛn de la falta en el mÛdulo inform·tico.  Caso de reincidencia, seguir el protocolo: a) comunicaciÛn escrita, b)acuse de recibo, c) traslado del caso a Asuntos Sociales', 'leve'),
(6, 'Llevar gorra, capucha, etc en el interior del edificio', 'AmonestaciÛn oral', 'Hacer que el alumno se quite la gorra o capucha, llegando, si es preciso, a requisar gorra y entregar en Jefatura para que la retire al final de la jornada.', 'leve'),
(8, 'Llevar ropa indecorosa en el Centro', 'AmonestaciÛn oral. Llamada telefÛnica.', 'Contactar con la familia para que aporte ropa adecuada o traslade al alumno/a a su domicilio para el oportuno cambio de indumentaria.', 'leve'),
(12, 'Mascar chicle en clase', 'AmonestaciÛn oral', 'Que tire el chicle a la papelera', 'leve'),
(13, 'Llevar telÈfono mÛvil, c·mara, aparatos de sonido, etc en el Centro', 'AmonestaciÛn oral', 'Requisar el aparato y entregar en Jefatura para que sea retirado por la familia.', 'leve'),
(14, 'Arrojar al suelo papeles o basura en general', 'AmonestaciÛn oral', 'Hacer que se retiren los objetos.  Ning˙n profesor permitir· que el aula estÈ sucia. Si es asÌ, obligar al alumnado a la limpieza oportuna.', 'leve'),
(16, 'Hablar en clase', 'AmonestaciÛn oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pÈrdida de', 'leve'),
(18, 'Lanzar objetos, sin peligrosidad o agresividad, a un compaÒero', 'AmonestaciÛn oral', 'Hacer que el compaÒero le devuelva el objeto, que el alumno solicite permiso al profesor para que este le permita, levant·ndose, entregar el objeto a su compaÒero.', 'leve'),
(20, 'No traer el material exigido para el desarrollo de una clase', 'AmonestaciÛn oral', 'Si reincide, contactar telefÛnicamente con la familia para que le aporte el material. Caso de existir alguna causa social que impida que el alumno tenga el material, solicitar la colaboraciÛn del centro o de las instituciones sociales oportunas.', 'leve'),
(22, 'No realizar las actividades encomendadas por el profesor', 'AmonestaciÛn oral', 'Contactar con la familia.', 'leve'),
(23, 'Beber o comer en el aula, en el transcurso de una clase', 'AmonestaciÛn oral', 'Obligar a que guarde la bebida o la arroje a la basura.', 'leve'),
(24, 'Comer en el aula', 'AmonestaciÛn oral', 'Obligar a que guarde la comida.', 'leve'),
(25, 'Permanecer en el pasillo entre clase y clase', 'AmonestaciÛn oral', 'Repercutir la acciÛn en su evaluaciÛn acadÈmica.', 'leve'),
(26, 'Falta de cuidado, respeto y protecciÛn de los recursos personales o del Centro', 'AmonestaciÛn oral', 'Pedir disculpas p˙blicamente y resarcir del posible daÒo a la persona o instituciÛn afectada.', 'leve'),
(27, 'Interrumpir la clase indebidamente', 'AmonestaciÛn oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pÈrdida de recreo o permaneciendo en el aula algunos minutos al final de la jornada o  viniendo el lunes por la tarde.', 'leve'),
(29, 'No realizar aquellas tareas que son planteadas en las distintas asignaturas', 'AmonestaciÛn oral', 'Contactar con la familia.', 'leve'),
(31, 'Faltas reiteradas de puntualidad o asistencia que no estÈn justificadas', 'AmonestaciÛn escrita', 'Seguir protocolo: a) Llamada telefÛnica a la familia b) Escrito a la familia c) Escrito certificado con acuse de recibo a la familia d) Traslado del caso a Asuntos Sociales.', 'grave'),
(32, 'Conductas graves que impidan o dificulten a otros compaÒeros el ejercicio del estudio', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria). El tutor tratar· el caso con Jefatura  para adoptar medidas.', 'grave'),
(34, 'Actos graves de incorrecciÛn con los miembros del Centro', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase  (medida extraordinaria que debe ir acompaÒada con escrito del profesor a los padres). La peticiÛn de excusas se considerar· un atenuante a valorar. El tutor tratar· el caso con la familia y propondr· a Jefatura medidas a adoptar.', 'grave'),
(36, 'Actos graves de indisciplina que perturben el desarrollo normal de las actividades', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria que debe ir acompaÒada con escrito del profesor a los padres). El tutor tratar· el caso con la familia y propondr· a Jefatura medidas a adoptar.', 'grave'),
(38, 'Causar daÒos leves intencionados en las instalaciones o el material del centro', 'AmonestaciÛn escrita', 'El tutor tratar· el caso con la familia y el alumno y familia realizar· trabajos complementarios para la comunidad y  restaurar· los daÒos o pagar· los gastos de reparaciÛn.', 'grave'),
(39, 'Causar daÒos intencionadamente en las pertenencias de los miembros del Centro', 'AmonestaciÛn escrita', 'El tutor tratar· el caso con la familia y el alumno y familia realizar· trabajos complementarios para la comunidad y  restaurar· los daÒos o pagar· los gastos de reparaciÛn o restituciÛn.', 'grave'),
(40, 'IncitaciÛn o estÌmulo a la comisiÛn de una falta contraria a las Normas de Convivencia', 'AmonestaciÛn escrita', 'El tutor tratar· el caso con la familia y propondr· a Jefatura las medidas correctoras a adoptar.', 'grave'),
(41, 'ReiteraciÛn en el mismo trimestre de cinco o m·s faltas leves', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(42, 'Incumplimiento de la sanciÛn impuesta por la DirecciÛn del Centro por una falta leve', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(45, 'GrabaciÛn, a travÈs de cualquier medio, de miembros del Centro sin su autorizaciÛn', 'AmonestaciÛn escrita', 'Entrega de la grabaciÛn y posibles copias en Jefatura de Estudios. Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(47, 'Abandonar el Centro sin autorizaciÛn antes de concluir el horario escolar', 'AmonestaciÛn escrita', 'ComunicaciÛn urgente con la familia.  Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(49, 'Fumar en el Centro (tanto en el interior del edificio como en los patios)', 'AmonestaciÛn escrita', 'ComunicaciÛn urgente con la familia.  Entrega de trabajo relacionado con tabaco y salud. Si es reincidente, imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(51, 'Mentir o colaborar para encubrir faltas propias o ajenas', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(52, 'Cualquier incorrecciÛn de igual gravedad que no constituya falta muy grave', 'AmonestaciÛn escrita', 'Imponer correcciones como: pÈrdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 dÌas.', 'grave'),
(54, 'Actos graves de indisciplina, insultos o falta de respeto con los Profesores y personal del centro', 'AmonestaciÛn escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; expulsiÛn del centro entre 1 y 3 dÌas o entre 4 y 29 si es reincidente.', 'grave'),
(55, 'Las injurias y ofensas contra cualquier miembro de la comunidad educativa', 'AmonestaciÛn escrita', 'PeticiÛn publica de disculpas. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; expulsiÛn del centro entre 1 y 3 dÌas o entre 4 y 29 si es reincidente', 'muy grave'),
(56, 'El acoso fÌsico o moral a los compaÒeros', 'AmonestaciÛn escrita', 'PeticiÛn publica de disculpas y comunicaciÛn con la familia. Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; o expulsiÛn del centro entre 1 y 29  dependiendo de la gravedad', 'muy grave'),
(58, 'Amenazas o coacciones contra cualquier miembro de la comunidad educativa', 'AmonestaciÛn escrita', 'PeticiÛn publica de disculpas y comunicaciÛn con la familia. Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; o expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(61, 'Uso de la violencia, ofensas y actos que atenten contra la intimidad o dignidad de los miembros del Centro', 'AmonestaciÛn escrita', 'PeticiÛn publica de disculpas y comunicaciÛn con la familia. Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(63, 'DiscriminaciÛn a cualquier miembro del centro, por razÛn de raza, sexo, religiÛn, orientaciÛn sexual, etc.', 'AmonestaciÛn escrita', 'PeticiÛn publica de disculpas y comunicaciÛn con la familia. Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(65, 'GrabaciÛn, publicidad o difusiÛn de agresiones o humillaciones cometidas contra miembros del centro', 'AmonestaciÛn escrita', 'Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(66, 'DaÒos graves causados en las instalaciones, materiales y documentos del centro, o en las pertenencias de sus miembros', 'AmonestaciÛn escrita', 'Jefatura de Estudios tratar· el caso con la familia y el alumno y familia realizar· trabajos complementarios para la comunidad y  restaurar· los daÒos o pagar· los gastos de reparaciÛn o restituciÛn.', 'muy grave'),
(67, 'SuplantaciÛn de personalidad en actos de la vida docente y la falsificaciÛn o sustracciÛn de documentos acadÈmicos', 'AmonestaciÛn escrita', 'Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.) Imponer expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(68, 'Uso, incitaciÛn al mismo o introducciÛn en el centro de sustancias perjudiciales para la salud', 'AmonestaciÛn escrita', 'Si el hecho es grave, iniciar los tr·mites legales oportunos (Asuntos Sociales, PolicÌa Nacional, etc.).  Entrega de trabajo relacionado con el hecho y la salud. Imponer sanciÛn de estancia en el Aula de Convivencia o  expulsiÛn del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(70, 'PerturbaciÛn grave del desarrollo de las actividades y cualquier incumplimiento grave de las normas de conducta', 'AmonestaciÛn escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; estancia de un familiar en el aula, con el alumno, durante varios dÌas; o expulsiÛn del centro entre 1 y 29 dÌas en funciÛn de la gravedad.', 'muy grave'),
(71, 'La reiteraciÛn en el mismo trimestre de tres o m·s faltas graves', 'AmonestaciÛn escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; expulsiÛn del centro entre 1 y 3 dÌas o entre 4 y 29 si es reincidente.', 'muy grave'),
(72, 'El incumplimiento de la sanciÛn impuesta por la DirecciÛn por una falta grave', 'AmonestaciÛn escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; o expulsiÛn del centro entre 4 y 29 dÌas, seg˙n gravedad del hecho.', 'muy grave'),
(73, 'Asistir al centro o a actividades programadas por el Centro en estado de embriaguez o drogado', 'AmonestaciÛn escrita', 'Jefatura de Estudios tratar· el caso con la familia y el alumno.  Trabajo sobre el hecho y la salud. Derivar el caso a Dep. OrientaciÛn o Asuntos Sociales si es grave. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; expulsiÛn del centro entre 1 y 3 dÌas o entre 4 y 29 si es reincidente', 'muy grave'),
(76, 'Cometer actos delictivos penados por nuestro Sistema JurÌdico', 'AmonestaciÛn escrita', 'Jefatura tratar· el caso con la familia y, si es grave, denunciar en la PolicÌa. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; estancia de un familiar en el aula, con el alumno, durante varios dÌas; o expulsiÛn del centro entre 1 y 29 dÌas en funciÛn de la gravedad', 'muy grave'),
(78, 'Cometer o encubrir hurtos', 'AmonestaciÛn escrita', 'Jefatura tratar· el caso con la familia. Proceder a la devoluciÛn de lo hurtado.  RealizaciÛn por parte del alumno y la familia de  trabajos para la comunidad.', 'muy grave'),
(79, 'Promover el uso de bebidas alcohÛlicas, sustancias psicotrÛpicas y material pornogr·fico', 'AmonestaciÛn escrita', 'Jefatura tratar· el caso con la familia y, si es grave, denunciar en la PolicÌa. Traslado del caso al Dep. de OrientaciÛn o Asuntos Sociales. Trabajo sobre h·bitos saludables. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; estancia de un familiar en el aula, con el alumno, durante varios dÌas; o expulsiÛn del centro entre 1 y 29 dÌas en funciÛn de la gravedad', 'muy grave'),
(81, 'Cualquier acto grave dirigido directamente a impedir el normal desarrollo de las actividades', 'AmonestaciÛn escrita', 'Jefatura tratar· el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; estancia de un familiar en el aula, con el alumno, durante varios dÌas; o expulsiÛn del centro entre 1 y 29 dÌas en funciÛn de la gravedad', 'muy grave'),
(82, 'No realizar las tareas encomendadas durante el periodo de expulsiÛn', 'AmonestaciÛn escrita', 'Jefatura tratar· el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios dÌas; estancia de un familiar en el aula, con el alumno, durante varios dÌas; o expulsiÛn del centro entre 1 y 29 dÌas en funciÛn de la gravedad', 'muy grave');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE IF NOT EXISTS `matriculas` (
  `id` int(11) NOT NULL,
  `claveal` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `apellidos` varchar(36) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nacido` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `provincia` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nacimiento` date NOT NULL DEFAULT '0000-00-00',
  `domicilio` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `localidad` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dni` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `padre` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dnitutor` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `madre` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dnitutor2` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `telefono1` int(10) NOT NULL DEFAULT '0',
  `telefono2` int(10) NOT NULL DEFAULT '0',
  `colegio` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `otrocolegio` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `letra_grupo` char(1) COLLATE latin1_spanish_ci DEFAULT NULL,
  `correo` varchar(36) COLLATE latin1_spanish_ci DEFAULT NULL,
  `idioma` varchar(6) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `religion` varchar(22) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `optativa1` tinyint(1) NOT NULL DEFAULT '0',
  `optativa2` tinyint(1) NOT NULL DEFAULT '0',
  `optativa3` tinyint(1) NOT NULL DEFAULT '0',
  `optativa4` tinyint(1) NOT NULL DEFAULT '0',
  `act1` tinyint(1) DEFAULT NULL,
  `act2` tinyint(1) DEFAULT NULL,
  `act3` tinyint(1) DEFAULT NULL,
  `act4` tinyint(1) DEFAULT NULL,
  `optativa21` tinyint(1) DEFAULT NULL,
  `optativa22` tinyint(1) DEFAULT NULL,
  `optativa23` tinyint(1) DEFAULT NULL,
  `optativa24` tinyint(1) DEFAULT NULL,
  `act21` tinyint(1) DEFAULT NULL,
  `act22` tinyint(1) DEFAULT NULL,
  `act23` tinyint(1) DEFAULT NULL,
  `act24` tinyint(1) DEFAULT NULL,
  `observaciones` text COLLATE latin1_spanish_ci,
  `exencion` tinyint(1) DEFAULT NULL,
  `bilinguismo` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `curso` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promociona` tinyint(1) DEFAULT NULL,
  `transporte` tinyint(1) DEFAULT NULL,
  `ruta_este` varchar(42) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ruta_oeste` varchar(42) COLLATE latin1_spanish_ci DEFAULT NULL,
  `sexo` varchar(6) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hermanos` tinyint(2) DEFAULT NULL,
  `nacionalidad` varchar(32) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `itinerario` tinyint(1) DEFAULT NULL,
  `matematicas4` char(1) COLLATE latin1_spanish_ci DEFAULT NULL,
  `optativa5` tinyint(1) DEFAULT NULL,
  `optativa6` tinyint(1) DEFAULT NULL,
  `optativa7` tinyint(1) DEFAULT NULL,
  `diversificacion` tinyint(1) DEFAULT NULL,
  `optativa25` tinyint(1) DEFAULT NULL,
  `optativa26` tinyint(1) DEFAULT NULL,
  `optativa27` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `grupo_actual` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `revisado` tinyint(1) DEFAULT NULL,
  `enfermedad` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `otraenfermedad` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `divorcio` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `matematicas3` char(1) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas_bach`
--

CREATE TABLE IF NOT EXISTS `matriculas_bach` (
  `id` int(11) NOT NULL,
  `claveal` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `apellidos` varchar(36) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nacido` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `provincia` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nacimiento` date NOT NULL DEFAULT '0000-00-00',
  `domicilio` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `localidad` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dni` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `padre` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dnitutor` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `madre` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dnitutor2` varchar(13) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `telefono1` int(10) NOT NULL DEFAULT '0',
  `telefono2` int(10) NOT NULL DEFAULT '0',
  `colegio` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `otrocolegio` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `letra_grupo` char(1) COLLATE latin1_spanish_ci DEFAULT NULL,
  `correo` varchar(36) COLLATE latin1_spanish_ci DEFAULT NULL,
  `idioma1` varchar(7) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `idioma2` varchar(7) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `religion` varchar(22) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `observaciones` text COLLATE latin1_spanish_ci,
  `curso` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promociona` tinyint(1) DEFAULT NULL,
  `transporte` tinyint(1) DEFAULT NULL,
  `ruta_este` varchar(42) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ruta_oeste` varchar(42) COLLATE latin1_spanish_ci DEFAULT NULL,
  `sexo` varchar(6) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hermanos` tinyint(2) DEFAULT NULL,
  `nacionalidad` varchar(32) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `confirmado` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `grupo_actual` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `revisado` tinyint(1) DEFAULT NULL,
  `itinerario1` tinyint(1) DEFAULT NULL,
  `itinerario2` tinyint(1) DEFAULT NULL,
  `optativa1` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `optativa2` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `optativa2b1` tinyint(1) DEFAULT NULL,
  `optativa2b2` tinyint(1) DEFAULT NULL,
  `optativa2b3` tinyint(1) DEFAULT NULL,
  `optativa2b4` tinyint(1) DEFAULT NULL,
  `optativa2b5` tinyint(1) DEFAULT NULL,
  `optativa2b6` tinyint(1) DEFAULT NULL,
  `optativa2b7` tinyint(1) DEFAULT NULL,
  `optativa2b8` tinyint(1) DEFAULT NULL,
  `optativa2b9` tinyint(1) DEFAULT NULL,
  `optativa2b10` tinyint(1) DEFAULT NULL,
  `repite` tinyint(1) NOT NULL DEFAULT '0',
  `enfermedad` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `otraenfermedad` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `divorcio` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `bilinguismo` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `religion1b` varchar(64) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(10) unsigned NOT NULL,
  `ahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dni` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `claveal` int(12) NOT NULL DEFAULT '0',
  `asunto` text COLLATE latin1_spanish_ci NOT NULL,
  `texto` text COLLATE latin1_spanish_ci NOT NULL,
  `ip` varchar(15) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `recibidotutor` tinyint(1) NOT NULL DEFAULT '0',
  `recibidopadre` tinyint(1) NOT NULL DEFAULT '0',
  `correo` varchar(72) COLLATE latin1_spanish_ci DEFAULT NULL,
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `archivo` VARCHAR(254) COLLATE latin1_spanish_ci NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mens_profes`
--

CREATE TABLE IF NOT EXISTS `mens_profes` (
  `id_profe` int(10) unsigned NOT NULL,
  `id_texto` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0',
  `recibidoprofe` tinyint(1) NOT NULL DEFAULT '0',
  `recibidojefe` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mens_texto`
--

CREATE TABLE IF NOT EXISTS `mens_texto` (
  `id` int(10) unsigned NOT NULL,
  `ahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `origen` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0',
  `asunto` text COLLATE latin1_spanish_ci NOT NULL,
  `texto` longtext COLLATE latin1_spanish_ci NOT NULL,
  `destino` text COLLATE latin1_spanish_ci NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0',
  `notas1` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `notas2` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `notas3` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `notas4` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_cuaderno`
--

CREATE TABLE IF NOT EXISTS `notas_cuaderno` (
  `id` int(11) NOT NULL,
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `nombre` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `texto` text COLLATE latin1_spanish_ci NOT NULL,
  `texto_pond` text COLLATE latin1_spanish_ci NOT NULL,
  `asignatura` int(6) NOT NULL DEFAULT '0',
  `curso` varchar(36) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `oculto` tinyint(1) NOT NULL DEFAULT '0',
  `visible_nota` int(1) unsigned NOT NULL DEFAULT '0',
  `orden` tinyint(2) NOT NULL DEFAULT '0',
  `Tipo` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `color` varchar(7) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL,
  `slug` text COLLATE latin1_spanish_ci NOT NULL,
  `content` longtext COLLATE latin1_spanish_ci,
  `contact` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `clase` varchar(48) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `pagina` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nuevas`
--

CREATE TABLE IF NOT EXISTS `nuevas` (
  `id` smallint(5) unsigned NOT NULL,
  `abrev` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `texto` varchar(128) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocultas`
--

CREATE TABLE IF NOT EXISTS `ocultas` (
  `id` smallint(5) unsigned NOT NULL,
  `aula` varchar(48) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partestic`
--

CREATE TABLE IF NOT EXISTS `partestic` (
  `parte` smallint(5) unsigned NOT NULL,
  `unidad` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `carro` char(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nserie` varchar(15) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `hora` char(2) COLLATE latin1_spanish_ci DEFAULT '',
  `alumno` varchar(35) COLLATE latin1_spanish_ci DEFAULT NULL,
  `profesor` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `estado` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'activo',
  `nincidencia` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE IF NOT EXISTS `profesores` (
  `nivel` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `materia` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `grupo` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `profesor` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_intranet`
--

CREATE TABLE IF NOT EXISTS `reg_intranet` (
  `id` int(11) NOT NULL,
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_paginas`
--

CREATE TABLE IF NOT EXISTS `reg_paginas` (
  `id` int(11) NOT NULL,
  `id_reg` int(11) NOT NULL DEFAULT '0',
  `pagina` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_principal`
--

CREATE TABLE IF NOT EXISTS `reg_principal` (
  `id` int(11) NOT NULL,
  `pagina` text COLLATE latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `dni` varchar(10) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` smallint(5) unsigned NOT NULL,
  `eventdate` date DEFAULT NULL,
  `dia` tinyint(1) NOT NULL DEFAULT '0',
  `html` tinyint(1) NOT NULL DEFAULT '0',
  `event1` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `event2` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `event3` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `event4` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `event5` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `event6` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `event7` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `servicio` varchar(32) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_elementos`
--

CREATE TABLE IF NOT EXISTS `reservas_elementos` (
  `id` int(11) NOT NULL,
  `elemento` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `id_tipo` tinyint(2) NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(255) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_hor`
--

CREATE TABLE IF NOT EXISTS `reservas_hor` (
  `dia` tinyint(1) NOT NULL DEFAULT '0',
  `hora1` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora2` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora3` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora4` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora5` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora6` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora7` varchar(24) COLLATE latin1_spanish_ci DEFAULT NULL,
  `servicio` varchar(32) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_tipos`
--

CREATE TABLE IF NOT EXISTS `reservas_tipos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `observaciones` varchar(255) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `reservas_tipos`
--

INSERT INTO `reservas_tipos` (`id`, `tipo`, `observaciones`) VALUES
(1, 'TIC', ''),
(2, 'Medios Audiovisuales', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistcal`
--

CREATE TABLE IF NOT EXISTS `sistcal` (
  `id` int(11) NOT NULL,
  `sistcal` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `codigo` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nota` varchar(72) COLLATE latin1_spanish_ci DEFAULT NULL,
  `abrev` varchar(5) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `telefono` text COLLATE latin1_spanish_ci NOT NULL,
  `mensaje` varchar(160) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `profesor` varchar(48) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_alumnos`
--

CREATE TABLE IF NOT EXISTS `tareas_alumnos` (
  `ID` smallint(5) unsigned zerofill NOT NULL,
  `CLAVEAL` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `APELLIDOS` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `NOMBRE` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `FECHA` date NOT NULL DEFAULT '0000-00-00',
  `FIN` date NOT NULL DEFAULT '0000-00-00',
  `DURACION` smallint(2) NOT NULL DEFAULT '3',
  `PROFESOR` varchar(40) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_profesor`
--

CREATE TABLE IF NOT EXISTS `tareas_profesor` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asignatura` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `tarea` text COLLATE latin1_spanish_ci NOT NULL,
  `confirmado` char(2) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE IF NOT EXISTS `temas` (
  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `tema` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `fondo` varchar(16) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Textos`
--

CREATE TABLE IF NOT EXISTS `Textos` (
  `id` int(10) unsigned NOT NULL,
  `Autor` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `Titulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Editorial` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Nivel` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Grupo` text COLLATE latin1_spanish_ci,
  `Notas` text COLLATE latin1_spanish_ci,
  `Departamento` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Asignatura` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Obligatorio` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `Clase` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'Texto',
  `isbn` varchar(18) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `textos_alumnos`
--

CREATE TABLE IF NOT EXISTS `textos_alumnos` (
  `id` int(11) NOT NULL,
  `claveal` int(12) NOT NULL DEFAULT '0',
  `materia` int(5) NOT NULL DEFAULT '0',
  `estado` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `devuelto` char(1) COLLATE latin1_spanish_ci DEFAULT '0',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00',
  `curso` varchar(7) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `textos_gratis`
--

CREATE TABLE IF NOT EXISTS `textos_gratis` (
  `id` int(11) NOT NULL,
  `materia` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `isbn` int(10) NOT NULL DEFAULT '0',
  `ean` int(14) NOT NULL DEFAULT '0',
  `editorial` varchar(32) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `titulo` varchar(96) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `ano` year(4) NOT NULL DEFAULT '0000',
  `caducado` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `importe` int(11) NOT NULL DEFAULT '0',
  `utilizado` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nivel` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoria`
--

CREATE TABLE IF NOT EXISTS `tutoria` (
  `id` int(11) NOT NULL,
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `apellidos` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(24) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `tutor` varchar(48) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `causa` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `accion` varchar(200) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `orienta` tinyint(1) NOT NULL DEFAULT '0',
  `prohibido` tinyint(1) NOT NULL DEFAULT '0',
  `jefatura` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioalumno`
--

CREATE TABLE IF NOT EXISTS `usuarioalumno` (
  `usuario` varchar(18) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pass` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(48) COLLATE latin1_spanish_ci DEFAULT NULL,
  `perfil` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `claveal` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioprofesor`
--

CREATE TABLE IF NOT EXISTS `usuarioprofesor` (
  `usuario` varchar(16) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `perfil` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- √çndices para tablas volcadas
--

--
-- Indices de la tabla `absentismo`
--
ALTER TABLE `absentismo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claveal` (`claveal`);

--
-- Indices de la tabla `actividadalumno`
--
ALTER TABLE `actividadalumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actualizacion`
--
ALTER TABLE `actualizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD KEY `CODIGO` (`CODIGO`),
  ADD KEY `ABREV` (`ABREV`);

--
-- Indices de la tabla `ausencias`
--
ALTER TABLE `ausencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `biblioteca_lectores`
--
ALTER TABLE `biblioteca_lectores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario_categorias`
--
ALTER TABLE `calendario_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD KEY `claveal` (`dni`);

--
-- Indices de la tabla `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convivencia`
--
ALTER TABLE `convivencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claveal` (`claveal`);

--
-- Indices de la tabla `c_profes`
--
ALTER TABLE `c_profes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PROFESOR` (`PROFESOR`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`idea`);

--
-- Indices de la tabla `FALTAS`
--
ALTER TABLE `FALTAS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unidad` (`UNIDAD`),
  ADD KEY `NC` (`NC`),
  ADD KEY `FECHA` (`FECHA`),
  ADD KEY `FALTA` (`FALTA`);

--
-- Indices de la tabla `FALUMNOS`
--
ALTER TABLE `FALUMNOS`
  ADD KEY `CLAVEAL` (`CLAVEAL`),
  ADD KEY `NC` (`NC`);

--
-- Indices de la tabla `Fechoria`
--
ALTER TABLE `Fechoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CLAVEAL` (`CLAVEAL`),
  ADD KEY `FECHA` (`FECHA`);

--
-- Indices de la tabla `festivos`
--
ALTER TABLE `festivos`
  ADD KEY `fecha` (`fecha`);

--
-- Indices de la tabla `FTUTORES`
--
ALTER TABLE `FTUTORES`
  ADD KEY `TUTOR` (`TUTOR`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor` (`profesor`);

--
-- Indices de la tabla `guardias`
--
ALTER TABLE `guardias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hermanos`
--
ALTER TABLE `hermanos`
  ADD KEY `telefono` (`telefono`),
  ADD KEY `telefonourgencia` (`telefonourgencia`);

--
-- Indices de la tabla `horw`
--
ALTER TABLE `horw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prof` (`prof`),
  ADD KEY `c_asig` (`c_asig`);

--
-- Indices de la tabla `infotut_alumno`
--
ALTER TABLE `infotut_alumno`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CLAVEAL` (`CLAVEAL`),
  ADD KEY `APELLIDOS` (`APELLIDOS`),
  ADD KEY `NOMBRE` (`NOMBRE`),
  ADD KEY `UNIDAD` (`UNIDAD`),
  ADD KEY `F_ENTREV` (`F_ENTREV`);

--
-- Indices de la tabla `infotut_profesor`
--
ALTER TABLE `infotut_profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`,`profesor`);

--
-- Indices de la tabla `intervenciones_profesores`
--
ALTER TABLE `intervenciones_profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_clases`
--
ALTER TABLE `inventario_clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_lugares`
--
ALTER TABLE `inventario_lugares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `listafechorias`
--
ALTER TABLE `listafechorias`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matriculas_bach`
--
ALTER TABLE `matriculas_bach`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mens_profes`
--
ALTER TABLE `mens_profes`
  ADD PRIMARY KEY (`id_profe`),
  ADD KEY `profesor` (`profesor`);

--
-- Indices de la tabla `mens_texto`
--
ALTER TABLE `mens_texto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor` (`origen`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`claveal`);

--
-- Indices de la tabla `notas_cuaderno`
--
ALTER TABLE `notas_cuaderno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor` (`profesor`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nuevas`
--
ALTER TABLE `nuevas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ocultas`
--
ALTER TABLE `ocultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partestic`
--
ALTER TABLE `partestic`
  ADD PRIMARY KEY (`parte`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD KEY `profesor` (`profesor`);

--
-- Indices de la tabla `reg_intranet`
--
ALTER TABLE `reg_intranet`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reg_paginas`
--
ALTER TABLE `reg_paginas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reg` (`id_reg`);

--
-- Indices de la tabla `reg_principal`
--
ALTER TABLE `reg_principal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `reservas_elementos`
--
ALTER TABLE `reservas_elementos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas_hor`
--
ALTER TABLE `reservas_hor`
  ADD KEY `dia` (`dia`);

--
-- Indices de la tabla `reservas_tipos`
--
ALTER TABLE `reservas_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sistcal`
--
ALTER TABLE `sistcal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas_alumnos`
--
ALTER TABLE `tareas_alumnos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CLAVEAL` (`CLAVEAL`),
  ADD KEY `APELLIDOS` (`APELLIDOS`),
  ADD KEY `NOMBRE` (`NOMBRE`);

--
-- Indices de la tabla `tareas_profesor`
--
ALTER TABLE `tareas_profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`,`profesor`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD UNIQUE KEY `idea` (`idea`);

--
-- Indices de la tabla `Textos`
--
ALTER TABLE `Textos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `textos_alumnos`
--
ALTER TABLE `textos_alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claveal` (`claveal`);

--
-- Indices de la tabla `textos_gratis`
--
ALTER TABLE `textos_gratis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claveal` (`claveal`),
  ADD KEY `tutor` (`tutor`);

--
-- Indices de la tabla `usuarioalumno`
--
ALTER TABLE `usuarioalumno`
  ADD KEY `claveal` (`claveal`);

--
-- Indices de la tabla `usuarioprofesor`
--
ALTER TABLE `usuarioprofesor`
  ADD KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `absentismo`
--
ALTER TABLE `absentismo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `actividadalumno`
--
ALTER TABLE `actividadalumno`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `actualizacion`
--
ALTER TABLE `actualizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ausencias`
--
ALTER TABLE `ausencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `biblioteca_lectores`
--
ALTER TABLE `biblioteca_lectores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calendario_categorias`
--
ALTER TABLE `calendario_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `convivencia`
--
ALTER TABLE `convivencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `c_profes`
--
ALTER TABLE `c_profes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `FALTAS`
--
ALTER TABLE `FALTAS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Fechoria`
--
ALTER TABLE `Fechoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `guardias`
--
ALTER TABLE `guardias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `horw`
--
ALTER TABLE `horw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `infotut_alumno`
--
ALTER TABLE `infotut_alumno`
  MODIFY `ID` smallint(5) unsigned zerofill NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `infotut_profesor`
--
ALTER TABLE `infotut_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `intervenciones_profesores`
--
ALTER TABLE `intervenciones_profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inventario_clases`
--
ALTER TABLE `inventario_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `inventario_lugares`
--
ALTER TABLE `inventario_lugares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `listafechorias`
--
ALTER TABLE `listafechorias`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `matriculas_bach`
--
ALTER TABLE `matriculas_bach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mens_profes`
--
ALTER TABLE `mens_profes`
  MODIFY `id_profe` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mens_texto`
--
ALTER TABLE `mens_texto`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notas_cuaderno`
--
ALTER TABLE `notas_cuaderno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nuevas`
--
ALTER TABLE `nuevas`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ocultas`
--
ALTER TABLE `ocultas`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `partestic`
--
ALTER TABLE `partestic`
  MODIFY `parte` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reg_intranet`
--
ALTER TABLE `reg_intranet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reg_paginas`
--
ALTER TABLE `reg_paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reg_principal`
--
ALTER TABLE `reg_principal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reservas_elementos`
--
ALTER TABLE `reservas_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reservas_tipos`
--
ALTER TABLE `reservas_tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `sistcal`
--
ALTER TABLE `sistcal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tareas_alumnos`
--
ALTER TABLE `tareas_alumnos`
  MODIFY `ID` smallint(5) unsigned zerofill NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tareas_profesor`
--
ALTER TABLE `tareas_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Textos`
--
ALTER TABLE `Textos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `textos_alumnos`
--
ALTER TABLE `textos_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `textos_gratis`
--
ALTER TABLE `textos_gratis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;