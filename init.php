<?php
define('ROOT_PATH',dirname(__FILE__));

include(ROOT_PATH.'/config.php');
define('URL_ROOT',$config['urlroot']);
define('SITE_NAME',$config['site']['sitename']);
define('TBPREFIX',$config['tbPrefix']);
date_default_timezone_set($config['timezone']);
session_start();
if($config['debug']==false) error_reporting(0);
$sql_conn = mysql_connect($config['dbHost'],$config['dbUser'],$config['dbPwd']);
if (!$sql_conn){
  die(mysql_errno().':'.mysql_error());
  exit;
}
mysql_select_db($config['database']);
//mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
include(ROOT_PATH.'/recaptchalib.php');
include(ROOT_PATH.'/function.php');
include(ROOT_PATH.'/loadlib.php');
?>
