<?php
date_default_timezone_set("Europe/Moscow");
session_start();
//отправка сообщений в базу
function otpr_sms()
{
    $url = $_SERVER['DOCUMENT_ROOT'];
    require_once $url . '/protected/connect/BD.php';
    $connect = BD::connect();
    @$id = $_SESSION["id_user"];
    @$login = $_SESSION["login_user"];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('c');
    $priv_sms="to";
    $sms1= htmlspecialchars(addslashes($_POST['content']));
   $sms=filter_var($sms1,FILTER_SANITIZE_SPECIAL_CHARS);
    $pos = strpos($sms, $priv_sms);


    //   $regul = "/^[a-zа-яё\d]{1}[a-zа-яё\d\s]*[a-zа-яё\d]{1}$/i"; and preg_match($regul, $sms)
    //проверяет написал ли пользователь to логин если да то добовляет в базу приват 
    $login_komu = $connect->q_arr("log");
    if ($pos !== false) {
        while ($resul = $login_komu->fetch_assoc()) {
            $pos_login = strpos($sms, $resul['login']."}");

            if ($pos !== false and $pos_login !== false) {
                $log = $resul['login'];
                $connect->q_c("privat_mesag", "login,login_privat,ip,date,sms", "'$login','$log','$ip','$date','$sms'");
            }
        }
        //если нет то дабовлет в общий чат
    } else {

        if (!empty($sms) and !$sms == null) {


            $connect->q_c("mesag", "login,ip,date,sms", "'$login','$ip','$date','$sms'");
            //ustonovka periodsa otklika user
            $time_new = time();
            $ishod_time = $connect->q_one("log", "dateactiv", "id='$id'");
            $time = $time_new - $ishod_time['dateactiv'];

            $connect->q_u("log", "dateactiv=$time_new", $id);
            $connect->q_u("log", "timeend=$time", $id);


        }

    }


}
otpr_sms();
