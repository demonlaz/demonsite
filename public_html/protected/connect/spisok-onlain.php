<?php
@session_start();

//<input type='button' value='' id='razarabu-input'  />
function onlain()
{

    $url = $_SERVER['DOCUMENT_ROOT'];
    require_once ($url . '/protected/connect/BD.php');
    $connect = BD::connect();
    $time = time();
    $arrSmss = $connect->q_arr("log");
    //echo "<h3 id='h3onlain'>Онлайн</h3>";
    while ($result = $arrSmss->fetch_assoc()) {
        $times = $time - $result['dateactiv'];
        if ($times <= 1200) {
            $login = $result['login'];
            $lvl = $result['lvl'];
            echo "<input type='button' value='$login [$lvl ур.]' onclick='lick(this)' class='onla' name='$login'   />  <pre>";
            //<script type='text/javascript'> </script>

        } else {

            $connect->q_u("log", "dateactiv=0", $result['id']);

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
                        if(isset($_SESSION['nic'])){
                        $_SESSION['nic']->exit_igri();
                              //$_SESSION = array();
                            //session_destroy();
                        }

                    //header('Location: index.php?vhod');


                    // unset($_SESSION['id_user']);
                    // unset($_SESSION['login_user']);

                    // echo "Звголовки уже были отправлены в $filename в строке $linenum\n" .
                    //"Невозможно перенаправить, пожалуйста, передите по этой <a " . "href=\?exit\">link</a> ссылке\n";

                }


            }
        }

    }

}

onlain();
