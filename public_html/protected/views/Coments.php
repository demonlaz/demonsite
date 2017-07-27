<?php
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['nic']->proverka_nali4i_boy()) {
?>
<!DOCTYPE html>
<html lang='ru'>
<head>
  <title>Главная</title>
  <link rel="shortcut icon" href="images/tree.ico" type="image/x-icon">
  <meta charset='utf-8'>
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/mesag.css" />
  <link rel="stylesheet" type="text/css" href="css/pers.css" />
  
   <link rel="stylesheet" type="text/css" href="css/naviki.css" />
   <link rel="stylesheet" type="text/css" href="css/energia.css" />
   <link rel="stylesheet" type="text/css" href="css/zaklin.css" />
    <link rel="stylesheet" type="text/css" href="css/gorod.css" />
    <link rel="stylesheet" type="text/css" href="css/inventar.css" />
    <link rel="stylesheet" type="text/css" href="css/nav.css" />
    <link rel="stylesheet" type="text/css" href="css/magazin.css" />
 <script src="https://code.jquery.com/jquery-3.0.0.min.js"> </script>
  

<script type="text/javascript" src="js/comenti.js"></script>
 </head>
 <?php if ($_SESSION['login_user'] == "admin") {

?>
        <div id="adminka">
            <form method='post' action='index.php'>
            <input type='submit' name='chistka' value='Очистить' style='color: red; border-radius: 2px;' />
            </form>
        <div id="otkl-regen-xp">
        <form method='post' action='index.php'>
            <input type='submit' name='regen_off' value='Отключить реген' style='color: red; border-radius: 2px;' />
            </form>
            <form method='post' action='index.php'>
            <input type='submit' name='regen_on' value='Включить реген' style='color: green; border-radius: 2px;' />
            </form>

           <form method='post' action='index.php'>
             <input type="text" name="namePers" placeholder="Имя персонажа для удаления" size="100" required />
            <input type='submit' name='deletPers' value='Удалить Перса' style='color: red; border-radius: 2px;' />
            </form>

            <div id="vivod"><?php
            $admin = new adminka();
            $admin->mess_regen();

?></div>
        </div>
        
         </div>

<?php } ?>
<body>
<!--загрузка опыта-->
    <div class="progress-barEXP blueEXP stripes">
        <span id="energXPE" style="width: <?php echo $_SESSION['nic']->opitDisplay();?>;">
           
        </span>
    </div> 
<!--Главная панель навигации****************************************************************-->
<nav class="nav">
    <ul class="ul">
      <li class="navli"><a class="li-a" id="tim" href="#">     <?php echo date("H:i:s"); ?></a></li>
      <li class="navli"><a class="li-a" href="?gorod">Город</a></li>
      <li class="navli"><a class="li-a" href="?naviki">Навыки</a></li>
      <!--<li class="navli"><a class="li-a" href="?zaklin">Заклятье</a></li>-->
      <li class="navli"><a class="li-a" href="?invent">Инвентарь</a></li>
      <li class="navli"><a class="li-a" href="#"><?php echo $_SESSION['nic']->
        money_display(); ?> <img src="images/money.png" /></a></li>
    <li class="navli"><a class="li-a" href="?exit">Выйти</a></li>
   
      
    </ul>
</nav>
 <!--Персонаж****************************************************************-->
<div id="div-nik">
        <h2 id="h2-nik"><?php echo $_SESSION['login_user'] ?></h2>
        <div id="pers-osnovno" class="tooltip">
        
            <div id="lvl"><?php
        $igrokk = new igrok();
        $igrokk->lvl(); ?></div>
                           <a href="?sniat=1"> <img class="odeto" src="<?php $ode=new odevanie(); echo $ode->left_display(); ?>" id="lef-ruka" /></a>
                            <a href="?sniat=2"><img class="odeto" src="<?php  echo $ode->right_display(); ?>" id="right-ruka" /></a>
                           <a href="?sniat=3"> <img class="odeto" src="<?php  echo $ode->art_display(); ?>" id="art" /></a>
                          <a href="?sniat=4"> <img class="odeto" src="<?php  echo $ode->zel_display(); ?>" id="selie"/></a>
          <!--  <a id='vixod-a' href='?exit' class="tooltip" >ВЫХОД</a> -->
        </div>
            <div class="progress-bar blue stripes">
            <span id="energ"><p id="energ2"></p><p id="xp-nad-procentami"><?php echo $_SESSION['nic']->
        xpboy_display(); ?>/<?php $_SESSION['nic']->xpmax_display(); ?></p></span>
        </div>
    </div>
            
     <?php //отоброжает после GET запросов разделы
     zapros::otobrojeneNaGlavnoii();  ?>
<div id="chat">

<div id='info'>
             <ul id='info2'>
             
             </ul>
            
            <ul id="boy-res" >
            
        </ul>

        </div>
<div id='form'>
  <p>
    
    <span class='fld'>
    
    </span>
  </p>
  <p>
    
    <span class='fld'>
    
		<!--<form action="#" method="post">-->
		<input type="text"  id='content'  name="textComent" required='заполни' />
        <input id='submit-id' type='submit' name="smsKnopka" value='Отправить' />
    </span>
  </p>
  <p>
    
    <span class='fld'>
      

<!--</form>-->
      
    </span>
  </p>

<script type="text/javascript">
 function lick(a){
    var nam = " "+'to '+$(a).attr('name')+'}'+' ';
    
    $('#content').val(nam);
    $('#onlain-spisok').load('/protected/connect/spisok-onlain.php');
    }

</script>



</div>

        <div id="onlain">
     <h3 id='h3onlain'>Онлайн</h3>
    <div id="onlain-spisok" >  <?php


        require_once "protected/connect/spisok-onlain.php";
?></div>
 <!-- 
     <div id="razarabu">
   <input type="button" value="Написать разработчику" id="razarabu-input"  /> 
     <form method="post" action="index.php" id="form-mail">
     	<textarea  id="textaria-mail" name="mail_text" required="заполни" ></textarea>
   
      <input type="submit" name="mail_submit" />
     </form>
     </div>
     -->
  </div>
  
</div>
</body>
</html>

<?php
    } else {
        require_once ('boy.php');
    }
} else {
    if (!headers_sent()) {
        header("Location: index.php?vhod");
        exit;
    } else {
        require_once ('A_vhod_views.php');
        //echo "<h1>Вы не зарегистрированы</h1> <a href='?vhod'>Авторизация</a>";
    }
}
?>
