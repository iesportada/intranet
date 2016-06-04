--
-- Estructura de tabla para la tabla `absentismo`
--

DROP TABLE IF EXISTS `absentismo`;
CREATE TABLE IF NOT EXISTS `absentismo` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `mes` char(2) collate latin1_spanish_ci NOT NULL default '',
  `numero` bigint(21) NOT NULL default '0',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `jefatura` text collate latin1_spanish_ci,
  `tutoria` text collate latin1_spanish_ci,
  `orientacion` text collate latin1_spanish_ci,
  `serv_sociales` text collate latin1_spanish_ci,
  PRIMARY KEY  (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='absentismo_seg' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadalumno`
--

DROP TABLE IF EXISTS `actividadalumno`;
CREATE TABLE IF NOT EXISTS `actividadalumno` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `cod_actividad` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE IF NOT EXISTS `actividades` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `grupos` varchar(156) collate latin1_spanish_ci NOT NULL default '',
  `actividad` varchar(164) collate latin1_spanish_ci NOT NULL default '',
  `descripcion` text collate latin1_spanish_ci NOT NULL,
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci default NULL,
  `profesor` varchar(196) collate latin1_spanish_ci NOT NULL default '',
  `horario` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `fecha` date NOT NULL default '0000-00-00',
  `hoy` date NOT NULL default '0000-00-00',
  `confirmado` tinyint(1) NOT NULL default '0',
  `justificacion` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_seneca`
--

DROP TABLE IF EXISTS `actividades_seneca`;
CREATE TABLE IF NOT EXISTS `actividades_seneca` (
  `regactividad` char(1) collate latin1_spanish_ci NOT NULL,
  `idactividad` int(12) unsigned NOT NULL,
  `nomactividad` varchar(100) collate latin1_spanish_ci NOT NULL,
  `requnidadactividad` char(1) collate latin1_spanish_ci NOT NULL,
  `reqmateriaactividad` char(1) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`idactividad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actualizacion`
--

DROP TABLE IF EXISTS `actualizacion`;
CREATE TABLE IF NOT EXISTS `actualizacion` (
  `d` int(11) NOT NULL auto_increment,
  `modulo` varchar(128) collate latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`d`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alma`
--

DROP TABLE IF EXISTS `alma`;
CREATE TABLE IF NOT EXISTS `alma` (
  `COMBASI` varchar(250) collate latin1_spanish_ci default NULL,
  `ESTADOMATRICULA` varchar(255) collate latin1_spanish_ci default NULL,
  `CLAVEAL` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `CLAVEAL1` varchar(8) collate latin1_spanish_ci default NULL,
  `PADRE` varchar(78) collate latin1_spanish_ci default NULL,
  `DNI` varchar(10) collate latin1_spanish_ci default NULL,
  `DOMICILIO` varchar(255) collate latin1_spanish_ci default NULL,
  `CODPOSTAL` varchar(255) collate latin1_spanish_ci default NULL,
  `LOCALIDAD` varchar(255) collate latin1_spanish_ci default NULL,
  `FECHA` varchar(255) collate latin1_spanish_ci default NULL,
  `PROVINCIARESIDENCIA` varchar(255) collate latin1_spanish_ci default NULL,
  `TELEFONO` varchar(255) collate latin1_spanish_ci default NULL,
  `TELEFONOURGENCIA` varchar(255) collate latin1_spanish_ci default NULL,
  `CORREO` varchar(64) collate latin1_spanish_ci default NULL,
  `CURSO` varchar(255) collate latin1_spanish_ci default NULL,
  `NUMEROEXPEDIENTE` varchar(255) collate latin1_spanish_ci default NULL,
  `UNIDAD` varchar(255) collate latin1_spanish_ci default NULL,
  `APELLIDOS` varchar(40) collate latin1_spanish_ci default NULL,
  `NOMBRE` varchar(30) collate latin1_spanish_ci default NULL,
  `DNITUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `PRIMERAPELLIDOTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `SEGUNDOAPELLIDOTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `NOMBRETUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `SEXOPRIMERTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `DNITUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `PRIMERAPELLIDOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `SEGUNDOAPELLIDOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `NOMBRETUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `SEXOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `LOCALIDADNACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `FECHAMATRICULA` varchar(255) collate latin1_spanish_ci default NULL,
  `MATRICULAS` varchar(255) collate latin1_spanish_ci default NULL,
  `OBSERVACIONES` varchar(255) collate latin1_spanish_ci default NULL,
  `PROVINCIANACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `PAISNACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `EDAD` varchar(2) collate latin1_spanish_ci default NULL,
  `NACIONALIDAD` varchar(32) collate latin1_spanish_ci default NULL,
  `SEXO` varchar(1) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`CLAVEAL`),
  KEY `CLAVEAL1` (`CLAVEAL1`),
  KEY `NOMBRE` (`NOMBRE`),
  KEY `APELLIDOS` (`APELLIDOS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alma_primaria`
--

DROP TABLE IF EXISTS `alma_primaria`;
CREATE TABLE IF NOT EXISTS `alma_primaria` (
  `CLAVEAL` varchar(12) collate latin1_spanish_ci default NULL,
  `DNI` varchar(10) collate latin1_spanish_ci default NULL,
  `DOMICILIO` varchar(255) collate latin1_spanish_ci default NULL,
  `CODPOSTAL` varchar(255) collate latin1_spanish_ci default NULL,
  `LOCALIDAD` varchar(255) collate latin1_spanish_ci default NULL,
  `FECHA` varchar(255) collate latin1_spanish_ci default NULL,
  `PROVINCIARESIDENCIA` varchar(255) collate latin1_spanish_ci default NULL,
  `TELEFONO` varchar(255) collate latin1_spanish_ci default NULL,
  `TELEFONOURGENCIA` varchar(255) collate latin1_spanish_ci default NULL,
  `CORREO` varchar(64) collate latin1_spanish_ci default NULL,
  `CURSO` varchar(255) collate latin1_spanish_ci default NULL,
  `NUMEROEXPEDIENTE` varchar(255) collate latin1_spanish_ci default NULL,
  `UNIDAD` varchar(255) collate latin1_spanish_ci default NULL,
  `APELLIDOS` varchar(40) collate latin1_spanish_ci default NULL,
  `NOMBRE` varchar(30) collate latin1_spanish_ci default NULL,
  `NIVEL` varchar(5) collate latin1_spanish_ci default NULL,
  `GRUPO` varchar(1) collate latin1_spanish_ci default NULL,
  `PADRE` varchar(78) collate latin1_spanish_ci default NULL,
  `DNITUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `PRIMERAPELLIDOTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `SEGUNDOAPELLIDOTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `NOMBRETUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `SEXOPRIMERTUTOR` varchar(255) collate latin1_spanish_ci default NULL,
  `DNITUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `PRIMERAPELLIDOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `SEGUNDOAPELLIDOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `NOMBRETUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `SEXOTUTOR2` varchar(255) collate latin1_spanish_ci default NULL,
  `LOCALIDADNACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `FECHAMATRICULA` varchar(255) collate latin1_spanish_ci default NULL,
  `MATRICULAS` varchar(255) collate latin1_spanish_ci default NULL,
  `OBSERVACIONES` varchar(255) collate latin1_spanish_ci default NULL,
  `PROVINCIANACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `PAISNACIMIENTO` varchar(255) collate latin1_spanish_ci default NULL,
  `EDAD` varchar(2) collate latin1_spanish_ci default NULL,
  `NACIONALIDAD` varchar(32) collate latin1_spanish_ci default NULL,
  `SEXO` varchar(1) collate latin1_spanish_ci default NULL,
  `COLEGIO` varchar(32) collate latin1_spanish_ci default NULL,
  KEY `CLAVEAL` (`CLAVEAL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `nombre` varchar(71) collate latin1_spanish_ci default NULL,
  `unidad` varchar(255) collate latin1_spanish_ci default NULL,
  `claveal` varchar(8) collate latin1_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `CODIGO` varchar(10) collate latin1_spanish_ci default NULL,
  `NOMBRE` varchar(128) collate latin1_spanish_ci default NULL,
  `ABREV` varchar(10) collate latin1_spanish_ci default NULL,
  `CURSO` varchar(128) collate latin1_spanish_ci default NULL,
  KEY `CODIGO` (`CODIGO`),
  KEY `ABREV` (`ABREV`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ausencias`
--

DROP TABLE IF EXISTS `ausencias`;
CREATE TABLE IF NOT EXISTS `ausencias` (
  `id` int(11) NOT NULL auto_increment,
  `profesor` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `inicio` date NOT NULL default '0000-00-00',
  `fin` date NOT NULL default '0000-00-00',
  `horas` int(11) NOT NULL default '0',
  `tareas` text collate latin1_spanish_ci NOT NULL,
  `ahora` datetime NOT NULL default '0000-00-00 00:00:00',
  `archivo` varchar(186) collate latin1_spanish_ci NOT NULL,
  `Observaciones` text collate latin1_spanish_ci,
  PRIMARY KEY  (`id`),
  KEY `inicio` (`inicio`),
  KEY `fin` (`fin`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca`
--

DROP TABLE IF EXISTS `biblioteca`;
CREATE TABLE IF NOT EXISTS `biblioteca` (
  `id` int(11) NOT NULL auto_increment,
  `Autor` varchar(128) collate latin1_spanish_ci NOT NULL,
  `Titulo` varchar(128) collate latin1_spanish_ci NOT NULL,
  `Editorial` varchar(128) collate latin1_spanish_ci NOT NULL,
  `ISBN` varchar(15) collate latin1_spanish_ci NOT NULL,
  `Tipo` varchar(64) collate latin1_spanish_ci NOT NULL,
  `anoEdicion` int(4) NOT NULL,
  `extension` varchar(8) collate latin1_spanish_ci NOT NULL,
  `serie` int(11) NOT NULL,
  `lugaredicion` varchar(48) collate latin1_spanish_ci NOT NULL,
  `tipoEjemplar` varchar(128) collate latin1_spanish_ci NOT NULL,
  `ubicacion` varchar(32) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca_lectores`
--

DROP TABLE IF EXISTS `biblioteca_lectores`;
CREATE TABLE IF NOT EXISTS `biblioteca_lectores` (
  `id` int(11) NOT NULL auto_increment,
  `Codigo` varchar(12) collate latin1_spanish_ci NOT NULL,
  `DNI` varchar(12) collate latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(48) collate latin1_spanish_ci NOT NULL,
  `Nombre` varchar(32) collate latin1_spanish_ci NOT NULL,
  `Grupo` varchar(6) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cal`
--

DROP TABLE IF EXISTS `cal`;
CREATE TABLE IF NOT EXISTS `cal` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `eventdate` date NOT NULL default '0000-00-00',
  `html` tinyint(1) NOT NULL default '0',
  `title` varchar(255) collate latin1_spanish_ci NOT NULL default '',
  `event` text collate latin1_spanish_ci NOT NULL,
  `idact` varchar(32) collate latin1_spanish_ci default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `eventdate` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

DROP TABLE IF EXISTS `calendario`;
CREATE TABLE IF NOT EXISTS `calendario` (
  `id` int(11) NOT NULL auto_increment,
  `categoria` int(11) NOT NULL,
  `nombre` varchar(255) collate latin1_spanish_ci NOT NULL,
  `descripcion` longtext collate latin1_spanish_ci NOT NULL,
  `fechaini` date default NULL,
  `horaini` time default NULL,
  `fechafin` date default NULL,
  `horafin` time default NULL,
  `lugar` varchar(180) collate latin1_spanish_ci NOT NULL,
  `departamento` text collate latin1_spanish_ci,
  `profesores` text collate latin1_spanish_ci,
  `unidades` text collate latin1_spanish_ci,
  `asignaturas` text collate latin1_spanish_ci,
  `fechareg` datetime NOT NULL,
  `profesorreg` varchar(60) collate latin1_spanish_ci NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `observaciones` text collate latin1_spanish_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_categorias`
--

DROP TABLE IF EXISTS `calendario_categorias`;
CREATE TABLE IF NOT EXISTS `calendario_categorias` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(30) collate latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `profesor` varchar(80) collate latin1_spanish_ci NOT NULL,
  `color` char(7) collate latin1_spanish_ci NOT NULL,
  `espublico` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
CREATE TABLE IF NOT EXISTS `calificaciones` (
  `codigo` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `nombre` varchar(64) collate latin1_spanish_ci default NULL,
  `abreviatura` varchar(4) collate latin1_spanish_ci default NULL,
  `orden` varchar(4) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

DROP TABLE IF EXISTS `cargos`;
CREATE TABLE IF NOT EXISTS `cargos` (
  `dni` varchar(9) collate latin1_spanish_ci NOT NULL default '',
  `cargo` varchar(8) collate latin1_spanish_ci NOT NULL default '0',
  KEY `dni` (`dni`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

DROP TABLE IF EXISTS `control`;
CREATE TABLE IF NOT EXISTS `control` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL,
  `pass` varchar(254) collate latin1_spanish_ci NOT NULL,
  `correo` varchar(128) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `claveal` (`claveal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_matriculas`
--

DROP TABLE IF EXISTS `control_matriculas`;
CREATE TABLE IF NOT EXISTS `control_matriculas` (
  `id` int(11) NOT NULL default '0',
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL,
  `pass` varchar(254) collate latin1_spanish_ci NOT NULL,
  `correo` varchar(128) collate latin1_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convivencia`
--

DROP TABLE IF EXISTS `convivencia`;
CREATE TABLE IF NOT EXISTS `convivencia` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` int(8) NOT NULL default '0',
  `dia` int(1) NOT NULL default '0',
  `hora` int(1) NOT NULL default '0',
  `trabajo` int(1) NOT NULL default '0',
  `fecha` date NOT NULL default '0000-00-00',
  `observaciones` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `idcurso` int(12) unsigned NOT NULL,
  `nomcurso` varchar(80) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`idcurso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_profes`
--

DROP TABLE IF EXISTS `c_profes`;
CREATE TABLE IF NOT EXISTS `c_profes` (
  `id` smallint(2) NOT NULL auto_increment,
  `pass` varchar(48) collate latin1_spanish_ci default NULL,
  `PROFESOR` varchar(48) collate latin1_spanish_ci default NULL,
  `dni` varchar(9) collate latin1_spanish_ci NOT NULL default '',
  `idea` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `correo` varchar(64) collate latin1_spanish_ci default NULL,
  `estado` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `PROFESOR` (`PROFESOR`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

DROP TABLE IF EXISTS `datos`;
CREATE TABLE IF NOT EXISTS `datos` (
  `id` int(4) NOT NULL default '0',
  `nota` text collate latin1_spanish_ci NOT NULL,
  `ponderacion` char(3) collate latin1_spanish_ci default NULL,
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_primaria`
--

DROP TABLE IF EXISTS `datos_primaria`;
CREATE TABLE IF NOT EXISTS `datos_primaria` (
  `apellidos` varchar(40) collate latin1_spanish_ci default NULL,
  `nombre` varchar(30) collate latin1_spanish_ci default NULL,
  `padre` varchar(78) collate latin1_spanish_ci default NULL,
  `dnitutor` varchar(255) collate latin1_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `NOMBRE` varchar(48) collate latin1_spanish_ci default NULL,
  `DNI` varchar(10) collate latin1_spanish_ci default NULL,
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci default NULL,
  `CARGO` varchar(5) collate latin1_spanish_ci default NULL,
  `idea` varchar(12) collate latin1_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos_seneca`
--

DROP TABLE IF EXISTS `departamentos_seneca`;
CREATE TABLE IF NOT EXISTS `departamentos_seneca` (
  `iddepartamento` int(2) unsigned NOT NULL auto_increment,
  `nomdepartamento` varchar(80) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`iddepartamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencias`
--

DROP TABLE IF EXISTS `dependencias`;
CREATE TABLE IF NOT EXISTS `dependencias` (
  `iddependencia` int(12) unsigned NOT NULL,
  `nomdependencia` varchar(30) collate latin1_spanish_ci NOT NULL,
  `descdependencia` varchar(80) collate latin1_spanish_ci default NULL,
  `reservadependencia` int(1) NOT NULL default '0',
  PRIMARY KEY  (`iddependencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diario`
--

DROP TABLE IF EXISTS `diario`;
CREATE TABLE IF NOT EXISTS `diario` (
  `id` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL,
  `grupo` varchar(72) collate latin1_spanish_ci NOT NULL,
  `materia` varchar(128) collate latin1_spanish_ci NOT NULL,
  `tipo` varchar(24) collate latin1_spanish_ci NOT NULL,
  `titulo` text collate latin1_spanish_ci NOT NULL,
  `observaciones` text collate latin1_spanish_ci NOT NULL,
  `calendario` int(1) default NULL,
  `profesor` varchar(64) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `asignatura` varchar(64) collate latin1_spanish_ci NOT NULL,
  `evaluacion` char(3) collate latin1_spanish_ci NOT NULL,
  `profesor` text collate latin1_spanish_ci NOT NULL,
  `calificaciones` blob NOT NULL,
  PRIMARY KEY  (`unidad`,`asignatura`,`evaluacion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_actas`
--

DROP TABLE IF EXISTS `evaluaciones_actas`;
CREATE TABLE IF NOT EXISTS `evaluaciones_actas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `evaluacion` char(3) collate latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `texto_acta` text collate latin1_spanish_ci NOT NULL,
  `impresion` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evalua_pendientes`
--

DROP TABLE IF EXISTS `evalua_pendientes`;
CREATE TABLE IF NOT EXISTS `evalua_pendientes` (
  `id` int(11) NOT NULL auto_increment,
  `evaluacion` tinyint(1) NOT NULL,
  `claveal` varchar(8) collate latin1_spanish_ci NOT NULL,
  `codigo` int(6) NOT NULL,
  `materia` varchar(8) collate latin1_spanish_ci NOT NULL,
  `nota` tinyint(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evalua_tutoria`
--

DROP TABLE IF EXISTS `evalua_tutoria`;
CREATE TABLE IF NOT EXISTS `evalua_tutoria` (
  `id` int(11) NOT NULL auto_increment,
  `unidad` varchar(32) collate latin1_spanish_ci NOT NULL,
  `evaluacion` varchar(32) collate latin1_spanish_ci NOT NULL,
  `alumno` varchar(10) collate latin1_spanish_ci NOT NULL,
  `campo` varchar(10) collate latin1_spanish_ci NOT NULL,
  `valor` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FALTAS`
--

DROP TABLE IF EXISTS `FALTAS`;
CREATE TABLE IF NOT EXISTS `FALTAS` (
  `id` int(11) NOT NULL auto_increment,
  `CLAVEAL` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `NC` tinyint(2) default NULL,
  `FECHA` date default NULL,
  `DIA` tinyint(1) NOT NULL default '0',
  `HORA` tinyint(1) default NULL,
  `PROFESOR` char(2) collate latin1_spanish_ci default NULL,
  `CODASI` varchar(10) collate latin1_spanish_ci default NULL,
  `FALTA` char(1) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `NC` (`NC`),
  KEY `FECHA` (`FECHA`),
  KEY `FALTA` (`FALTA`),
  KEY `CLAVEAL` (`CLAVEAL`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FALUMNOS`
--

DROP TABLE IF EXISTS `FALUMNOS`;
CREATE TABLE IF NOT EXISTS `FALUMNOS` (
  `CLAVEAL` char(12) collate latin1_spanish_ci NOT NULL default '',
  `NC` double default NULL,
  `APELLIDOS` char(30) collate latin1_spanish_ci default NULL,
  `NOMBRE` char(24) collate latin1_spanish_ci default NULL,
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FechCaduca`
--

DROP TABLE IF EXISTS `FechCaduca`;
CREATE TABLE IF NOT EXISTS `FechCaduca` (
  `id` int(11) NOT NULL default '0',
  `fecha` date NOT NULL default '0000-00-00',
  `dias` int(7) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fechoria`
--

DROP TABLE IF EXISTS `Fechoria`;
CREATE TABLE IF NOT EXISTS `Fechoria` (
  `CLAVEAL` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `FECHA` date NOT NULL default '0000-00-00',
  `ASUNTO` text collate latin1_spanish_ci NOT NULL,
  `NOTAS` text collate latin1_spanish_ci NOT NULL,
  `INFORMA` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `grave` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `medida` varchar(148) collate latin1_spanish_ci NOT NULL default '',
  `expulsion` tinyint(2) NOT NULL default '0',
  `inicio` date default '0000-00-00',
  `fin` date default '0000-00-00',
  `tutoria` text collate latin1_spanish_ci,
  `expulsionaula` tinyint(1) default NULL,
  `enviado` char(1) collate latin1_spanish_ci NOT NULL default '1',
  `recibido` char(1) collate latin1_spanish_ci NOT NULL default '0',
  `aula_conv` tinyint(1) default '0',
  `inicio_aula` date default NULL,
  `fin_aula` date default NULL,
  `horas` int(11) default '123456',
  `confirmado` tinyint(1) default NULL,
  `tareas` char(2) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `FECHA` (`FECHA`),
  KEY `grave` (`grave`),
  KEY `expulsion` (`expulsion`),
  KEY `expulsionaula` (`expulsionaula`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `festivos`
--

DROP TABLE IF EXISTS `festivos`;
CREATE TABLE IF NOT EXISTS `festivos` (
  `fecha` date NOT NULL default '0000-00-00',
  `nombre` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `docentes` char(2) collate latin1_spanish_ci NOT NULL default '',
  `ambito` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

DROP TABLE IF EXISTS `fotos`;
CREATE TABLE IF NOT EXISTS `fotos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(18) collate latin1_spanish_ci NOT NULL default '',
  `datos` mediumblob NOT NULL,
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `tamaño` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `nombre` (`nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FTUTORES`
--

DROP TABLE IF EXISTS `FTUTORES`;
CREATE TABLE IF NOT EXISTS `FTUTORES` (
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `TUTOR` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `observaciones1` text collate latin1_spanish_ci NOT NULL,
  `observaciones2` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`unidad`),
  KEY `TUTOR` (`TUTOR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(4) NOT NULL auto_increment,
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `asignatura` int(6) NOT NULL default '0',
  `curso` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `alumnos` varchar(124) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardias`
--

DROP TABLE IF EXISTS `guardias`;
CREATE TABLE IF NOT EXISTS `guardias` (
  `id` int(11) NOT NULL auto_increment,
  `profesor` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `profe_aula` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `dia` tinyint(1) NOT NULL default '0',
  `hora` tinyint(1) NOT NULL default '0',
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `fecha_guardia` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hermanos`
--

DROP TABLE IF EXISTS `hermanos`;
CREATE TABLE IF NOT EXISTS `hermanos` (
  `id` int(11) NOT NULL auto_increment,
  `telefono` varchar(255) collate latin1_spanish_ci default NULL,
  `telefonourgencia` varchar(255) collate latin1_spanish_ci default NULL,
  `hermanos` bigint(21) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `telefono` (`telefono`),
  KEY `telefonourgencia` (`telefonourgencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horw`
--

DROP TABLE IF EXISTS `horw`;
CREATE TABLE IF NOT EXISTS `horw` (
  `id` int(11) NOT NULL auto_increment,
  `dia` char(1) collate latin1_spanish_ci NOT NULL default '',
  `hora` char(2) collate latin1_spanish_ci NOT NULL default '',
  `a_asig` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `asig` varchar(128) collate latin1_spanish_ci NOT NULL default '',
  `c_asig` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `prof` varchar(50) collate latin1_spanish_ci NOT NULL default '',
  `no_prof` tinyint(4) default NULL,
  `c_prof` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `a_aula` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `n_aula` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `a_grupo` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `nivel` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `n_grupo` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `clase` varchar(16) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `prof` (`prof`),
  KEY `c_asig` (`c_asig`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horw_faltas`
--

DROP TABLE IF EXISTS `horw_faltas`;
CREATE TABLE IF NOT EXISTS `horw_faltas` (
  `id` int(11) NOT NULL auto_increment,
  `dia` char(1) collate latin1_spanish_ci NOT NULL default '',
  `hora` char(2) collate latin1_spanish_ci NOT NULL default '',
  `a_asig` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `asig` varchar(128) collate latin1_spanish_ci NOT NULL default '',
  `c_asig` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `prof` varchar(50) collate latin1_spanish_ci NOT NULL default '',
  `no_prof` tinyint(4) default NULL,
  `c_prof` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `a_aula` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `n_aula` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `a_grupo` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `nivel` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `n_grupo` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `clase` varchar(16) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infotut_alumno`
--

DROP TABLE IF EXISTS `infotut_alumno`;
CREATE TABLE IF NOT EXISTS `infotut_alumno` (
  `ID` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `CLAVEAL` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `APELLIDOS` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `NOMBRE` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `F_ENTREV` date NOT NULL default '0000-00-00',
  `TUTOR` varchar(40) collate latin1_spanish_ci NOT NULL default '',
  `FECHA_REGISTRO` date NOT NULL default '0000-00-00',
  `valido` tinyint(1) NOT NULL default '1',
  `motivo` varchar(255) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`ID`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `F_ENTREV` (`F_ENTREV`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infotut_profesor`
--

DROP TABLE IF EXISTS `infotut_profesor`;
CREATE TABLE IF NOT EXISTS `infotut_profesor` (
  `id` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL default '0',
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `asignatura` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `informe` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_alumno` (`id_alumno`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervenciones_profesores`
--

DROP TABLE IF EXISTS `intervenciones_profesores`;
CREATE TABLE IF NOT EXISTS `intervenciones_profesores` (
  `id` int(11) NOT NULL auto_increment,
  `idea` varchar(10) collate latin1_spanish_ci NOT NULL,
  `nombre` varchar(64) collate latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `causa` varchar(64) collate latin1_spanish_ci NOT NULL,
  `observaciones` text collate latin1_spanish_ci NOT NULL,
  `accion` varchar(64) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL auto_increment,
  `clase` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `lugar` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `descripcion` text collate latin1_spanish_ci NOT NULL,
  `marca` varchar(32) collate latin1_spanish_ci NOT NULL default '',
  `modelo` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `serie` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `unidades` int(11) NOT NULL default '0',
  `fecha` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `ahora` datetime NOT NULL default '0000-00-00 00:00:00',
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci default NULL,
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_clases`
--

DROP TABLE IF EXISTS `inventario_clases`;
CREATE TABLE IF NOT EXISTS `inventario_clases` (
  `id` int(11) NOT NULL auto_increment,
  `familia` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `clase` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `inventario_clases`
--

INSERT INTO `inventario_clases` (`id`, `familia`, `clase`) VALUES
(1, 'Mobiliario', 'Amarios'),
(3, 'Mobiliario', 'Estanterías'),
(5, 'Mobiliario', 'Sillas'),
(6, 'Mobiliario', 'Mesas'),
(7, 'Mobiliario', 'Pupitre'),
(8, 'Mobiliario', 'Mesas profesorado '),
(9, 'Mobiliario', 'Otras mesas'),
(10, 'Mobiliario', 'Ficheros y archivadores'),
(11, 'Mobiliario', 'Pizarras'),
(12, 'Mobiliario', 'Otros'),
(13, 'Informática y comunicaciones', 'Ordenador'),
(14, 'Informática y comunicaciones', 'Monitor'),
(15, 'Informática y comunicaciones', 'Impresora'),
(16, 'Informática y comunicaciones', 'Escáner'),
(17, 'Informática y comunicaciones', 'Grabadoras de CD'),
(18, 'Informática y comunicaciones', 'DVD'),
(19, 'Informática y comunicaciones', 'Telefono'),
(20, 'Informática y comunicaciones', 'Router'),
(21, 'Informática y comunicaciones', 'Switch'),
(22, 'Informática y comunicaciones', 'Otros'),
(23, 'Material Audiovisual', 'Proyector de diapositivas'),
(24, 'Material Audiovisual', 'Altavoces'),
(25, 'Material Audiovisual', 'Reproductor de video'),
(26, 'Material Audiovisual', 'Proyector de video'),
(27, 'Material Audiovisual', 'Reproductor de música'),
(28, 'Material Audiovisual', 'Micrófono'),
(29, 'Material Audiovisual', 'Cámara fotográfica'),
(30, 'Material Audiovisual', 'Cámara de Vídeo'),
(31, 'Material Audiovisual', 'Otros'),
(32, 'Material de laboratorio, talleres y departamentos', 'Mapas y cartografía'),
(33, 'Material de laboratorio, talleres y departamentos', 'Material variado'),
(34, 'Material deportivo', 'Porterías'),
(35, 'Material deportivo', 'Canastas'),
(36, 'Material deportivo', 'Colchonetas'),
(37, 'Material deportivo', 'Vallas'),
(38, 'Material deportivo', 'Otros'),
(39, 'Material de papelería y oficina', 'Varios'),
(40, 'Botiquín y material de farmacia', 'Varios'),
(41, 'Extintores y material de autoprotección', 'Normales'),
(42, 'Extintores y material de autoprotección', 'Polvo seco (CO2)'),
(43, 'Extintores y material de autoprotección', 'Otros'),
(44, 'Equipos de seguridad', 'Cámaras'),
(45, 'Equipos de seguridad', 'Sensores'),
(46, 'Equipos de seguridad', 'Sirenas y timbres'),
(47, 'Equipos de seguridad', 'Otros'),
(48, 'Otros', 'Varios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_lugares`
--

DROP TABLE IF EXISTS `inventario_lugares`;
CREATE TABLE IF NOT EXISTS `inventario_lugares` (
  `id` int(11) NOT NULL auto_increment,
  `lugar` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `inventario_lugares`
--

INSERT INTO `inventario_lugares` (`id`, `lugar`) VALUES
(1, 'Aulas planta baja ed. Antiguo.'),
(2, 'Aulas 1ª planta ed. Antiguo'),
(3, 'Aulas 2ª planta ed. Antiguo'),
(4, 'Aulas módulo bachillerato '),
(5, 'Aulas módulo nuevo'),
(6, 'Audiovisuales 1'),
(7, 'Audiovisuales 2'),
(8, 'Biblioteca'),
(9, 'Bar - Cafetería'),
(10, 'Laboratorio o Taller de Especialidad'),
(11, 'Gimnasio'),
(12, 'Carrito Nº'),
(13, 'Departamento'),
(14, 'Despacho'),
(15, 'Aseos'),
(16, 'Zona Patios'),
(17, 'Almacen'),
(18, 'Otros'),
(19, 'Conserjería'),
(20, 'Conserjería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

DROP TABLE IF EXISTS `jornada`;
CREATE TABLE IF NOT EXISTS `jornada` (
  `tramo` varchar(24) collate latin1_spanish_ci NOT NULL,
  `hora_inicio` varchar(5) collate latin1_spanish_ci NOT NULL,
  `hora_fin` varchar(5) collate latin1_spanish_ci NOT NULL,
  `minutos` int(11) NOT NULL,
  PRIMARY KEY  (`tramo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listafechorias`
--

DROP TABLE IF EXISTS `listafechorias`;
CREATE TABLE IF NOT EXISTS `listafechorias` (
  `ID` int(11) NOT NULL auto_increment,
  `fechoria` varchar(255) collate latin1_spanish_ci default NULL,
  `medidas` varchar(64) collate latin1_spanish_ci default NULL,
  `medidas2` mediumtext collate latin1_spanish_ci,
  `tipo` varchar(10) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=83 ;

--
-- Volcado de datos para la tabla `listafechorias`
--

INSERT INTO `listafechorias` (`ID`, `fechoria`, `medidas`, `medidas2`, `tipo`) VALUES
(2, 'La falta de puntualidad en la entrada a clase', 'Amonestación oral', 'El alumno siempre entrará en el aula. Caso de ser reincidente, se contactará con la familia y se le comunicará al tutor', 'leve'),
(4, 'La falta de asistencia a clase', 'Llamada telefónica. Comunicación escrita', 'Se contactará con la familia para comunicar el hecho (teléfono o SMS) Grabación de la falta en el módulo informático.  Caso de reincidencia, seguir el protocolo: a) comunicación escrita, b)acuse de recibo, c) traslado del caso a Asuntos Sociales', 'leve'),
(6, 'Llevar gorra, capucha, etc en el interior del edificio', 'Amonestación oral', 'Hacer que el alumno se quite la gorra o capucha, llegando, si es preciso, a requisar gorra y entregar en Jefatura para que la retire al final de la jornada.', 'leve'),
(8, 'Llevar ropa indecorosa en el Centro', 'Amonestación oral. Llamada telefónica.', 'Contactar con la familia para que aporte ropa adecuada o traslade al alumno/a a su domicilio para el oportuno cambio de indumentaria.', 'leve'),
(12, 'Mascar chicle en clase', 'Amonestación oral', 'Que tire el chicle a la papelera', 'leve'),
(13, 'Llevar teléfono móvil, cámara, aparatos de sonido, etc en el Centro', 'Amonestación oral', 'Requisar el aparato y entregar en Jefatura para que sea retirado por la familia.', 'leve'),
(14, 'Arrojar al suelo papeles o basura en general', 'Amonestación oral', 'Hacer que se retiren los objetos.  Ningún profesor permitirá que el aula esté sucia. Si es así, obligar al alumnado a la limpieza oportuna.', 'leve'),
(16, 'Hablar en clase', 'Amonestación oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pérdida de', 'leve'),
(18, 'Lanzar objetos, sin peligrosidad o agresividad, a un compañero', 'Amonestación oral', 'Hacer que el compañero le devuelva el objeto, que el alumno solicite permiso al profesor para que este le permita, levantándose, entregar el objeto a su compañero.', 'leve'),
(20, 'No traer el material exigido para el desarrollo de una clase', 'Amonestación oral', 'Si reincide, contactar telefónicamente con la familia para que le aporte el material. Caso de existir alguna causa social que impida que el alumno tenga el material, solicitar la colaboración del centro o de las instituciones sociales oportunas.', 'leve'),
(22, 'No realizar las actividades encomendadas por el profesor', 'Amonestación oral', 'Contactar con la familia.', 'leve'),
(23, 'Beber o comer en el aula, en el transcurso de una clase', 'Amonestación oral', 'Obligar a que guarde la bebida o la arroje a la basura.', 'leve'),
(24, 'Comer en el aula', 'Amonestación oral', 'Obligar a que guarde la comida.', 'leve'),
(25, 'Permanecer en el pasillo entre clase y clase', 'Amonestación oral', 'Repercutir la acción en su evaluación académica.', 'leve'),
(26, 'Falta de cuidado, respeto y protección de los recursos personales o del Centro', 'Amonestación oral', 'Pedir disculpas públicamente y resarcir del posible daño a la persona o institución afectada.', 'leve'),
(27, 'Interrumpir la clase indebidamente', 'Amonestación oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pérdida de recreo o permaneciendo en el aula algunos minutos al final de la jornada o  viniendo el lunes por la tarde.', 'leve'),
(29, 'No realizar aquellas tareas que son planteadas en las distintas asignaturas', 'Amonestación oral', 'Contactar con la familia.', 'leve'),
(31, 'Faltas reiteradas de puntualidad o asistencia que no estén justificadas', 'Amonestación escrita', 'Seguir protocolo: a) Llamada telefónica a la familia b) Escrito a la familia c) Escrito certificado con acuse de recibo a la familia d) Traslado del caso a Asuntos Sociales.', 'grave'),
(32, 'Conductas graves que impidan o dificulten a otros compañeros el ejercicio del estudio', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria). El tutor tratará el caso con Jefatura  para adoptar medidas.', 'grave'),
(34, 'Actos graves de incorrección con los miembros del Centro', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase  (medida extraordinaria que debe ir acompañada con escrito del profesor a los padres). La petición de excusas se considerará un atenuante a valorar. El tutor tratará el caso con la familia y propondrá a Jefatura medidas a adoptar.', 'grave'),
(36, 'Actos graves de indisciplina que perturben el desarrollo normal de las actividades', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria que debe ir acompañada con escrito del profesor a los padres). El tutor tratará el caso con la familia y propondrá a Jefatura medidas a adoptar.', 'grave'),
(38, 'Causar daños leves intencionados en las instalaciones o el material del centro', 'Amonestación escrita', 'El tutor tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación.', 'grave'),
(39, 'Causar daños intencionadamente en las pertenencias de los miembros del Centro', 'Amonestación escrita', 'El tutor tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación o restitución.', 'grave'),
(40, 'Incitación o estímulo a la comisión de una falta contraria a las Normas de Convivencia', 'Amonestación escrita', 'El tutor tratará el caso con la familia y propondrá a Jefatura las medidas correctoras a adoptar.', 'grave'),
(41, 'Reiteración en el mismo trimestre de cinco o más faltas leves', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(42, 'Incumplimiento de la sanción impuesta por la Dirección del Centro por una falta leve', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(45, 'Grabación, a través de cualquier medio, de miembros del Centro sin su autorización', 'Amonestación escrita', 'Entrega de la grabación y posibles copias en Jefatura de Estudios. Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(47, 'Abandonar el Centro sin autorización antes de concluir el horario escolar', 'Amonestación escrita', 'Comunicación urgente con la familia.  Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(49, 'Fumar en el Centro (tanto en el interior del edificio como en los patios)', 'Amonestación escrita', 'Comunicación urgente con la familia.  Entrega de trabajo relacionado con tabaco y salud. Si es reincidente, imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(51, 'Mentir o colaborar para encubrir faltas propias o ajenas', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(52, 'Cualquier incorrección de igual gravedad que no constituya falta muy grave', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(54, 'Actos graves de indisciplina, insultos o falta de respeto con los Profesores y personal del centro', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente.', 'grave'),
(55, 'Las injurias y ofensas contra cualquier miembro de la comunidad educativa', 'Amonestación escrita', 'Petición publica de disculpas. Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente', 'muy grave'),
(56, 'El acoso físico o moral a los compañeros', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 1 y 29  dependiendo de la gravedad', 'muy grave'),
(58, 'Amenazas o coacciones contra cualquier miembro de la comunidad educativa', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(61, 'Uso de la violencia, ofensas y actos que atenten contra la intimidad o dignidad de los miembros del Centro', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(63, 'Discriminación a cualquier miembro del centro, por razón de raza, sexo, religión, orientación sexual, etc.', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(65, 'Grabación, publicidad o difusión de agresiones o humillaciones cometidas contra miembros del centro', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(66, 'Daños graves causados en las instalaciones, materiales y documentos del centro, o en las pertenencias de sus miembros', 'Amonestación escrita', 'Jefatura de Estudios tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación o restitución.', 'muy grave'),
(67, 'Suplantación de personalidad en actos de la vida docente y la falsificación o sustracción de documentos académicos', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(68, 'Uso, incitación al mismo o introducción en el centro de sustancias perjudiciales para la salud', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.).  Entrega de trabajo relacionado con el hecho y la salud. Imponer sanción de estancia en el Aula de Convivencia o  expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(70, 'Perturbación grave del desarrollo de las actividades y cualquier incumplimiento grave de las normas de conducta', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad.', 'muy grave'),
(71, 'La reiteración en el mismo trimestre de tres o más faltas graves', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente.', 'muy grave'),
(72, 'El incumplimiento de la sanción impuesta por la Dirección por una falta grave', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 4 y 29 días, según gravedad del hecho.', 'muy grave'),
(73, 'Asistir al centro o a actividades programadas por el Centro en estado de embriaguez o drogado', 'Amonestación escrita', 'Jefatura de Estudios tratará el caso con la familia y el alumno.  Trabajo sobre el hecho y la salud. Derivar el caso a Dep. Orientación o Asuntos Sociales si es grave. Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente', 'muy grave'),
(76, 'Cometer actos delictivos penados por nuestro Sistema Jurídico', 'Amonestación escrita', 'Jefatura tratará el caso con la familia y, si es grave, denunciar en la Policía. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(78, 'Cometer o encubrir hurtos', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Proceder a la devolución de lo hurtado.  Realización por parte del alumno y la familia de  trabajos para la comunidad.', 'muy grave'),
(79, 'Promover el uso de bebidas alcohólicas, sustancias psicotrópicas y material pornográfico', 'Amonestación escrita', 'Jefatura tratará el caso con la familia y, si es grave, denunciar en la Policía. Traslado del caso al Dep. de Orientación o Asuntos Sociales. Trabajo sobre hábitos saludables. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(81, 'Cualquier acto grave dirigido directamente a impedir el normal desarrollo de las actividades', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(82, 'No realizar las tareas encomendadas durante el periodo de expulsión', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE IF NOT EXISTS `maquinas` (
  `id` int(11) NOT NULL auto_increment,
  `lugar` char(3) collate latin1_spanish_ci NOT NULL default '',
  `serie` varchar(15) collate latin1_spanish_ci NOT NULL default '',
  `numero` int(2) default NULL,
  `observaciones` varchar(128) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE IF NOT EXISTS `materias` (
  `CODIGO` varchar(10) collate latin1_spanish_ci default NULL,
  `NOMBRE` varchar(64) collate latin1_spanish_ci default NULL,
  `ABREV` varchar(10) collate latin1_spanish_ci default NULL,
  `CURSO` varchar(128) collate latin1_spanish_ci default NULL,
  `GRUPO` varchar(6) collate latin1_spanish_ci default NULL,
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY (`CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_seneca`
--

DROP TABLE IF EXISTS `materias_seneca`;
CREATE TABLE IF NOT EXISTS `materias_seneca` (
  `idmateria` int(12) unsigned NOT NULL,
  `nommateria` varchar(80) collate latin1_spanish_ci NOT NULL,
  `abrevmateria` varchar(8) collate latin1_spanish_ci default NULL,
  `idcurso` int(12) unsigned NOT NULL,
  PRIMARY KEY  (`idmateria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

DROP TABLE IF EXISTS `matriculas`;
CREATE TABLE IF NOT EXISTS `matriculas` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `apellidos` varchar(36) collate latin1_spanish_ci NOT NULL default '',
  `nombre` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `nacido` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `provincia` varchar(16) collate latin1_spanish_ci NOT NULL default '',
  `nacimiento` date NOT NULL default '0000-00-00',
  `domicilio` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `localidad` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `dni` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `padre` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `dnitutor` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `madre` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `dnitutor2` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `telefono1` int(10) NOT NULL default '0',
  `telefono2` int(10) NOT NULL default '0',
  `colegio` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `otrocolegio` varchar(64) collate latin1_spanish_ci default NULL,
  `letra_grupo` char(1) collate latin1_spanish_ci default NULL,
  `correo` varchar(36) collate latin1_spanish_ci default NULL,
  `idioma` varchar(6) collate latin1_spanish_ci NOT NULL default '',
  `religion` varchar(22) collate latin1_spanish_ci NOT NULL default '',
  `optativa1` tinyint(1) NOT NULL default '0',
  `optativa2` tinyint(1) NOT NULL default '0',
  `optativa3` tinyint(1) NOT NULL default '0',
  `optativa4` tinyint(1) NOT NULL default '0',
  `act1` tinyint(1) default NULL,
  `act2` tinyint(1) default NULL,
  `act3` tinyint(1) default NULL,
  `act4` tinyint(1) default NULL,
  `optativa21` tinyint(1) default NULL,
  `optativa22` tinyint(1) default NULL,
  `optativa23` tinyint(1) default NULL,
  `optativa24` tinyint(1) default NULL,
  `act21` tinyint(1) default NULL,
  `act22` tinyint(1) default NULL,
  `act23` tinyint(1) default NULL,
  `act24` tinyint(1) default NULL,
  `observaciones` text collate latin1_spanish_ci,
  `exencion` tinyint(1) default NULL,
  `bilinguismo` char(2) collate latin1_spanish_ci default NULL,
  `curso` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `promociona` tinyint(1) default NULL,
  `transporte` tinyint(1) default NULL,
  `ruta_este` varchar(42) collate latin1_spanish_ci default NULL,
  `ruta_oeste` varchar(42) collate latin1_spanish_ci default NULL,
  `sexo` varchar(6) collate latin1_spanish_ci NOT NULL default '',
  `hermanos` tinyint(2) default NULL,
  `nacionalidad` varchar(32) collate latin1_spanish_ci NOT NULL default '',
  `itinerario` tinyint(1) default NULL,
  `matematicas4` char(1) collate latin1_spanish_ci default NULL,
  `optativa5` tinyint(1) default NULL,
  `optativa6` tinyint(1) default NULL,
  `optativa7` tinyint(1) default NULL,
  `diversificacion` tinyint(1) default NULL,
  `optativa25` tinyint(1) default NULL,
  `optativa26` tinyint(1) default NULL,
  `optativa27` tinyint(1) default NULL,
  `confirmado` tinyint(1) default NULL,
  `admin` tinyint(1) default NULL,
  `grupo_actual` char(2) collate latin1_spanish_ci default NULL,
  `revisado` tinyint(1) default NULL,
  `enfermedad` varchar(254) collate latin1_spanish_ci NOT NULL,
  `otraenfermedad` varchar(254) collate latin1_spanish_ci NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `divorcio` varchar(64) collate latin1_spanish_ci default NULL,
  `matematicas3` char(1) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas_bach`
--

DROP TABLE IF EXISTS `matriculas_bach`;
CREATE TABLE IF NOT EXISTS `matriculas_bach` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `apellidos` varchar(36) collate latin1_spanish_ci NOT NULL default '',
  `nombre` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `nacido` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `provincia` varchar(16) collate latin1_spanish_ci NOT NULL default '',
  `nacimiento` date NOT NULL default '0000-00-00',
  `domicilio` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `localidad` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `dni` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `padre` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `dnitutor` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `madre` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `dnitutor2` varchar(13) collate latin1_spanish_ci NOT NULL default '',
  `telefono1` int(10) NOT NULL default '0',
  `telefono2` int(10) NOT NULL default '0',
  `colegio` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `otrocolegio` varchar(64) collate latin1_spanish_ci default NULL,
  `letra_grupo` char(1) collate latin1_spanish_ci default NULL,
  `correo` varchar(36) collate latin1_spanish_ci default NULL,
  `idioma1` varchar(7) collate latin1_spanish_ci NOT NULL default '',
  `idioma2` varchar(7) collate latin1_spanish_ci NOT NULL default '',
  `religion` varchar(22) collate latin1_spanish_ci NOT NULL default '',
  `observaciones` text collate latin1_spanish_ci,
  `curso` varchar(5) collate latin1_spanish_ci NOT NULL default '',
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `promociona` tinyint(1) default NULL,
  `transporte` tinyint(1) default NULL,
  `ruta_este` varchar(42) collate latin1_spanish_ci default NULL,
  `ruta_oeste` varchar(42) collate latin1_spanish_ci default NULL,
  `sexo` varchar(6) collate latin1_spanish_ci NOT NULL default '',
  `hermanos` tinyint(2) default NULL,
  `nacionalidad` varchar(32) collate latin1_spanish_ci NOT NULL default '',
  `confirmado` tinyint(1) default NULL,
  `admin` tinyint(1) default NULL,
  `grupo_actual` char(2) collate latin1_spanish_ci default NULL,
  `revisado` tinyint(1) default NULL,
  `itinerario1` tinyint(1) default NULL,
  `itinerario2` tinyint(1) default NULL,
  `optativa1` varchar(64) collate latin1_spanish_ci default NULL,
  `optativa2` varchar(64) collate latin1_spanish_ci default NULL,
  `optativa2b1` tinyint(1) default NULL,
  `optativa2b2` tinyint(1) default NULL,
  `optativa2b3` tinyint(1) default NULL,
  `optativa2b4` tinyint(1) default NULL,
  `optativa2b5` tinyint(1) default NULL,
  `optativa2b6` tinyint(1) default NULL,
  `optativa2b7` tinyint(1) default NULL,
  `optativa2b8` tinyint(1) default NULL,
  `optativa2b9` tinyint(1) default NULL,
  `optativa2b10` tinyint(1) default NULL,
  `repite` tinyint(1) NOT NULL default '0',
  `enfermedad` varchar(254) collate latin1_spanish_ci NOT NULL,
  `otraenfermedad` varchar(254) collate latin1_spanish_ci NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `divorcio` varchar(64) collate latin1_spanish_ci default NULL,
  `bilinguismo` char(2) collate latin1_spanish_ci default NULL,
  `religion1b` varchar(64) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mem_dep`
--

DROP TABLE IF EXISTS `mem_dep`;
CREATE TABLE IF NOT EXISTS `mem_dep` (
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci NOT NULL default '',
  `jefe` varchar(150) collate latin1_spanish_ci NOT NULL,
  `p1` longtext collate latin1_spanish_ci NOT NULL,
  `p2` longtext collate latin1_spanish_ci NOT NULL,
  `p3` longtext collate latin1_spanish_ci NOT NULL,
  `p4` longtext collate latin1_spanish_ci NOT NULL,
  `p5` longtext collate latin1_spanish_ci NOT NULL,
  `p6` longtext collate latin1_spanish_ci NOT NULL,
  `p7` longtext collate latin1_spanish_ci NOT NULL,
  `p8` longtext collate latin1_spanish_ci NOT NULL,
  `p9` longtext collate latin1_spanish_ci NOT NULL,
  `p10` longtext collate latin1_spanish_ci NOT NULL,
  `p11` longtext collate latin1_spanish_ci NOT NULL,
  `p12` longtext collate latin1_spanish_ci NOT NULL,
  `p13` longtext collate latin1_spanish_ci NOT NULL,
  `p14` longtext collate latin1_spanish_ci NOT NULL,
  `p15` longtext collate latin1_spanish_ci NOT NULL,
  `p16` longtext collate latin1_spanish_ci NOT NULL,
  `p17` longtext collate latin1_spanish_ci NOT NULL,
  `p18` longtext collate latin1_spanish_ci NOT NULL,
  `p19` longtext collate latin1_spanish_ci NOT NULL,
  `p20` longtext collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`DEPARTAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

DROP TABLE IF EXISTS `mensajeria`;
CREATE TABLE IF NOT EXISTS `mensajeria` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `idhilo` int(10) unsigned default NULL,
  `asunto` varchar(125) collate latin1_spanish_ci NOT NULL,
  `contenido` text collate latin1_spanish_ci NOT NULL,
  `usuarioorig` varchar(60) collate latin1_spanish_ci NOT NULL,
  `usuariodest` varchar(60) collate latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `esleido` tinyint(1) NOT NULL,
  `esborradoorigen` tinyint(1) NOT NULL default '0',
  `esborradodestino` tinyint(1) NOT NULL default '0',
  `adjunto` text collate latin1_spanish_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ahora` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dni` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  `claveal` int(12) NOT NULL default '0',
  `asunto` text collate latin1_spanish_ci NOT NULL,
  `texto` text collate latin1_spanish_ci NOT NULL,
  `ip` varchar(15) collate latin1_spanish_ci NOT NULL default '',
  `recibidotutor` tinyint(1) NOT NULL default '0',
  `recibidopadre` tinyint(1) NOT NULL default '0',
  `correo` varchar(72) collate latin1_spanish_ci default NULL,
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `archivo` varchar(255) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mens_profes`
--

DROP TABLE IF EXISTS `mens_profes`;
CREATE TABLE IF NOT EXISTS `mens_profes` (
  `id_profe` int(10) unsigned NOT NULL auto_increment,
  `id_texto` int(11) NOT NULL,
  `profesor` varchar(64) collate latin1_spanish_ci NOT NULL,
  `recibidoprofe` tinyint(1) NOT NULL default '0',
  `recibidojefe` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_profe`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mens_texto`
--

DROP TABLE IF EXISTS `mens_texto`;
CREATE TABLE IF NOT EXISTS `mens_texto` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ahora` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `origen` varchar(64) collate latin1_spanish_ci NOT NULL,
  `asunto` varchar(255) collate latin1_spanish_ci NOT NULL,
  `texto` longtext collate latin1_spanish_ci NOT NULL,
  `destino` text collate latin1_spanish_ci NOT NULL,
  `oculto` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `profesor` (`origen`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `morosos`
--

DROP TABLE IF EXISTS `morosos`;
CREATE TABLE IF NOT EXISTS `morosos` (
  `id` varchar(10) collate latin1_spanish_ci NOT NULL,
  `curso` varchar(50) collate latin1_spanish_ci NOT NULL,
  `apellidos` varchar(60) collate latin1_spanish_ci NOT NULL,
  `nombre` varchar(25) collate latin1_spanish_ci NOT NULL,
  `ejemplar` varchar(100) collate latin1_spanish_ci NOT NULL,
  `devolucion` varchar(10) collate latin1_spanish_ci NOT NULL,
  `hoy` date NOT NULL,
  `amonestacion` varchar(2) collate latin1_spanish_ci NOT NULL default 'NO',
  `sms` varchar(2) collate latin1_spanish_ci NOT NULL default 'NO',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

DROP TABLE IF EXISTS `notas`;
CREATE TABLE IF NOT EXISTS `notas` (
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default '0',
  `notas1` varchar(200) collate latin1_spanish_ci default NULL,
  `notas2` varchar(200) collate latin1_spanish_ci default NULL,
  `notas3` varchar(200) collate latin1_spanish_ci default NULL,
  `notas4` varchar(200) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_cuaderno`
--

DROP TABLE IF EXISTS `notas_cuaderno`;
CREATE TABLE IF NOT EXISTS `notas_cuaderno` (
  `id` int(11) NOT NULL auto_increment,
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `fecha` date NOT NULL default '0000-00-00',
  `nombre` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `texto` text collate latin1_spanish_ci NOT NULL,
  `texto_pond` text collate latin1_spanish_ci NOT NULL,
  `asignatura` int(6) NOT NULL default '0',
  `curso` varchar(36) collate latin1_spanish_ci NOT NULL default '',
  `oculto` tinyint(1) NOT NULL default '0',
  `visible_nota` int(1) unsigned NOT NULL default '0',
  `orden` tinyint(2) NOT NULL default '0',
  `Tipo` varchar(32) collate latin1_spanish_ci default NULL,
  `color` varchar(7) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL auto_increment,
  `slug` text collate latin1_spanish_ci NOT NULL,
  `content` longtext collate latin1_spanish_ci NOT NULL,
  `contact` varchar(255) collate latin1_spanish_ci default NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `clase` varchar(48) collate latin1_spanish_ci default NULL,
  `fechafin` date default NULL,
  `pagina` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nuevas`
--

DROP TABLE IF EXISTS `nuevas`;
CREATE TABLE IF NOT EXISTS `nuevas` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `abrev` varchar(5) collate latin1_spanish_ci NOT NULL,
  `nombre` varchar(128) collate latin1_spanish_ci NOT NULL,
  `texto` varchar(128) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocultas`
--

DROP TABLE IF EXISTS `ocultas`;
CREATE TABLE IF NOT EXISTS `ocultas` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `aula` varchar(48) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partestic`
--

DROP TABLE IF EXISTS `partestic`;
CREATE TABLE IF NOT EXISTS `partestic` (
  `parte` smallint(5) unsigned NOT NULL auto_increment,
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `carro` char(2) collate latin1_spanish_ci default NULL,
  `nserie` varchar(15) collate latin1_spanish_ci NOT NULL default '',
  `fecha` date NOT NULL default '0000-00-00',
  `hora` char(2) collate latin1_spanish_ci default '',
  `alumno` varchar(35) collate latin1_spanish_ci default NULL,
  `profesor` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `descripcion` text collate latin1_spanish_ci NOT NULL,
  `estado` varchar(12) collate latin1_spanish_ci NOT NULL default 'activo',
  `nincidencia` varchar(10) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`parte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pendientes`
--

DROP TABLE IF EXISTS `pendientes`;
CREATE TABLE IF NOT EXISTS `pendientes` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(9) collate latin1_spanish_ci NOT NULL default '',
  `codigo` varchar(8) collate latin1_spanish_ci NOT NULL default '',
  `grupo` varchar(32) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `claveal` (`claveal`),
  KEY `codigo` (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE IF NOT EXISTS `profesores` (
  `nivel` varchar(255) collate latin1_spanish_ci default NULL,
  `materia` varchar(255) collate latin1_spanish_ci default NULL,
  `grupo` varchar(255) collate latin1_spanish_ci default NULL,
  `profesor` varchar(255) collate latin1_spanish_ci default NULL,
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_seg`
--

DROP TABLE IF EXISTS `profesores_seg`;
CREATE TABLE IF NOT EXISTS `profesores_seg` (
  `nivel` varchar(255) collate latin1_spanish_ci default NULL,
  `materia` varchar(255) collate latin1_spanish_ci default NULL,
  `grupo` varchar(255) collate latin1_spanish_ci default NULL,
  `profesor` varchar(255) collate latin1_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_seneca`
--

DROP TABLE IF EXISTS `profesores_seneca`;
CREATE TABLE IF NOT EXISTS `profesores_seneca` (
  `idprofesor` int(9) unsigned NOT NULL,
  `nomprofesor` varchar(64) collate latin1_spanish_ci NOT NULL,
  `deptoprofesor` varchar(80) collate latin1_spanish_ci NOT NULL,
  `correoprofesor` varchar(80) collate latin1_spanish_ci default NULL,
  `telefonoprofesor` char(9) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`idprofesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos_alumnos`
--

DROP TABLE IF EXISTS `puestos_alumnos`;
CREATE TABLE IF NOT EXISTS `puestos_alumnos` (
  `unidad` varchar(10) collate latin1_spanish_ci NOT NULL,
  `puestos` text collate latin1_spanish_ci,
  PRIMARY KEY  (`unidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_intranet`
--

DROP TABLE IF EXISTS `reg_intranet`;
CREATE TABLE IF NOT EXISTS `reg_intranet` (
  `id` int(11) NOT NULL auto_increment,
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` varchar(15) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_paginas`
--

DROP TABLE IF EXISTS `reg_paginas`;
CREATE TABLE IF NOT EXISTS `reg_paginas` (
  `id` int(11) NOT NULL auto_increment,
  `id_reg` int(11) NOT NULL default '0',
  `pagina` text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_reg` (`id_reg`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_principal`
--

DROP TABLE IF EXISTS `reg_principal`;
CREATE TABLE IF NOT EXISTS `reg_principal` (
  `id` int(11) NOT NULL auto_increment,
  `pagina` text collate latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` varchar(15) collate latin1_spanish_ci NOT NULL default '',
  `claveal` varchar(10) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `eventdate` date default NULL,
  `dia` tinyint(1) NOT NULL default '0',
  `html` tinyint(1) NOT NULL default '0',
  `event1` varchar(64) collate latin1_spanish_ci default NULL,
  `event2` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `event3` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `event4` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `event5` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `event6` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `event7` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `servicio` varchar(32) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_elementos`
--

DROP TABLE IF EXISTS `reservas_elementos`;
CREATE TABLE IF NOT EXISTS `reservas_elementos` (
  `id` int(11) NOT NULL auto_increment,
  `elemento` varchar(128) collate latin1_spanish_ci NOT NULL,
  `id_tipo` tinyint(2) NOT NULL,
  `oculto` tinyint(1) NOT NULL default '0',
  `observaciones` varchar(255) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_hor`
--

DROP TABLE IF EXISTS `reservas_hor`;
CREATE TABLE IF NOT EXISTS `reservas_hor` (
  `dia` tinyint(1) NOT NULL default '0',
  `hora1` varchar(24) collate latin1_spanish_ci default NULL,
  `hora2` varchar(24) collate latin1_spanish_ci default NULL,
  `hora3` varchar(24) collate latin1_spanish_ci default NULL,
  `hora4` varchar(24) collate latin1_spanish_ci default NULL,
  `hora5` varchar(24) collate latin1_spanish_ci default NULL,
  `hora6` varchar(24) collate latin1_spanish_ci default NULL,
  `hora7` varchar(24) collate latin1_spanish_ci default NULL,
  `servicio` varchar(32) collate latin1_spanish_ci NOT NULL,
  KEY `dia` (`dia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_tipos`
--

DROP TABLE IF EXISTS `reservas_tipos`;
CREATE TABLE IF NOT EXISTS `reservas_tipos` (
  `id` int(11) NOT NULL auto_increment,
  `tipo` varchar(254) collate latin1_spanish_ci NOT NULL,
  `observaciones` varchar(255) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `reservas_tipos`
--

INSERT INTO `reservas_tipos` (`id`, `tipo`, `observaciones`) VALUES
(1, 'TIC', ''),
(2, 'Medios Audiovisuales', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `r_departamento`
--

DROP TABLE IF EXISTS `r_departamento`;
CREATE TABLE IF NOT EXISTS `r_departamento` (
  `id` int(11) NOT NULL auto_increment,
  `contenido` longtext collate latin1_spanish_ci NOT NULL,
  `jefedep` varchar(255) collate latin1_spanish_ci default NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci default NULL,
  `fecha` date NOT NULL,
  `impreso` tinyint(1) NOT NULL,
  `numero` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms`
--

DROP TABLE IF EXISTS `sms`;
CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `telefono` text collate latin1_spanish_ci NOT NULL,
  `mensaje` varchar(160) collate latin1_spanish_ci NOT NULL default '',
  `profesor` varchar(48) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_alumnos`
--

DROP TABLE IF EXISTS `tareas_alumnos`;
CREATE TABLE IF NOT EXISTS `tareas_alumnos` (
  `ID` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `CLAVEAL` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `APELLIDOS` varchar(30) collate latin1_spanish_ci NOT NULL default '',
  `NOMBRE` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `FECHA` date NOT NULL default '0000-00-00',
  `FIN` date NOT NULL default '0000-00-00',
  `DURACION` smallint(2) NOT NULL default '3',
  `PROFESOR` varchar(40) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `APELLIDOS` (`APELLIDOS`),
  KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_profesor`
--

DROP TABLE IF EXISTS `tareas_profesor`;
CREATE TABLE IF NOT EXISTS `tareas_profesor` (
  `id` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL default '0',
  `profesor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `asignatura` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `tarea` text collate latin1_spanish_ci NOT NULL,
  `confirmado` char(2) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_alumno` (`id_alumno`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

DROP TABLE IF EXISTS `temas`;
CREATE TABLE IF NOT EXISTS `temas` (
  `idea` varchar(12) collate latin1_spanish_ci NOT NULL,
  `tema` varchar(64) collate latin1_spanish_ci NOT NULL,
  `fondo` varchar(16) collate latin1_spanish_ci NOT NULL,
  UNIQUE KEY `idea` (`idea`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Textos`
--

DROP TABLE IF EXISTS `Textos`;
CREATE TABLE IF NOT EXISTS `Textos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `Autor` varchar(128) collate latin1_spanish_ci default NULL,
  `Titulo` varchar(128) collate latin1_spanish_ci NOT NULL default '',
  `Editorial` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `Nivel` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `Grupo` text collate latin1_spanish_ci NOT NULL,
  `Notas` text collate latin1_spanish_ci,
  `DEPARTAMENTO` varchar(80) collate latin1_spanish_ci default NULL,
  `Asignatura` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `Obligatorio` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `Clase` varchar(8) collate latin1_spanish_ci NOT NULL default 'Texto',
  `isbn` varchar(18) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `textos_alumnos`
--

DROP TABLE IF EXISTS `textos_alumnos`;
CREATE TABLE IF NOT EXISTS `textos_alumnos` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` int(12) NOT NULL default '0',
  `materia` int(5) NOT NULL default '0',
  `estado` char(1) collate latin1_spanish_ci NOT NULL default '',
  `devuelto` char(1) collate latin1_spanish_ci default '0',
  `fecha` datetime default '0000-00-00 00:00:00',
  `curso` varchar(7) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `textos_gratis`
--

DROP TABLE IF EXISTS `textos_gratis`;
CREATE TABLE IF NOT EXISTS `textos_gratis` (
  `id` int(11) NOT NULL auto_increment,
  `materia` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `isbn` int(10) NOT NULL default '0',
  `ean` int(14) NOT NULL default '0',
  `editorial` varchar(32) collate latin1_spanish_ci NOT NULL default '',
  `titulo` varchar(96) collate latin1_spanish_ci NOT NULL default '',
  `ano` year(4) NOT NULL default '0000',
  `caducado` char(2) collate latin1_spanish_ci NOT NULL default '',
  `importe` int(11) NOT NULL default '0',
  `utilizado` char(2) collate latin1_spanish_ci NOT NULL default '',
  `nivel` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramos`
--

DROP TABLE IF EXISTS `tramos`;
CREATE TABLE IF NOT EXISTS `tramos` (
  `tramo` int(6) unsigned NOT NULL,
  `hora` varchar(80) collate latin1_spanish_ci NOT NULL,
  `horini` int(4) unsigned NOT NULL,
  `horfin` int(4) unsigned NOT NULL,
  `hora_inicio` varchar(5) collate latin1_spanish_ci NOT NULL,
  `hora_fin` varchar(5) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`tramo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transito_control`
--

DROP TABLE IF EXISTS `transito_control`;
CREATE TABLE IF NOT EXISTS `transito_control` (
  `id` int(11) NOT NULL auto_increment,
  `colegio` varchar(128) collate latin1_spanish_ci NOT NULL,
  `pass` varchar(254) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transito_datos`
--

DROP TABLE IF EXISTS `transito_datos`;
CREATE TABLE IF NOT EXISTS `transito_datos` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(12) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tipo` varchar(24) character set latin1 collate latin1_spanish_ci NOT NULL,
  `dato` text character set latin1 collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transito_tipo`
--

DROP TABLE IF EXISTS `transito_tipo`;
CREATE TABLE IF NOT EXISTS `transito_tipo` (
  `id` int(11) NOT NULL auto_increment,
  `tipo` varchar(24) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoria`
--

DROP TABLE IF EXISTS `tutoria`;
CREATE TABLE IF NOT EXISTS `tutoria` (
  `id` int(11) NOT NULL auto_increment,
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  `apellidos` varchar(42) collate latin1_spanish_ci NOT NULL default '',
  `nombre` varchar(24) collate latin1_spanish_ci NOT NULL default '',
  `tutor` varchar(48) collate latin1_spanish_ci NOT NULL default '',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL,
  `observaciones` text collate latin1_spanish_ci NOT NULL,
  `causa` varchar(42) collate latin1_spanish_ci NOT NULL default '',
  `accion` varchar(200) collate latin1_spanish_ci NOT NULL default '',
  `fecha` date NOT NULL default '0000-00-00',
  `orienta` tinyint(1) NOT NULL default '0',
  `prohibido` tinyint(1) NOT NULL default '0',
  `jefatura` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `claveal` (`claveal`),
  KEY `tutor` (`tutor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `idunidad` int(12) unsigned NOT NULL,
  `nomunidad` varchar(10) collate latin1_spanish_ci NOT NULL,
  `idcurso` int(12) unsigned NOT NULL,
  PRIMARY KEY  (`idunidad`,`idcurso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `username` varchar(25) collate latin1_spanish_ci NOT NULL default '',
  `password` varchar(50) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioalumno`
--

DROP TABLE IF EXISTS `usuarioalumno`;
CREATE TABLE IF NOT EXISTS `usuarioalumno` (
  `usuario` varchar(18) collate latin1_spanish_ci default NULL,
  `pass` varchar(16) collate latin1_spanish_ci NOT NULL default '',
  `nombre` varchar(48) collate latin1_spanish_ci default NULL,
  `perfil` char(1) collate latin1_spanish_ci NOT NULL default '',
  `unidad` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY (`usuario`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioprofesor`
--

DROP TABLE IF EXISTS `usuarioprofesor`;
CREATE TABLE IF NOT EXISTS `usuarioprofesor` (
  `usuario` varchar(16) default NULL,
  `nombre` varchar(64) default NULL,
  `perfil` varchar(10) default NULL,
  PRIMARY KEY (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
