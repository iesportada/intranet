<?php

if ( !defined('IN_PHPATM') )
{
	die("Hacking attempt");
}

// 
define('PROGRAM_VERSION', '1.10');


define('ANONYMOUS', 1);
define('ADMIN',      0);
define('www',      0);
define('POWER',      1);
define('NORMAL',     2);
define('VIEWER',     3);
define('UPLOADER',   4);


define('VIEW',      0);
define('MODOWN',    1);
define('DELOWN',    2);
define('DOWNLOAD',  3);
define('MAIL',      4);
define('UPLOAD',    5);
define('MKDIR',     6);
define('MODALL',    7);
define('DELALL',    8);
define('MAILALL',   9);
define('WEBCOPY',  10);


define('USER_DISABLED', 1);
define('USER_ACTIVE',   1);


define('ORDER_NAME', 0);
define('ORDER_SIZE', 1);
define('ORDER_MOD',  2);
define('ORDER_DL',   3);
define('ORDER_TYPE', 4);


define('ACTION_SAVELANGUAGE', 'savelanguage');
define('ACTION_SELECTSKIN',   'selectskin');
define('ACTION_PROFILE',      'profile');
define('ACTION_EDITFILE',     'editfile');
define('ACTION_SAVEFILE',     'savefile');
define('ACTION_CONFIRM',      'confirm');
define('ACTION_REGISTER',     'register');


define('DIRECTION_DOWN', 0);
define('DIRECTION_UP',   1);

?>
