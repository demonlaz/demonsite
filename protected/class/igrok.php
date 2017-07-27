<?php
//сделать деконструкт чтоб выбивала из игры при смерти класса
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');

class igrok
{

    private $connect;
    private $sessia_login;
    private $sessia_id;
    private $reakcia;
    private $intelect;
    private $dmgMax;
    private $dmgMin;
    private $dmg;
    private $uron_posle_bloka;
    public $login;
    public $id_loga;

    public function __construct()
    {
        //$this->vhod();
        $this->connect = BD::connect();
        $this->sessia_login = @$_SESSION['login_user'];
        $this->sessia_id = @$_SESSION['id_user'];
        $this->login = $this->sessia_login;


        $vrag = $this->connect->q_one("log", "intelekt,reakcia", "id='$this->sessia_id'");
        $this->reakcia = $vrag['reakcia'];
        $this->intelect = $vrag['intelekt'];
    }
    //расщет урона
    public function dmg()
    {

        $this->dmgMax = $this->intelect * 10;
        $this->dmgMin = $this->intelect * 5;
        $this->dmg = mt_rand($this->dmgMin, $this->dmgMax);
        if ($this->wansKrita()) {
            return $this->dmg * 2;
        } else {
            return $this->dmg;
        }
    }
    //урон минус то что отняла защита
    public function uron($kol_pol_urona)
    {


        $kol_blok_urona = $kol_pol_urona / 100 * $this->reakcia;
        $this->uron_posle_bloka = $kol_pol_urona - $kol_blok_urona;
        return $this->uron_posle_bloka;

    }
    //расщет шанса крита
    public function wansKrita()
    {
        $krit = $this->connect->q_one("log", "moguwestvo", "id='$this->sessia_id'");

        $rand = mt_rand(1, 100);

        //echo "<h1>$rand </h1>";
        if ($rand <= $krit['moguwestvo']) {
            return true;
        } else {
            return false;
        }

    }
    
    //расщет шанс уворота
        public function wansUvorota()
    {
        $uvorot = $this->connect->q_one("log", "skorost", "id='$this->sessia_id'");

        $rand = mt_rand(1, 100);

        //echo "<h1>$rand </h1>";
        if ($rand <= $uvorot['skorost']) {
            return true;
        } else {
            return false;
        }

    }
    
    public function login()
    {
        echo $this->login;

    }
    /**
     * добавляем денег играку
     */
    public function dobavim_deneg($money)
    {

        $mani = $this->connect->q_one("log", "money", "id='$this->sessia_id'");
        $res = $mani['money'] + $money;
        $this->connect->q_u("log", "money=$res", $this->sessia_id);
        return $res;
    }
    public function dobavim_opit($opit)
    {
        $opitBD = $this->connect->q_one("log", "opit", "id='$this->sessia_id'");
        $res = $opitBD['opit'] + $opit;
        $this->connect->q_u("log", "opit=$res", $this->sessia_id);
        return $res;
    }
    /**
     * создает обьект врага и начинается бой
     */
    public function sozdat_vraga($id_vraga)
    { //проверяем существует ли бой
        $id_logBoy = $this->connect->q_one("log", "id_logBoy", "id='$this->sessia_id'");
        if ($id_logBoy['id_logBoy'] === null) {
            //получаем пораметры противника
            $vrag = $this->connect->q_one("vrag",
                "namevrag,intelekt,reakcia,xp,money,opit,url", "id='$id_vraga'");
            $namevrag = $vrag['namevrag'];
            $money = $vrag['money'];
            $xpvrag = $vrag['xp'];
            $opitMoba = $vrag['opit'];
            $urlIma = $vrag['url'];
            $zagolovok = '<br>Бой начался<br>';
            //создаем в logBoy противника
            $this->id_loga = $this->connect->q_c("logBoy",
                "login,id_vrag,namevrag,xp_vrag,to4ka_udara_igroka,money,opit,url", "'$this->sessia_login','$id_vraga','$namevrag','$xpvrag','$zagolovok','$money','$opitMoba','$urlIma'");
            $this->connect->q_u("log", "id_logBoy=$this->id_loga", $this->sessia_id);
            $this->connect->q_u("log", "activregen=0", $this->sessia_id);
            return $this->id_loga;
        } else {
            $this->connect->q_u("log", "activregen=0", $this->sessia_id);
            $this->id_loga = $id_logBoy['id_logBoy'];
        }
    }
    /**
     * покупка в магазине вещь, появляется 
     * в инвентаре
     */
    public function pokupka($id)
    {
        if (is_numeric($id) and $id >= 1) {

            $cenaVewi = $this->connect->q_one("wmot", "cena", "id='$id'");
            $dengiIgroka = $this->money_display();
            $result = $dengiIgroka - $cenaVewi['cena'];

            if ($result >= 0) {
                $this->connect->q_u("log", "money=$result", $this->sessia_id);
                $this->connect->q_c("inventar", "login,id_wmota", "'$this->sessia_login','$id'");
                return $result;
            }
        }

    }

    /**
     * продажа вещь
     * из инвентаре
     */
    public function prodatVew($id,$uID)
    {
        if (is_numeric($id) and $id >= 1 and is_numeric($uID) and $uID >= 1) {

            $cenaVewi = $this->connect->q_one("wmot", "cena", "id='$id'");
            $dengiIgroka = $this->money_display();
            $result = round($dengiIgroka + ($cenaVewi['cena']/1.5));
            
            if ($result >= 0) {
                $this->connect->q_u("log", "money=$result", $this->sessia_id);
                $this->connect->q_delet_id("inventar","$uID");
                return $result;
            }
        }

    }


    /**
     * опыт игрока
     */
    public function opitDisplay()
    {
        $Obwii = $this->connect->q_one("log", "opit,lvl,sposobnosti,naviki,money", "id='$this->sessia_id'");
        if ($Obwii['lvl'] !== 0) {
            $lvlIzTablici = $Obwii['lvl'] - 1;
            $tablOpita = $this->connect->q_one("tabl_opit",
                "kol_opita,kol_stat,kol_navik,kol_deneg", "lvl='$lvlIzTablici'");
            $procentRes = $Obwii['opit'] / $tablOpita['kol_opita'] * 100;
            /**
             * игрок апает лвл если опыт привышает табличный
             * все изменяется в зависомости от таблицы tabl_opit
             */
            if ($Obwii['opit'] > $tablOpita['kol_opita']) {
                $sposob = $Obwii['sposobnosti'] + $tablOpita['kol_stat'];
                $naviki = $Obwii['naviki'] + $tablOpita['kol_navik'];
                $dengi = $Obwii['money'] + $tablOpita['kol_deneg'];


                $this->connect->q_u("log", "lvl=$lvlIzTablici,opit=1,sposobnosti=$sposob,naviki=$naviki,money=$dengi",
                    $this->sessia_id);

            }
            return $procentRes . "%";
        } else {
            return "100%";
        }
    }


    public function xpboy_display()
    {
        $xpMin = $this->connect->q_one("log", "xpMin", "id='$this->sessia_id'");
        return $xpMin['xpMin'];
    }
    public function xpmax_display()
    {
        $xpMax = $this->connect->q_one("log", "xpMax", "id='$this->sessia_id'");
        echo $xpMax['xpMax'];
    }
    public function od_display()
    {
        $od = $this->connect->q_one("log", "od", "id='$this->sessia_id'");
        echo $od['od'];
    }
    public function lvl()
    {

        $lvl = $this->connect->q_one("log", "lvl", "id='$this->sessia_id'");
        echo $lvl['lvl'];

    }

    public function proverka_nali4i_boy()
    {

        $id_logBoy = $this->connect->q_one("log", "id_logBoy", "id='$this->sessia_id'");
        if ($id_logBoy['id_logBoy'] > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function money_display()
    {
        $money = $this->connect->q_one("log", "money", "id='$this->sessia_id'");
        return $money['money'];
    }
    public function naviki_display()
    {
        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        echo $naviki['naviki'];
    }


    public function sposobnosti_display()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        echo $sposobnosti['sposobnosti'];
    }


    public function modul_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "modul", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['modul'] + 1;
            $this->connect->q_u("log", "modul=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function modul_display()
    {
        $modul = $this->connect->q_one("log", "modul", "id='$this->sessia_id'");
        echo $modul['modul'];
    }

    public function komul_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "komul", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['komul'] + 1;
            $this->connect->q_u("log", "komul=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function komul_display()
    {
        $modul = $this->connect->q_one("log", "komul", "id='$this->sessia_id'");
        echo $modul['komul'];
    }
    public function detro_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "detro", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['detro'] + 1;
            $this->connect->q_u("log", "detro=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function detro_display()
    {
        $modul = $this->connect->q_one("log", "detro", "id='$this->sessia_id'");
        echo $modul['detro'];
    }
    public function gidro_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "gidro", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['gidro'] + 1;
            $this->connect->q_u("log", "gidro=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function gidro_display()
    {
        $modul = $this->connect->q_one("log", "gidro", "id='$this->sessia_id'");
        echo $modul['gidro'];
    }
    public function sveto_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "sveto", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['sveto'] + 1;
            $this->connect->q_u("log", "sveto=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function sveto_display()
    {
        $modul = $this->connect->q_one("log", "sveto", "id='$this->sessia_id'");
        echo $modul['sveto'];
    }
    public function petrol_uvel()
    {

        $naviki = $this->connect->q_one("log", "naviki", "id='$this->sessia_id'");
        if ($naviki['naviki'] > 0) {
            $modul = $this->connect->q_one("log", "petrol", "id='$this->sessia_id'");
            $result_nav = $naviki['naviki'] - 1;
            $result = $modul['petrol'] + 1;
            $this->connect->q_u("log", "petrol=$result", $this->sessia_id);
            $this->connect->q_u("log", "naviki=$result_nav", $this->sessia_id);


        }
    }

    public function petrol_display()
    {
        $modul = $this->connect->q_one("log", "petrol", "id='$this->sessia_id'");
        echo $modul['petrol'];
    }

    public function intelekt_uvel()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        if ($sposobnosti['sposobnosti'] > 0) {
            $modul = $this->connect->q_one("log", "intelekt", "id='$this->sessia_id'");
            $result_nav = $sposobnosti['sposobnosti'] - 1;
            $result = $modul['intelekt'] + 1;
            $this->connect->q_u("log", "intelekt=$result", $this->sessia_id);
            $this->connect->q_u("log", "sposobnosti=$result_nav", $this->sessia_id);


        }
    }

    public function intelekt_display()
    {
        $modul = $this->connect->q_one("log", "intelekt", "id='$this->sessia_id'");
        echo $modul['intelekt'];
    }

    public function reakcia_uvel()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        if ($sposobnosti['sposobnosti'] > 0) {
            $modul = $this->connect->q_one("log", "reakcia", "id='$this->sessia_id'");
            $result_nav = $sposobnosti['sposobnosti'] - 1;
            $result = $modul['reakcia'] + 1;
            $this->connect->q_u("log", "reakcia=$result", $this->sessia_id);
            $this->connect->q_u("log", "sposobnosti=$result_nav", $this->sessia_id);


        }
    }


    public function moguwestvo_uvel()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        if ($sposobnosti['sposobnosti'] > 0) {
            $modul = $this->connect->q_one("log", "moguwestvo", "id='$this->sessia_id'");
            $result_nav = $sposobnosti['sposobnosti'] - 1;
            $result = $modul['moguwestvo'] + 1;
            $this->connect->q_u("log", "moguwestvo=$result", $this->sessia_id);
            $this->connect->q_u("log", "sposobnosti=$result_nav", $this->sessia_id);


        }
    }

    public function skorost_uvel()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        if ($sposobnosti['sposobnosti'] > 0) {
            $modul = $this->connect->q_one("log", "skorost", "id='$this->sessia_id'");
            $result_nav = $sposobnosti['sposobnosti'] - 1;
            $result = $modul['skorost'] + 1;
            $this->connect->q_u("log", "skorost=$result", $this->sessia_id);
            $this->connect->q_u("log", "sposobnosti=$result_nav", $this->sessia_id);


        }
    }


    public function reakcia_display()
    {
        $modul = $this->connect->q_one("log", "reakcia", "id='$this->sessia_id'");
        echo $modul['reakcia'];
    }

    public function koncentracia_uvel()
    {

        $sposobnosti = $this->connect->q_one("log", "sposobnosti", "id='$this->sessia_id'");
        if ($sposobnosti['sposobnosti'] > 0) {
            $modul = $this->connect->q_one("log", "koncentracia", "id='$this->sessia_id'");
            $xpMax = $this->connect->q_one("log", "xpMax", "id='$this->sessia_id'");
            $resulXPmax = $xpMax['xpMax'] + 50;
            $result_nav = $sposobnosti['sposobnosti'] - 1;
            $result = $modul['koncentracia'] + 1;
            $this->connect->q_u("log", "xpMax=$resulXPmax", $this->sessia_id);
            $this->connect->q_u("log", "koncentracia=$result", $this->sessia_id);
            $this->connect->q_u("log", "sposobnosti=$result_nav", $this->sessia_id);


        }
    }


    public function koncentracia_display()
    {
        $modul = $this->connect->q_one("log", "koncentracia", "id='$this->sessia_id'");
        echo $modul['koncentracia'];
    }
    public function moguwestvo_display()
    {
        $modul = $this->connect->q_one("log", "moguwestvo", "id='$this->sessia_id'");
        echo $modul['moguwestvo'];
    }
    public function skorost_display()
    {
        $modul = $this->connect->q_one("log", "skorost", "id='$this->sessia_id'");
        echo $modul['skorost'];
    }
    public static function mail_razrabu()
    {
        mail('demonlaz@yandex.com', 'от игрока =>' . $_SESSION['login_user'], $_POST['mail_text']);
    }
    public function obnowTime()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = time();
        $this->connect->q_u("log", "ipv='$ip'", $this->sessia_id);
        $this->connect->q_u("log", "dateactiv=$time", $this->sessia_id);
    }


    /**
     * удаления всех сесий и выход на страницу входа
     */
    public function exit_igri()
    {
        $id_a = $this->sessia_id;
        $this->connect->q_u("log", "dateactiv=0", $id_a);
        require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
        unset($_SESSION['id_user']);
        unset($_SESSION['login_user']);
        $_SESSION = array();
        session_destroy();


    }

}
