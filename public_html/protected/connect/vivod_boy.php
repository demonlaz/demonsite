<?php
@session_start();
require_once("BD.php");
$id=@$_SESSION['id_user'];
$connect=BD::connect();
 $id_logBoy = $connect->q_one("log", "id_logBoy", "id='$id'");
 $id_log=$id_logBoy['id_logBoy'];
if($id_log!=0){
    $logBoy = $connect->q_one("logBoy", "to4ka_udara_igroka", "id='$id_log'");
    echo($logBoy["to4ka_udara_igroka"]);
}
@$user = $_SESSION['login_user'];

$privat_mesag = $connect->q_arr("privat_mesag");
while ($result = $privat_mesag->fetch_assoc()) {
    //мне
    if ($result['login_privat'] == @$user) {
        echo "<li style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
            $result['login'] . "(" . $result['date'] . ")" . $result['sms'] . "</li> " .
            "<br> ";

    }
    //от меня
    if ($result['login'] == @$user) {
        echo "<li style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
            $result['login'] . "(" . $result['date'] . ")" . $result['sms'] . "</li> " .
            "<br> ";

    }

}