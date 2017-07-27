<?php
session_start();
require_once("BD.php");
$id=@$_SESSION['id_user'];
$connect=BD::connect();
$xp = $connect->q_one("log", "xpMin,xpMax", "id='$id'");

        exit($xp['xpMin'].'/'.$xp['xpMax']);
?>
