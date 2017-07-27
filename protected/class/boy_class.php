<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');
class boy_class
{ //id бой
    private $id_boy;
    //игрок
    private $id_igroka;
    private $to4ka_udara_igrok;
    private $to4ka_zawiti_igrok;
    private $nanes_uron_igrok;
    private $uvorot_igroka;
    //враг
    private $to4ka_udara_vrag;
    private $to4ka_zawiti_vrav;
    private $nanes_uron_vrag;
    private $vrag;
    private $connect;
    private $money;
    private $opit;
    public $namevrag;
    /**
     * 
     */
    public function __construct($id)
    {
        $this->id_igroka = $_SESSION['id_user'];
        $this->id_boy = $_SESSION['nic']->id_loga;
        $this->connect = BD::connect();
        //обьект врага
        $this->vrag = new vrag($id);
        //получаем имя врага
        $this->namevrag = $this->vrag->namevrag;
        //получаем кол денег с врага
        $this->money = $this->vrag->money;
        //получаем кол опыта с врага
        $this->opit = $this->vrag->opit;
        
        
        
        //точки удара игрока
        $this->to4ka_udara_igrok = $this->vi4eslenia_kuda_udaril_igrok();
        $this->to4ka_zawiti_igrok = $this->vi4eslenia_kuda_zawiwaet_igrok();
        $this->uvorot_igroka=$_SESSION['nic']->wansUvorota();
        //точки удара врага
        $this->to4ka_udara_vrag = vrag::tochka_udara();
        $this->to4ka_zawiti_vrav = vrag::tochka_zawiti();
        $this->nanes_uron_igrok = $this->proverka_na_popodanie_igrok();
        $this->nanes_uron_vrag = $this->proverka_na_popodanie_vrag();
        $this->nanosit_uron_igrok();
        $this->nanosit_uron_vrag();


        $time = time();
        $this->connect->q_u("log", "dateactiv=$time", $_SESSION['id_user']);
    }
    /**
     * игрок наносит урон и наносимый урон с вычитой
     *  хп врага заносится в базу если бот не поставил блок
     */
    private function nanosit_uron_igrok()
    {

        
        if ($this->nanes_uron_igrok == true) {

            $uron = $_SESSION['nic']->dmg();
            $itog_uron = $this->vrag->uron($uron);
            $vrag = $this->connect->q_one("logBoy", "xp_vrag,to4ka_udara_igroka", "id='$this->id_boy'");
            $itog_xp = $vrag['xp_vrag'] - $itog_uron;
            $this->connect->q_u("logBoy", "xp_vrag=$itog_xp", $this->id_boy);
            //дата нанисения урона
            $date = date('c');
            $dysplay_udar = $this->dysplay_to4ki_udara($this->to4ka_udara_igrok);
            $soobwenie_v_basu = "<br>" . $date . "<br> " . $_SESSION['login_user'] .
                "  ударил $this->namevrag в $dysplay_udar урона =$itog_uron " . $vrag['to4ka_udara_igroka'];
            $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu'", $this->
                id_boy);
            //смерть бота
            if (vrag::display_xp_vraga($this->id_boy) <= 0) {
                //кол денег с моба
                $res_deneg_smoba = mt_rand($this->money/2, $this->money);
                 $res_opit_smoba = mt_rand($this->opit/2, $this->opit);
                $vragg = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$this->id_boy'");
                $soobwenie_v_basu_end = "<br> $this->namevrag сканчался..... <br> Выпало $res_deneg_smoba рублей <br> <br> Получено $res_opit_smoba опыта <br>Бой Окончин!" .
                    $vragg['to4ka_udara_igroka'];
                $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu_end'", $this->
                    id_boy);
                $this->connect->q_u("log", "activregen=1", $this->id_igroka);
                $this->connect->q_u("log", "id_logBoy=null", $this->id_igroka);
                //в классе игрок добавим  денег и оптыта с моба
                $_SESSION['nic']->dobavim_opit($res_opit_smoba );
                $_SESSION['nic']->dobavim_deneg($res_deneg_smoba);
                header("Location: index.php?x");
            }
        } else {
            //игрок ударяет в блок
            $vrag = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$this->id_boy'");
            $date = date('c');
            $dysplay_udar = $this->dysplay_to4ki_udara($this->to4ka_udara_igrok);
            $soobwenie_v_basu_end = "<br> $date <br>$this->namevrag заблокировал удар в $dysplay_udar " .
                $vrag['to4ka_udara_igroka'];
            $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu_end'", $this->
                id_boy);
        }

    }

    /**
     * урон наносит враг
     */
    private function nanosit_uron_vrag()
    {
        $date = date('c');
        $login = $_SESSION['login_user'];
        $id = $_SESSION['id_user'];
        if ($this->nanes_uron_vrag == true and $this->uvorot_igroka===false) {
            $uron_vraga = $this->vrag->dmg();
            $resul_urona_ot_vraga = $_SESSION['nic']->uron($uron_vraga);
            $igrok = $this->connect->q_one("log", "xpMin", "id='$this->id_igroka'");
            $itogxp = $igrok['xpMin'] - $resul_urona_ot_vraga;
            $this->connect->q_u("log", "xpMin='$itogxp'", $this->id_igroka);
            $vrag = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$this->id_boy'");
            $dysplay_udar = $this->dysplay_to4ki_udara($this->to4ka_udara_vrag);
            //вывод наносимого урона
            $soobwenie_v_basu = "<br>" . $date . "<br>" . $this->namevrag . "   ударил $login в $dysplay_udar урона =$resul_urona_ot_vraga " .
                $vrag['to4ka_udara_igroka'];
            $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu'", $this->
                id_boy);
            if ($itogxp <= 0) {
                //смерть игрока запись в базу
                $soobwenie_v_basu = "<br>" . $date . "<br>" . $this->namevrag . "   Убил $login ..... Бой Окончен! " .
                    $vrag['to4ka_udara_igroka'];
                $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu'", $this->
                    id_boy);
                    //включает реген игрока 
                $this->connect->q_u("log", "xpMin=1", $this->id_igroka);
                $this->connect->q_u("log", "activregen=1", $this->id_igroka);
                $this->connect->q_u("log", "id_logBoy=null", $this->id_igroka);

                header("Location: index.php?x");
            }
        
        
        
        }else if($this->uvorot_igroka===true){
         //враг ударяет в блок
            $vrag = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$this->id_boy'");
            $date = date('c');
            $dysplay_udar = $this->dysplay_to4ki_udara($this->to4ka_udara_vrag);
            $soobwenie_v_basu_end = "<br> $date <br> $login увернулся от удар в $dysplay_udar " .
                $vrag['to4ka_udara_igroka'];
            $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu_end'", $this->
                id_boy);
        
        } else {
            //враг ударяет в блок
            $vrag = $this->connect->q_one("logBoy", "to4ka_udara_igroka", "id='$this->id_boy'");
            $date = date('c');
            $dysplay_udar = $this->dysplay_to4ki_udara($this->to4ka_udara_vrag);
            $soobwenie_v_basu_end = "<br> $date <br> $login заблокировал удар в $dysplay_udar " .
                $vrag['to4ka_udara_igroka'];
            $this->connect->q_u("logBoy", "to4ka_udara_igroka='$soobwenie_v_basu_end'", $this->
                id_boy);


        }
    }
    /**
     * 
     */
    private function dysplay_to4ki_udara($to4ka_udara)
    {

        switch ($to4ka_udara) {
            case 1:
                return "тень";
                break;
            case 2:
                return "физ";
                break;
            case 3:
                return "душу";
                break;

        }
    }


    private function vi4eslenia_kuda_udaril_igrok()
    { //запросы на атаку
        return $_POST['uron-kuda'];
    }

    private function vi4eslenia_kuda_zawiwaet_igrok()
    {
        //запросы на защиту
        return $_POST['def-kuda'];
    }
    private function proverka_na_popodanie_igrok()
    {
        if ($this->to4ka_udara_igrok == $this->to4ka_zawiti_vrav) {
            return false;
        } else {
            return true;
        }

    }
    private function proverka_na_popodanie_vrag()
    {
        if ($this->to4ka_udara_vrag == $this->to4ka_zawiti_igrok) {
            return false;
        } else {
            return true;
        }

    }
}
?>