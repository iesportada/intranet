<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

	if ($_POST) {
		foreach ($_POST as $key=>$val){
			$n_curso = substr($curso, 0, 1);
			$curso_anterior = $n_curso-1;
			//echo "$key --> $val<br>";
			$tr = explode("-",$key);
			$id_submit = $tr[1];
			$col = $tr[0];
			if ($col == 'confirmado'){$con.=$id_submit." ";} 
			if ($col == 'revisado'){$revis.=$id_submit." ";}
			if ($col == "grupo_actual"){$val=strtoupper($val);}
		
			//Promocion	
			if ($col=='promociona'){
				if ($val=='2' or $val=='3') {
				// Resplado de datos modificados
				$n_promo = mysqli_query($db_con, "select promociona, repite, claveal from matriculas_bach where id = '$id_submit'");	
				$n_prom = mysqli_fetch_array($n_promo);
				//echo $n_prom[0];
				if (!($n_prom[0]=='2') and !($n_prom[0]=='3') and $n_prom[1]<>1) {
				//echo $curso;	
				if ($curso == "2BACH") {
					
				$i2 = mysqli_query($db_con, "select itinierario1 from matriculas_bach where id = '$id_submit'");
				$i1 = mysqli_fetch_array($i2);
				if ($i1[0]<1) {
				// Recolocamos datos porque no promociona.						
				mysqli_query($db_con, "insert into matriculas_bach_backup select * from matriculas_bach where id = '$id_submit'");
				$cambia_datos = "update matriculas_bach set curso = '1BACH' where id = '$id_submit'";
				mysqli_query($db_con, $cambia_datos);
				}				
				}
				elseif($curso == "1BACH"){
				$a_bd = substr($config['curso_actual'],0,4);
				mysqli_query($db_con, "insert into matriculas_bach_backup select * from matriculas_bach where id = '$id_submit'");
				$ret_4 = mysqli_query($db_con, "select * from ".$db.$a_bd.".matriculas where claveal = '$n_prom[2]'");
				$ret = mysqli_fetch_array($ret_4);
				$sql="";				
				$sql = "insert into matriculas VALUES (''";
				for ($i = 1; $i < 68; $i++) {
					$sql.=", '$ret[$i]'";
				}
				$sql.=")";
				$n_afect = mysqli_query($db_con, $sql);
				mysqli_query($db_con, "delete from matriculas_bach where id='$id_submit'");
				}
				}
				}
				else{
					mysqli_query($db_con, "update matriculas_bach set promociona='$val' where id='$id_submit'");
				}
			}
			
			mysqli_query($db_con, "update matriculas_bach set $col = '$val' where id = '$id_submit'");
			mysqli_query($db_con, "update matriculas_bach set confirmado = '' where id = '$id_submit'");
			mysqli_query($db_con, "update matriculas_bach set revisado = '' where id = '$id_submit'");
		}
		
		$tr_con = explode(" ",$con);
		foreach ($tr_con as $clave){
			mysqli_query($db_con, "update matriculas_bach set confirmado = '1' where id = '$clave'");
		}
		$tr_con5 = explode(" ",$revis);
		foreach ($tr_con5 as $clave_revis){
			mysqli_query($db_con, "update matriculas_bach set revisado = '1' where id = '$clave_revis'");
		}
	}
	?>
	
	
	
	
	
	