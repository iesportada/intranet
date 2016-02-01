<?php
require('../../bootstrap.php');


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Páginas de Conserjería</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<LINK href="//<?php echo $config['dominio']; ?>/<?php echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="//<?php echo $config['dominio']; ?>/<?php echo $css2; ?>" rel="stylesheet" type="text/css">
<script languaje="javascript">
function habilitaDeshabilita()
{
    if (document.getElementById('personal').checked == true)
    {
document.getElementById('administraccion').checked = false
    }
     if (document.getElementById('administraccion').checked == true)
    {
document.getElementById('personal').checked = false
    } 
}
</script>
</head>

  <body onload="document.getElementById('n_numero').style.backgroundColor='#cde';
document.getElementById('n_numero').style.border='#aaaaaa solid 1px'; 
document.getElementById('n_numero').focus();">
  <?php
  	include("../../menu.php");
  ?>
<div align=center>
  <div class=titulogeneral style="margin:auto;margin-top:25px;margin-bottom:5px;width:500px;">Registro de Fotocopias</div>
</div>
<div align="center">
<?php
if ($submit=="Enviar datos")
{
if (is_numeric($n_numero) and strlen($n_numero)>0) {
	if ($tipo=='') {
		$tipo='3';
	}
	mysqli_query($db_con, "INSERT INTO `fotocopias` ( `id` , `nombre` , `numero` , `observaciones`, `tipo` )
VALUES (NULL , '$profeso', '$n_numero', '$n_observaciones', '$tipo')");
	if (mysqli_affected_rows()>0) {
		echo "<p id='texto_en_marco'>Las copias se han registrado en la Base de datos</p>";
	}
	else {
		echo "<p id='texto_en_marco style='color:red;font-weight:bold;'>Ha habido problemas y no se han registrado las copias en la Base de datos. Ponte en contacto con quien pueda arreglarlo.</p>";
	}
}
}
?>
<TABLE class="tabla" width="350">
  			       <TR> 
                    <TD id="filaprincipal" colspan="2" style="text-align:center">Selecciona Profesor</TD>
                  </TR>
	   <tr><FORM action="index.php" method="POST" name="copias">
          <td id="filasecundaria">
             Profesor 
            </td>
          <td> <div align="center">
              <SELECT  name=profeso onChange="submit()">
              <option><?php echo $profeso;?></option>
		        <?php
  $profe = mysqli_query($db_con, " SELECT distinct nombre FROM departamentos where nombre not like 'admin' order by nombre asc");
  if ($filaprofe = mysqli_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysqli_fetch_array($profe));
        }
	?>
              </select>
              </form>
            </div></td>
        </TR>   
      <TR> 
        <TD colspan="2" style="text-align:center; padding:6px;" > 
		  </TD>
      </tr>
  </TABLE>
  <?php
if ($profeso) {
	$total="0";
$ft=mysqli_query($db_con, "select numero from fotocopias where nombre = '$profeso'");
while ($copia=mysqli_fetch_array($ft)) {
	$total+=$copia[0];
}
?>

<FORM action="index.php" method="POST" name="numeros">
<table class="tabla" align="center" style="margin-top:0px;">
	<tr><td id="filaprincipal">Número de Copias</td>
	<td><input name="n_numero" id="n_numero" value="" type="text" size="4"   />
	</td></tr>
	<tr><td colspan="2" style="text-align:center;">
	<span id="filaprincipal" style="background-color:white;margin-left:25px;">
	Administración<input id="administraccion" name="tipo" type="checkbox" value="1" <?php if ($profeso=="CONSERJE") {echo "checked";} ?> onClick="habilitaDeshabilita()" /></span>
	<span id="filaprincipal" style="background-color:white;margin-left:25px;">
	Personal<input id="personal" name="tipo" type="checkbox" value="2" onClick="habilitaDeshabilita()" /></span>
	</td></tr>
	<tr><td id="filaprincipal">Observaciones</td>
	<td><textarea name="n_observaciones" value="" cols="30" type="text"  /></textarea></td></tr>
	<tr><td colspan="2" style="text-align:center;"><span style="font-size:1.0em;color:#261;word-spacing:1px;">Total de copias:</span><span style="color:red;font-weight:bold;margin-left:2px;"><?php echo $total;?></span><span style="margin-left:15px;font-size:1.0em;color:#261;word-spacing:1px;">Sesiones: </span><span style="color:blue;font-weight:bold;margin-left:2px;"><?php echo mysqli_num_rows($ft);?></span></td></tr>
	<tr><td colspan="2" id="filaprincipal" style="text-align:center;padding:6px;"><input name="submit" value="Enviar datos" type="submit" style="width:100px;" /></td></tr>
	</table>
	<input type="hidden" value="<?php echo $profeso;?>" name="profeso" />
	</form>
<?php
}
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
?>
<br>
<a href="total.php" style="color:#261;font-size:1.0em;word-spacing:1px;border:1px solid #aaa;background-color:#feb;padding:5px 15px; margin-top:15px;">Ver estadísticas de fotocopias</a>
<?php
}
?>

</div>
</body>
</html>
