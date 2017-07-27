<?php

class zapros
{


    //обработка GET запросов
    public static function get_zapros($get)
    {

        if (isset($get) and !empty($get)) {

            switch ($get) {
                case isset($_GET['vhod']):
                    require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    break;
                case isset($_GET['register']):
                    require_once (realpath('../public_html/protected/views/B_registr_views.php'));
                    break;


                    /**
                     * работа с одноклассниками*******
                     */
                case isset($_GET['ok']):
                    OAuthOK::goToAuth();
                    break;
                case isset($_GET['code']) and !empty($_GET['code']) and isset($_GET['codeOK']):

                    if (!OAuthOK::getToken($_GET['code'])) {
                        die('Error - no token by code');
                        require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    }
                    $user = OAuthOK::getUser();
                    $ok = new vhod_registr();
                    $ok->okRega(OAuthOK::$userId);


                    break;
                case isset($_GET['error']) and !empty($_GET['error']):
                    die($_GET['error']);
                    require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    break;


                    /**
                     * **************************
                     */


                    /**
                     * работа с контактом*******
                     */

                case isset($_GET['vk']):
                    OAuthVK::goToAuth();
                    break;

                case isset($_GET['code']) and !empty($_GET['code']) and isset($_GET['codeVK']):


                    if (!OAuthVK::getToken($_GET['code'])) {
                        die('Error - no token by code');
                        require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    }


                    $user = OAuthVK::getUser();
                    //print_r($user);
                    $vk = new vhod_registr();
                    $vk->vkRega(OAuthVK::$userId);

                    break;


                    /**
                     * ***************************************************
                     */
                case isset($_GET['odevaem']) and isset($_SESSION['nic']):
                    odevanie::odevaem($_GET['odevaem']) ;
                    if (!headers_sent()) {
                        header("Location: index.php?invent");

                    } else {
                        require_once (realpath('../public_html/protected/views/Coments.php'));
                    }
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['sniat']) and isset($_SESSION['nic']):
                    odevanie::snemaem($_GET['sniat']);

                    if (!headers_sent()) {
                        header("Location: index.php?invent");

                    } else {
                        require_once (realpath('../public_html/protected/views/Coments.php'));
                    }

                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['naviki']) and isset($_SESSION['nic']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['zaklin']) and isset($_SESSION['nic']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['gorod']) and isset($_SESSION['nic']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['invent']) and isset($_SESSION['nic']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['magazin']) and isset($_SESSION['nic']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                    /**
                     * выберает противника относительно его индекса в базе*****************
                     */
                case isset($_GET['napast']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->sozdat_vraga(mt_rand(1,3));
                    require_once (realpath('../public_html/protected/views/boy.php'));
                    break;
                    /**
                     * **********************************************************************
                     */
                case isset($_GET['delettt']):
                    if ($_SESSION['login_user'] === 'admin') {
                        adminka::delet_id();
                        require_once (realpath('../public_html/protected/views/Coments.php'));
                    }
                    break;
                case isset($_GET['x']):
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    $_SESSION['nic']->obnowTime();
                    break;
                case isset($_GET['exit']):
                    if (isset($_SESSION['nic'])) {
                        $_SESSION['nic']->exit_igri();
                    } else {
                        require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    }
                    break;

                default:

                    require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    break;
            }

        }
    }


    public static function post_zapros($post)
    {
        if (isset($post) and !empty($post)) {

            switch ($post) {
                case isset($_POST['registr']):
                    $registr = new vhod_registr();
                    $registr->regist();
                    break;
                case isset($_POST['vhod']):
                    $vhodd = new vhod_registr();
                    $vhodd->vhod();
                    break;
                case isset($_POST['kupit']) and isset($_SESSION['nic']):
                   // $p = $_POST['kupit'];

                     $_SESSION['nic']->pokupka($_POST['kupit']);
                    header("Location: index.php?magazin&ruka=1");
                    break;
                case isset($_POST['prodat']) and isset($_POST['uID']) and isset($_SESSION['nic']):
                  

                     $_SESSION['nic']->prodatVew($_POST['prodat'],$_POST['uID']);
                    header("Location: index.php?invent");
                    break;    
                case isset($_POST['mail_submit']):
                    igrok::mail_razrabu();
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    break;
                case isset($_POST['chistka']) and isset($_SESSION["admin"]):

                    $_SESSION["admin"]->delet_sms();
                    require_once (realpath('../public_html/protected/views/Coments.php'));

                    break;
                case isset($_POST['deletPers']) and isset($_SESSION["admin"]):

                    $_SESSION["admin"]->deletPers();
                    require_once (realpath('../public_html/protected/views/Coments.php'));

                    break;
                case isset($_POST['regen_off']) and isset($_SESSION["admin"]):
                    $_SESSION["admin"]->stop_regen();
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    break;
                case isset($_POST['regen_on']) and isset($_SESSION["admin"]):
                    $_SESSION["admin"]->activ_regen();
                    require_once (realpath('../public_html/protected/views/Coments.php'));
                    break;
                case isset($_POST['modul']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->modul_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['komul']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->komul_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['detro']):
                    $_SESSION['nic']->detro_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['gidro']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->gidro_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['sveto']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->sveto_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['petrol']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->petrol_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['intelekt']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->intelekt_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['reakcia']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->reakcia_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['koncentracia']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->koncentracia_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['moguwestvo']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->moguwestvo_uvel();
                    header("Location: index.php?naviki");
                    break;
                case isset($_POST['skorost']) and isset($_SESSION['nic']):
                    $_SESSION['nic']->skorost_uvel();
                    header("Location: index.php?naviki");
                    break;

                case isset($_POST['nanesti-udar']) and isset($_SESSION['nic']):

                    //обработка атк запросов
                    $_SESSION['nic']->sozdat_vraga(2);
                    $na4alaBoy = new boy_class(2);

                    require_once (realpath('../public_html/protected/views/boy.php'));

                    break;

                case isset($_POST['smsKnopka']) && isset($_SESSION["login_user"]) && isset($_POST["textComent"]):
                    if (!empty($_POST['textComent'])) {
                        require_once ('protected/connect/comentBD.php');
                        header("Location: index.php?x");
                    }
                    break;
                default:
                    require_once (realpath('../public_html/protected/views/A_vhod_views.php'));
                    break;
            }

        }
    }

    public static function otobrojeneNaGlavnoii()
    {
        switch ($_GET) {
            case isset($_GET['naviki']):
                require_once (realpath("../public_html/protected/views2/naviki.php"));
                break;
            case isset($_GET['zaklin']):
                require_once (realpath("../public_html/protected/views2/zaklin.php"));
                break;
            case isset($_GET['gorod']):
                require_once (realpath("../public_html/protected/views2/gorod.php"));
                break;
            case isset($_GET['invent']):
                require_once (realpath("../public_html/protected/views2/inventar.php"));
                break;
            case isset($_GET['magazin']):
                require_once (realpath("../public_html/protected/views2/magazinViews.php"));
                break;

        }

    }
    public static function post_zapros_boy()
    {
        if (isset($_POST['nanesti-udar']) and !empty($_POST['nanesti-udar'])) {

            $_SESSION['nic']->sozdat_vraga(2);
            $na4alaBoy = new boy_class(2);
            require_once (realpath('../public_html/protected/views/boy.php'));


        }


    }
}
