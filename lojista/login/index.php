<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo login painel administrativo
* Versão: 1.0
*/
session_start();
require_once('../../sistema/constantes.php');
require_once('../../sistema/constantes.php');
require_once('../../sistema/core/connectdb.php');
require_once('../../functions.php');

//verifica se esse usuario esta cadastrado se não estiver ele e cadastrado
$admquery = "SELECT * FROM admin WHERE login = 'netyul'";
$admResult = mysqli_query($dboferapp, $admquery);
$admintotalRows = mysqli_num_rows($admResult);
if($admintotalRows == 0){
	$admInserir ="INSERT INTO admin(nome, login, senha, statos) VALUES('Netyul', 'netyul', SHA1('**987jft'), 'on')";
	mysqli_query($dboferapp, $admInserir);
}

//verifica se o usuario root esta cadastrado se não estiver ele cadastra
$admquery2 = "SELECT * FROM admin WHERE login = 'root'";
$admResult2 = mysqli_query($dboferapp, $admquery2);
$admintotalRows2 = mysqli_num_rows($admResult2);
if($admintotalRows2 == 0){
	$admInserir ="INSERT INTO admin(nome, login, senha, statos) VALUES('Root', 'root', 'oferapp2014', 'on')";
	mysqli_query($dboferapp, $admInserir);
}	


$lembrarAdmin = (isset($_COOKIE['lembrarLojista']) && $_COOKIE['lembrarLojista'] != '' ? $_COOKIE['lembrarLojista'] : false);
 $arr = explode('/', $lembrarAdmin);
 $user_id = isset($arr[0]) ? base64_decode($arr[0]) : '';
 $login   = isset($arr[1]) ? base64_decode($arr[1]) : '';
 $senha   = isset($arr[2]) ? base64_decode($arr[2]) : '';
 
 $urlpost = 'http://'. $_SERVER['HTTP_HOST'].'/lojista';
 
 if(isset($_POST['enviar'])){
	 
	 $input['login']   = mysqli_real_escape_string($dboferapp, trim($_POST['login']));
	 $input['senha']   = mysqli_real_escape_string($dboferapp, trim($_POST['senha']));
	 $input['lembrar'] = isset($_POST['lembrar']) ? $_POST['lembrar'] : "";
	 
	 if(empty($input['login']) && empty($input['senha'])){
		 
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus dados!</div>';
		 
	 }
	 elseif(empty($input['login'])){
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus Login!</div>';
		 
	 }
	 elseif(empty($input['senha'])){
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus senha!</div>';
		 
	 }else{
		 $queryLogin = "SELECT * FROM lojista WHERE email='".$input['login']."'";
		 $resultadoLogin = mysqli_query($dboferapp, $queryLogin);
		 $LinhasLogin = mysqli_num_rows($resultadoLogin);
		 if($LinhasLogin <= 0){
			  $msg = '<div class="alert alert-warning" role="alert">Usuario não Cadastrado!</div>';
		 }
		 else{
			$querySenha = "SELECT * FROM lojista WHERE email ='".$input['login']."' AND senha = '".$input['senha']."'";
			$resultadoSenha = mysqli_query($dboferapp, $querySenha);
			$LinhasSenha = mysqli_num_rows($resultadoSenha);
			if($LinhasSenha <=0){
				$msg = '<div class="alert alert-warning" role="alert">Senha não Cadastrada!</div>';
			}
			else{
				$queryStatus = "SELECT * FROM lojista WHERE email= '".$input['login']."' AND senha = '".$input['senha']."' AND statos = 'on'";
				$resultadoStatus = mysqli_query($dboferapp, $queryStatus);
				$LinhasStatus = mysqli_num_rows($resultadoStatus);
				if($LinhasStatus <=0){
					$msg = '<div class="alert alert-warning" role="alert">Esta conta estar desativda!</div>';
				}else{
					$adm = mysqli_fetch_array($resultadoStatus);
					$_SESSION['id_lojista'] = $adm['id'];
					$_SESSION['lojista'] = $adm['nomeFantasia'];
					$_SESSION['lojistaSenha']   = $adm['senha'];
					if($input['lembrar'] == true){
						setcookie('lembrarLojista', base64_encode($adm['id']).'/'.base64_encode($adm['email']).'/'.base64_encode($input['senha']), time() + (60 * 60 * 24 * 30), '/');
					}
					else{
						setcookie('lembrarLojista', '', time() - (60 * 60 * 24 * 30), '/');						
					}
					if(isset($_SESSION['id_lojista']) && !empty($_SESSION['id_lojista'])){
						header('Location: ' .$urlpost);
						exit;
					}
					
				}
			}
			
		 }
	 }
 
 }
 if(isset($_SESSION['id_lojista']) && !empty($_SESSION['id_lojista'])){
						header('Location: ' .$urlpost);
						exit;
}
 
 ?>
 <!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html>
<head>
<meta charset="utf-8">
<title>Administração da OferApp</title>
<link href="<?php SkinUrl('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
<link href="<?php SkinUrl('css/bootstrap-theme.min.css');?>" rel="stylesheet" type="text/css">
<link href="<?php SkinUrl('css/oferapp-boilerplate.css');?>" rel="stylesheet" type="text/css">
<link href="<?php SkinUrl('css/oferapp.css');?>" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="<?php SkinUrl('js/jquery.min.js'); ?>"></script>
<script src="<?php  SkinUrl('js/bootstrap.min.js');?>"></script>
<script src="<?php SkinUrl('js/respond.min.js');?>"></script>
</head>

<body>
<div id="popup-login" class="login">
<div class=" modal fade login-sm in" tabindex="-1" id="login" role="dialog" aria-labelledby="loginModal" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" align="center">
                <img src="<?php  SkinUrl('images/logo.png');?>" alt="Administração OferApp">
                <h4 class="modal-title" id="myModalLabel">Painel Lojista</h4>
            </div>
            <div class="modal-body">
            	<?php if(isset($msg)){ echo $msg; }?>
            	<form class="form-horizontal" role="form" action="http://<?php  echo $_SERVER['HTTP_HOST']; ?>/lojista/login/" method="post">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email: </label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" name="login" id="login" value="<?php  echo $login; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Senha: </label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $senha; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="lembrar" id="lembrar" <?php if($lembrarAdmin != false){ echo'checked';}?> >Lembrar
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="center">
                    
                      <button type="submit" class="btn btn-primary" name="enviar" id="enviar">Entrar</button>
                    
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> 
</body>
</html>