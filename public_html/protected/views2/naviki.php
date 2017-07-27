
<div id="naviki">
       <!-- <h3 id="nerasp-stati">0</h3> -->
      <!--  <ul id="dotted">
        <li><span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Навыки </span><span><?php $_SESSION['nic']->naviki_display(); ?></span></li>
            <form method="post" action="index.php"> <li><span>Модуляция <input id="modul" class="plus" name="modul" type="submit" value="+" /></span ><span id="span-modul" ><?php $_SESSION['nic']->modul_display(); ?></span></li></form>
           <form method="post" action="index.php">  <li><span>Комуляция  <input class="plus" name="komul" type="submit" value="+" /></span><span><?php $_SESSION['nic']->komul_display(); ?></span></li></form>
            <form method="post" action="index.php"> <li><span>Детроляция <input class="plus" name="detro" type="submit" value="+" /></span><span><?php $_SESSION['nic']->detro_display(); ?></span></li></form>
           <form method="post" action="index.php">  <li><span>Гидроляция <input class="plus" name="gidro" type="submit" value="+" /></span><span><?php $_SESSION['nic']->gidro_display(); ?></span></li></form>
           <form method="post" action="index.php">  <li><span>Светоляция <input class="plus" name="sveto" type="submit" value="+" /></span><span><?php $_SESSION['nic']->sveto_display(); ?></span></li></form>
           <form method="post" action="index.php">  <li><span>Петроляция <input class="plus" name="petrol" type="submit" value="+" /></span><span><?php $_SESSION['nic']->petrol_display(); ?></span></li></form>
        </ul>-->
        <ul id="dotted" >
        <li><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Способности</span><span><?php $_SESSION['nic']->sposobnosti_display(); ?></span></li>
           <form method="post" action="index.php">  <li><span id="osnov-stat">Интелект  <input class="plus" name="intelekt" type="submit" value="+" /></span><span><?php $_SESSION['nic']->intelekt_display(); ?></span><span class="tooltip">Урон</span></li></form>
          <form method="post" action="index.php">   <li><span id="osnov-stat">Реакция  <input class="plus" name="reakcia" type="submit" value="+" /></span><span><?php $_SESSION['nic']->reakcia_display(); ?></span><span class="tooltiptext">Защита</span></li></form>
           <form method="post" action="index.php">  <li><span id="osnov-stat">Концентрация <input class="plus" name="koncentracia" type="submit" value="+" /></span><span><?php $_SESSION['nic']->koncentracia_display() ?></span><span class="tooltiptext">Энергия</span></li></form>
             <form method="post" action="index.php">  <li><span id="osnov-stat"> Могущество<input class="plus" name="moguwestvo" type="submit" value="+" /></span><span><?php $_SESSION['nic']->moguwestvo_display() ?></span><span class="tooltiptext">Шанс крита</span></li></form>
             <form method="post" action="index.php">  <li><span id="osnov-stat">Скорость<input class="plus" name="skorost" type="submit" value="+" /></span><span><?php $_SESSION['nic']->skorost_display() ?></span><span class="tooltiptext">Шанс Уворота</span></li></form>
            
        </ul>
    </div>

