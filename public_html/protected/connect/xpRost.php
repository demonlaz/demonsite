<?php
@session_start();
function rostXp()
{
    if (isset($_SESSION['id_user'])) {
        @$id = $_SESSION['id_user'];
        $url = $_SERVER['DOCUMENT_ROOT'];
        require_once ($url . '/protected/connect/BD.php');
        $connect = BD::connect();
         $activ = $connect->q_one("log", "activregen", "id=$id");
       
        $xp = $connect->q_one("log", "xpMin,xpMax","id=$id");
        $max=$xp['xpMax'];
            $timeregen = $connect->q_one("log", "timeregena", "id=$id");
            $time_nastoiawie = time();
           
 $time = $time_nastoiawie - $timeregen['timeregena'];
if ($xp['xpMin'] > $xp['xpMax'] and $activ['activregen'] == 1){
            $connect->q_u("log", "xpMin=$max", $id);
       $connect->q_u("log", "timeregena=$time_nastoiawie", $id);
              $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                echo ($procenti . '%');       }
         else   if($xp['xpMin'] < $xp['xpMax'] and $time>=600 and $activ['activregen'] == 1)
            {   $connect->q_u("log", "xpMin=$max", $id); 
             $connect->q_u("log", "timeregena=$time_nastoiawie", $id);
                $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                echo ($procenti . '%');  }
                     
         else    if ($xp['xpMin'] < $xp['xpMax'] and $time >= 60 and $activ['activregen'] == 1) {
	               
            
                $connect->q_u("log", "timeregena=$time_nastoiawie", $id);
                $xpmin = $xp['xpMin'];
                $xpmin =  $xpmin+$xp['xpMax']/100*10;
                $connect->q_u("log", "xpMin=$xpmin", $id);
                $procenti = $xp['xpMin'] / $xp['xpMax'] * 100;
                echo ($procenti . '%');

           
        } else {
            $procenti = ($xp['xpMin'] / $xp['xpMax']) * 100;
            echo ($procenti . '%');
        }
    }
}

rostXp();
?>