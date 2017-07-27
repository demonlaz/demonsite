<?php
//класс базы данных для подклоючение используйте $perem=BD::connect();
//*********************************************************************$massiv=$perem->q_a(sql);
// require_once 'protected/rb/rb.php';
//R::setup('mysql:host=localhost;dbname=id374759_demon','id374759_demon','demon');

class BD
{
    private $_connect;
    public static $mysqli = null;

    const HOST = "localhost";
    const LOGIN = "cp366796_demon";
    const PASSW = "q4w4e4r4";
    const NAMEBD = "cp366796_demonlaz";

    private function __construct()
    { //конструктор подключения

        $obj_mysqli = @new mysqli(self::HOST, self::LOGIN, self::PASSW, self::NAMEBD); //сабака не дает отоброжать ошибки в подключение
        if (!$obj_mysqli->connect_error) {
            $this->_connect = $obj_mysqli;
            $this->_connect->query("SET NAMES 'utf8'");
        } else {
            exit("Нет соединения");
        }
        return $this->_connect;
    }

    public static function connect()
    { //вызывается этот метод
        if (self::$mysqli == null) {

            $obj = new BD(); //создается экземпляр класса для работы конструктара и возврата уже соединения
            self::$mysqli = $obj;
        }
        return self::$mysqli;
    }
    //добавление записей
    public function q_c($tablename, $polia, $zna4enie)
    { try{
        $resul = $this->_connect->query("INSERT INTO $tablename  ($polia) VALUES ($zna4enie)");

        return $this->_connect->insert_id;
        }catch (exception $e){
            echo "Исключение 1 код $e->getMessage()";
        }
    }
    //извлечения записей 1 zapisi

    public function q_one($tabelname, $polu4enie, $uslovie)
    {
            try{
        $resul = $this->_connect->query("SELECT $polu4enie FROM $tabelname  WHERE $uslovie ");
        //$resul= $this->_connect->query($sql);
        $nex = $resul->fetch_assoc();
        return $nex;
                    }catch (exception $e){
            echo "Исключение 2 код $e->getMessage()";
        }

    }
    public function q_stolbec($tabelname, $polu4enie)
    {
            try{
        $resul = $this->_connect->query("SELECT $polu4enie FROM $tabelname ORDER BY id DESC");
        //$nex = $resul->fetch_assoc();
        return $resul;
                }catch (exception $e){
            echo "Исключение 3 код $e->getMessage()";
        }
    }
    public function q_v_arr($tabelname, $uslovie)
    {try{
        $resul = $this->_connect->query("SELECT * FROM $tabelname WHERE $uslovie");
        $nex = $resul; //->fetch_assoc();
        return $nex;
        }catch (exception $e){
            echo "Исключение 4 код $e->getMessage()";
        }

    }
    public function q_arr($tabelname, $polu4enie = 0, $uslovie = 0, $limit = ";")
    {   try{
        $resul = $this->_connect->query("SELECT  * FROM $tabelname ORDER BY id DESC $limit");
        $nex = $resul; //->fetch_assoc();
        return $nex;
            }catch (exception $e){
            echo "Исключение 5 код $e->getMessage()";
        }

    }
    //obnovlenie записей
    public function q_u($tablename, $polia, $id)
    {   try{
        $resul = $this->_connect->query("UPDATE $tablename SET $polia WHERE id='$id' ");
        }catch (exception $e){
            echo "Исключение 6 код $e->getMessage()";
        }

    }
    public function q_delet($tablename, $id = 0)
    {try{
        $resul = $this->_connect->query("DELETE  FROM $tablename ");
        }catch (exception $e){
            echo "Исключение 7 код $e->getMessage()";
        }

    }


    public function q_delet_login($tablename, $login = null)
    {try{
        $resul = $this->_connect->query("DELETE  FROM $tablename WHERE login='$login' ");

        }catch (exception $e){
            echo "Исключение 8 код $e->getMessage()";
        }
    }
    public function q_delet_id($tablename, $id = 0)
    {try{
        $resul = $this->_connect->query("DELETE  FROM $tablename WHERE id='$id' ");
        }catch (exception $e){
            echo "Исключение 9 код $e->getMessage()";
        }

    }
    public function q_u_all($tablename, $polia)
    {try{
        $resul = $this->_connect->query("UPDATE $tablename SET $polia");
        }catch (exception $e){
            echo "Исключение 10 код $e->getMessage()";
        }

    }
    public function q_max($tablename, $polu4enie)
    {
try{
        $resul = $this->_connect->query("SELECT MAX('$polu4enie') FROM $tabelname ");

        $nex = $resul->fetch_assoc();
        return $nex;
                }catch (exception $e){
            echo "Исключение 11 код $e->getMessage()";
        }
    }

    public function q_join($polu4enie, $tablename1, $tablename2, $key,$virovnit=";",$limit=";")
    {   try{
        /**
         * пример $sql = "SELECT log.login,sms FROM log inner join mesag on log.login=mesag.login ";
         */
        $resul = $this->_connect->query("SELECT $polu4enie FROM $tablename1 INNER JOIN $tablename2 ON $key $virovnit $limit");

        $nex = $resul;//->fetch_array();
        return $nex;
        }catch(Exception $e){
            echo "Исключение 12 код $e->getMessage()";
        }
    }


}


//include 'путь к файлу';
//подключаемся к бд
/*
function conectBD($host='localhost', $login='demon',$pass='demon',$nameBD='demon')
{
$mysqil= new mysqli($host,$login,$pass,$nameBD);
return $mysqil;

}
//выборка всех столбцов
function SELECT($mysqil,$stolbik,$table){
$log=$mysqil->query("SELECT ".$stolbik." FROM ".$table."");
return $log;
}
//добовление записи
function create($mysqil,$login="",$pass=""){
if(empty($login) or empty($pass)) {
return FALSE;
}
$date= date("c");
//получение IP
$ip=$_SERVER[REMOTE_ADDR];
$mysqil->query("INSERT INTO log (login,pass,ip,datatimee) VALUES ('$login','$pass','$ip','$date') ");
}
function UPDATE($mysqil,$login="",$pass="",$id){

$result=$mysqil->query("UPDATE log SET login='$login',pass='$pass' WHERE id='$id'");
return $result;
}  

*/
