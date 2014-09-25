<?php require_once('../verificar-login.php');?>
<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo de cadastro do lojista do sistema oferapp
* Versão: 1.0
*/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$nomeEmp   = $_POST['nomeempresa'];
	$nomeFan   = $_POST['nomefantasia'];
	$nomeRes   = $_POST['nomeresponsavel'];
	$email     = $_POST['email'];
	$senha     = $_POST['senha'];
	$endereco  = $_POST['endereco'];
	$bairro    = $_POST['bairro'];
	$cidade    = $_POST['cidade'];
	$cep       = $_POST['cep'];
	$cpf       = $_POST['cpf'];
	$cnpj      = $_POST['cnpj'];
	$tipoLojis = $_POST['tipolojista'];
	$telefone  = $_POST['telefone'];
	$celular   = $_POST['celular'];
	$imagetype = explode('/', $_FILES['img']['type']);				   
	$imagetemp = $_FILES['img']['tmp_name'];
	$strKey    = substr(md5(uniqid(microtime())),0, 28);
	$idAdmin   = $_POST['id_admin'];
	
	mysql_select_db($database_dboferapp, $dboferapp);
	$query_LojistaEmail = sprintf("SELECT * FROM lojista WHERE email = %s", GetSQLValueString($email, 'text'));
	$lojistaEmail = mysql_query($query_LojistaEmail, $dboferapp) or die(mysql_error());
	$row_LojistaEmail = mysql_fetch_assoc($lojistaEmail);
	$totalRows_LojistaEmail = mysql_num_rows($lojistaEmail);
	
	if(empty($nomeEmp)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor preencha O nome da empresa!</div>';
	}
	elseif(empty($nomeFan)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor preencha O nome fantasia da empresa!</div>';
	}
	elseif(empty($nomeRes)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor preencha O nome do Responsavel pela empresa!</div>';
	}
	elseif(empty($email)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe um e-mail!</div>';
	}
	elseif(!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/i", $email)){
			$msg ='<div class="alert alert-warning" role="alert">Por favor informe um e-mail valido!</div>';
	}
	elseif($email == $row_LojistaEmail['email']){
		$msg = '<div class="alert alert-warning" role="alert">Este email já estar cadastrado!</div>';
	}
	elseif(empty($senha)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe sua senha!</div>';
	}
	elseif(empty($endereco)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o endereço!</div>';
	}
	elseif(empty($bairro)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o bairro!</div>';
	}
	elseif(empty($cep)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o cep!</div>';
	}
	elseif(!preg_match("/^[0-9]{5}([-][0-9]{3})$/", $cep)){
		$msg ='<div class="alert alert-warning" role="alert">Digite o formato correto no campo cep 00000-000!</div>';
	}
	elseif(empty($cpf) && $tipoLojis == 'fisica'){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o CPF!</div>';
	}
	elseif($tipoLojis == 'fisica' && !preg_match("/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2,2}$/", $cpf)){
		$msg ='<div class="alert alert-warning" role="alert">Digite o formato correto no campo CPF 000.000.000-00!</div>';
	}
	elseif(empty($cnpj) && $tipoLojis == 'fisica'){
		$cnpj = '0';
	}
	elseif(empty($cnpj) && $tipoLojis == 'Juridica'){
			$msg ='<div class="alert alert-warning" role="alert">Por favor informe o CNPJ!</div>';
	}
	elseif($tipoLojis == 'Juridica' && !preg_match("/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2,2}$/", $cnpj)){
			$msg ='<div class="alert alert-warning" role="alert">Digite o formato correto do CNPJ: 00.000.000/0000-00!</div>';
	}
	elseif(empty($cpf) && $tipoLojis == 'Juridica'){
			$cpf = '0';
	}
	elseif(empty($telefone)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o Telefone!</div>';
	}
	elseif(!preg_match("/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/", $telefone)){
		$msg = '<div class="alert alert-warning" role="alert">Digite o formato correto do Telefone: (00)0000-0000!</div>';
	}
	elseif(empty($celular)){
		$msg ='<div class="alert alert-warning" role="alert">Por favor informe o celular!</div>';
	}
	elseif(!preg_match("/^\([0-9]{2}\)|\d{1}?[0-9]{4}\-[0-9]{4}$/", $celular)){
		$msg = '<div class="alert alert-warning" role="alert">Digite o formato correto do celular: (00)0000-0000!</div>';
	}
	elseif(empty($imagetemp)){
		$msg = '<div class="alert alert-warning" role="alert">Selecione uma imagem!</div>';
	}
	else{
		$insertSQL = sprintf("INSERT INTO lojista (nomeEmpresa, nomeFantasia, nomeResponsavel, email, senha, endereco, bairro, cidade, cep, cpf, cnpj, tipoLojista, telefone, celular, img, id_admin) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								GetSQLValueString($nomeEmp, "text"),
								GetSQLValueString($nomeFan, "text"),
								GetSQLValueString($nomeRes, "text"),
								GetSQLValueString($email, "text"),
								GetSQLValueString($senha, "text"),
								GetSQLValueString($endereco, "text"),
								GetSQLValueString($bairro, "text"),
								GetSQLValueString($cidade, "int"),
								GetSQLValueString($cep, "text"),
								GetSQLValueString($cpf, "text"),
								GetSQLValueString($cnpj, "text"),
								GetSQLValueString($tipoLojis, "text"),
								GetSQLValueString($telefone, "text"),
								GetSQLValueString($celular, "text"),
								GetSQLValueString($strKey.'.'.$imagetype[1], "text"),
								GetSQLValueString($idAdmin, "int"));
						
		$imgperfil = IMGPERFIL;
		$img = new W3_Image;
		$img->create($imagetemp, 218, 147, '../../'.$imgperfil.$strKey.'.thumb.'.$imagetype[1]);
		$img->create($imagetemp, 570, 450, '../../'.$imgperfil.$strKey.'.'.$imagetype[1]); 
		mysql_select_db($database_dboferapp, $dboferapp);
		$Result1 = mysql_query($insertSQL, $dboferapp) or die(mysql_error());
	
	  $insertGoTo = "index.php?action=cadastrado";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
}
?>