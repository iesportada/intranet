# [Intranet del IES Portada Alta](http://iesportada.org/intranet/)

Lo que aquí llamamos la Intranet del IES Portada Alta es una aplicación web creada y probada a lo largo de los años por el IES Monterroso de Estepona y adaptada a la forma de trabajar del claustro. Nació dentro del Programa de Autoevaluación y Mejora de la Consejería de Educación de la Junta de Andalucía, y ha sido pensada para facilitar y simplificar el trabajo diario de los profesores en general.

En realidad se trata de un conjunto de módulos interconectados que responden a tareas específicas que debe realizar un profesor en su trabajo diario. Los módulos han ido ido surgiendo de necesidades concretas planteadas por los propios profesores a lo largo de los años. Precisamente por eso, debe quedar claro que la aplicación solo expresa un punto de vista, el nuestro, acerca de cómo se lleva un Instituto (Problemas e convivencia, comunicación entre los profesores, trabajo de los tutores, reservas de aulas y material, actividades extraescolares, etc.).

La Intranet se ha ajustado a las exigencias y necesidades del IES Portada Alta, pero a lo largo de los años hemos podido comprobar que tanto las tareas como los procedimientos para resolverlas son en general comunes a la mayoría de los IES de la Comunidad, razón por la que hemos decidido ofrecer esta aplicación.


## Requisitos

* Servidor Web: [Apache (versión 2 o superior)](http://httpd.apache.org/) 
* Versión de PHP: [PHP 5.3 o superior](http://www.php.net/)
* Base de datos: [MySQL 5 o superior](http://www.php.net/)

## Módulos y funciones

La Intranet funciona a partir de un conjunto de datos que son importados desde Séneca: profesores, alumnos, asignaturas, etc. La compatibilidad con Séneca es tan alta como lo permite la propia aplicación de la Junta de Andalucía, que, no debe olvidarse, es una aplicación propietaria y cerrada. 
Dispone de un sencillo proceso de instalación que permite ajustar los datos esenciales a un Centro determinado, y un sistema de importación de datos a partir de Séneca que en pocos minutos la pone a funcionar. Los módulos más importantes que contiene son los siguientes:

* un conjunto de páginas de consulta que presentan datos de los alumnos, listas de grupos y horarios tanto de grupos como de profesores y aulas.
* un módulo para registrar los problemas de convivencia, las expulsiones del Centro, etc. (Asociado al módulo de envío de SMS)
* otro módulo para poner y justificar las faltas de asistencia de los alumnos, que posteriormente pueden ser exportadas a Séneca, y que nos ahorra el penoso trabajo de realizar la misma tarea con esa aplicación (Asociado al módulo de envío de SMS).
* un módulo para generar informes para el Tutor que recibe la visita de los padres de un alumno, y pide a los miembros de su equipo educativo que le digan cómo va el alumno en su asignatura.
* otro módulo para rellenar tareas para un alumno que va a ser expulsado del Centro durante un tiempo, activado por un Tutor o el Jefe de Estudios.
* un conjunto de páginas destinadas al Tutor de un grupo, donde este puede ver todos los datos relevantes de los alumnos de su tutoría (faltas de asistencia, problemas de convivencia, tareas por expulsión, visitas de padres, actividades extraescolares de su grupo, etc.), así como registrar las distintas intervenciones que realiza en su tarea de tutor. Todo ello se presenta en un informe de Tutoría que solo tendrá que imprimir a final de curso y presentar a la Dirección.
* un módulo de mensajería interna entre los usuarios de la Intranet que permite enviar y recibir mensajes.
* un sistema de envío de mensajes SMS, que se activará automáticamente en caso de problemas de convivencia graves, faltas de asistencia continuadas, o que se podrá utilizar para poner en contacto rápido al tutor o la Dirección con los padres de un alumno.
* un módulo para registrar y gestionar las Actividades Extraescolares.
* dos módulos para los libros de texto. El primero permite crear la lista de los libros de texto por Departamento para los distintos niveles del centro (para consulta de padres y librerías, por ejemplo). El segundo es un módulo completo para la gestión de los libros de textos gratuitos por parte de los Tutores y la Secretaría del Centro dentro del Programa de Gratuidad de Libros de Texto de la Consejería de Educación.
* un conjunto de páginas destinadas a generar Memorias para Jefatura de estudios y Tutores a final de Curso.
* módulos para tareas como las guardias, registro de bajas de los profesores, inventario de material de los Departamentos, búsqueda y generación de informes con todos los datos de un alumno, subida de fotos para profesores y alumnos, etc.

La aplicación ha sido pensada también para realizar tareas específicas de un Centro TIC. Los siguientes módulos están orientados a las tareas propias de un Centro TIC:

* un sistema de reservas para para las aulas, los carros de portátiles y medios audiovisuales.
* un módulo para la gestión y registro de incidencias y problemas con los ordenadores.
* un módulo para la creación de los usuarios TIC, tanto alumnos como profesores, preparado para el alta masiva en Gesuser y en la Plataforma educativa (en nuestro caso, Moodle).
* una página que concentra los documentos esenciales de un Centro TIC.
* una página de estadísticas de uso de los recursos TIC por profesor, carrito, etc.

## Notas de la instalación

* El primer requisito para la instalación es tener dónde hacerlo. Hay dos posibilidades. La primera es instalar la aplicación en un servidor dentro del mismo Centro; la segunda es alojarla en un servidor externo contratado con alguna de las empresas que ofrecen servicios de alojamiento web. Si optamos por la primera opción, el Centro debe disponer de una máquina (el Servidor) y una línea propia de ADSL (preferiblemente con una dirección IP estática, aunque no es necesario). Debe también disponer de un Dominio (iesmonterroso.org), y este dominio debe apuntar a la IP de vuestro ADSL. Además, debéis redirigir todos los Puertos del Router ADSL hacia la dirección IP del Servidor. Ideas básicas sobre instalación de un Servidor Linux preparado para estas tareas la podéis encontrar en nuestra página principal, concretamente aquí.
* El segundo requisito, opcional pero recomendable, es tener un Horario que pueda ser exportado a la Base de datos de la aplicación. La Intranet está preparada para trabajar con Horw, pero la mayoría de las aplicaciones que generan horarios pueden importar datos desde Séneca, por lo que debería ser posible trabajar con las mismas. 
Si hemos optado por incorporar el horario de Horw, es esencial que se den dos condiciones por razones de compatibilidad con Séneca:
*La primera es que los nombres de los profesores y el nombre de los grupos sean los mismos en Séneca que en Horw, exactamente los mismos. 
*La segunda es que se importen los códigos de las asignaturas de Séneca dentro de Horw (una opción que nos permite el programa), y que naturalmente utilicemos un código de asignatura de Séneca para cada asignatura del horario.

Por otro lado, se puede usar la Intranet sin horario, aunque las funciones quedan reducidas.

* Descargamos el archivo comprimido desde el enlace de Descargas, lo descomprimimos y colocamos los archivos en el directorio de nuestro servidor local o remoto. La aplicación necesita escribir y modificar archivos, por ejemplo a la hora de importar los datos de Séneca o cambiar el archivo de configuración. Por esa razón, el directorio donde se colocan los archivos de la Intranet debe tener permiso de escritura ( en un sistema con Linux instalado, podemos hacerlo fácilmente con el comando chmod 777 -R /ruta_de_la_aplicacion/intranet/* ).
* Vamos a la dirección de la Intranet, por ejemplo [http://iesportada.org/intranet/](http://iesportada.org/intranet/). La primera vez que se ejecuta la aplicación se presenta la página de instalación. Si todo ha ido bien, podéis empezar la importación de datos de Alumnos y Profesores de Séneca desde la página de Administración de la Intranet. En la propia página de Administración de la Intranet tenéis información sobre los archivos que debéis descargar de Séneca, así como el lugar de Séneca desde el que podéis bajaros cada uno de ellos.
* Una vez importados los datos de alumnos, profesores , departamentos y, llegado el caso, el horario del Centro debéis ir a la página de Perfiles de los Profesores desde la misma página de Administración de la Intranet. Seleccionar el perfil o perfiles de cada profesor (puede tener varios, no hay problema). Marcar también los Tutores y elegir su grupo.
* Recordad que todos los miembros del Equipo Directivo tienen el perfil de Administradores de la Aplicación. A partir de este momento, la Intranet está operativa y los profesores ya pueden entrar con su usuario IdEA (el usuario de Séneca) y el DNI. La primera vez que entran se les obliga a cambiar la contraseña, y es aconsejable que elijan como nueva contraseña la que usan para entrar en Séneca.


## Autores

Esta aplicación existe y es mantenida por:

* [Miguel Ángel García González](https://github.com/mgarcia39) 
* [Rubén López Herrera](https://github.com/rubenlh91) 

A quienes estamos inmensamente agradecidos por el gran trabajo desarrollado.
