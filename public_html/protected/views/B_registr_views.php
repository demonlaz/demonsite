
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Вход</title>
	<link rel="stylesheet" href="css/registr.css" media="screen" type="text/css" />
	<link rel="icon" href="images/tree.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/tree.ico" type="image/x-icon">
</head>

<body>



  <form action="index.php" method="post">

  <h1>Регистр</h1>
  <input class="user" type="text" placeholder="Логин" name="login" required />
   <input class="pass" type="email" placeholder="Mail" name="mailt" required />
  <input class="pass" type="password" placeholder="Пароль" name="password1" required />
  <input class="pass" type="password" placeholder="Пароль повторить" name="password2" required />
  <input class="btn"  type="submit" name="registr" value="ВОЙТИ" />

  <hr style="background-color : #bebebe;"/>
  <hr style="background-color : #FFF; "/>

  <h5><a href="">Забыли пароль?</a> | <a href="?vhod">Авторизация</a></h5>

<div class="setting">
    <a class="icon-cog" href="#"></a>
    <h6  class="set">настройки</h6>
    <div class="middle" style="left : 6px;"></div>
    <div class="middle" style="left : 18px;"></div>
    <div class="middle" style="left : 30px;"></div>
    <div class="middle" style="left : 42px;"></div>
    <div class="side left"></div>
    <div class="side right"></div>
  </div>

</form>


</body>

</html>








