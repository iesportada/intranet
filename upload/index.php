<?php
require('../bootstrap.php');

$caracteres_no_permitidos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
$caracteres_permitidos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

$result = mysqli_query($db_con, "SELECT grupo FROM profesores WHERE profesor ='".$_SESSION['profi']."'");
$unidades = array(); 
while ($row = mysqli_fetch_array($result)) {
	$unidades[] = $row['grupo']; 
}
mysqli_free_result($result);


define('IN_PHPATM', true);
include('include/conf.php');
include('include/common.'.$phpExt);

//
//
function msdos_time_to_unix($DOSdate, $DOStime)
{
	$year = (($DOSdate & 65024) >> 9) + 1980;
	$month = ($DOSdate & 480) >> 5;
	$day = ($DOSdate & 31);
	$hours = ($DOStime & 63488) >> 11;
	$minutes = ($DOStime & 2016) >> 5;
	$seconds = ($DOStime & 31) * 2;
	return mktime($hours, $minutes, $seconds, $month, $day, $year);
}

//
//
function list_zip($filename)
{
	global $bordercolor, $headercolor, $tablecolor, $font, $headerfontcolor;
	global $normalfontcolor, $datetimeformat, $me;

	$fp = @fopen($filename,'rb');
	if (!$fp)
	{
		return;
	}
	fseek($fp, -22, SEEK_END);

	// Get central directory field values
	$headersignature = 0;
	do
	{
		// Search header
		$data = fread($fp, 22);
		list($headersignature,$numberentries, $centraldirsize, $centraldiroffset) =
			array_values(unpack('Vheadersignature/x6/vnumberentries/Vcentraldirsize/Vcentraldiroffset', $data));

		fseek($fp, -23, SEEK_CUR);
	} while (($headersignature != 0x06054b50) && (ftell($fp) > 0));

	if ($headersignature != 0x06054b50)
	{
		echo "<p><font face=\"$font\" size=\"3\" color=\"$normalfontcolor\">$mess[45]</p>";
		fclose($fp);
		return;
	}

	fseek($fp, $centraldiroffset, SEEK_SET);

	// Read central dir entries
	echo "<h3>$mess[46]</h3><br />";
	echo "<table class='table table-bordered table-striped'>";
	echo "<thead>";
	echo "<tr>
	<th nowrap>$mess[15]</th>
	<th nowrap>$mess[17]</th>
	<th nowrap>$mess[47]</th>
	</tr>";
	echo "</thead>";
	echo "<tbody>";

	for ($i = 1; $i <= $numberentries; $i++)
	{
		// Read central dir entry
		$data = fread($fp, 46);
		list($arcfiletime,$arcfiledate,$arcfilesize,$arcfilenamelen,$arcfileattr) =
			array_values(unpack("x12/varcfiletime/varcfiledate/x8/Varcfilesize/Varcfilenamelen/x6/varcfileattr", $data));
		$filenamelen = fread($fp, $arcfilenamelen);

		$arcfiledatetime = msdos_time_to_unix($arcfiledate, $arcfiletime);

		echo "<tr>";

		// Print FileName
		echo '<td>';
		echo "";
		if ($arcfileattr == 16)
		{
			echo "<b>$filenamelen</b>";
		}
		else
		{
			echo $filenamelen;
		}

		echo '';
		echo '</td>';

		// Print FileSize column
		echo "<td>";

		if ($arcfileattr == 16)
			echo $mess[48];
		else
			echo $arcfilesize . ' bytes';

		echo '</td>';

		// Print FileDate column
		echo "<td>";
		echo date($datetimeformat, $arcfiledatetime);
		echo '</td>';
		echo '</tr>';
	}
	echo "</tbody>";
	echo '</table></p>';
	fclose($fp);
	return;
}

//
//
function unix_time()
{
	global $timeoffset;
	$tmp = time() + 3600 * $timeoffset;
	return $tmp;
}

//
//
function file_time($filename)
{
	global $timeoffset;
	$tmp = filemtime($filename) + 3600 * $timeoffset;
	return $tmp;
}

//
//
function delete_file($filename)
{
	if (file_exists($filename))
		unlink($filename);
}


function scan_dir_for_digest($current_dir, &$message)
{
	global $timeoffset, $comment_max_caracters, $datetimeformat, $uploads_folder_name;
	global $hidden_dirs, $showhidden;

	$currentdate = getdate();
	$time1 = mktime(0, 0, 0, $currentdate['mon'], $currentdate['mday']-1, $currentdate['year']);
	$time2 = $time1 + 86400;

	list($liste, $totalsize) = listing($current_dir);

	$filecount = 0;
	if (is_array($liste))
	{
		while (list($filename, $mime) = each($liste))
		{
			if(is_dir("$current_dir/$filename"))
			{
		      	if (eregi($hidden_dirs, $filename) && !$showhidden)
		      	{
		      		continue;
		      	}

				$filecount += scan_dir_for_digest("$current_dir/$filename", $message);
				continue;
			}

			$file_modif_time = filemtime("$current_dir/$filename");
			if (($file_modif_time < $time1) || ($file_modif_time >= $time2))
				continue;

		    $filecount++;

			list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

			$message.="
			    <tr valign=\"top\">
			        <td align=\"left\" width=\"45%\">
			          <font size=3>$filename<BR>
			          <font size=2>$contents
			        </td>
			        <td align=\"left\" width=\"30%\" valign=\"middle\">
			        	Documentos".ereg_replace($uploads_folder_name, '', $current_dir)."
			        </td>
			        <td align=\"right\"  nowrap valign=\"middle\">\n";
			$message.= get_filesize("$current_dir/$filename");
			$message.= "</td>
			 		<td align=\"left\"  nowrap valign=\"middle\">\n";
			$message.=date($datetimeformat, $file_modif_time - $timeoffset * 3600);
			$message.= "</td>
					<td align=\"left\"  valign=\"middle\">\n";

			if ($upl_user != "")
			$message.= "<b>$upl_user</b><br>";

			$message.= "
					</td>
				</tr>\n";
		}
	}

	return $filecount;
}

function init($directory)
{
	global $uploads_folder_name, $direction, $mess, $font, $normalfontcolor;

	$direction = ($direction == DIRECTION_UP) ? DIRECTION_DOWN : DIRECTION_UP;

	$current_dir = $uploads_folder_name;
	if ($directory != '')
		$current_dir = "$current_dir/$directory";

	if (!is_dir($uploads_folder_name))
	{
		echo "$mess[196]<br><br>
			  <a href=\"index.$phpExt?".SID."\">$mess[29]</a>\n";
		exit;
	}

	if (!is_dir($current_dir))
	{
		echo "$mess[30]<br><br>
			  <a href=\"javascript:window.history.back()\">$mess[29]</a>\n";
		exit;
	}

	return $current_dir;
}

//
//
function assemble_tables($tab1, $tab2)
{
	global $direction;

	$liste = '';

	if (is_array($tab1))
	{
		while (list($cle, $val) = each($tab1))
			$liste[$cle] = $val;
	}

	if (is_array($tab2))
	{
		while (list($cle, $val) = each($tab2))
			$liste[$cle] = $val;
	}

	return $liste;
}

//
//
function txt_vers_html($text)
{
	$text = str_replace('&', '&amp;', $text);
	$text = str_replace('<', '&lt;', $text);
	$text = str_replace('>', '&gt;', $text);
	$text = str_replace('\"', '&quot;', $text);
	return $text;
}

//
function listing($current_dir)
{
	global $direction, $order;

	$totalsize = 0;
	$handle = opendir($current_dir);
	$list_dir = '';
	$list_file = '';
	while (false !== ($filename = readdir($handle)))
    {
	    if ($filename != '.' && $filename != '..'
//	    	&& !eregi("\.desc$|\.dlcnt$|^index\.", $filename)
	    	&& show_hidden_files($filename))
		{
			$filesize=filesize("$current_dir/$filename");
			$totalsize += $filesize;
			if (is_dir("$current_dir/$filename"))
			{
				if($order == 'mod')
					$list_dir[$filename] = filemtime("$current_dir/$filename");
				else
					$list_dir[$filename] = $filename;
            }
            else
            {
            	switch($order)
            	{
					case 'taille';
						$list_file[$filename] = $filesize;
						break;
					case 'mod';
						$list_file[$filename] = filemtime("$current_dir/$filename");
						break;
					//case 'rating';
					//	$list_file[$filename] = count_file_download("$current_dir/$filename");
					//	break;
					default;
						$list_file[$filename] = get_mimetype_img("$current_dir/$filename");
						break;
				}
			}
		}
	}
    closedir($handle);

	if(is_array($list_file))
	{
       	switch($order)
    	{
			case 'taille':
			//case 'rating':
			//	$direction == DIRECTION_DOWN ? asort($list_file) : arsort($list_file);
			//	break;
			case 'mod':
				$direction == DIRECTION_DOWN ? arsort($list_file) : asort($list_file);
				break;
			default:
				$direction == DIRECTION_DOWN ? ksort($list_file) : krsort($list_file);
				break;
		}
	}

	if(is_array($list_dir))
	{
		if ($order == "mod")
		{
			$direction == DIRECTION_UP ? arsort($list_dir) : asort($list_dir);
		}
		else
		{
			$direction == DIRECTION_UP ? krsort($list_dir) : ksort($list_dir);
		}
	}

	$liste = assemble_tables($list_dir, $list_file);

	if ($totalsize >= 1073741824)
		$totalsize = round($totalsize / 1073741824 * 100) / 100 . " GB";
	elseif ($totalsize >= 1048576)
		$totalsize = round($totalsize / 1048576 * 100) / 100 . " MB";
	elseif ($totalsize >= 1024)
		$totalsize = round($totalsize / 1024 * 100) / 100 . " KB";
	else
		$totalsize = $totalsize . " B";

    return array($liste, $totalsize);
}

//

function contents_dir($current_dir, $directory)
{
	global $index;
	global $font,$direction,$order,$totalsize,$mess,$tablecolor,$lightcolor;
	global $file_out_max_caracters,$normalfontcolor, $phpExt, $hidden_dirs, $showhidden;
	global $comment_max_caracters,$datetimeformat, $logged_user_name;
	global $user_status,$activationcode,$max_filesize_to_mail,$mail_functions_enabled, $timeoffset, $grants;
	
	$direction = 0;
	
	$num_row = 0;
	
  // Read directory
  list($liste, $totalsize) = listing($current_dir);

  if(is_array($liste))
  {
    while (list($filename,$mime) = each($liste))
    {
    	
    	$num_row++;
    	
      if (is_dir("$current_dir/$filename"))
      {

      	if (eregi($hidden_dirs, $filename) && !$showhidden)
      	{
      		continue;
      	}

        $filenameandpath = "index.$phpExt?index=$index&direction=$direction&order=$order&directory=";

        if ($directory != '')
        	$filenameandpath .= "$directory/";

        $filenameandpath .= $filename;
      }
      else
      {
        $filenameandpath = '';
        if ($directory != '')
        {
        	$filenameandpath .= "$directory/";
        }
        $filenameandpath .= $filename;
      }
  
		  $dir_protegidos = array('Biblioteca', 'Recursos educativos', 'Departamentos');
		  $subdir_protegidos = array('Recursos educativos', 'Departamentos');
		
			echo "    <tr>\n";
			
		  echo "      <td>\n";
		 	if (is_dir("$current_dir/$filename")) echo "<a href=\"$filenameandpath\">";
		  	echo "		  <span class=\"fa " . get_mimetype_img("$current_dir/$filename") . " fa-fw fa-lg\"></span>";	  
		  	
			if(strlen($filename) > $file_out_max_caracters) {
				echo htmlspecialchars(substr($filename, 0, $file_out_max_caracters-4).'...', ENT_QUOTES, 'ISO-8859-1');
			}
			else {
				echo htmlspecialchars($filename, ENT_QUOTES, 'ISO-8859-1');
			}
			if (is_dir("$current_dir/$filename")) echo "</a>";
			echo "        $content\n";
			echo "      </td>\n";
			
			echo "      <td nowrap>\n";
			if ($grants[$user_status][DELALL] || ($upl_user == $logged_user_name && $grants[$user_status][DELOWN]))
			{
				if (!is_dir("$current_dir/$filename"))
				{
					echo "<a href=\"index.${phpExt}?index=$index&action=deletefile&filename=$filename&directory=$directory\" data-bb=\"confirm-delete\" rel=\"tooltip\" title=\"Eliminar\"><span class=\"fa fa-trash-o fa-lg fa-fw\" alt=\"$mess[169]\"></span></a>";
			    }
			    else
			    {
			    	if ($grants[$user_status][DELALL])
			    	{
			    		if ((! in_array($filename, $dir_protegidos) && ! in_array($directory, $subdir_protegidos)) || (in_array($directory, $subdir_protegidos) && stristr($_SESSION['cargo'],'1') == TRUE)) {
					    	echo "<a href=\"index.${phpExt}?index=$index&action=deletedir&filename=$filename&directory=$directory\" data-bb=\"confirm-delete\" rel=\"tooltip\" title=\"Eliminar\"><span class=\"fa fa-trash-o fa-lg fa-fw\" alt=\"$mess[169]\"></span></a>";
							}
						}
			    }
			}
		
		
			if ($grants[$user_status][MODALL] || ($upl_user == $logged_user_name && $grants[$user_status][MODOWN]))
			{
				
				if (! in_array($filename, $dir_protegidos) && ! in_array($directory, $subdir_protegidos)) {
					// RENOMBRAR
					echo "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal_$num_row\" rel=\"tooltip\" title=\"Renombrar\"><span class=\"fa fa-edit fa-lg fa-fw\" alt=\"Renombrar\"></span></a>
						
						<div id=\"modal_$num_row\" class=\"modal fade\">
						  <div class=\"modal-dialog\">
						  	<form method=\"post\" action=\"\">
							    <div class=\"modal-content\">
							      <div class=\"modal-header\">
							        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Cerrar\"><span aria-hidden=\"true\">&times;</span></button>
							        <h4 class=\"modal-title\">Renombrar</h4>
							      </div>
							      <div class=\"modal-body\">
							        		
					        		<input type=\"hidden\" name=\"action\" value=\"rename\">
					        		<input type=\"hidden\" name=\"directory\" value=\"$directory\">
					        		<input type=\"hidden\" name=\"filename\" value=\"$filename\">
					        		<input type=\"hidden\" name=\"index\" value=\"$index\">
					        		<input type=\"hidden\" name=\"direction\" value=\"$direction\">
					        		
						        	<div class=\"form-group\">
						        		<label for=\"userfile\">Nuevo nombre</label>
					        			<input type=\"text\" class=\"form-control\" id=\"userfile\" name=\"userfile\" value=\"$filename\" maxlenght=\"250\">
					        		</div>
							        	
							      </div>
							      <div class=\"modal-footer\">
							        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancelar</button>
							        <button type=\"submit\" class=\"btn btn-primary\">Renombrar</button>
							      </div>
							    </div><!-- /.modal-content -->
							   </form>
						  </div><!-- /.modal-dialog -->
						</div><!-- /.modal -->";
				}
					
				if (!is_dir("$current_dir/$filename") || $grants[$user_status][MODALL])
				{
			  }
			}
		
		
			if ($grants[$user_status][DOWNLOAD] && !is_dir("$current_dir/$filename")) {
				
				
				// DESCARGAR ARCHIVO
				echo "<a href=\"index.${phpExt}?index=$index&action=downloadfile&filename=$filename&directory=$directory\" rel=\"tooltip\" title=\"Descargar\"><span class=\"fa fa-cloud-download fa-lg fa-fw\" alt=\"$mess[23]\"></span></a>";
			}
				
				if ($_GET['index'] == 'privado' && !is_dir("$current_dir/$filename")) {
					// COMPARTIR ARCHIVO
					if (isset($directory)) {
						$share_string = urlencode("<br><br>Archivo adjunto:<br><span class=\"fa fa-download fa-fw\"></span> <a href=\"http://".$_SERVER['SERVER_NAME']."/intranet/varios/".$_SESSION['ide']."/$directory/$filename\" target=\"_blank\">$filename</a>");
					}
					else {
						$share_string = urlencode("<br><br>Archivo adjunto:<br><span class=\"fa fa-download fa-fw\"></span> <a href=\"http://".$_SERVER['SERVER_NAME']."/intranet/varios/".$_SESSION['ide']."/$filename\" target=\"_blank\">$filename</a>");
					}
					
					echo "<a href=\"../admin/mensajes/redactar.php?texto=$share_string\" rel=\"tooltip\" title=\"Compartir\"><span class=\"fa fa-share-alt fa-lg fa-fw\" alt=\"$mess[23]\"></span></a>";
				}
					
				echo "</td>";
				echo "<td class=\"hidden-xs hidden-sm\" nowrap>";
				echo "<span class=\"text-muted\">";
				// TIPO DE ARCHIVO
				if (is_dir("$current_dir/$filename")) echo "directorio";
				else echo get_filesize("$current_dir/$filename");
				echo "</span>";
				echo "</td>";
				echo "<td class=\"hidden-xs hidden-sm\" nowrap>";
				
				// FECHA DE MODIFICACIÓN
				$file_modif_time = filemtime("$current_dir/$filename") - $timeoffset * 3600;
				echo "<span class=\"text-muted\">".date($datetimeformat, $file_modif_time)."</span>";
				
				echo "</td>\n";
				echo "</tr>\n";
			}
			
			
  }
}

//
//
function list_dir($directory)
{
	global $mess,$direction,$uploads_folder_name;
	global $font,$order,$totalsize,$tablecolor,$headercolor,$bordercolor;
	global $headerfontcolor, $normalfontcolor, $phpExt;
	$directory = clean_path($directory);
	$current_dir = init($directory);
	$filenameandpath = ($directory != '') ? "&directory=".$directory : '';
	
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table table-striped table-hover\">";
	echo "  <thead>\n";
	echo "    <tr>\n";
	echo "      <th nowrap>$mess[15]</th>\n";
	echo "      <th nowrap>$mess[16]</th>\n";
	echo "      <th class=\"hidden-xs hidden-sm\" nowrap>$mess[17]</th>\n";
	echo "      <th class=\"hidden-xs hidden-sm\" nowrap>$mess[18]</th>\n";
	echo "    </tr>\n";
	echo "  </thead>\n";
	
	contents_dir($current_dir, $directory);
	
	echo "  <tfoot>\n";
	echo "    <tr>\n";
	echo "      <td colspan=\"4\"><p class=\"text-right text-muted\">$mess[43]: $totalsize</p></td>\n";
	echo "    </tr>\n";
	echo "	</tfooter>\n";
	echo "</table>\n";
	echo "</div>";
	
}

//
function delete_dir($location)
{
	if(is_dir($location))
	{
		$all = opendir($location);
		while (false !== ($file = readdir($all)))
		{
			if (is_dir("$location/$file") && $file != '..' && $file != '.')
			{
				delete_dir("$location/$file");
				rmdir("$location/$file");
			}
			elseif (is_file("$location/$file"))
			{
				unlink("$location/$file");
			}
			unset($file);
		}
		closedir($all);
		rmdir($location);
	}
	else
	{
		if (file_exists($location))
		{
			unlink($location);
		}
	}
}

//
function normalize_filename($name)
{
	global $file_name_max_caracters, $invalidchars;
	$caracteres_no_permitidos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
	$caracteres_permitidos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

	$name = stripslashes($name);

	reset($invalidchars);
	while (list($key, $value) = each($invalidchars))
	{
		$name = str_replace($value, '', $name);
	}

	$name = substr($name, 0, $file_name_max_caracters);
	$name = str_replace($caracteres_no_permitidos, $caracteres_permitidos, $name);
	
	return $name;
}

//
//
function show_contents() {
	global $index;
	global $current_dir,$directory,$uploads_folder_name,$mess,$direction,$timeoffset;
	global $order,$totalsize,$font,$tablecolor,$bordercolor,$headercolor;
	global $headerfontcolor,$normalfontcolor,$user_status, $grants, $phpExt;

	switch ($index) {
		default :
		case 'publico' : $activo1 = 'class="active"'; $titulo='Documentos públicos'; break;
		case 'privado' : $activo2 = 'class="active"'; $titulo='Documentos personales'; break;
	}
	
	echo "<div class=\"container\">\n";
	?>
	<!-- Button trigger modal -->
	<a href="#" class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
		<span class="fa fa-question fa-lg"></span>
	</a>

	<!-- Modal -->
	<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
					<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
				</div>
				<div class="modal-body">
					<p>La página presenta dos tipos de documentos: los <strong><em>Documentos 
					públicos del Centro</em></strong> y los <strong><em>Documentos privados de 
					cada Profesor</em></strong>.</p>
					<p>Los <strong><em>Documentos Públicos</em></strong> se configuran en la 
					instalación de la Intranet, y son visibles desde la página pública del Centro. Ofrecen un directorio donde el Equipo 
					directivo y demás profesores colocan aquellos archivos que consideran relevantes para la Comunidad 
					educativa (Programaciones, Plan del Centro, etc.). <br>					
					Dependiendo de las opciones elegidas en la instalación, podemos encontrar tres categorías: <strong><em>Biblioteca</em></strong>, donde los miembros del equipo de la misma pueden subir y compartir sus archivos; <strong><em>Departamentos</em></strong>, dentro del 
					cual encontraremos directorios de los distintos Departamentos del Centro y que pueden ser utilizados por los miembros de los mismos; y <strong><em>Recursos</em></strong>, con un directorio para cada grupo del Centro en el que los Equipos educativos pueden colocar materiales diversos para sus alumnos.</p>
					<p>Los <strong><em>Documentos Personales</em></strong> son propios de cada 
					Profesor y sólo son accesibles por él. Podemos subir archivos para luego usarlos en el Centro, o bien 
					utilizar esos archivos para incrustarlos en un mensaje que luego se comparte 
					dentro de la Intranet. Este módulo se puede también entender como un pequeño 
					Explorador personal de nuestros archivos. No es visible desde la Página 
					pública del Centro.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	echo "  <ul class=\"nav nav-tabs\">\n";
	echo "    <li $activo1><a href=\"index.${phpExt}?index=publico\">Documentos públicos</a></li>\n";
	echo "    <li $activo2><a href=\"index.${phpExt}?index=privado\">Documentos personales</a></li>\n";
	echo "  </ul>\n";
	
	echo "   <div class=\"page-header\">\n";
  echo "      <h2>$titulo</h2>\n";
  echo "   </div>\n";
    
	// BREADCUMB
	$directory = clean_path($directory);
	if (!file_exists("$uploads_folder_name/$directory")) {
		$directory = '';
	}
	if ($directory != '') {
	    $name = dirname($directory);
	    if ($directory == $name || $name == '.') $name = '';
	    
			echo "<div class=\"text-uppercase\">\n";
			echo "  <a href=\"index.${phpExt}?index=$index&direction=$direction&order=$order&directory=$name\">\n";
			echo "   <i class=\"fa fa-chevron-up iconf-fixed-width\"></i>\n";
			echo "  </a>\n";
			echo split_dir("$directory");
			echo "</div>";
			echo "<br>";
	}
	
	if ($grants[$user_status][UPLOAD] || $grants[$user_status][MKDIR]) {
		$col_sm = 'col-sm-8';
	}
	else {
		$col_sm = 'col-sm-12';
	}
	
	// COLUMNA IZQUIERDA
	
	echo "      <div class=\"row\">\n";
	echo "        <div class=\"$col_sm\">\n";
	
	if ($grants[$user_status][VIEW]) {
		list_dir($directory);
	}
  echo "        </div>\n";
	
	// COLUMNA DERECHA
	echo "        <div class=\"col-sm-4\">\n";
	
	if ($grants[$user_status][UPLOAD]) {
		
		echo "          <div class=\"well\">\n";
		echo "            <form name=\"upload\" enctype=\"multipart/form-data\" method=\"POST\">\n";
		echo "              <fieldset>\n";
		echo "                <legend>$mess[20]</legend>\n";
		echo "                <input type=\"hidden\" name=\"action\" value=\"upload\">\n";
		echo "                <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
		echo "                <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
		echo "                <input type=\"hidden\" name=\"index\" value=\"$index\">\n";
		echo "                <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";
		echo "                <div class=\"form-group\">\n";
		echo "                <input type=\"file\" name=\"userfile[]\" multiple>\n";
		echo "                </div>\n";
		echo "                <input type=\"submit\" class=\"btn btn-primary\" value=\"$mess[20]\">\n";
		echo "              </fieldset>\n";
		echo "            </form>\n";
		echo "          </div>\n";
	}
	
	if ($grants[$user_status][MKDIR]) {
		echo "          <div class=\"well\">\n";
		echo "            <form name=\"newdir\" enctype=\"multipart/form-data\" method=\"POST\">\n";
		echo "              <fieldset>\n";
		echo "                <legend>$mess[186]</legend>";
		echo "                <input type=\"hidden\" name=\"action\" value=\"createdir\">\n";
		echo "                <input type=\"hidden\" name=\"directory\" value=\"$directory\">\n";
		echo "                <input type=\"hidden\" name=\"order\" value=\"$order\">\n";
		echo "                <input type=\"hidden\" name=\"index\" value=\"$index\">\n";
		echo "                <input type=\"hidden\" name=\"direction\" value=\"$direction\">\n";
		echo "                <div class=\"form-group\">\n";
		echo "                    <input type=\"text\" name=\"filename\" class=\"form-control\" placeholder=\"$mess[187]\">";
		echo "                </div>\n";
		echo "                <input type=\"submit\" class=\"btn btn-primary\" value=\"$mess[188]\">\n";
		echo "              </fieldset>\n";
		echo "            </form>\n";
		echo "          </div>\n";
		
	}
	
	echo "       </div>\n";
	
	echo "    </div>\n";
	echo "</div>\n";
}


function is_path_safe(&$path, &$filename) {
	global $uploads_folder_name;

	$path = clean_path($path);
	$filename = clean_path($filename);

	if (!file_exists("$uploads_folder_name/$path") || !show_hidden_files($filename)) {
		return false;
	}

	return true;
}

//----------------------------------------------------------------------------
//   CREACIÓN / ELIMINACIÓN DE DIRECTORIOS EN FUNCIÓN DE LA CONFIGURACIÓN
//----------------------------------------------------------------------------

if($index=='publico') {
	// Biblioteca
	if(isset($config['mod_documentos_biblioteca']) && $config['mod_documentos_biblioteca']) {
	
		if(!file_exists($config['mod_documentos_dir'].'/Biblioteca')) mkdir($config['mod_documentos_dir'].'/Biblioteca', 0777);
		
	}
	else {
		delete_dir($config['mod_documentos_dir'].'/Biblioteca');
	}
	
	// Recursos educativos
	if(isset($config['mod_documentos_recursos']) && $config['mod_documentos_recursos']) {
	
		if(!file_exists($config['mod_documentos_dir'].'/Recursos educativos')) mkdir($config['mod_documentos_dir'].'/Recursos educativos', 0777);
		$result = mysqli_query($db_con, "SELECT nomunidad FROM unidades ORDER BY nomunidad ASC");
		while ($row = mysqli_fetch_array($result)) {
		
			if(!file_exists($config['mod_documentos_dir'].'/Recursos educativos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['nomunidad']))) mkdir($config['mod_documentos_dir'].'/Recursos educativos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['nomunidad']), 0777);
			
			// Se puede eliminar esta linea en futuras actualizaciones...
			if(file_exists($config['mod_documentos_dir'].'/Recursos educativos/'.$row['nomunidad'])) rename($config['mod_documentos_dir'].'/Recursos educativos/'.$row['nomunidad'], $config['mod_documentos_dir'].'/Recursos educativos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['nomunidad']));
		}
		mysqli_free_result($result);
		
	}
	else {
		delete_dir($config['mod_documentos_dir'].'/Recursos educativos');
	}
	
	// Departamentos
	if(isset($config['mod_documentos_departamentos']) && $config['mod_documentos_departamentos']) {
		
		if(!file_exists($config['mod_documentos_dir'].'/Departamentos')) mkdir($config['mod_documentos_dir'].'/Departamentos', 0777);
		$result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento NOT LIKE 'Admin' AND departamento NOT LIKE 'Auxiliar de Conversaci_n' AND departamento NOT LIKE 'Administraci_n' AND departamento NOT LIKE 'Conserjer_a' ORDER BY departamento ASC");
		while ($row = mysqli_fetch_array($result)) {
		
			if(!file_exists($config['mod_documentos_dir'].'/Departamentos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['departamento']))) mkdir($config['mod_documentos_dir'].'/Departamentos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['departamento']), 0777);
			
			// Se puede eliminar esta linea en futuras actualizaciones...
			if(file_exists($config['mod_documentos_dir'].'/Departamentos/'.$row['departamento'])) rename($config['mod_documentos_dir'].'/Departamentos/'.$row['departamento'], $config['mod_documentos_dir'].'/Departamentos/'.str_replace($caracteres_no_permitidos, $caracteres_permitidos, $row['departamento']));
		}
		mysqli_free_result($result);
	}
	else {
		//delete_dir($config['mod_documentos_dir'].'/Departamentos');
	}
 
}

if($index=='privado' && !file_exists($uploads_folder_name)) mkdir("$uploads_folder_name", 0777);


//----------------------------------------------------------------------------
//      MAIN
//----------------------------------------------------------------------------
switch($action)
{
	case 'deletefile';
			$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);


		if (!file_exists("$current_dir/$filename"))
		{
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (is_path_safe($directory, $filename))
	    {
			list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

			if ($grants[$user_status][DELALL] || ($upl_user == $logged_user_name && $grants[$user_status][DELOWN]))
			{
				delete_file("$current_dir/$filename");
			}
		}

	  include("../menu.php");
	  show_contents();
	  include("../pie.php");
		break;


	case 'deletedir';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!file_exists("$current_dir/$filename"))
		{
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (is_path_safe($directory, $filename))
	    {
			if ($grants[$user_status][DELALL])
			{
				delete_dir("$current_dir/$filename");
			}
		}
	  include("../menu.php");
	  show_contents();
	  include("../pie.php");
		break;

	case 'createdir';

		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

      	if (eregi($hidden_dirs, $filename) && !$showhidden)
      	{
      		include("../menu.php");
      		show_contents();
      		include("../pie.php");
			break;
      	}

		if (is_path_safe($directory, $filename))
		{
			$filename = normalize_filename($filename);

			if ($filename != '')
			{
				if ($grants[$user_status][MKDIR])
				{
					if (!file_exists("$current_dir/$filename"))
					{
						mkdir("$current_dir/$filename", 0777);
					}
				}
			}
		}

	  include("../menu.php");
	  show_contents();
	  include("../pie.php");
		break;

	case 'downloadfile';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!$grants[$user_status][DOWNLOAD])
		{
			include("../menu.php");
			show_contents();
			break;
		}

		if (!file_exists("$current_dir/$filename"))
		{
			include("../menu.php");
			show_contents();
			break;
		}

		if (!is_path_safe($directory, $filename))
		{
			include("../menu.php");
			show_contents();
			break;
		}

		$size = filesize("$current_dir/$filename");

		if (($user_status != ANONYMOUS) && ($logged_user_name != ''))  // Update user statistics
		{
		  list($files_uploaded, $files_downloaded, $files_emailed) = load_userstat($logged_user_name);
		  $files_downloaded++;
		  save_userstat($logged_user_name, $files_uploaded, $files_downloaded, $files_emailed, time());
		}

		header("Content-Type: application/force-download; name=\"$filename\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $size");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Expires: 0");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		readfile("$current_dir/$filename");
		exit;
		break;

	case 'view';
		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		$filename = basename($filename);

		if (!$grants[$user_status][VIEW])
		{
			header("Status: 404 Not Found");
			exit;
		}

		if (!file_exists("$current_dir/$filename") || !is_path_safe($directory, $filename))
		{
			header("Status: 404 Not Found");
			exit;
		}

		$filenametoview = basename($filename);
		page_header($mess[26].": ".$filenametoview);

		echo "<center><h4>$mess[26] : ";
		echo "<img src=\"images/".get_mimetype_img("$current_dir/$filename")."\" align=\"ABSMIDDLE\">\n";
		echo "".$filenametoview."<br><br><hr>\n";
		echo "<a href=\"javascript:window.print()\"><i class='fa fa-print' alt=\"$mess[27]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<a href=\"index.${phpExt}?action=downloadfile&filename=".$filename."&directory=".$directory."h.php\"><i class='fa fa-download' alt=\"$mess[23]\" width=\"20\" height=\"20\" border=\"0\"> &nbsp;&nbsp;</i></a>";
		echo "<a href=\"javascript:window.close()\"><i class='fa fa-chevron-left' alt=\"$mess[28]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "</h4>\n";


		if(!is_image($filename))
		{
			echo "</center>\n";
			if (is_browsable($filename))
			{
				list_zip("$current_dir/$filename");
			}
				else
			{
				$fp=@fopen("$current_dir/$filename", "r");
				if($fp)
				{
					echo "\n";
					while(!feof($fp))
					{
						$buffer=fgets($fp,4096);
						$buffer=txt_vers_html($buffer);
						$buffer=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$buffer);
						echo $buffer."<br>";
					}
					fclose($fp);
					echo "\n";
				}
				else
				{
					echo "$mess[31] : $current_dir/$filename";
				}
			}
			echo "<center>\n";
		}
		else
		{
			echo "<img src=\"getimg.${phpExt}?image=$directory/$filename\">\n";
		}
		echo "<hr>\n";
		echo "<a href=\"javascript:window.print()\"><i class='fa fa-print' alt=\"$mess[27]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<a href=\"index.${phpExt}?action=downloadfile&filename=$filename&directory=$directory\"><i class='fa fa-download' alt=\"$mess[23]\" width=\"20\" height=\"20\" border=\"0\"> &nbsp;&nbsp;</i></a>";
		echo "<a href=\"javascript:window.close()\"><i class='fa fa-chevron-left' alt=\"$mess[28]\" border=\"0\"> &nbsp;&nbsp;</i></a>\n";
		echo "<hr></center>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
		break;

	case 'upload';
		$message = $mess[40];
		
		for ($i = 0; $i < count($userfile['name']); $i++) {
				
				$userfile_name = $userfile['name'][$i];
				$userfile_size = $userfile['size'][$i];
				$destination = $uploads_folder_name."/$directory";
		
				if (!$grants[$user_status][UPLOAD])
				{
					place_header(sprintf($mess[49], "<b>$userfile_name</b>"));
					include("../menu.php");
					show_contents();
					include("../pie.php");
					break;
				}
		
				if (!is_path_safe($directory, $userfile_name))
				{
					place_header(sprintf($mess[49], "<b>$userfile_name</b>"));
					include("../menu.php");
					show_contents();
					include("../pie.php");
					break;
				}
		
				if ($userfile_name == '')
				{
					$message = $mess[34];
				}
		
				if ($userfile_size != 0)
				{
					$size_kb = $userfile_size/1024;
				}
				else
				{
					$message = $mess[34];
					$size_kb = 0;
				}
		
				if ($userfile_name != '' && $userfile_size !=0)
				{
					$userfile_name = normalize_filename($userfile_name);
					if (file_exists("$destination/$userfile_name") || eregi($rejectedfiles, $userfile_name) || ($size_kb > $max_allowed_filesize))
					{
						if ($size_kb > $max_allowed_filesize)
							$message="$mess[38] <b>$userfile_name</b> $mess[50] ($max_allowed_filesize Kb)!";
						else
							if (eregi($rejectedfiles, $userfile_name))  // If file is script
								$message=sprintf($mess[49], "<b>$userfile_name</b>");
							else
								$message="$mess[38] <b>$userfile_name</b> $mess[39]";
					}
					else
					{
						if (($user_status != ANONYMOUS) && ($logged_user_name != ''))  // Update user statistics
						{
							list($files_uploaded, $files_downloaded, $files_emailed) = load_userstat($logged_user_name);
							$files_uploaded++;
							save_userstat($logged_user_name, $files_uploaded, $files_downloaded, $files_emailed, time());
						}
		
						// Save description
						$ip = getenv('REMOTE_ADDR');
		
						if (!move_uploaded_file($userfile['tmp_name'][$i], "$destination/$userfile_name"))
							$message="$mess[33] $userfile_name";
						else
							$message="$mess[36] <b>$userfile_name</b> $mess[37]";
						chmod("$destination/$userfile_name",0777);
						}
				}
				
		}
				
	  include("../menu.php");
	  show_contents();
	  include("../pie.php");
		break;


	case 'webcopy';

		$message = $mess[40];

		$destination = $uploads_folder_name."/$directory";
		$filename = normalize_filename(basename($filename));

		if (!$grants[$user_status][WEBCOPY])
		{
			place_header(sprintf($mess[49], "<b>$filename</b>"));
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (!is_path_safe($directory, $filename))
		{
			place_header(sprintf($mess[49], "<b>$filename</b>"));
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (!eregi("^http://|^ftp://", $fileurl))
		{
			place_header($mess[202]);
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if ($filename == '')
		{
			place_header($mess[34]);
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (file_exists("$destination/$filename") || eregi($rejectedfiles, basename($filename)))
		{
			place_header("$mess[38] <b>$filename</b> $mess[39]");
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;

		}

		if (eregi($rejectedfiles, basename($filename)))
		{
			place_header(sprintf($mess[49], "<b>$filename</b>"));
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}


	case 'rename';

		$userfile = normalize_filename($userfile);

		$current_dir = $uploads_folder_name;
		if ($directory != '')
			$current_dir.="/$directory";

		if (!file_exists("$current_dir/$filename"))
		{
			place_header($mess[125]);
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		if (is_dir("$current_dir/$filename"))
		{
	      	if (eregi($hidden_dirs, $userfile) && !$showhidden)
	      	{
	      		place_header($mess[206]);
	      		include("../menu.php");
	      		show_contents();
	      		include("../pie.php");
				break;
	      	}
      	}

		if (!is_path_safe($directory, $filename) || !is_path_safe($directory, $userfile))
		{
			place_header($mess[201]);
			include("../menu.php");
			show_contents();
			include("../pie.php");
			break;
		}

		list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$filename", $comment_max_caracters);

		if ($grants[$user_status][MODALL] || ($upl_user == $logged_user_name && $grants[$user_status][MODOWN]))
		{
			if (!eregi($rejectedfiles, $userfile))
			{
				if (!file_exists("$current_dir/$userfile") || $filename == $userfile)
				{
					if ($filename != $userfile)
					{
						if (file_exists("$current_dir/$filename"))
						{
						
							if(! is_dir("$current_dir/$filename")) {
								$filetype = end(explode(".", $filename));
								$userfile2 = str_replace('.'.$filetype, '', $userfile);
								
								rename("$current_dir/$filename", "$current_dir/$userfile2.$filetype");
							}
							else {
								rename("$current_dir/$filename", "$current_dir/$userfile");
							}
							
							
						}
					}

					if (!is_dir("$current_dir/$userfile") && ($old_description != $new_description))
					{
						list($upl_user, $upl_ip, $contents) = get_file_description("$current_dir/$userfile", 0, 0);
					}
				}
			}
		}


	  include("../menu.php");
		show_contents();
		include("../pie.php");
		break;

	default;
	    
	  include("../menu.php");
	  show_contents();
	  include("../pie.php");
		break;
}
?>

