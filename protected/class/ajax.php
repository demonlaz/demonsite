<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');


class ajax
{
    private $connect;

    public function __construct($post)
    {

        $this->connect = BD::connect();
        if($post==5){
        $this->spisokOnlain();
        }else if(isset($_POST['content'])){
          $this->otprComentov();
        }
    }


    public function otprComentov()
    {
        @$id = $_SESSION["id_user"];
        @$login = $_SESSION["login_user"];
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('c');
        $sms = htmlspecialchars($_POST['content']);

        if (!empty($sms) and !$sms == null) {

            $this->connect->q_c("mesag", "login,ip,date,sms", "'$login','$ip','$date','$sms'");
            //ustonovka periodsa otklika user
            $time_new = time();
            $ishod_time = $this->connect->q_one("log", "dateactiv", "id='$id'");
            $time = $time_new - $ishod_time['dateactiv'];

            $this->connect->q_u("log", "dateactiv=$time_new", $id);
            $this->connect->q_u("log", "timeend=$time", $id);

        } else {
        }

    }
    public function vivodComentov()
    {
        @$user = $_SESSION['login_user'];


        $arrSms = $this->connect->q_arr("mesag", "login,date,sms");
        if (@$user == 'admin') {
            while ($resul = $arrSms->fetch_assoc()) {

                if ($resul['login'] == 'admin') {
                    $idd = $resul['id'];
                    echo ("<strong id='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                        $resul['sms'] . "</strong> " . "<a href='?delettt=$idd'&glav=delettt>X</a> " .
                        "<pre> ");
                } else {
                    $idd = $resul['id'];
                    echo "<p id='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                        $resul['sms'] . "<a href='?delettt=$idd'>X</a> " . "</p>" . "<pre>";
                }
            }
        } else {
            while ($resul = $arrSms->fetch_assoc()) {
                if ($resul['login'] == 'admin') {
                    echo "<strong id='admincvet'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                        $resul['sms'] . "</strong> " . "<pre> ";
                } else {
                    echo "<p id='vivod-sobwenii'>" . $resul['login'] . "(" . $resul['date'] . ")" .
                        $resul['sms'] . "</p>" . "<pre>";
                }
            }
        }

        exit();

    }
    public function spisokOnlain()
    {

        $time = time();
        $arrSmss = $this->connect->q_arr("log");
        //echo "<h3 id='h3onlain'>Онлайн</h3>";
        while ($result = $arrSmss->fetch_assoc()) {
            $times = $time - $result['dateactiv'];
            if ($times <= 1200) {

                echo "<p class='P-onlin'>" . $result['login'] . "   [" . $result['lvl'] .
                    "ур.]</p>" . "<pre>";
            } else {

                $this->connect->q_u("log", "dateactiv=0", $result['id']);

                if ($result['login'] == @$_SESSION['login_user']) {
                    if (!headers_sent()) {
                        header("Location: index.php?exit");
                        exit;
                    }

                    // Пример использования необязательных параметров file и line.
                    // Необходимо отметить, что $filename и $linenum передаются для дальнейшего использования.
                    // Не назначайте их значения заранее.
                    if (!headers_sent($filename, $linenum)) {
                        header("Location: index.php?exit");
                        exit;

                        // Скорее всего, ошибка будет происходит здесь.
                    } else {


                        $_SESSION = array();
                        session_destroy();
                        //header('Location: index.php?vhod');


                        // unset($_SESSION['id_user']);
                        // unset($_SESSION['login_user']);

                        // echo "Звголовки уже были отправлены в $filename в строке $linenum\n" .
                        //"Невозможно перенаправить, пожалуйста, передите по этой <a " . "href=\?exit\">link</a> ссылке\n";

                    }


                    //header("Location: index.php?exit");
                    // require_once ("index.php");
                    //$igrok = new igrok();
                    // $igrok->exit_igri();

                }
            }

        }


    }
    public function vivodBoy()
    {
        @session_start();

        $id = @$_SESSION['id_user'];

        $id_logBoy = $this->connect->q_one("log", "id_logBoy", "id='$id'");
        $id_log = $id_logBoy['id_logBoy'];
        if ($id_log != 0) {
            $logBoy = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$id_log'");
            exit($logBoy["to4ka_udara_igroka"]);
        }

    }
    public function xpDisplay()
    {
        session_start();

        $id = @$_SESSION['id_user'];

        $xp = $this->connect->q_one("log", "xpMin,xpMax", "id='$id'");

        exit($xp['xpMin'] . '/' . $xp['xpMax']);

    }
    public function xpRost()
    {
        if (isset($_SESSION['id_user'])) {
            @$id = $_SESSION['id_user'];

            $activ = $this->connect->q_one("log", "activregen", "id=$id");

            $xp = $this->connect->q_one("log", "xpMin,xpMax", "id=$id");
            $max = $xp['xpMax'];
            $timeregen = $this->connect->q_one("log", "timeregena", "id=$id");
            $time_nastoiawie = time();

            $time = $time_nastoiawie - $timeregen['timeregena'];
            if ($xp['xpMin'] > $xp['xpMax'] and $activ['activregen'] == 1) {
                $this->connect->q_u("log", "xpMin=$max", $id);
                $this->connect->q_u("log", "timeregena=$time_nastoiawie", $id);
                $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                echo ($procenti . '%');
            } else
                if ($xp['xpMin'] < $xp['xpMax'] and $time >= 600 and $activ['activregen'] == 1) {
                    $this->connect->q_u("log", "xpMin=$max", $id);
                    $this->connect->q_u("log", "timeregena=$time_nastoiawie", $id);
                    $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                    echo ($procenti . '%');
                } else
                    if ($xp['xpMin'] < $xp['xpMax'] and $time >= 60 and $activ['activregen'] == 1) {


                        $this->connect->q_u("log", "timeregena=$time_nastoiawie", $id);
                        $xpmin = $xp['xpMin'];
                        $xpmin = $xpmin + $xp['xpMax'] / 100 * 10;
                        $this->connect->q_u("log", "xpMin=$xpmin", $id);
                        $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                        echo ($procenti . '%');


                    } else {
                        $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                        echo ($procenti . '%');
                    }
        }

    }

    public function timeVivod()
    {
        exit( date("H:i:s"));
    }
}

?>