
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Вход</title>
	
	<link rel="stylesheet" href="css/vhod.css" media="screen" type="text/css" />
	<link rel="icon" href="images/tree.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/tree.ico" type="image/x-icon">
     <script src="https://code.jquery.com/jquery-3.0.0.min.js"> </script>
    <script type="text/javascript" src="js/vhod.js"></script>

</head>

<body>



<form action="index.php" method="post"> 

  <h1>Войти</h1>
  <input class="user" type="text" placeholder="Логин" name="login" id="login" required />
  <input class="pass" type="password" placeholder="Пароль" name="password" id="password" required />
  <input class="btn"  type="submit" name="vhod" id="submit" value="ВОЙТИ" />

  <hr style="background-color : #bebebe;"/>
  <hr style="background-color : #FFF; "/>
    <a href="index.php?ok"><img src="images/odnoklassniki.png"/></a>
    <a href="index.php?vk"><img src="images/vkontakt.png"/></a>
  <h5><a href="">Забыли пароль?</a> | <a href="?register">Регистрация</a></h5>

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
