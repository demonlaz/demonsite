<?php
session_start();

	public $user = 'c33253_makita';
	public $password = '123456';
	public $db = 'c33253_makita';

if(isset($_SESSION['login'])&&isset($_SESSION['password'])){

echo $_SESSION['id'];
include 'protected/connect/BD.php';


//подключаемся к бд
$mysqil= BD::connect();
//делаем выборку
$log=$mysqil->q_a("SELECT login,pass FROM log");

//проверка на наличия записей
if( $log->num_rows){
 

 //вывод перебор масива
 while ($log){
     echo('<p>'.'<h1>'.$log['login'].'/'.$log['pass'].'/'.$log['datatimee'].'</h1>'.'</p>');
 }
 
 
 
}  else {
echo 'Нет записей в бд!!!';    
}
}
 else {
    exit("Войдите под свойим логиным или зарегестрируйтесь!");    
}?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Главная</title>

<div id="udar">

                        <select id="udar-select-ten" name="udar-select-ten">
                            <option>удар в тень{не выбран}</option>
                            <option value="1">лучи света{50}</option>
                            <option value="1">мерцания{50}</option>


                        </select>

                        <select id="udar-select-fiz" name="udar-select-fiz">
                            <option>удар в физ{не выбран}</option>
                            <option value="2">шипами{50}</option>
                            <option value="2">болью{50}</option>


                        </select>
                        <select id="udar-select-duwu" name="udar-select-duwu">
                            <option>удар в душу{не выбран}</option>
                            <option value="3">концентрация{50}</option>
                            <option value="3">медитация{50}</option>


                        </select>


                    </div>

                    <select id="blok-select-ten" name="blok-select-ten">
                        <option>осветить тень{не выбран}</option>
                        <option value="1">вспышкой{50}</option>
                        <option value="1">огнем{50}</option>


                    </select>
                    <select id="blok-select-fiz" name="blok-select-fiz">
                        <option>спасти тело{не выбран}</option>
                        <option value="2">увернутся{50}</option>
                        <option value="2">блокировать{50}</option>


                    </select>
                    <select id="blok-select-duwu" name="blok-select-duwu">
                        <option>защитить душу{не выбран}</option>
                        <option value="3">очистить{50}</option>
                        <option value="3">медитировать{50}</option>


                    </select>
                    
                    
                    
                    
                    
                    
                    <li><a href="">
                        <h2> Тапор просветления(лев.рука)</h2>
                        
                        <p>  <img src="/images/images-orujie/tapor.gif" /></p>
                          <p>Интелект +10</p>
                        <p>Реакция +10</p>
                          <p>Концентрация +10</p>
                        <p>Могушество -разработка</p>
                        <p>Скорость -разработка</p>
                     </a>
                </li>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
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

            echo "<p class='P-onlin'>" . $result['login']."   [".$result['lvl'] . "ур.]</p>" . "<pre>";
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

onlain();

        
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    