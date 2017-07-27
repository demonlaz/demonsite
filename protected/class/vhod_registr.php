<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');

class vhod_registr
{
    private $connect;
    private $regul = "/^[a-zа-яё\d]{1}[a-zа-яё\d\s]*[a-zа-яё\d]{1}$/i";
    public function __construct()
    {
        $this->connect = BD::connect();
    }
    public function vhod()
    {

        if (preg_match($this->regul, $_POST['login']) and preg_match($this->regul, $_POST['password'])) {
            $login = trim(stripcslashes(htmlspecialchars(strtolower(str_replace("'", "\'", $_POST['login'])))));
            // $pass2 = str_replace("'", "\'", $_POST['password']);
            $pass = str_replace("'", "\'", $_POST['password']);
            $pass = md5(trim(stripcslashes(htmlspecialchars($pass))));


            $id_arr = $this->connect->q_one("log", "id,nic", "login='$login' AND pass='$pass'");
            $id = $id_arr['id'];
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];

            if ($id_arr > 0) {
                $this->connect->q_u("log", "ipv='$ip'", $id);
                $this->connect->q_u("log", "dateactiv=$time", $id);

                $_SESSION['id_user'] = $id;
                $_SESSION['login_user'] = $login;
                $_SESSION['nic'] = $id_arr['nic'];
                $_SESSION['nic'] = new igrok();
                require_once (realpath('../public_html/protected/views/Coments.php'));

            } else {
                unset($_SESSION['id_user']);
                unset($_SESSION['login_user']);
                $_SESSION = array();
                session_destroy();
                //   header("Location: index.php?vhod");
                echo "<h1 align=center>Не верный логин или пароль</h1>";
                require_once (realpath('../public_html/protected/views/A_vhod_views.php'));


            }
        } else {
            unset($_SESSION['id_user']);
            unset($_SESSION['login_user']);
            $_SESSION = array();
            session_destroy();
            //   header("Location: index.php?vhod");
            require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
        }
    }
    public function regist()
    {
        if (preg_match($this->regul, $_POST['password1']) and preg_match($this->regul, $_POST['password2']) and
            preg_match($this->regul, $_POST['login'])) {

            $password1 = trim(stripcslashes(htmlspecialchars(str_replace("'", "\'", $_POST['password1']))));
            $password2 = trim(stripcslashes(htmlspecialchars(str_replace("'", "\'", $_POST['password2']))));
            $login = trim(stripcslashes(htmlspecialchars(strtolower(str_replace("'", "\'", $_POST['login'])))));
            $mailt = trim(stripcslashes(htmlspecialchars(str_replace("'", "\'", $_POST['mailt']))));

            $proverkaLogina = $this->connect->q_one("log", "login", "login='$login'");
            if ($password1 === $password2 and filter_var($_POST['mailt'],
                FILTER_VALIDATE_EMAIL) and $proverkaLogina['login'] !== $login) {


                $ip = $_SERVER['REMOTE_ADDR'];
                $date = date('c');
                $password1 = md5($password1);
                $random_nic = 'nic' . md5(microtime() . rand(0, 9999));
                $this->connect->q_c(" log",
                    "login,nic,pass,mail,ip,datatimee,lvl,opit,xpMin,xpMax,sposobnosti,naviki,money,intelekt,reakcia,koncentracia",
                    "'$login','$random_nic','$password1','$mailt','$ip','$date','9','0','500','1000','10','5','500','1','1','1'");

                mail('demonlaz@yandex.com', 'Зарегистрировался =>' . $login, "логин=" . $login .
                    " майл=" . $mailt . " ip=" . $ip);


                $id_arr = $this->connect->q_one("log", "id,nic", "login='$login' AND pass='$password1'");

                $id = $id_arr['id'];
                $time = time();
                $ip = $_SERVER['REMOTE_ADDR'];
                $_SESSION['id_user'] = $id;
                $_SESSION['login_user'] = $login;
                $_SESSION['nic'] = $random_nic;
                $_SESSION['nic'] = new igrok();
                $this->connect->q_u("log", "ipv='$ip'", $id);
                $this->connect->q_u("log", "dateactiv=$time", $id);

                require_once (realpath('../public_html/protected/views/Coments.php'));


            } else {

                require_once '../public_html/protected/views/B_registr_views.php';
                echo ("<h1 align=center>Епт пароль не совпадает,ну или еще какая ошибка!</h1>");
            }


        } else {
            require_once '../public_html/protected/views/B_registr_views.php';
            echo ("<h1 align=center>Епт пароль не совпадает,ну или еще какая ошибка!</h1>");

        }
    }


    public function okRega($uID = null)
    {
        if( $uID !== null){
        $nic = $this->connect->q_one("log", "login,id,nic", "id_ok=$uID");}
        if ($uID !== 0 and isset($nic['login']) and $uID !== null) {

            @session_start();
            $nic = $this->connect->q_one("log", "login,id,nic", "id_ok=$uID");
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->connect->q_u("log", "ipv='$ip'", $nic['id']);
            $this->connect->q_u("log", "dateactiv=$time", $nic['id']);
            $_SESSION['id_user'] = $nic['id'];
            $_SESSION['login_user'] = $nic['login'];
            //$_SESSION['nic'] = $nic['nic'];
            $_SESSION['nic'] = new igrok();
            require_once (realpath('../public_html/protected/views/Coments.php'));

        } else
            if ($uID !== 0 and !isset($nic['login']) and !isset($_SESSION['id_user']) and $uID !== null) {


                $ip = $_SERVER['REMOTE_ADDR'];
                $date = date('c');
                //$password1 = md5($password1);
                $random_nic = 'nic' . md5(microtime() . rand(0, 9999));
                $random_login = 'login' . time();
                $this->connect->q_c(" log",
                    "login,nic,pass,mail,ip,datatimee,lvl,opit,xpMin,xpMax,sposobnosti,naviki,money,intelekt,reakcia,koncentracia,id_ok",
                    "'$random_login','$random_nic','$random_nic','null','$ip','$date','9','0','500','1000','10','5','500','1','1','1','$uID'");

                mail('demonlaz@yandex.com', 'Зарегистрировался =>' . $random_login, "логин=" . $random_login .
                    " майл=" . null . " ip=" . $ip . "uID=" . $uID);


                $id_arr = $this->connect->q_one("log", "id,nic,login", "id_ok=$uID");
                if (isset($id_arr['login'])) {
                    @session_start();
                    $id = $id_arr['id'];
                    $time = time();
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['id_user'] = $id;
                    $_SESSION['login_user'] = $id_arr['login'];

                    $_SESSION['nic'] = $random_nic;
                    $_SESSION['nic'] = new igrok();
                    $this->connect->q_u("log", "ipv='$ip'", $id);
                    $this->connect->q_u("log", "dateactiv=$time", $id);

                    require_once (realpath('../public_html/protected/views/Coments.php'));


                }


            } else
                if ($uID !== 0 and isset($_SESSION['id_user']) and $uID !== null) {

                    $this->connect->q_u("log", "id_ok=$uID", $_SESSION['id_user']);
                    require_once (realpath('../public_html/protected/views/Coments.php'));

                }

    }


    public function vkRega($uID = null)
    {

        
        
           if( $uID !== null){
        $nic = $this->connect->q_one("log", "login,id,nic", "id_vk=$uID");}
        if ($uID !== 0 and isset($nic['login']) and $uID !== null) {

            @session_start();
            $nic = $this->connect->q_one("log", "login,id,nic", "id_vk=$uID");
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->connect->q_u("log", "ipv='$ip'", $nic['id']);
            $this->connect->q_u("log", "dateactiv=$time", $nic['id']);
            $_SESSION['id_user'] = $nic['id'];
            $_SESSION['login_user'] = $nic['login'];
            //$_SESSION['nic'] = $nic['nic'];
            $_SESSION['nic'] = new igrok();
            require_once (realpath('../public_html/protected/views/Coments.php'));

        } else
            if ($uID !== 0 and !isset($nic['login']) and !isset($_SESSION['id_user']) and $uID !== null) {


                $ip = $_SERVER['REMOTE_ADDR'];
                $date = date('c');
                //$password1 = md5($password1);
                $random_nic = 'nic' . md5(microtime() . rand(0, 9999));
                $random_login = 'login' . time();
                $this->connect->q_c(" log",
                    "login,nic,pass,mail,ip,datatimee,lvl,opit,xpMin,xpMax,sposobnosti,naviki,money,intelekt,reakcia,koncentracia,id_vk",
                    "'$random_login','$random_nic','$random_nic','null','$ip','$date','9','0','500','1000','10','5','500','1','1','1','$uID'");

                mail('demonlaz@yandex.com', 'Зарегистрировался =>' . $random_login, "логин=" . $random_login .
                    " майл=" . null . " ip=" . $ip . "uID=" . $uID);


                $id_arr = $this->connect->q_one("log", "id,nic,login", "id_vk=$uID");
                if (isset($id_arr['login'])) {
                    @session_start();
                    $id = $id_arr['id'];
                    $time = time();
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['id_user'] = $id;
                    $_SESSION['login_user'] = $id_arr['login'];

                    $_SESSION['nic'] = $random_nic;
                    $_SESSION['nic'] = new igrok();
                    $this->connect->q_u("log", "ipv='$ip'", $id);
                    $this->connect->q_u("log", "dateactiv=$time", $id);

                    require_once (realpath('../public_html/protected/views/Coments.php'));


                }


            } else
                if ($uID !== 0 and isset($_SESSION['id_user']) and $uID !== null) {

                    $this->connect->q_u("log", "id_vk=$uID", $_SESSION['id_user']);
                    require_once (realpath('../public_html/protected/views/Coments.php'));

                }
        
        
    }


}

?>