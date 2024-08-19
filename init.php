<?php
ini_set("arg_separator.output", "&amp;");
ini_set('default_charset', 'utf-8');
ini_set('display_errors', 'on');
// Start output buffering with gzip compression and start the session
ob_start('ob_gzhandler');
session_start();
// get full path to collabtive
define("CL_ROOT", realpath(dirname(__FILE__)));
define("CL_VERSION", 1.0);
define("CL_PUBDATE","1365026400");
// uncomment for debugging
//error_reporting(E_ALL | E_STRICT);
// include config file , pagination and global functions
require(CL_ROOT . "/include/initfunctions.php");
require(CL_ROOT . "/config.php");
// Start database connection
if (!empty($db_name) and !empty($db_user))
{
  //$tdb = new datenbank();
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	
}
// get the available languages
$languages = getAvailableLanguages();
// get URL to collabtive
$url = getMyUrl();
// Set Template directory

$locale="fr";
if (isset($_GET["lang"]))
{
    $_SESSION['locale']=$_GET["lang"];
	$locale=$_GET["lang"];
}else if(isset($_SESSION['locale']))
{

	$locale=$_SESSION['locale'];	
}
else if(!isset($_GET["lang"])&&!isset($_SESSION['locale']))
{
    $_SESSION['locale'] ="fr";
}

// read language file into PHP array
$langfile = readLangfile($locale);
?>