<?php
date_default_timezone_set("Europe/Moscow");
@session_start();
function sms()
{
    @$user = $_SESSION['login_user'];
    $url = $_SERVER['DOCUMENT_ROOT'];
    require_once ($url . '/protected/connect/BD.php');
    $connect = BD::connect();

    $arrSms = $connect->q_join("log.login,mesag.id,mesag.sms,mesag.date", "log",
        "mesag", "log.login=mesag.login", "ORDER BY date DESC","limit 30");

    if (@$user == 'admin') {
 
        while($resul=$arrSms->fetch_assoc()) {
           
            $resul['date']=date('G:i:s', strtotime($resul['date']));
            $resul['sms'] = nl2br(htmlspecialchars($resul['sms']));
            if ($resul['login'] == 'admin') {
                $idd = $resul['id'];
                echo ("<li class='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                    $resul['sms'] . "<a href='?delettt=$idd'&glav=delettt>X</a> " . "</li> " .
                    "<pre> ");
            } else {
                $idd = $resul['id'];
                echo "<li class='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] .
                    ")" . $resul['sms'] . "<a href='?delettt=$idd'>X</a> " . "</li>" . "<pre>";
            }
        }
    } else {
        while ($resul = $arrSms->fetch_assoc()) {
           $resul['date']=date('G:i:s', strtotime($resul['date']));
            $resul['sms'] = nl2br(htmlspecialchars($resul['sms']));

            if ($resul['login'] == 'admin') {
                echo "<li class='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" . $resul['sms'] .
                    "</li> " . "<pre> ";
            } else {
                echo "<li class='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] .
                    ")" . $resul['sms'] . "</li>" . "<pre>";
            }
        }
    }


    /*


 if (@$user == 'admin') {
        while ($resul = $arrSms->fetch_assoc()) {
            
            
            $resul['sms'] = nl2br(htmlspecialchars($resul['sms']));
            if ($resul['login'] == 'admin') {
                $idd = $resul['id'];
                echo ("<li class='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                    $resul['sms'] . "<a href='?delettt=$idd'&glav=delettt>X</a> " . "</li> " .
                    "<pre> ");
            } else {
                $idd = $resul['id'];
                echo "<li class='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] .
                    ")" . $resul['sms'] . "<a href='?delettt=$idd'>X</a> " . "</li>" . "<pre>";
            }
        }
    } else {
        while ($resul = $arrSms->fetch_assoc()) {
            $resul['sms'] = nl2br(htmlspecialchars($resul['sms']));

            if ($resul['login'] == 'admin') {
                echo "<li class='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" . $resul['sms'] .
                    "</li> " . "<pre> ";
            } else {
                echo "<li class='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] .
                    ")" . $resul['sms'] . "</li>" . "<pre>";
            }
        }
    }


    */


    exit();
}


sms();
