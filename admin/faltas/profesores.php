<?php
require('../../bootstrap.php');

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("../../faltas/menu.php");

?>
<div class="container">

<div class="page-header">
  <h2>Faltas de Asistencia <small> Profesores que registran faltas de asistencia</small></h2>
</div>
<br />

<div class="row">
<div class="col-sm-10 col-sm-offset-1">

  <table class='table table-bordered table-striped table-vcentered datatable'>
  <thead><tr>
      <th>Profesor</th>
      <th>Total Faltas</th>
      <th>Grupos</th>
      <th>Alumnos</th>
      <th>Media Grupo</th>          
  </tr></thead><tbody>
<?php 
$profe = mysqli_query($db_con, "SELECT profesor, count(*) as numero FROM FALTAS where profesor not like '' group by profesor order by numero desc");
  while($fprofe = mysqli_fetch_array($profe))
        {
          $alumnos_profesor = "";
          $alumnos_totales="";
          $unidades="";
          $no_profe = $fprofe[0];
          $numero_faltas = $fprofe[1];
          $nombre = mysqli_query($db_con, "SELECT prof FROM horw where no_prof = '$no_profe'");
          $nombre_profe = mysqli_fetch_array($nombre);
          $nombre_profesor = $nombre_profe[0];

          $grupos = mysqli_query($db_con, "SELECT distinct a_grupo, c_asig FROM horw where no_prof = '$no_profe' and a_grupo in (select distinct grupo from profesores where profesor = '$nombre_profesor')");
          $n_grupos = mysqli_num_rows($grupos);
          while ($asig_al = mysqli_fetch_array($grupos)) {

            $asig = mysqli_query($db_con,"select distinct nombre from asignaturas where codigo = '$asig_al[1]' and abrev not like '%\_%'");
            $asignatu = mysqli_fetch_array($asig);
            if (!empty($asignatu[0])) {
              $unidades.=$asig_al[0]." (".$asignatu[0]."); <br>";
            }

            $num_al = mysqli_query($db_con,"select * from alma where unidad = '$asig_al[0]' and combasi like '%$asig_al[1]:%'");
            $alumno_total = mysqli_num_rows($num_al);

            $num_prof = mysqli_query($db_con,"select distinct prof from horw where a_grupo = '$asig_al[0]' and c_asig = '$asig_al[1]'");
            $profesores_asig = mysqli_num_rows($num_prof);

            $alumnos_profesor+=$alumno_total/$profesores_asig;
          }

          $alumnos_profesor = round($alumnos_profesor);
          
          $profe_grupos = round($numero_faltas/$n_grupos);

          echo "<tr><td>$no_profe. $nombre_profesor </td> <td>$numero_faltas</td> <td data-bs='tooltip' data-html='true' title='$unidades'>$n_grupos</td> <td>$alumnos_profesor</td> <td>$profe_grupos</td></tr>";
        }
	?>
</tbody>
<table>
</div>
</div>
</div>
<?php	
include("../../pie.php");
?>  
  <script>
  $(document).ready(function() {
    var table = $('.datatable').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        
        "lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
        
        "order": [[ 1, "asc" ]],
        
        "language": {
                    "lengthMenu": "_MENU_",
                    "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay resultados disponibles.",
                    "infoFiltered": "(filtrado de _MAX_ resultados)",
                    "search": "Buscar: ",
                    "paginate": {
                          "first": "Primera",
                          "next": "Última",
                          "next": "",
                          "previous": ""
                        }
                }
      });
  });
  </script> 
</body>
</html>
