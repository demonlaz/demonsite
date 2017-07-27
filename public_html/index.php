<?php
//date_default_timezone_set("Europe/Moscow");
session_start();
$url = $_SERVER['DOCUMENT_ROOT'];

//авто подгрузка классов
spl_autoload_register(function($classname){
	
	require_once ("../protected/class/$classname.php");
	
});
//require_once 'dumper.php';

//require_once 'protected/connect/BD.php';
//**********************************************************
//создает обьект класса админ если заходит админ
if (isset($_SESSION['login_user'])) {
    $_SESSION['nic'] = new igrok();
    if ($_SESSION['login_user'] === 'admin') {
        $_SESSION["admin"] = new adminka();
    }
}
/**
 * обработка GET запросов
 */
if(!empty($_GET)){
    zapros::get_zapros($_GET);
}
	if(!isset($_SESSION['login_user']) and empty($_POST) and empty($_GET) or empty($_POST) and empty($_GET) )
  { header("Location: index.php?vhod");}
    
    
/**
 * обработка POST запросов
 */
if(!empty($_POST) and isset($_POST)){
    zapros::post_zapros($_POST);
}


 
?>
