<?php
	@session_start();
    require_once("BD.php");
    $id = @$_SESSION['id_user'];
    $connect = BD::connect();  
    $xpVraga = $connect->q_one("log", "id_logBoy", "id='$id '");
    
    
    $xpVraga = $connect->q_one("logBoy", "xp_vrag", "id=$xpVraga[id_logBoy]");
    exit($xpVraga['xp_vrag']);
    

