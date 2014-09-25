<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções de login ultilizadas no sistema Oferapp.
 * versão 1.0
 */		
 

if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];


if (isset($_POST['login'])) {
  $login=$_POST['login'];
  $Senha=$_POST['Senha'];
  $redirectLoginSuccess = BASEURL;
  $redirectLoginFailed = BASEURL;
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
<div class="container login">
<div class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" align="center"><img src="<?php SkinUrl('images/logo.png');?>" alt="Login OferApp" title="Login OferApp"></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" role="form">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
