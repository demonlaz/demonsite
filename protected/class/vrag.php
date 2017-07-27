<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');
class vrag
{
    // 1 интелект,реакция =1-6 урона,1-6 защита
    private $xp;
    public $namevrag;
    public $money;
    public $opit;
    public $urlIma;
    private $intelect;
    private $reakcia;
    private $connect;
    private $dmgMax;
    private $dmgMin;
    private $dmg;
    private $uron_posle_bloka;
    public function __construct($id)
    {
        $this->connect = BD::connect();
        //получаем параметры врага
        $vrag = $this->connect->q_one("vrag", "namevrag,intelekt,reakcia,xp,money,opit,url",
            "id='$id'");
        $this->xp = $vrag['xp'];
        $this->namevrag = $vrag['namevrag'];
        $this->reakcia = $vrag['reakcia'];
        $this->intelect = $vrag['intelekt'];
        $this->money = $vrag['money'];
        $this->opit = $vrag['opit'];
        $this->urlIma = $vrag['url'];
    }
    //нанасимый урон
    public function dmg()
    {

        $this->dmgMax = $this->intelect * 10;
        $this->dmgMin = $this->intelect * 5;
        $this->dmg = mt_rand($this->dmgMin, $this->dmgMax);

        return $this->dmg;
    }
    //урон минус то что отняла защита
    public function uron($kol_pol_urona)
    {


        $kol_blok_urona = $kol_pol_urona / 100 * $this->reakcia;
        $this->uron_posle_bloka = $kol_pol_urona - $kol_blok_urona;
        return $this->uron_posle_bloka;

    }
    //вычитает xp
    public function nasto_xp()
    {
        $this->xp = $this->xp - $this->uron_posle_bloka;

    }
    //куда бьет моб
    public static function tochka_udara()
    {
        $x = mt_rand(1, 3);
        return $x;
    }

    public static function tochka_zawiti()
    {
        $x = mt_rand(1, 3);
        return $x;

    }

    public static function display_xp_vraga($id)
    {
        $connect = BD::connect();
        $vrag = $connect->q_one("logBoy", "xp_vrag", "id='$id'");
        return $vrag['xp_vrag'];
    }
    public static function display_name_vraga($id)
    {
        $connect = BD::connect();
        $namevrag = $connect->q_one("logBoy", "namevrag", "id='$id'");
        return $namevrag['namevrag'];
    }
     public static function display_images_vraga($id)
    {
        $connect = BD::connect();
        $url = $connect->q_one("logBoy", "url", "id='$id'");
        return $url['url'];
    }


}





?>