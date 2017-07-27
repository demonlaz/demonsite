<?php
$url = $_SERVER['DOCUMENT_ROOT'];
require_once ($url . '/protected/connect/BD.php');
class adminka
{
    private $connect;
    
    private $sessia_admin;
    
    public function __construct()
    {
        $this->connect = BD::connect();
        $this->sessia_admin=$_SESSION['login_user'];
    }

    public function delet_sms()
    {
//mail("demonlaz@yandex.com","test","active");

        $this->connect->q_delet('mesag');
        $this->connect->q_delet('privat_mesag');
    }
    
      public function deletPers()
    {
//mail("demonlaz@yandex.com","test","active");

       
        $this->connect->q_delet_login('log',$_POST['namePers']);
    }
    public function stop_regen()
    {

        $this->connect->q_u_all('log', 'activregen=0');
    }
    public function activ_regen()
    {

        $this->connect->q_u_all('log', 'activregen=1');
      //   mail("demonlaz@mail.com","test","active");
    }
    public  static function delet_id(){
        $id=$_GET['delettt'];
             $connect = BD::connect();
                   $connect->q_delet_id('mesag',$id);
                  
  }
   public function mess_regen(){
    $status_regen=$this->connect->q_one("log","activregen","login='admin'");
        
            if($status_regen['activregen']==1){
                echo "<p style='color:green'>activated regeneration<p>";
            }else{
                echo "regeneration is stopped";
            }
   }
  
}


?>