<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');


class vewi
{
    protected $connect;
    protected $login;

    protected $id_wmota;
    protected $name;
    protected $intelekt;
    protected $reakcia;
    protected $koncentr;
    protected $moguwestvo;
    protected $skorost;
    protected $kuda;
    protected $cena;
    protected $url_images;
    protected $idWmotaInventar;
    public function __construct()
    {

        $this->connect = BD::connect();
        $this->login = @$_SESSION['login_user'];
        $this->nal_viwei();
    }


    protected function ust_vew($id)
    { //инициализирует веши перед выводом статами и ценой
        $wmotki = $this->connect->q_one("wmot",
            "name,intelekt,reakcia,koncentr,moguwestvo,skorost,kuda,url_images,cena", "id=$id");
        $this->id_wmota = $id;
        $this->name = $wmotki['name'];
        $this->intelekt = $wmotki['intelekt'];
        $this->reakcia = $wmotki['reakcia'];
        $this->koncentr = $wmotki['koncentr'];
        $this->moguwestvo = $wmotki['moguwestvo'];
        $this->skorost = $wmotki['skorost'];
        $this->kuda = $wmotki['kuda'];
        $this->cena = round($wmotki['cena'] / 1.5);
        $this->url_images = $wmotki['url_images'];
        $this->fabrika_wmota();
    }
    /**
     * поиск вещей для инвентаря если находит то
     * выводит их в зависимости от логина 
     */
    protected function nal_viwei()
    {
        //находит каму что принадлежит

        $nali4ia = $this->connect->q_join("inventar.login,inventar.id,inventar.id_wmota",
            "inventar", "log", "log.login=inventar.login", "ORDER BY data_preobretenia");

        while ($result = $nali4ia->fetch_assoc()) {
            if ($result['login'] == $this->login) {
                $this->idWmotaInventar = $result['id'];
                $this->ust_vew($result['id_wmota']);


            }

        }

    }
    protected function fabrika_wmota()
    {
        //делает шаблон для вывода шмоток и выводит его

        echo "<li><a href=index.php?odevaem=$this->id_wmota>";
        echo "<form method=post action=index.php>";
        echo "<h2>$this->name </h2>";
        echo '<p><img src="' . $this->url_images . '" /></p>';
        echo '<p>Интелект + ' . $this->intelekt . '</p>';
        echo '<p>Реакция + ' . $this->reakcia . '</p>';
        echo '<p>Могушество + ' . $this->moguwestvo . '</p>';
        echo '<p>Скорость +' . $this->skorost . '</p>';
        echo '<p>Энергия +' . $this->koncentr . '</p>';
        echo "<input type=hidden name=prodat value=$this->id_wmota  />";
        echo "<input type=hidden name=uID value=$this->idWmotaInventar  />";
        echo "<p><input style=font-famaly:Gotik; type=submit name=prodatja value=Продать />за  $this->cena p</p>";
        echo '</form></a></li>';

    }

}
