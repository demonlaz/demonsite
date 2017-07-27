 <?php 
 session_start();
 


<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?139"></script>

<script type="text/javascript">
  VK.init({apiId: API_ID});
</script>

<!-- Put this div tag to the place, where Auth block will be -->
<div id="vk_auth"></div>
<script type="text/javascript">
VK.Widgets.Auth("vk_auth", {width: "200px", authUrl: '/dev/Login'});
</script>

















//echo $_SESSION['login'];
include 'protect/BDconect.php';


//подключаемся к бд
$mysqil= conectBD();
//делаем выборку

$log=SELECT($mysqil,'login,pass,datatimee','log');
//проверка на наличия записей
if( $log->num_rows){
 

 //вывод перебор масива
 while ($stroc= $log->fetch_assoc()){
     echo('<p>'.'<h1>'.$stroc['login'].'/'.$stroc[pass].'/'.$stroc[datatimee].'</h1>'.'</p>');
 }
 
 
 
}  else {
echo 'Нет записей в бд!!!';    
}

//UPDATE($mysqil,"Шлюхин","яйки",'7');
$string="\\<p>\\\dfnfdgjknfgk</p>";
$names=  trim(stripcslashes(htmlspecialchars($string)));
//create($mysqil, $names, '1231sad5f');


//наличия ошибки
//$mysqil->connect_errno;
/*echo '<pre>';
print_r( $_SERVER[REMOTE_ADDR]);
echo '</pre>';*/
 
function write($arr){
                $putc= fopen("text.txt", "w");
            foreach ($arr as $key => $value) {
                fwrite($putc, "$key => $value \n");
            }
            fclose($putc);
}
function read(){
     
     $value= file("http://mail.ru");
     
     return $value;
}
function gets(){
       $putc= fopen("text.txt", "r");
       while(!feof($putc)){
           $perem= fread($putc,12);
           echo '<pre>';
           echo $perem;
           if( $perem=="\n"){
               echo "<pre>";
           }
       }
       fclose($putc);
}

function creat($a){
        $name="fatal/$a.txt";
        $file= fopen($name, "w");
        fwrite($file, $name);
        fclose($file);
}

$arr=['kakka'=>'zd','dom'=>'ads','asd'=>'sdf'];
if(isset($_GET["write"])){
            write($arr);
            echo "Запись успешна";

 }
 elseif (isset($_GET["read"])) {
     foreach (read() as $value){
         echo $value;
     }
   
     
}
elseif (isset ($_GET["creat"])) {
    for($a=0;$a<100000;$a++){
        creat("test".$a);
    }
    echo "Файлы созданы";
}
elseif (isset($_GET["get"])) {
    gets();
}
else{
echo "требуется джет запрос WRITE или READ || get";
}

define(START_TIME,microtime(true));
sleep(2);
echo "<pre>";
printf("Время работы скрипта: %.5f c", microtime(true) - START_TIME); 
/*
$now=html::enter();
$arr=['kakka'=>'zd','dom'=>'ads','asd'=>'sdf'];
natcasesort($arr);
echo '<pre>';
print_r($arr);


$str="12в34561789";
$rez=  "12д4561789";          // strpos( $str,"1");
if($str<=>$rez){echo 'хуй';}
//$html_filter=str_replace('/>\s+</', '><', $html);
dumper(date("s"));*/
define(START_TIME,microtime(true));


/*

//$inde=  mt_rand(50, 100);
//$i=array("dsflsd","\dslfk");
//var_export($i);
//$hj=$_REQUEST["login"] ?? false;
//$rr=$_SERVER;
//echo $rr;

foreach ($_SERVER as $SCRIPT_NAME=>&$i ){
   
    echo "$SCRIPT_NAME =>"."<pre>";
    
}
echo "<pre>";
//print_r ($rr);
print_r($GLOBALS); 
echo "</pre>";*/
/*
$connection =BD::connect(); // Соединение с базой данных 
//$arrabd  = $connection->q_a("SELECT pass FROM log WHERE id='1'");

$host_server=$_SERVER['SERVER_NAME'];

if (isset($_POST['submit'])) // Отлавливаем нажатие кнопки "Отправить"
{
if (empty($_POST['login'])) // Если поле логин пустое
{
echo '<script>alert("Поле логин не заполненно");</script>'; // То выводим сообщение об ошибке
}
elseif (empty($_POST['password'])) // Если поле пароль пустое
{
echo '<script>alert("Поле пароль не заполненно");</script>'; // То выводим сообщение об ошибке
}
else  // Иначе если все поля заполненны
{    
$login = $_POST['login']; // Записываем логин в переменную 
$password = $_POST['password']; // Записываем пароль в переменную           
$result  = $connection->q_a("SELECT `id` FROM `log` WHERE `login` = '$login' AND `pass` = '$password'"); // Формируем переменную с запросом к базе данных с проверкой пользователя
//$res=$connection->query("SELECT id FROM log WHERE login='$login'");
//$result= $arrabd->fetch_assoc();

// Формируем переменную с исполнением запроса к БД 
if (empty($result['id'])) // Если запрос к бд не возвразяет id пользователя
{
echo '<script>alert("Неверные Логин или Пароль");</script>'; // Значит такой пользователь не существует или не верен пароль
}
else // Если возвращяем id пользователя, выполняем вход под ним
{
$_SESSION['password'] = $password; // Заносим в сессию  пароль
$_SESSION['login'] = $login; // Заносим в сессию  логин
$_SESSION['id'] = $result['id']; // Заносим в сессию  id
echo '<div align="center">Вы успешно вощли в систему: '.$_SESSION['login'].'</div>'; // Выводим сообщение что пользователь авторизирован        
//system("rundll32.exe user32.dll,LockWorkStation"); 
//header("Location : http://".$host_server."/www/new.php");
}     
}		
} 

 if (isset($_GET['exit'])) { // если вызвали переменную "exit"
unset($_SESSION['password']); // Чистим сессию пароля
unset($_SESSION['login']); // Чистим сессию логина
unset($_SESSION['id']); // Чистим сессию id
} 

if (isset($_SESSION['login']) && isset($_SESSION['id'])) // если в сессии загружены логин и id
{
echo '<div align="center"><a href="index.php?exit">Выход</a></div>'; // Выводим нашу ссылку выхода
} 


//echo $html;
if (!isset($_SESSION['login']) || !isset($_SESSION['id'])) // если в сессии не загружены логин и id
{
echo '<div align="center"><a href="reg.php">Регистрация</a></div>'; // Выводим нашу ссылку регистрации
} */
//  else{
//require_once (realpath('protected/views/A_vhod_views.php'));
  // }

//обьект шаблонов
/*

if (get('vhod')) {
    //при гет забросе страница входа
    require_once (realpath('protected/views/A_vhod_views.php'));

} else
    if (get('delettt')) {
        //удаления сообшения гет запросом
        if (isset($admin)) {

            adminka::delet_id();

            header("Location: index.php?x");
        } else {
            header("Location: index.php?x");
        }
        //$admin->delet_id();
        //require_once ('protected/connect/delettt_id_sms.php');
       // header("Location: index.php?x");
    } else
        if (get('naviki')) {
            require_once (realpath('protected/views/Coments.php'));

        } else
            if (get('zaklin')) {
                require_once (realpath('protected/views/Coments.php'));

            } else
                if (get('register')) {

                    require_once (realpath('protected/views/B_registr_views.php'));

                } else
                    if (get('x')) {
                        if (isset($_SESSION['id_user'])) { //require_once (realpath('../protected/views/Coments.php'));
                            require_once (realpath('protected/views/Coments.php'));
                        } else {
                            require_once (realpath('protected/views/A_vhod_views.php'));
                        }
                    } else
                        if (get('exit')) {

                            //выход из игры

                            $_SESSION['nic']->exit_igri();
                        } else {
                            header("Location: index.php?x");

                            //POST запросы
                            if (post('registr')) {

                                $a = new vhod_registr();
                                $a->regist();
                            } else
                                if (post('chistka')) {
                                    if (isset($admin)) {
                                    $admin->delet_sms();}

                                } else
                                    if (post('regen_off')) {
                                        if (isset($admin)) {
                                        $admin->stop_regen();}
                                    } else
                                        if (post('regen_on')) {
                                            if (isset($admin)) {
                                            $admin->activ_regen();}
                                        } else
                                            if (post('modul')) {

                                                $_SESSION['nic']->modul_uvel();
                                                header("Location: index.php?naviki");
                                            } else
                                                if (post('komul')) {

                                                    $_SESSION['nic']->komul_uvel();
                                                    header("Location: index.php?naviki");
                                                } else
                                                    if (post('detro')) {

                                                        $_SESSION['nic']->detro_uvel();
                                                        header("Location: index.php?naviki");
                                                    } else
                                                        if (post('gidro')) {

                                                            $_SESSION['nic']->gidro_uvel();
                                                            header("Location: index.php?naviki");
                                                        } else
                                                            if (post('sveto')) {

                                                                $_SESSION['nic']->sveto_uvel();
                                                                header("Location: index.php?naviki");
                                                            } else
                                                                if (post('petrol')) {

                                                                    $_SESSION['nic']->petrol_uvel();
                                                                    header("Location: index.php?naviki");
                                                                } else
                                                                    if (post('intelekt')) {

                                                                        $_SESSION['nic']->intelekt_uvel();
                                                                        header("Location: index.php?naviki");
                                                                    } else
                                                                        if (post('reakcia')) {

                                                                            $_SESSION['nic']->reakcia_uvel();
                                                                            header("Location: index.php?naviki");
                                                                        } else
                                                                            if (post('koncentracia')) {

                                                                                $_SESSION['nic']->koncentracia_uvel();
                                                                                header("Location: index.php?naviki");
                                                                            } else
                                                                                if (post('vhod')) {
                                                                                   $vhodd = new vhod_registr();
                                                                                    $vhodd->vhod();
                                                                                    //$_SESSION['nic']grok->vhod();

                                                                                } else
                                                                                    if (post("smsKnopka") && isset($_SESSION["login_user"]) && post("textComent")) {
                                                                                        if (!empty($_POST['textComent'])) {
                                                                                            require_once ('protected/connect/comentBD.php');
                                                                                            header("Location: index.php?x");
                                                                                        } else {

                                                                                            //echo "В видите сообшение перед отправкой!";
                                                                                        }
                                                                                    } else {
                                                                                      //  require_once (realpath('protected/views/A_vhod_views.php'));
                                                                                    }

                                                                                    if (isset($_SESSION['id_user'])) {
                                                                                       // require_once (realpath('protected/views/Coments.php'));

                                                                                    } else {
                                                                                       // require_once (realpath('protected/views/A_vhod_views.php'));
                                                                                       // echo "No login or password";

                                                                                    }
                        }

*/