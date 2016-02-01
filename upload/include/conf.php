<?php

if ( !defined('IN_PHPATM') )
{
	die("Hacking attempt");
}

//
//
$phpExt = 'php';

//
//
include('include/constants.'.$phpExt);
//include("../../config.php");
//
//
$homeurl = $config['dominio']."/intranet/upload/index.php";

//
$admin_name = 'Admin';

//
//
$admin_email = 'admin@'.$config['dominio'];

//
$use_smtp = false;
$smtp_host ='mail';
$smtp_username = 'admin';
$smtp_password = '';

//

$domain_name = $config['dominio'];
$script_folder_path = 'intranet/upload/';
$installurl = 'http://' . $domain_name . '/' . $script_folder_path;

//
$users_folder_name = 'users';
$userstat_folder_name = 'userstat';

switch ($_GET['index']) {
	default :
	case 'publico' : $uploads_folder_name = $config['mod_documentos_dir']; $index="publico"; break;
	case 'privado' : $uploads_folder_name = '../varios/'.$_SESSION['ide'].'/'; $index="privado"; break;
}

$languages_folder_name = 'languages';

//

$cookiedomain = '';
$cookiepath = '';
$cookiesecure = false;
$cookievalidity = 8760; //hours

//  STATUS    => array(view,    modown,  delown,  download, mail,    upload,  mkdir,   modall,  delall,  mailall,  webcopy)
//                       V        V        V        V         V        V        V        V        V        V         V
if(stristr($_SESSION['cargo'],'1') == TRUE){
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
elseif(strstr(rawurldecode(str_replace($caracteres_no_permitidos, $caracteres_permitidos, $_GET['directory'])), str_replace($caracteres_no_permitidos, $caracteres_permitidos, $_SESSION['dpt'])) == TRUE)
{
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
elseif($_GET['index']=='privado') {
$grants = array(
	POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
);
}
else
{
$grants = array(
	POWER     => array(TRUE,    FALSE,    FALSE,    TRUE,     FALSE,    FALSE,    FALSE,    FALSE,    FALSE ,   FALSE,     FALSE ),
);
}

// PERMISOS PARA BIBLIOTECA Y RECURSOS EDUCATIVOS
$exp_dir = explode('/', $_GET['directory']);

if($exp_dir[0] == 'Biblioteca' && (stristr($_SESSION['cargo'],'c') == TRUE)) {
	$grants = array(
		POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
	);
}

if($exp_dir[0] == 'Recursos educativos' && in_array($exp_dir[1], $unidades)) {
	$grants = array(
		POWER     => array(TRUE,    TRUE,    TRUE,    TRUE,     TRUE,    TRUE,    TRUE,    TRUE,    TRUE ,   TRUE,     TRUE ),
	);
}


//
$default_user_status = ANONYMOUS;

//
$page_title = 'Archivos del '.$config['centro_denominacion'];

//
$GMToffset = date('Z')/3600;

$maintenance_time = 2;

//

$mail_functions_enabled = false;

//
$max_filesize_to_mail = 10000;

$require_email_confirmation = false;

//
$max_last_files = 12;

//
$max_topdownloaded_files = 10;

//
$dft_language = 'es';


//
$max_allowed_filesize = 50000;

//
$direction = 1;


//
$datetimeformat = 'd/m/Y H:i';

//
$file_name_max_caracters = 150;

//
$file_out_max_caracters = 50;

//
//
$comment_max_caracters = 300;

//

$rejectedfiles = "^index\.|\.desc$|\.dlcnt$|\.php$|\.php3$|\.cgi$|\.pl$";

//
$showhidden = false;

//
//
$hidden_dirs = "^_vti_";

//
$skins = array(
  array(
    'bordercolor' => '#A7BFFE',    // The table border color
    'headercolor' => '#FFFFCC',    // The table header color
    'tablecolor' => '#ffffff',     // The table background color
    'lightcolor' => '#FFFFFF',     // Table date field color
    'headerfontcolor' => '#CC3333',
    'normalfontcolor' => '#000000',
    'selectedfontcolor' => '#4682B4',
    'bodytag' => "bgcolor=\"#E5E5E5\" text=\"#000000\" link=\"#000000\" vlink=\"#333333\" alink=\"#000000\""
  )
);

//
$font = 'Verdana';

//
//
$mimetypes = array (
// text
'.css'  => array('img' => 'fa-file-code-o',    'mime' => 'text/css'),
'.djvu' => array('img' => 'fa-file-o',   'mime' => 'image/vnd.djvu'),
'.epub' => array('img' => 'fa-file-o',   'mime' => 'application/epub+zip'),
'.html' => array('img' => 'fa-file-code-o',   'mime' => 'text/html'),
'.htm'  => array('img' => 'fa-file-code-o',   'mime' => 'text/html'),
'.log'  => array('img' => 'fa-file-text-o',    'mime' => 'text/plain'),
'.php'  => array('img' => 'fa-file-code-o',    'mime' => 'text/php'),
'.rtf'  => array('img' => 'fa-file-text-o',    'mime' => 'application/rtf'),
'.sql'  => array('img' => 'fa-file-code-o',    'mime' => 'application/x-sql'),
'.txt'  => array('img' => 'fa-file-text-o',    'mime' => 'text/plain'),
'.xml'  => array('img' => 'fa-file-code-o',    'mime' => 'application/xml'),

// documents
'.csv'  => array('img' => 'fa-file-word-o',    'mime' => 'text/csv'),
'.doc'  => array('img' => 'fa-file-word-o',    'mime' => 'application/msword'),
'.dot'  => array('img' => 'fa-file-word-o',    'mime' => 'application/msword'),
'.docx' => array('img' => 'fa-file-word-o',   'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
'.pdf'  => array('img' => 'fa-file-pdf-o',    'mime' => 'application/pdf'),
'.ppt'  => array('img' => 'fa-file-powerpoint-o',    'mime' => 'application/vnd.ms-powerpoint'),
'.pps'  => array('img' => 'fa-file-powerpoint-o',    'mime' => 'application/vnd.ms-powerpoint'),
'.pot'  => array('img' => 'fa-file-powerpoint-o',    'mime' => 'application/vnd.ms-powerpoint'),
'.pptx' => array('img' => 'fa-file-powerpoint-o',   'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'),
'.ppsx' => array('img' => 'fa-file-powerpoint-o',   'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'),
'.pub'  => array('img' => 'fa-file-o',    'mime' => 'application/x-mspublisher'),
'.odt'  => array('img' => 'fa-file-word-o',    'mime' => 'application/vnd.oasis.opendocument.text'),
'.ott'  => array('img' => 'fa-file-word-o',    'mime' => 'application/vnd.oasis.opendocument.text-template'),
'.ods'  => array('img' => 'fa-file-excel-o',    'mime' => 'application/vnd.oasis.opendocument.spreadsheet'),
'.ots'  => array('img' => 'fa-file-excel-o',    'mime' => 'application/vnd.oasis.opendocument.spreadsheet-template'),
'.odp'  => array('img' => 'fa-file-powerpoint-o',    'mime' => 'application/vnd.oasis.opendocument.presentation'),
'.otp'  => array('img' => 'fa-file-powerpoint-o',    'mime' => 'application/vnd.oasis.opendocument.presentation-template'),
'.xls'  => array('img' => 'fa-file-excel-o',    'mime' => 'application/vnd.ms-excel'),
'.xlsx' => array('img' => 'fa-file-excel-o',   'mime' => 'application/vnd.ms-excel'),

// image

'.bmp'  => array('img' => 'fa-file-image-o',    'mime' => 'image/bmp'),
'.gif'  => array('img' => 'fa-file-image-o',    'mime' => 'image/gif'),
'.ico'  => array('img' => 'fa-file-image-o',    'mime' => 'image/x-icon'),
'.jpg'  => array('img' => 'fa-file-image-o',    'mime' => 'image/jpeg'),
'.jpeg' => array('img' => 'fa-file-image-o',   'mime' => 'image/jpeg'),
'.png'  => array('img' => 'fa-file-image-o',    'mime' => 'image/png'),
'.skp'  => array('img' => 'fa-file-image-o',    'mime' => 'application/vnd.koan'),
'.tiff' => array('img' => 'fa-file-image-o',   'mime' => 'image/tiff'),
'.tif'  => array('img' => 'fa-file-image-o',   'mime' => 'image/tiff'),

// compression
'.gz'   => array('img' => 'fa-file-archive-o',     'mime' => 'application/x-compressed'),
'.rar'  => array('img' => 'fa-file-archive-o',    'mime' => 'application/x-rar-compressed'),
'.tar'  => array('img' => 'fa-file-archive-o',    'mime' => 'application/x-tar'),
'.tgz'  => array('img' => 'fa-file-archive-o',    'mime' => 'application/x-compressed'),
'.zip'  => array('img' => 'fa-file-archive-o',    'mime' => 'application/zip'),

// compression images
'.dmg'  => array('img' => 'fa-file',    'mime' => 'application/x-apple-diskimage'),
'.iso'  => array('img' => 'fa-file',    'mime' => 'application/x-iso9660-image'),

// executable
'.deb'  => array('img' => 'fa-file',    'mime' => 'application/x-debian-package'),
'.exe'  => array('img' => 'fa-file',    'mime' => 'application/x-msdownload'),
'.msi'  => array('img' => 'fa-file',    'mime' => 'application/x-msdownload'),
'.xpi'  => array('img' => 'fa-file',    'mime' => 'application/x-xpinstall'),


// audio
'.mid'  => array('img' => 'fa-file-audio-o',   'mime' => 'audio/mid'),
'.midi' => array('img' => 'fa-file-audio-o',   'mime' => 'audio/mid'),
'.m4a'  => array('img' => 'fa-file-audio-o',    'mime' => 'audio/mp4'),
'.mp3'  => array('img' => 'fa-file-audio-o',    'mime' => 'audio/mpeg'),
'.ogg'  => array('img' => 'fa-file-audio-o',    'mime' => 'audio/ogg'),
'.wav'  => array('img' => 'fa-file-audio-o',    'mime' => 'audio/x-wav'),

// video
'.3g2'  => array('img' => 'fa-file-video-o',    'mime' => 'video/3gpp2'),
'.3gp'  => array('img' => 'fa-file-video-o',    'mime' => 'video/3gpp'),
'.asf'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-ms-asf'),
'.avi'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-msvideo'),
'.flv'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-flv'),
'.m4v'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-m4v'),
'.mkv'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-matroska'),
'.mp4'  => array('img' => 'fa-file-video-o',    'mime' => 'video/mp4'),
'.mpg'  => array('img' => 'fa-file-video-o',   'mime' => 'video/mpeg'),
'.mpeg' => array('img' => 'fa-file-video-o',   'mime' => 'video/mpeg'),
'.mov'  => array('img' => 'fa-file-video-o',     'mime' => 'video/quicktime'),
'.ogv'  => array('img' => 'fa-file-video-o',    'mime' => 'video/ogg'),
'.qt'   => array('img' => 'fa-file-video-o'  ,   'mime' => 'video/quicktime'),
'.wmv'  => array('img' => 'fa-file-video-o',    'mime' => 'video/x-ms-wmv'),

// tipography
'.ttf'  => array('img' => 'fa-file-text',    'mime' => 'application/x-font-ttf'),

// postscript
'.ai'   => array('img' => 'fa-file-image-o',     'mime' => 'application/postscript'),
'.psd'  => array('img' => 'fa-file-image-o',    'mime' => 'image/vnd.adobe.photoshop'),
'.eps'  => array('img' => 'fa-file-image-o',    'mime' => 'application/postscript'),
'.ps'   => array('img' => 'fa-file-image-o',    'mime' => 'application/postscript'),

// directoy and default
'directory' => array('img' => 'fa-folder-o', 'mime' => ''),
'default' =>   array('img' => 'fa-file-o',  'mime' => 'application/octet-stream')
);

//
$invalidchars = array (
"'",
"\"",
"\"",
'&',
',',
';',
'/',
"\\",
'`',
'<',
'>',
':',
'*',
'|',
'?',
'+',
'^',
'(',
')',
'=',
'$',
'%'
);

//
//$ip_black_list = array (
//'127.0.0.2',
//'127.0.0.3',
//);

?>
