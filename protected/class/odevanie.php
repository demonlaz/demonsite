<?php

$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');

class odevanie
{
    protected $connect;
    protected $id_igroka;
    protected $login;
    public $left_ruka;
    public $right_ruka;
    public $artifakt;
    public $zelie;

    public function __construct()
    {

        $this->connect = BD::connect();
        $this->login = @$_SESSION['login_user'];
        $this->id_igroka = @$_SESSION['id_user'];
        $this->proverkaNadetoVew();


    }

    protected function proverkaNadetoVew()
    {

        $odejda = $this->connect->q_one("log", "left_ruka,right_ruka,artifakt,zelie",
            "id='$this->id_igroka'");
        $this->left_ruka = $odejda['left_ruka'];
        $this->right_ruka = $odejda['right_ruka'];
        $this->artifakt = $odejda['artifakt'];
        $this->zelie = $odejda['zelie'];
    }
    /**
     * вывод изображения одетых шмотак 
     */
    public function left_display()
    {

        if ($this->left_ruka != 0) {
            $url_images = $this->connect->q_one("wmot", "url_images", "id='$this->left_ruka'");
            return $url_images['url_images'];
        }
    }
    public function right_display()
    {
        if ($this->right_ruka != 0) {
            $url_images = $this->connect->q_one("wmot", "url_images", "id='$this->right_ruka'");
            return $url_images['url_images'];
        }
    }
    public function art_display()
    {
        if ($this->artifakt != 0) {
            $url_images = $this->connect->q_one("wmot", "url_images", "id='$this->artifakt'");
            return $url_images['url_images'];
        }
    }
    public function zel_display()
    {
        if ($this->zelie != 0) {
            $url_images = $this->connect->q_one("wmot", "url_images", "id='$this->zelie'");
            return $url_images['url_images'];
        }
    }

    public static function odevaem($get)
    {
        $odejda = new odevanie();
        $login = @$_SESSION['login_user'];
        $id = @$_SESSION['id_user'];
        $connect = BD::connect();
        if (is_numeric($get)) {
            $invent = $connect->q_arr("inventar");
            //ищем придмет в инвентаре
            while ($result = $invent->fetch_assoc()) {
                if ($result["login"] == $login and $result['id_wmota'] == $get) {
                    $idWmotaInventar = $result["id"];
                    //нашли придмет в инвентаре одевай в зависомости от принадлежности
                    $kuda = $connect->q_one("wmot", "kuda", "id='$get'");

                    if ($kuda['kuda'] == 1) {
                        //одеваем на левую руку
                        if ($odejda->left_ruka == 0) {
                            $connect->q_u("log", "left_ruka=$get", "$id");

                            //дабваляем статы веши
                            $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                                "id=$get");
                            $modul = $connect->q_one("log",
                                "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                            $intelekt = $modul['intelekt'] + $wmotki['intelekt'];
                            $reakcia = $modul['reakcia'] + $wmotki['reakcia'];
                            $koncentr = $modul['xpMax'] + $wmotki['koncentr'];
                            $moguwestvo = $modul['moguwestvo'] + $wmotki['moguwestvo'];
                            $skorost = $modul['skorost'] + $wmotki['skorost'];
                            $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                                "$id");


                            $connect->q_delet_id("inventar", "$idWmotaInventar");
                        } else {
                            odevanie::snemaem(1);
                        }
                        break;

                    } else
                        if ($kuda['kuda'] == 2) {
                            //одеваем на правую руку
                            if ($odejda->right_ruka == 0) {
                                $connect->q_u("log", "right_ruka=$get", "$id");

                                //дабваляем статы веши

                                 $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                                "id=$get");
                            $modul = $connect->q_one("log",
                                "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                            $intelekt = $modul['intelekt'] + $wmotki['intelekt'];
                            $reakcia = $modul['reakcia'] + $wmotki['reakcia'];
                            $koncentr = $modul['xpMax'] + $wmotki['koncentr'];
                            $moguwestvo = $modul['moguwestvo'] + $wmotki['moguwestvo'];
                            $skorost = $modul['skorost'] + $wmotki['skorost'];
                            $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                                "$id");


                            $connect->q_delet_id("inventar", "$idWmotaInventar");
                            } else {
                                odevanie::snemaem(2);
                            }
                            break;
                        } else
                            if ($kuda['kuda'] == 3) {
                                //одевайм артифакт
                                if ($odejda->artifakt == 0) {
                                    $connect->q_u("log", "artifakt=$get", "$id");


                                    //дабваляем статы веши
                                     $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                                "id=$get");
                            $modul = $connect->q_one("log",
                                "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                            $intelekt = $modul['intelekt'] + $wmotki['intelekt'];
                            $reakcia = $modul['reakcia'] + $wmotki['reakcia'];
                            $koncentr = $modul['xpMax'] + $wmotki['koncentr'];
                            $moguwestvo = $modul['moguwestvo'] + $wmotki['moguwestvo'];
                            $skorost = $modul['skorost'] + $wmotki['skorost'];
                            $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                                "$id");


                            $connect->q_delet_id("inventar", "$idWmotaInventar");
                                } else {
                                    odevanie::snemaem(3);
                                }
                                break;
                            } else {
                                //одеваем зелье
                                if ($odejda->zelie == 0) {
                                    $connect->q_u("log", "zelie=$get", "$id");


                                    //дабваляем статы веши
                                     $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                                "id=$get");
                            $modul = $connect->q_one("log",
                                "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                            $intelekt = $modul['intelekt'] + $wmotki['intelekt'];
                            $reakcia = $modul['reakcia'] + $wmotki['reakcia'];
                            $koncentr = $modul['xpMax'] + $wmotki['koncentr'];
                            $moguwestvo = $modul['moguwestvo'] + $wmotki['moguwestvo'];
                            $skorost = $modul['skorost'] + $wmotki['skorost'];
                            $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                                "$id");


                            $connect->q_delet_id("inventar", "$idWmotaInventar");
                                } else {
                                    odevanie::snemaem(4);
                                }
                                break;
                            }

                }
            }
        }
    }

    public static function snemaem($get)
    {
        $login = @$_SESSION['login_user'];
        $id = @$_SESSION['id_user'];
        $odejda = new odevanie();
        $connect = BD::connect();
        //$maxIdWmota = $connect->q_max("wmot", "id");
        if (is_numeric($get) and $get <= 4 and $get != 0) {


            if ($get == 1 and $odejda->left_ruka != 0) {
                //снемаем на левую руку
                $connect->q_c("inventar", "login,id_wmota", "'$login','$odejda->left_ruka'");


                //уменьшаем статы веши
                $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                    "id=$odejda->left_ruka");
                $modul = $connect->q_one("log",
                    "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                $intelekt = $modul['intelekt'] - $wmotki['intelekt'];
                $reakcia = $modul['reakcia'] - $wmotki['reakcia'];
                $koncentr = $modul['xpMax'] - $wmotki['koncentr'];
                $moguwestvo = $modul['moguwestvo'] - $wmotki['moguwestvo'];
                $skorost = $modul['skorost'] - $wmotki['skorost'];
                $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                    "$id");


                $connect->q_u("log", "left_ruka=0", "$id");


            } else
                if ($get == 2 and $odejda->right_ruka != 0) {
                    //снемаем на правую руку
                    $connect->q_c("inventar", "login,id_wmota", "'$login','$odejda->right_ruka'");


                    //уменьшаем статы веши
                    $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                        "id=$odejda->right_ruka");
                    $modul = $connect->q_one("log",
                        "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                    $intelekt = $modul['intelekt'] - $wmotki['intelekt'];
                    $reakcia = $modul['reakcia'] - $wmotki['reakcia'];
                    $koncentr = $modul['xpMax'] - $wmotki['koncentr'];
                    $moguwestvo = $modul['moguwestvo'] - $wmotki['moguwestvo'];
                    $skorost = $modul['skorost'] - $wmotki['skorost'];
                    $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                        "$id");

                    $connect->q_u("log", "right_ruka=0", "$id");

                } else
                    if ($get == 3 and $odejda->artifakt != 0) {
                        //снемаем артифакт
                        $connect->q_c("inventar", "login,id_wmota", "'$login','$odejda->artifakt'");


                        //уменьшаем статы веши
                        $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                            "id=$odejda->artifakt");
                        $modul = $connect->q_one("log",
                            "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                        $intelekt = $modul['intelekt'] - $wmotki['intelekt'];
                        $reakcia = $modul['reakcia'] - $wmotki['reakcia'];
                        $koncentr = $modul['xpMax'] - $wmotki['koncentr'];
                        $moguwestvo = $modul['moguwestvo'] - $wmotki['moguwestvo'];
                        $skorost = $modul['skorost'] - $wmotki['skorost'];
                        $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                            "$id");


                        $connect->q_u("log", "artifakt=0", "$id");

                    } else
                        if ($get == 4 and $odejda->zelie != 0) {
                            //оснемаем зелье
                            $connect->q_c("inventar", "login,id_wmota", "'$login','$odejda->zelie'");


                            //уменьшаем статы веши
                            $wmotki = $connect->q_one("wmot", "intelekt,reakcia,koncentr,moguwestvo,skorost",
                                "id=$odejda->zelie");
                            $modul = $connect->q_one("log",
                                "intelekt,reakcia,xpMax,moguwestvo,skorost", "id='$id'");
                            $intelekt = $modul['intelekt'] - $wmotki['intelekt'];
                            $reakcia = $modul['reakcia'] - $wmotki['reakcia'];
                            $koncentr = $modul['xpMax'] - $wmotki['koncentr'];
                            $moguwestvo = $modul['moguwestvo'] - $wmotki['moguwestvo'];
                            $skorost = $modul['skorost'] - $wmotki['skorost'];
                            $connect->q_u("log", "intelekt=$intelekt,reakcia=$reakcia,xpMax=$koncentr,moguwestvo=$moguwestvo,skorost=$skorost",
                                "$id");


                            $connect->q_u("log", "zelie=0", "$id");

                        }


        }
    }

}
