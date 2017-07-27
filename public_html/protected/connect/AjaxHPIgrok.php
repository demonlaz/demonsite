<?php
@session_start();
require_once("BD.php");
	function AjaxHPIgrok(){
	         $login = @$_SESSION['login_user'];
        $id = @$_SESSION['id_user'];
        
        $connect = BD::connect();  
        $xpMin = $connect->q_one("log", "xpMin", "id='$id '");
        exit($xpMin['xpMin']);
        }
         AjaxHPIgrok();