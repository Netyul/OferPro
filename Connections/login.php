<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];


if (isset($_POST['login'])) {
  $login=$_POST['login'];
  $Senha=$_POST['Senha'];
  $redirectLoginSuccess = "../index.php";
  $redirectLoginFailed = "../index.php";
  $redirecttoReferrer = false;
  
  
  $Login_query = "SELECT id, login, senha FROM usuario WHERE login=".$login." AND senha=".$Senha;
    
   
  $LoginRS = mysqli_query($Login_query, $dboferapp) or die(mysqli_error());
  $loginRow = mysql_num_rows($LoginRS);
  if ($loginRow == 1) {
     $loginStrGroup = "";
    $row = mysqli_fetch_array($LoginRS);
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['Usuario'] = $row['login'];
	$_SESSION['Usuario_id'] = $row['id'];	      

   
    header("Location: " . $redirectLoginSuccess );
  }
  else {
    header("Location: ". $redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body>
<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="login">
<label id="login" > Login:</label>
<input type="text" name="login" id="login">
<label id="login" > Senha:</label>
<input type="text" name="Senha" id="Senha">
<button id="enviar" name="enviar">Entrar</button>
</form>
</body>
</html>