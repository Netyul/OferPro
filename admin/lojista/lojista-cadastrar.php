<?php require_once('../verificar-login.php');?>
<?php require_once('../../Connections/dboferapp.php'); ?>
<?php 
 
require_once('../../sistema/classes/W3_Image.class.php');
require_once('../../sistema/constantes.php');
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

require_once('validar/validar-cadastro.php');

$maxRows_adminLojista = 10;
$pageNum_adminLojista = 0;
if (isset($_GET['pageNum_adminLojista'])) {
  $pageNum_adminLojista = $_GET['pageNum_adminLojista'];
}
$startRow_adminLojista = $pageNum_adminLojista * $maxRows_adminLojista;

$colname_adminLojista = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_adminLojista = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_adminLojista = sprintf("SELECT * FROM lojista WHERE id_admin = %s", GetSQLValueString($colname_adminLojista, "int"));
$query_limit_adminLojista = sprintf("%s LIMIT %d, %d", $query_adminLojista, $startRow_adminLojista, $maxRows_adminLojista);
$adminLojista = mysql_query($query_limit_adminLojista, $dboferapp) or die(mysql_error());
$row_adminLojista = mysql_fetch_assoc($adminLojista);

if (isset($_GET['totalRows_adminLojista'])) {
  $totalRows_adminLojista = $_GET['totalRows_adminLojista'];
} else {
  $all_adminLojista = mysql_query($query_adminLojista);
  $totalRows_adminLojista = mysql_num_rows($all_adminLojista);
}
$totalPages_adminLojista = ceil($totalRows_adminLojista/$maxRows_adminLojista)-1;
$maxRows_RsLojistas = 10;
$pageNum_RsLojistas = 0;
if (isset($_GET['pageNum_RsLojistas'])) {
  $pageNum_RsLojistas = $_GET['pageNum_RsLojistas'];
}
$startRow_RsLojistas = $pageNum_RsLojistas * $maxRows_RsLojistas;

mysql_select_db($database_dboferapp, $dboferapp);
$query_RsLojistas = "SELECT * FROM lojista ORDER BY id DESC";
$query_limit_RsLojistas = sprintf("%s LIMIT %d, %d", $query_RsLojistas, $startRow_RsLojistas, $maxRows_RsLojistas);
$RsLojistas = mysql_query($query_limit_RsLojistas, $dboferapp) or die(mysql_error());
$row_RsLojistas = mysql_fetch_assoc($RsLojistas);

if (isset($_GET['totalRows_RsLojistas'])) {
  $totalRows_RsLojistas = $_GET['totalRows_RsLojistas'];
} else {
  $all_RsLojistas = mysql_query($query_RsLojistas);
  $totalRows_RsLojistas = mysql_num_rows($all_RsLojistas);
}
$totalPages_RsLojistas = ceil($totalRows_RsLojistas/$maxRows_RsLojistas)-1;

mysql_select_db($database_dboferapp, $dboferapp);
$query_CidadeCadastro = "SELECT * FROM cidade ORDER BY nome ASC";
$CidadeCadastro = mysql_query($query_CidadeCadastro, $dboferapp) or die(mysql_error());
$row_CidadeCadastro = mysql_fetch_assoc($CidadeCadastro);
$totalRows_CidadeCadastro = mysql_num_rows($CidadeCadastro);

$colname_AdminLogado = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_AdminLogado = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_AdminLogado = sprintf("SELECT id FROM `admin` WHERE login = %s", GetSQLValueString($colname_AdminLogado, "text"));
$AdminLogado = mysql_query($query_AdminLogado, $dboferapp) or die(mysql_error());
$row_AdminLogado = mysql_fetch_assoc($AdminLogado);
$totalRows_AdminLogado = mysql_num_rows($AdminLogado);


$queryString_RsLojistas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsLojistas") == false && 
        stristr($param, "totalRows_RsLojistas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsLojistas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsLojistas = sprintf("&totalRows_RsLojistas=%d%s", $totalRows_RsLojistas, $queryString_RsLojistas);
$queryString_adminLojista = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_adminLojista") == false && 
        stristr($param, "totalRows_adminLojista") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_adminLojista = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_adminLojista = sprintf("&totalRows_adminLojista=%d%s", $totalRows_adminLojista, $queryString_adminLojista);
?>

<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="author" content="Jefte Amorim da Costa">
<meta name="generator" content="Netyul">
<title>Administração da OferApp - Cadastro de logista</title>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="../css/oferapp.css" rel="stylesheet" type="text/css">
<link href="../css/oferapp-boilerplate.css" rel="stylesheet" type="text/css">
<link href="../css/oferapp-admin.css" rel="stylesheet" type="text/css">



<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/respond.min.js"></script>


</head>

<body>
</div>
<header>
    <div class="container" >
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://<?php echo BASEURL; ?>"><img  src="../images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                	<?php 
					$level = LEVEL;
					if($level == 'superadmin'){
					?>                 
                    <li><a href="<?php echo BASEURL; ?>/admin/cidade">Cidades</a></li>
                    <li><a href="<?php echo BASEURL; ?>/admin/administradores">Administradores</a></li>
                    <?php } ?> 
                    <li><a href="<?php echo BASEURL; ?>/admin/lojista">Lojistas</a></li>
                    
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo ADMNOME; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                           
                            <li><a href="<?php echo BASEURL; ?>/admin/logout">sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav><!-- /.container-fluid -->
       
    </div>
</header><!--/#header-->
<main>
    <div class="container">
        <div class="area principal">
            <div class="top row">
            <div class="col-md-6">
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span>Administração Lojista</h2>
            </div>
            <div class="col-md-6" align="right">
            	
            </div>
            </div>
            <div class="row">
            	<div class="col-md-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">Lista de clientes lojistas</div>
                        <?php if($level == 'admin'){ ?>
                        <div class="panel-body">
                            <table class="table">
                              <tbody>
                                  <?php if ($totalRows_adminLojista == 0) { // Show if recordset empty ?>
                                  <tr>
                                  <td colspan="4">Não a nenhum lojista cadastardo</td>
                                  </tr>
                                  <?php } // Show if recordset empty ?>
								  
                                  <?php do { ?>
                                    <tr>
                                      <td width="16%">&nbsp;</td>
                                      <td width="60%"><a href="ofertas.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_adminLojista['nomeEmpresa']; ?></a></td>
                                      <td width="8%"><a href="lojista-editar.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      <td width="8%"><a href="lojista-excluir.php?id=<?php echo $row_adminLojista['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_adminLojista = mysql_fetch_assoc($adminLojista)); ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, 0, $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, max(0, $pageNum_adminLojista - 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_adminLojista + 1) ?> a <?php echo min($startRow_adminLojista + $maxRows_adminLojista, $totalRows_adminLojista) ?> de <?php echo $totalRows_adminLojista ?> </a> </li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, min($totalPages_adminLojista, $pageNum_adminLojista + 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, $totalPages_adminLojista, $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                            </ul>
                        </div>
                        <?php }else{ ?>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                  <?php if ($totalRows_RsLojistas == 0) { // Show if recordset empty ?>
                                  <tr>
                                  <td colspan="4">Não a nenhum lojista cadastardo</td>
                                  </tr>
                                  <?php } // Show if recordset empty ?>
								  <?php do { ?>
                                    <tr>
                                      <td width="16%">&nbsp;</td>
                                      <td width="60%"><a href="ofertas.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_RsLojistas['nomeEmpresa']; ?></a></td>
                                      <td width="8%"><a href="lojista-editar.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      
                                      <td width="8%"><a href="lojista-excluir.php?id=<?php echo $row_RsLojistas['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_RsLojistas = mysql_fetch_assoc($RsLojistas)); ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, 0, $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, max(0, $pageNum_RsLojistas - 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_RsLojistas + 1) ?> a <?php echo min($startRow_RsLojistas + $maxRows_RsLojistas, $totalRows_RsLojistas) ?> de <?php echo $totalRows_RsLojistas ?></a> </li>
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, min($totalPages_RsLojistas, $pageNum_RsLojistas + 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, $totalPages_RsLojistas, $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                            </ul>
                        </div> 
                        <?php } ?>                       
                    </div>
       			</div>
                <div class="col-md-8">
                	 <div class="panel panel-default">
                            <div class="panel-heading">Cadastrar novo lojista</div>
                            <div class="panel-body">
                            	<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" role="form">
                              		<div class="form-group">
                              			<label for="nome-da-empresa" class="col-sm-4 control-label">Rasão Social:</label>
                                    	<div class="col-sm-8">
                                        	<input type="text" name="nomeempresa" value="<?php if(isset($nomeEmp)){ echo $nomeEmp;} ?>" class="form-control" required>
                                 		</div>
                                	</div>
                                  	<div class="form-group">
                                        <label for="nome-fantazia" class="col-sm-4 control-label">Nome fantasia:</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="nomefantasia" value="<?php if(isset($nomeFan)){ echo $nomeFan;} ?>" class="form-control" required>
                                        </div>
                                  	</div>
                                    <div class="form-group">
                                        <label for="nome-reponsavel" class="col-sm-4 control-label">Nome do responsavel:</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="nomeresponsavel" value="<?php if(isset($nomeRes)){ echo $nomeRes;} ?>" class="form-control" required>
                                        </div>
                                  	</div>
                                  	<div class="form-group">
                                        <label for="nome-fantazia" class="col-sm-4 control-label">Email:</label>
                                        <div class="col-sm-7">
                                            <input type="email" name="email" value="<?php if(isset($email)){ echo $email;} ?>" class="form-control" required>
                                        </div>
                                  	</div>
                                    <div class="form-group">
                                        <label for="nome-fantazia" class="col-sm-4 control-label">Senha:</label>
                                      <div class="col-sm-4">
                                        	<input type="password" name="senha" value="<?php if(isset($senha)){ echo $senha;} ?>" class="form-control" required>
                                        </div>
                                    </div>
                                  	<div class="form-group">
                                  		<label class="col-sm-3 control-label">Endereco:</label>
                                        <div class="col-sm-9">
                                        	<input type="text" name="endereco" value="<?php if(isset($endereco)){ echo $endereco;} ?>"class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-sm-3 control-label">Bairro:</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="bairro" value="<?php if(isset($bairro)){ echo $bairro;} ?>" class="form-control" required>
                                        </div>
                                    </div>
                                  <div class="form-group">
                                   	<label class="col-sm-3 control-label">Cidade:</label>
                                    <div class="col-sm-4" id="sprytrigger1">
                                       	  <select name="cidade" class="form-control">
                                          	
											<?php 
                                            do {  
												if(isset($cidade) && $cidade==$row_CidadeCadastro['id']){
                                            ?>
                                            <option value="<?php echo $row_CidadeCadastro['id']?>" ><?php echo $row_CidadeCadastro['nome']?></option>
                                            <?php } ?>
                                            <option value="<?php echo $row_CidadeCadastro['id']?>" ><?php echo $row_CidadeCadastro['nome']?></option>
                                            <?php
                                              } while ($row_CidadeCadastro = mysql_fetch_assoc($CidadeCadastro));
                                            ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-sm-3 control-label">CEP:</label>
                                      <div class="col-sm-3">
                                        	<input type="text" name="cep" value="<?php if(isset($cep)){ echo $cep;} ?>" size="32" class="form-control" required>
                                        </div>
                                  </div>
                                  <div class="form-group">
                                    	<label class="col-sm-3 control-label">Pessoa:</label>
                                       <div class="col-sm-3">
                                        	<select name="tipolojista" class="form-control">
                                      			<option value="fisica" <?php if (!(strcmp("fisica", ""))) {echo "SELECTED";} ?>>Fisica</option>
                                      			<option value="Juridica" <?php if (!(strcmp("Juridica", ""))) {echo "SELECTED";} ?>>Juridica</option>
                                    		</select>
                                        </div>
                                     </div>
                                   	 <div class="form-group">
                                    	<label class="col-sm-3 control-label">CPF:</label>
                                       <div class="col-sm-5">
                                        	<input type="text" name="cpf" value="<?php if(isset($cpf)){ echo $cpf;} ?>" class="form-control" required>
                                        </div>
                                     </div>
                                     <div class="form-group">
                                    	<label class="col-sm-3 control-label">CNPJ:</label>
                                       <div class="col-sm-5">
                                        	<input type="text" name="cnpj" value="<?php if(isset($cnpj)){ echo $cnpj;} ?>"class="form-control" required>
                                        </div>
                                     </div>
                                     
                                     <div class="form-group">
                                    	<label class="col-sm-3 control-label">Telefone:</label>
                                       <div class="col-sm-3">
                                        	<input type="tel" id="telefone" name="telefone" value="<?php if(isset($telefone)){ echo $telefone;} ?>" class="form-control" required>
                                        </div>
                                     </div>
                                     <div class="form-group">
                                    	<label class="col-sm-3 control-label">Celular:</label>
                                       <div class="col-sm-3">
                                        	<input type="text" name="celular" value="<?php if(isset($celular)){ echo $celular;} ?>" class="form-control" required> 
                                        </div>
                                     </div>
                                     <div class="form-group">
                                    	<label class="col-sm-3 control-label">Imagem:</label>
                                       <div class="col-sm-3">
                                        	<input type="file" name="img" value="<?php if(isset($$imageTemp)){ echo $$imageTemp;} ?>" size="35" required>
                                        </div>
                                     </div>
                                  <div class="form-group">
                                    	<div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                     </div>
                                <input type="hidden" name="id_admin" value="<?php  echo $_SESSION['admin_id']; ?>">
                                <input type="hidden" name="MM_insert" value="form1">
                              </form>
                              
                            </div>
                        </div>	
                </div>
        	</div>
          </div>
    </div>
</main>
<footer>
	<div class="footer">
        	
    </div>
</footer>

</body>
</html>
<?php


mysql_free_result($RsLojistas);

mysql_free_result($CidadeCadastro);

mysql_free_result($AdminLogado);


?>
