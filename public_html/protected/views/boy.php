<?php
if (isset($_SESSION['id_user'])) {
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/boy.css" />
     <script src="https://code.jquery.com/jquery-3.0.0.min.js"> </script>
    <script type="text/javascript" src="js/boy.js"></script>
    <title>Бой</title>
	<meta charset="utf-8" />
</head>

<body>
    <div id="pers-boy">
        <div id="div-nik">
            <h2 id="h2-nik"><?php $_SESSION['nic']->login(); ?></h2>
            <div id="pers-osnovno" class="tooltip">

                <div id="lvl">
                <?php $_SESSION['nic']->lvl(); ?>
                </div>
              <a href="#"> <img class="odeto" src="<?php $ode=new odevanie(); echo $ode->left_display(); ?>" id="lef-ruka" /></a>
                            <a href="#"><img class="odeto" src="<?php  echo $ode->right_display(); ?>" id="right-ruka" /></a>
                           <a href="#"> <img class="odeto" src="<?php  echo $ode->art_display(); ?>" id="art" /></a>
                          <a href="#"> <img class="odeto" src="<?php  echo $ode->zel_display(); ?>" id="selie"/></a>
              <div id="xp-igrok">
              <h2 id="xp-igroka-h2"><?php echo $_SESSION['nic']->xpboy_display();?></h2>
              </div>
            </div>
            
        </div>







        <div id="boy">

            <div id="mainselection">

                <form method="post" action="#">



            <div class="radio-toolbar" id="radio">

                <input type="radio" id="radio1" name="uron-kuda" value="1" checked>
                <label for="radio1">Ударить в тень</label>

                <input type="radio" id="radio2" name="uron-kuda" value="2">
                <label for="radio2">Ударить в тело</label>

                <input type="radio" id="radio3" name="uron-kuda" value="3">
                <label for="radio3">Ударить в душу</label>

            </div>

            <div class="radio-toolbar2" id="radiodef">

                <input type="radio" id="radio4" name="def-kuda" value="1" >
                <label for="radio4">Защитить тень</label>

                <input type="radio" id="radio5" name="def-kuda" value="2">
                <label for="radio5">Защитить тело</label>

                <input type="radio" id="radio6" name="def-kuda" value="3" checked>
                <label for="radio6">Защитить душу</label>

            </div>
            <input type="submit" name="nanesti-udar" value="КАСТАНУТЬ" id="submit-udar" />
        </form>
            </div>
        </div>
    </div>
<div id="div-nik-vrag">
    <h2 id="h2-nik"><?php echo vrag::display_name_vraga($_SESSION['nic']->id_loga) ?></h2>
    <div id="vrag-skin">
        
        <img id="vrag-img"src="<?php echo vrag::display_images_vraga($_SESSION['nic']->id_loga); ?>"/>
       <h2 id="xp-vragg"><?php echo vrag::display_xp_vraga($_SESSION['nic']->id_loga); ?></h2>
    </div>
    </div>
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
                    <input type="text" id='content' name="textComent">
                    <input id='submit-id' type='submit' name="smsKnopka" value='Отправить' />
                </span>
            </p>
            <p>

                <span class='fld'>


                    <!--</form>-->

                </span>
            </p>

        </div>
<script type="text/javascript">
 function lick(a){
    var nam = " "+'to '+$(a).attr('name')+'}'+' ';
    
    $('#content').val(nam);
    $('#onlain-spisok').load('/protected/connect/spisok-onlain.php');
    }

</script>
        <div id="onlain">
            <h3 id='h3onlain'>Онлайн</h3>
            <div id="onlain-spisok">
                <?php


    require_once "protected/connect/spisok-onlain.php";
?>
            </div>


        </div>

    </div>
</body>
</html>
<?php
} else {
    if (!headers_sent()) {
        header("Location: index.php?vhod");
        exit;
    } else {
        echo "<h1>Вы не зарегистрированы</h1> <a href='?vhod'>Авторизация</a>";
    }
}
?>