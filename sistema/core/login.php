<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções de login ultilizadas no sistema Oferapp.
 * versão 1.0
 */	
 
 $lembrar = (isset($_COOKIE['lembrar']) && $_COOKIE['lembrar'] != '' ? $_COOKIE['lembrar'] : false);
 $arr = explode('/', $lembrar);
 $user_id = isset($arr[0]) ? base64_decode($arr[0]) : '';
 $login   = isset($arr[1]) ? base64_decode($arr[1]) : '';
 $senha   = isset($arr[2]) ? base64_decode($arr[2]) : '';
 
 $urlpost =  $_SERVER['HTTP_HOST'];
 if(isset($_POST['enviar'])){
	 
	 $input['login']   = mysqli_real_escape_string($dboferapp, trim($_POST['login']));
	 $input['senha']   = mysqli_real_escape_string($dboferapp, trim($_POST['senha']));
	 $input['lembrar'] = $_POST['lembrar'];
	 
	 if(empty($input['login']) && empty($input['senha'])){
		 
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus dados!</div>';
		 
	 }
	 elseif(empty($input['login'])){
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus Login!</div>';
		 
	 }
	 elseif(empty($input['senha'])){
		 $msg = '<div class="alert alert-warning" role="alert">Preencha seus senha!</div>';
		 
	 }else{
		 $queryLogin = "SELECT * FROM usuario WHERE email='".$input['login']."'";
		 $resultadoLogin = mysqli_query($dboferapp, $queryLogin);
		 $LinhasLogin = mysqli_num_rows($resultadoLogin);
		 if($LinhasLogin <= 0){
			  $msg = '<div class="alert alert-warning" role="alert">Usuario não Cadastrado!</div>';
		 }
		 else{
			$querySenha = "SELECT * FROM usuario WHERE email ='".$input['login']."' AND senha = '".$input['senha']."'";
			$resultadoSenha = mysqli_query($dboferapp, $querySenha);
			$LinhasSenha = mysqli_num_rows($resultadoSenha);
			if($LinhasSenha <=0){
				$msg = '<div class="alert alert-warning" role="alert">Senha não Cadastrada!</div>';
			}
			else{
				$queryStatus = "SELECT * FROM usuario WHERE email= '".$input['login']."' AND senha = '".$input['senha']."' AND estatos = 'ativada'";
				$resultadoStatus = mysqli_query($dboferapp, $queryStatus);
				$LinhasStatus = mysqli_num_rows($resultadoStatus);
				if($LinhasStatus <=0){
					$msg = '<div class="alert alert-warning" role="alert">Esta conta estar desativda!</div>';
				}else{
					$usuario = mysqli_fetch_array($resultadoStatus);
					$_SESSION['user_id'] = $usuario['id'];
					$_SESSION['usuario'] = $usuario['nome'];
					$_SESSION['senha']   = $usuario['senha'];
					if($input['lembrar'] == true){
						setcookie('lembrar', base64_encode($usuario['id']).'/'.base64_encode($usuario['email']).'/'.base64_encode($input['senha']), time() + (60 * 60 * 24 * 30), '/');
					}
					else{
						setcookie('lembrar', '', time() - (60 * 60 * 24 * 30), '/');						
					}
					if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
						header('Location: http://' .$urlpost);
						exit;
					}
					
				}
			}
			
		 }
	 }
 
 }