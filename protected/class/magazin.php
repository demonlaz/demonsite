<?php

$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');

class magazin extends vewi
{
    private $ruka;
    public function __construct($ruka = 1)
    {
        if (isset($_GET['ruka']) and is_int($_GET['ruka']) and $_GET['ruka'] >= 1 and $_GET['ruka'] <=4) {
            $this->ruka = $_GET['ruka'];

        } else {
            $this->ruka = $ruka;
        }
        //$this->ruka=$ruka;
        parent::__construct();
    }
        /**
         * подключается к таблицы с образцом шмота
         * проверяет куда одевается шмотка 
         * и инициализирует найденую вешь статами
         */
    protected function nal_viwei()
    {

        $nali4ia = $this->connect->q_arr("wmot");
        while ($result = $nali4ia->fetch_assoc()) {
            if ($result['kuda'] == $this->ruka) {
                $this->ust_vew($result['id']);
            }

        }

    }
    /**
     * выводит шаблон в магазин
     */
    protected function fabrika_wmota(){
        
        echo '<li><a href="#">';
              echo "<form method=post action=index.php>";
              echo "<h2>$this->name </h2>";           
              echo '<p><img src="'.$this->url_images.'" /></p>';
              echo '<p>Интелект + '.$this->intelekt.'</p>';
              echo '<p>Реакция + '.$this->reakcia.'</p>';    
              echo '<p>Могушество + '.$this->moguwestvo.'</p>';
              echo '<p>Скорость +'.$this->skorost.'</p>';
              echo '<p>Энергия +'. $this->koncentr.'</p>';
              echo "<input type=hidden name=kupit value=$this->id_wmota  />";
              echo "<p><input style=font-famaly:Gotik; type=submit name=pokupka value=Купить />за  $this->cena p</p>";
              echo '</form></a></li>';
    }

}
