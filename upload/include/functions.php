<?php

if ( !defined('IN_PHPATM') )
{
	die("Hacking attempt");
}

//
//
function clean_path($path)
{

	$path = str_replace("\\", "/", stripslashes($path));
	$path = explode('/', $path);

	$del = 0;
	if (true==true)
	{
		reset($path);
		while (list($key, $value) = each($path))
		{
			if ($value == "." || $value == "..")
			{
				array_splice($path, $key - $del, 1);
				$del++;
			}
		}
	}
	else
	{
		if ($path == "." || $path == "..")
		{
			$path = '';
		}
	}

	$path = implode('/', $path);

	return $path;
}
//
function is_viewable($filename)
{
	if(eregi('\.txt$|\.sql$|\.php$|\.php3$|\.phtml$|\.htm$|\.html$|\.cgi$|\.pl$|\.js$|\.css$|\.inc$', $filename))
		return TRUE;

	return FALSE;
}

//
//
function is_image($filename)
{
	if (eregi("\.png$|\.bmp$|\.jpg$|\.jpeg$|\.gif$", $filename))
		return TRUE;

	return FALSE;
}

//

//
function is_browsable($filename)
{
	if(eregi("\.zip$", $filename))
		return TRUE;

	return FALSE;
}

//

function count_file_download($filename)
{
	if (file_exists("$filename.dlcnt"))
	{
		$fp = fopen("$filename.dlcnt",'r');
		$count = fread($fp, 15);
		fclose($fp);
		return $count;
	}

	return 0;
}

//

function get_mimetype_img($filename)
{
	global $mimetypes;


	if (is_dir($filename))
	{
		return $mimetypes['directory']['img'];
	}
	else
	{
		reset($mimetypes);
		while (list($key, $value) = each($mimetypes))
		{
			if (eregi($key.'$', $filename))
			{
				return $value['img'];
			}
		}
	}

	return $mimetypes['default']['img'];
}

//

//
function mime_type($filename)
{
	global $mimetypes;

	reset($mimetypes);
	while (list($key, $value) = each($mimetypes))
	{
		if (eregi($key.'$', $filename))
		{
			return $value['mime'];
		}
	}

	return $mimetypes['default']['mime'];
}

//
//
//
function get_filesize($filename)
{
	$size = filesize($filename);

	if ($size >= 1073741824)
		$size = intval(round($size / 1073741824 * 100) / 100) . ' GB';
	elseif ($size >= 1048576)
		$size = intval(round($size / 1048576 * 100) / 100) . ' MB';
	elseif ($size >= 1024)
		$size = intval(round($size / 1024 * 100) / 100) . ' KB';
	elseif ($size > 0)
		$size = intval($size) . ' B';
	else
		$size = '-';

	return $size;
}

//
//
function show_hidden_files($filename)
{
	global $showhidden;

	if (substr($filename, 0, 1) == '.' && $showhidden == false)
		return false;

	return true;
}

//
//
function save_file_description($filename, $description, $logged_user_name, $ip)
{
	$description = stripslashes($description);

	$fp=fopen($filename, 'w');
	fputs($fp, $logged_user_name."\n");
	fputs($fp, $ip."\n");
	fputs($fp, $description);
	fclose($fp);
}

//
//
function get_file_description($filename, $max_caracters = 0, $replacecharacters = 1)
{
	if (!file_exists("$filename.desc"))
		return array('','','');

	if ($max_caracters == 0)
		$max_caracters = filesize("$filename.desc");

	$fp = @fopen("$filename.desc",'r');

	$upl_user = rtrim(fgets($fp, 255));
	$upl_ip = rtrim(fgets($fp, 255));

	$contents = fread ($fp, $max_caracters);
	fclose($fp);
	if ($replacecharacters)
	{
		$contents = str_replace('&',    '&amp;',  $contents);
		$contents = str_replace('<',    '&lt;',   $contents);
		$contents = str_replace('>',    '&gt;',   $contents);
		$contents = str_replace('\"',   '&quot;', $contents);
		$contents = str_replace('\x0D', '',       $contents);
		$contents = str_replace('\x0A', ' ',      $contents);
		$contents = str_replace('_',    ' ',      $contents);
	}

	return array($upl_user, $upl_ip, $contents);
}

//
//
function page_header($title)
{
  global $charsetencoding,$skins,$skinindex,$headerpage;

  $bodytag = $skins[$skinindex]["bodytag"];
  echo "<html><head><title>$title</title>";
  echo "<link rel=\"stylesheet\" href=\"../css/bootstrap.css\" type=\"text/css\">";
  if ($charsetencoding != "")
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
  echo "<style type=\"text/css\"></style></head><body>";
  if (file_exists($headerpage))
    include($headerpage);        
}

//
//
function place_message($title, $message, $link)
{
	global $phpExt;
	global $mess, $font, $normalfontcolor, $selectedfontcolor, $homeurl;
	global $uploadcentercaption, $logged_user_name, $user_status, $page_title;
	global $tablecolor, $bordercolor, $headercolor, $headerfontcolor;

	if ($logged_user_name == '' || !check_is_user_session_active($logged_user_name))
	{
		$logged_user_name = 'root';
		$user_status = ANONYMOUS;
	}

	page_header($page_title);

	echo "
	<div align=\"center\">
	  <table border=\"0\" width=\"90%\" bgcolor=\"$bordercolor\" cellpadding=\"4\" cellspacing=\"1\">
	    <tr>
	      <td align=\"left\" bgcolor=\"$headercolor\" colspan=\"4\">
	        <table border=\"0\" width=\"100%\">
	          <tr>
	            <th align=\"left\" bgcolor=\"$headercolor\" valign=\"middle\" width=\"50%\">
	              <h2><font color=\"$headerfontcolor\" size=\"5\"><b>$uploadcentercaption</b></font></h1>
	            </th>
	            <td align=\"right\" bgcolor=\"$headercolor\" valign=\"middle\" width=\"50%\" nowrap>
	              <p><font face=\"$font\" size=\"1\" color=\"$headerfontcolor\">
	                $title</font></p>
	            </td>
	          </tr>
	        </table>
	      </td>
	    </tr>

	    <tr>
	      <td align=\"left\" bgcolor=\"$tablecolor\" valign=\"middle\">
	        <table border=\"0\" width=\"100%\">
	          <tr>
	            <th align=\"left\" valign=\"middle\" width=\"90%\">
	              <font size=\"1\" face=\"$font\" color=\"$selectedfontcolor\">&raquo;</font>

	              <font size=\"1\" face=\"$font\" color=\"$normalfontcolor\">
	";

	if ($user_status == ANONYMOUS)
		echo $message;
	else
		echo $logged_user_name.": ".$message;

	echo "      	</font>
				</th>
	            <td align=\"right\" valign=\"middle\" width=\"10%\">
	              <a href=\"$homeurl\"><img src=\"images/home.gif\"  align=\"ABSMIDDLE\" alt=\"$mess[25]\" border=\"0\" /></a>&nbsp;
	              <a href=\"$link?".SID."\"><img src=\"images/refresh.gif\"  align=\"ABSMIDDLE\" alt=\"$mess[97]\" border=\"0\" /></a>&nbsp;";
	if ($user_status == ADMIN)
	{
		echo "    <a href=\"configure.".$phpExt."?".SID."\"><img src=\"images/config.gif\"  align=\"ABSMIDDLE\" alt=\"$mess[132]\" border=\"0\" /></a>&nbsp;
				  <a href=\"usrmanag.".$phpExt."?".SID."\"><img src=\"images/users.gif\"  align=\"ABSMIDDLE\" alt=\"$mess[137]\" border=\"0\" /></a>&nbsp;";
	}
	if ($user_status != ANONYMOUS)
	{
		echo "    <a href=\"login.".$phpExt."?".SID."\"><img src=\"images/user.gif\"  align=\"ABSMIDDLE\" alt=\"$mess[81]\" border=\"0\" /></a>&nbsp;";
	}
	echo "       </td>
	             <td align=\"right\" valign=\"middle\" width=\"10%\">";

	// Show login/logout message

	echo '
	            </td>
	          </tr>
	        </table>
	      </td>
	   </tr>
	</table>
	<br>
	';
}

function load_user_profile($username)
{
  global $users_folder_name, $enc_user_pass, $enc_logged_user_id, $user_email;
  global $user_status, $activationcode, $user_temp_info, $user_wish_receive_digest;
  global $default_user_status,$user_account_creation_time, $language, $dft_language;

  $enc_user_pass = '';
  $enc_logged_user_id = 0;
  $user_email = '';
  $user_status = ANONYMOUS;
  $activationcode = USER_DISABLED;
  $user_temp_info = '';
  $user_wish_receive_digest = 0;
  $user_account_creation_time = 0;
  $language = $dft_language;

  $userfilename = "$users_folder_name/$username";
  if (!file_exists($userfilename))
  {
    return;
  }

  $fp=@fopen($userfilename,"r");
  if($fp)
  {
    if(!feof($fp))
      $enc_user_pass=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $enc_logged_user_id=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $user_email=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $user_status=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $activationcode=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $user_temp_info=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $user_wish_receive_digest=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $user_account_creation_time=rtrim(fgets($fp, 255));
    if(!feof($fp))
      $language=rtrim(fgets($fp, 255));
  }

  fclose($fp);

  if ($language == '')
  	$language = $dft_language;
}


function save_user_profile($username)
{
  global $users_folder_name, $enc_user_pass, $enc_logged_user_id, $user_email;
  global $user_status, $activationcode, $user_temp_info, $user_wish_receive_digest;
  global $user_account_creation_time, $language;

  $userfilename = "$users_folder_name/$username";
  $fp = fopen($userfilename, "w+"); // File named as User Name
  fwrite($fp, $enc_user_pass);      // 1st line: Encrypted user password
  fwrite($fp, "\n");
  fwrite($fp, $enc_logged_user_id); // 2nd line: Encrypted user session ID, 0 - if user logged out
  fwrite($fp, "\n");
  fwrite($fp, $user_email);         // 3rd line: User E-Mail address
  fwrite($fp, "\n");
  fwrite($fp, $user_status);    // 4 line: account status: 0 - Administrator, 1 - Power User, 2 - Normal User, 3 - Viewer (view only), 4 - Uploader (upload only)
  fwrite($fp, "\n");
  fwrite($fp, $activationcode); // 5 line: 1 - if account active, 0 - if disabled, other value - activation code
  fwrite($fp, "\n");
  fwrite($fp, $user_temp_info); // 6 line: any temporary information
  fwrite($fp, "\n");
  fwrite($fp, $user_wish_receive_digest);  // 7 line: User wish to receive files digest via e-mail
  fwrite($fp, "\n");
  fwrite($fp, $user_account_creation_time);  // 8 line: The time when user account created
  fwrite($fp, "\n");
  fwrite($fp, $language);  // 
  fwrite($fp, "\n");
  fclose($fp);
}

function check_is_user_session_active($username)
{
  global $logged_user_id, $enc_logged_user_id;

  load_user_profile($username);
  if (!empty($enc_logged_user_id) && (md5($logged_user_id) == $enc_logged_user_id))
  	return true;

  return false;
}

function check_user_password($username, $password)
{
  global $users_folder_name,$enc_user_pass;
  // Check user session id
  $userfilename = "$users_folder_name/$username";
  load_user_profile($username);
  return (md5($password) == $enc_user_pass);
}

function change_skin()
{
  global $HTTP_GET_VARS, $skinindex, $skins, $bordercolor, $headercolor, $tablecolor;
  global $lightcolor, $headerfontcolor, $normalfontcolor, $selectedfontcolor;
  global $cookiepath, $cookiedomain, $cookievalidity;

  $skinindex=$HTTP_GET_VARS["skinindex"];
  if ($skinindex > count($skins))
    $skinindex = 0;
  setcookie("skinindex",$skinindex,time() + $cookievalidity * 3600);
  $bordercolor=$skins[$skinindex]["bordercolor"];
  $headercolor = $skins[$skinindex]["headercolor"];
  $tablecolor=$skins[$skinindex]["tablecolor"];
  $lightcolor=$skins[$skinindex]["lightcolor"];
  $headerfontcolor=$skins[$skinindex]["headerfontcolor"];
  $normalfontcolor=$skins[$skinindex]["normalfontcolor"];
  $selectedfontcolor=$skins[$skinindex]["selectedfontcolor"];
}

function generate_password()
{
  // Generate new password
  $consonants="BCDFGHJKLMNPQRSTWXVZ";
  $vowels="AEIOUY";
  mt_srand((double)microtime()*1000000);
  $leng=mt_rand(3,5);
  $newpass="";
  for ($i = 0; $i < $leng; $i++)
  {
    mt_srand((double)microtime()*1000000);
    $newpass.=$consonants[mt_rand(0,19)].$vowels[mt_rand(0,5)];
  }
  return $newpass;
}

function userslist($order = "name")
{
  global $users_folder_name, $user_account_creation_time, $user_status, $activationcode, $user_wish_receive_digest, $user_email;
  $userslist = "";
  // Browse each user
  $handle=opendir($users_folder_name);
  while (false !== ($filename = readdir($handle)))
  {
    if (substr($filename,0,1) != '.' && !eregi('^index\.', $filename))
    {
      if (!is_dir("$users_folder_name/$filename"))
      {
        if ($order == "name")
          $userslist[$filename] = $filename;
        else
        {
          if (($order == "uploaded") || ($order == "downloaded") || ($order == "emailed") || ($order == "access"))
          {
            list($files_uploaded, $files_downloaded, $files_emailed, $last_acess_time) = load_userstat($filename);
            if ($order == "uploaded")
              $userslist[$filename] = $files_uploaded;
            if ($order == "downloaded")
              $userslist[$filename] = $files_downloaded;
            if ($order == "emailed")
              $userslist[$filename] = $files_emailed;
            if ($order == "access")
              $userslist[$filename] = $last_acess_time;
          }
          else
          {
            load_user_profile($filename);
            if ($order == "date")
              $userslist[$filename] = $user_account_creation_time;
            if ($order == "status")
              $userslist[$filename] = $user_status;
            if ($order == "activestatus")
              $userslist[$filename] = $activationcode;
            if ($order == "receivedigest")
              $userslist[$filename] = $user_wish_receive_digest;
            if ($order == "email")
              $userslist[$filename] = $user_email;
          }
        }
      }
    }
  }
  closedir($handle);
  if (($order == "uploaded") || ($order == "downloaded") || ($order == "emailed"))
    arsort($userslist);
  else
    asort($userslist);
  return $userslist;
}

function load_userstat($username)
{
  global $userstat_folder_name;
  $files_uploaded = 0;
  $files_downloaded = 0;
  $files_emailed = 0;
  $last_acess_time = 0;

  $userfilename = "$userstat_folder_name/$username.stat";
  if (file_exists($userfilename))
  {
    $fp=@fopen($userfilename,"r");
    if($fp)
    {
      if(!feof($fp))
        $files_uploaded=rtrim(fgets($fp, 255));
      if(!feof($fp))
        $files_downloaded=rtrim(fgets($fp, 255));
      if(!feof($fp))
        $files_emailed=rtrim(fgets($fp, 255));
      if(!feof($fp))
        $last_acess_time=rtrim(fgets($fp, 255));
    }
    fclose($fp);
  }
  return array($files_uploaded, $files_downloaded, $files_emailed, $last_acess_time);
}

function save_userstat($username, $files_uploaded, $files_downloaded, $files_emailed, $last_acess_time)
{
  global $userstat_folder_name;

  $userfilename = "$userstat_folder_name/$username.stat";
  $fp=fopen($userfilename,"w+");
  if($fp)
  {
    fwrite($fp, $files_uploaded);
    fwrite($fp, "\n");
    fwrite($fp, $files_downloaded);
    fwrite($fp, "\n");
    fwrite($fp, $files_emailed);
    fwrite($fp, "\n");
    fwrite($fp, $last_acess_time);
    fwrite($fp, "\n");
  }
  fclose($fp);
}

class MIME_MAIL {
  var $attachments = array();
  var $from = "";
  var $subject = "";
  var $body = "";
  var $charset = "";

  function MIME_MAIL($from = "", $subject = "", $body = "", $charset = "")
  {
    $this->from = $from;
    $this->subject = $subject;
    $this->body = $body;
    $this->charset = $charset;
  }

  function attachment($name = "", $contents = "",
                      $type = "application/octet-stream", $encoding = "base64")
  {
    $this->attachments[] = array("filename" => $name,
                                 "type" => $type,
                                 "encoding" => $encoding,
                                 "data" => $contents);
  }


  function _build()
  {
    mt_srand((double)microtime()*1000000);
    $boundary = '--b'.md5(uniqid(mt_rand())) . getmypid();

    if ($this->from != "")
      $ret = "From: " . $this->from . "\n";
    else
      $ret = "";

    $ret .= "MIME-Version: 1.0\n";
    $ret .= "Content-Type: multipart/mixed; ";
    $ret .= "boundary=\"$boundary\"\n\n";


    $ret .= "This is a MIME encoded message. \n\n";
    $ret .= "--$boundary\n";

    $ret .= "Content-Type: text/plain";
    if ($this->charset != "")
      $ret .= "; charset=$this->charset";

    $ret .= "\n";
    $ret .= "Content-Transfer-Encoding: 8bit\n\n";
    $ret .= $this->body . "\n--$boundary";

    foreach($this->attachments as $attachment)
    {
      $attachment["data"] = base64_encode($attachment["data"]);
      $attachment["data"] = chunk_split($attachment["data"]);
      $data =
        "Content-Type: $attachment[type]";
        if ($attachment["filename"] != "")
          $data .= "; name = \"$attachment[filename]\"";
        else
          $data .= "";
        $data .= "\n" .
        "Content-Transfer-Encoding: $attachment[encoding]" .
        "\n\n$attachment[data]\n";
      $ret .= "\n$data\n--$boundary";
    }
    $ret .= "--\n";
    return($ret);
  }

  function send($to)
  {
  	global $use_smtp, $phpExt;

  	if (!$use_smtp)
	{
		$result = @mail($to, $this->subject, ' ', $this->_build());
	}
	else
	{
		if (!defined('SMTP_INCLUDED'))
		{
			include('include/smtp.'.$phpExt);
		}
		$result = smtpmail($to, $this->subject, ' ', $this->_build());
	}

	return $result;

  }


  function add_html($html_message)
  {
    $this->attachment("", $html_message, "text/html");
  }


function add_file($filename)
{
    if (!file_exists($filename))
      return;
    $fp=@fopen($filename,"rb");
    $contents = fread($fp, filesize($filename));
    fclose($fp);
    $this->attachment(basename($filename), $contents, mime_type($filename));
  }

} // Enc of class MIME_MAIL

//
// Dato un percorso in input, lo spezza creando la barra di naviagazione
//
function split_dir($directory)
{
	global $index;
	global $uploads_folder_name, $direction, $order, $phpExt;

	$directory = clean_path($directory);
	if (!file_exists("$uploads_folder_name/$directory"))
	{
		$directory = '';
	}

	$arr = explode("/", $directory);

	$address = '';
	$nav="<a href=\"index.${phpExt}?index=$index&direction=$direction&order=$order\">Inicio</a>";
	foreach ($arr as $value)
	{
		if ($address == '')
			$address.="$value";
		else
			$address.="/$value";
		$nav.=" / <a href=\"index.${phpExt}?index=$index&direction=$direction&order=$order&directory=$address\">$value</a>";
	}

	return($nav);
}

function show_footer_page()
{
	global $footerpage;

	echo "	<center>
			   <br>
			   <a href=\"http://phpatm.free.fr\">
			   <font size=1 face=\"Verdana\" color=\"#888888\">
			      Powered by PHP Advanced Transfer Manager v".PROGRAM_VERSION." - @2002 Bugada Andrea
			    </font>
			    </a>
			    <br>
			</center>
		";
//	include($footerpage);
	echo "</body></html>";
}

//
// Entra nella directory languages e ritorna l'array delle lingue trovate
//
function available_languages($folder)
{
	$languages = array();
	$handle = opendir($folder);
	while (false !== ($filename = readdir($handle)))
	{
		if (eregi('\.lang$', $filename))
		{
			$fp = @fopen("$folder/$filename", "r");
	  		if ($fp)
	  		{
	    		if (!feof($fp))
	      			$lang_id = rtrim(fgets($fp, 255));
	    		if (!feof($fp))
	      			$lang_name = rtrim(fgets($fp, 255));
	    		if (!feof($fp))
	      			$lang_time = rtrim(fgets($fp, 255));
			}
			fclose($fp);
			$languages[$lang_id]['LangName'] = $lang_name;
			$languages[$lang_id]['TimeZone'] = $lang_time;
		}
	}
	closedir($handle);
	asort($languages);
	return $languages;
}

function is_ip_blocked($user_ip)
{
	global $ip_black_list;

	if (is_array($ip_black_list))
	{
		reset($ip_black_list);
		while (list(, $value) = each($ip_black_list))
		{
			if (ereg($value, $user_ip))
			{
				return true;
			}
		}
	}
	return false;
}

?>
