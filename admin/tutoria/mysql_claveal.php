<?php
require('../../bootstrap.php');

  $al0 = mysqli_query($db_con, "select distinct id, FALUMNOS.claveal, tutoria.claveal from tutoria, FALUMNOS where tutoria.apellidos=FALUMNOS.apellidos and tutoria.nombre=FALUMNOS.nombre and tutoria.unidad=FALUMNOS.unidad order by id");
  while($al1 = mysqli_fetch_array($al0))
  {
 $claveal = $al1[1];
 $clave_tut = $al1[2];
 $id = $al1[0];
 if (empty($clave_tut)) {
 	mysqli_query($db_con, "update tutoria set claveal='$claveal' where id='$id'");
echo "OK<br />";
 }

}
?>
