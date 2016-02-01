<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 7, 8));

include("../../menu.php");
include("menu.php");
?>

<div class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Matriculación de alumnos <small> Previsiones de Matrícula</small></h2>
</div>


<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-12"><?php 
$crea_tabla = "CREATE TABLE IF NOT EXISTS `suspensos` (
  `claveal` varchar(12) NOT NULL,
  `suspensos` tinyint(4) NOT NULL,
  `pil` tinyint(4) NOT NULL,
  `grupo` varchar( 6 ) NOT NULL,
  `nivel` varchar( 64 ) NOT NULL,
  KEY `claveal` (`claveal`)
)";
mysqli_query($db_con, $crea_tabla);
// Comprobamos datos de evaluaciones
$n3 = mysqli_query($db_con, "select * from notas where notas3 not like ''");
$n2 = mysqli_query($db_con, "select * from notas where notas2 not like ''");
$n1 = mysqli_query($db_con, "select * from notas where notas1 not like ''");
if(mysqli_num_rows($n3)>0){$n_eval = "notas3";}
elseif(mysqli_num_rows($n2)>0){$n_eval = "notas2";}
elseif(mysqli_num_rows($n1)>0){$n_eval = "notas1";}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÃ“N:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administración de la Intranet --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
	exit();
}
?>
<table align="center" style="width: auto" cellpadding=6>
	<tr>

	<?php
	// Evaluaciones ESO
	$niv = mysqli_query($db_con, "select nomcurso from cursos where nomcurso like '%E.S.O.%' or nomcurso like '%Bach%'");
	while ($ni = mysqli_fetch_array($niv)) {
		$n_grupo+=1;
		$curso = $ni[0];
		$rep = "";
		$promo = "";
		$notas1 = "select ". $n_eval .", claveal1, matriculas, unidad from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
		// echo $notas1."<br>";
		echo "<td style='text-align:center;' valign='top'>";

		$result1 = mysqli_query($db_con, $notas1);
		$todos = mysqli_num_rows($result1);
		if ($todos < '1') {
			echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓ“N:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administracción --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
		}
		while($row1 = mysqli_fetch_array($result1)){
			$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
			$claveal = $row1[1];
			$grupo = $row1[3];
			if ($row1[2]>"1") {
				$pil = "1";
			}
			else{
				$pil = '0';
			}
			$trozos1 = explode(";", $asignatura1);
			$num = count($trozos1);
			$susp="";
			for ($i=0;$i<$num; $i++)
			{
				$bloque = explode(":", $trozos1[$i]);




				$nombreasig = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";
				$asig = mysqli_query($db_con, $nombreasig);
				$cali = mysqli_fetch_row($asig);

				// Borramos de la tabla la Libre Disposición de ESO

				$lbd = mysqli_query($db_con,"select nombre from asignaturas where codigo = '$bloque[0]'");
				$libre_disp = mysqli_fetch_array($lbd);
				// strstr($libre_disp[0],"Libre Dispos")==FALSE and
				if (strstr($libre_disp[0],"Libre Dispos")==FALSE and strstr($libre_disp[0],"Relig")==FALSE and strstr($libre_disp[0],"Atenci")==FALSE) {
					if (strstr($libre_disp[0],"Ciencias de la Nat")==TRUE and strstr($curso,"3")==TRUE and (strstr($n_eval,"1")==TRUE or strstr($n_eval,"2")==TRUE)) {}
					elseif ((strstr($libre_disp[0],"Biolog")==TRUE or strstr($libre_disp[0],"sica y Qu")==TRUE) and strstr($curso,"3")==TRUE and strstr($n_eval,"3")==TRUE){}
					elseif ((strstr($libre_disp[0],"Biolog")==TRUE or strstr($libre_disp[0],"sica y Qu")==TRUE) and (strstr($n_eval,"1")==TRUE or strstr($n_eval,"2")==TRUE)){
						if($cali[0] < '5')	{
							$susp+=0.5;
						}
					}
					else{
						if($cali[0] < '5')	{
							$susp+=1;
						}
					}
				}
			}
			mysqli_query($db_con, "insert into suspensos  (
`claveal` ,
`suspensos` ,
`pil` ,
`grupo`,
`nivel`
)
VALUES (
'$claveal',  '$susp',  '$pil', '$grupo', '$curso'
)");
		}

		// Calculamos
		$mas_cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos > '4'");
		$mas_cuatro=mysqli_num_rows($mas_cuatr);
		$cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos = '4'");
		$cuatro=mysqli_num_rows($cuatr);
		$menos_cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos < '4'");
		$menos_cuatro=mysqli_num_rows($menos_cuatr);
		$n_pil = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and pil = '1'");
		$num_pil=mysqli_num_rows($n_pil);
		$pil_mas_cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos > '4' and pil = '1'");
		$pil_mas_cuatro=mysqli_num_rows($pil_mas_cuatr);
		$pil_menos_cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos < '4' and pil = '1'");
		$pil_menos_cuatro=mysqli_num_rows($pil_menos_cuatr);
		$pil_cuatr = mysqli_query($db_con, "select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos = '4' and pil = '1'");
		$pil_cuatro=mysqli_num_rows($pil_cuatr);

		$tot = mysqli_query($db_con, "select * from alma where curso = '$curso'");
		$total = mysqli_num_rows($tot);
		$total_notas=$mas_cuatro+$cuatro+$menos_cuatro;

		if (stristr($curso, "E.S.O.") == TRUE) {
			$rep="";
			$promo="";
			$rep = ($mas_cuatro - $pil_mas_cuatro) + (($cuatro - $pil_cuatro)/2);
			$promo = ($menos_cuatro - $pil_menos_cuatro) + (($cuatro - $pil_cuatro)/2) + $num_pil;
		}
		else{
			$rep = ($mas_cuatro) + (($cuatro)/2);
			$promo = $todos - $rep;
		}
		if ($n_grupo=="5") {
			echo "</td></tr><tr><td style='text-align:center' valign='top'>";
		}
		?>

		<table class="table table-striped" align="center" style="width: 96%"
			valign="top">
			<?php
			if (strstr($curso, "E.S.O.") == TRUE) {
				echo "<h4>".$curso."</h4>";
				$rep_pil = "PIL <br /><small class='muted'>(+4: $pil_mas_cuatro; 4: $pil_cuatro; -4: $pil_menos_cuatro)</small>";
			}
			else{
				echo "<h4>".$curso."</h4>";
				$rep_pil="Repetidores";
			}
			?>
			<thead>
				<th>Suspensos</th>
				<th>Nº Alumnos</th>
			</thead>
			<tbody>
				<tr>
					<th>Más de 4</th>
					<td style='text-align: right'><?php echo $mas_cuatro;?></td>
				</tr>
				<th>4</th>
				<td style='text-align: right'><?php echo $cuatro;?></td>
				</tr>
				<th>Menos de 4</th>
				<td style='text-align: right'><?php echo $menos_cuatro;?></td>
				</tr>
				<tr>
					<th><?php echo $rep_pil;?></th>
					<td style='text-align: right'><?php echo $num_pil;?></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered" align="center" style="width: 96%">
			<tr>
				<th class="danger">Repiten</th>
				<td style='text-align: right' class="danger"><?php echo $rep;?></td>
			</tr>
			<tr>
				<th class="success">Promocionan</th>
				<td style='text-align: right' class="success"><?php echo $promo;?></td>
			</tr>
			<tr>
			<th colspan="2">Alumnos</th>
			</tr>
			<tr>
				<th class="info">Total con Calificaciones</th>
				<td style='text-align: right' class="info"><?php echo $total_notas;?></td>
			</tr>
			<tr>
				<th class=warning>Total matriculados</th>
				<td style='text-align: right' class="warning"><?php echo $total;?></td>
			</tr>
		</table>
		</td>
		<?php
	}
	mysqli_query($db_con, "drop table suspensos");

	?>
	</tr>
</table>

</div>
</div>
	<?php include("../../pie.php"); ?>
	
</body>
</html>
