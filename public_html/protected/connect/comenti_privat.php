<?php
@session_start();
require_once ("BD.php");
$id = @$_SESSION['id_user'];
@$user = $_SESSION['login_user'];
$connect = BD::connect();
//$privat_mesag = $connect->q_arr("privat_mesag");
//$privat_mesa = $connect->q_stolbec("privat_mesag", "login,login_privat,date,sms");
$privat_mesa = $connect->q_join("log.login,privat_mesag.sms,privat_mesag.date,privat_mesag.login_privat",
    "log", "privat_mesag", "log.login=privat_mesag.login","ORDER BY date DESC");
while ($privat_mesag2 = $privat_mesa->fetch_assoc()) {
    $privat_mesag2['login_privat'] = nl2br(htmlspecialchars($privat_mesag2['login_privat']));
    $privat_mesag2['sms'] = nl2br(htmlspecialchars($privat_mesag2['sms']));

    //мне
    if ($privat_mesag2['login_privat'] == @$user) {
        echo "<strong style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
            $privat_mesag2['login'] . "(" . $privat_mesag2['date'] . ")" . $privat_mesag2['sms'] .
            "</strong> " . "<br> ";

    }
    //от меня
    if ($privat_mesag2['login'] == @$user) {
        echo "<strong style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
            $privat_mesag2['login'] . "(" . $privat_mesag2['date'] . ")" . $privat_mesag2['sms'] .
            "</strong> " . "<br> ";

    }


}

/*
while ($result = $privat_mesag->fetch_assoc()) {
//мне
if ($result['login_privat'] == @$user) {
echo "<strong style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
$result['login'] . "(" . $result['date'] . ")" . $result['sms'] . "</strong> " .
"<br> ";

}
//от меня
if ($result['login'] == @$user) {
echo "<strong style='color:#c0c0c0;background-color: #1a1a1a;' id='admincvet'>" .
$result['login'] . "(" . $result['date'] . ")" . $result['sms'] . "</strong> " .
"<br> ";

}

}*/
