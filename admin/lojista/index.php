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
$query_ofertas = "SELECT * FROM ofertas";
$ofertas = mysql_query($query_ofertas, $dboferapp) or die(mysql_error());
$row_ofertas = mysql_fetch_assoc($ofertas);
$totalRows_ofertas = mysql_num_rows($ofertas);

mysql_select_db($database_dboferapp, $dboferapp);
$query_presentes = "SELECT * FROM presentes";
$presentes = mysql_query($query_presentes, $dboferapp) or die(mysql_error());
$row_presentes = mysql_fetch_assoc($presentes);
$totalRows_presentes = mysql_num_rows($presentes);

mysql_select_db($database_dboferapp, $dboferapp);
$query_tabloides = "SELECT * FROM tabloide";
$tabloides = mysql_query($query_tabloides, $dboferapp) or die(mysql_error());
$row_tabloides = mysql_fetch_assoc($tabloides);
$totalRows_tabloides = mysql_num_rows($tabloides);

mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = "SELECT * FROM solicitacoes";
$solicitacoes = mysql_query($query_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);

mysql_select_db($database_dboferapp, $dboferapp);
$query_vendidos = "SELECT * FROM solicitacoes WHERE vendido = 'yes'";
$vendidos = mysql_query($query_vendidos, $dboferapp) or die(mysql_error());
$row_vendidos = mysql_fetch_assoc($vendidos);
$totalRows_vendidos = mysql_num_rows($vendidos);

mysql_select_db($database_dboferapp, $dboferapp);
$query_concorrentes = "SELECT  SUM(cliks) FROM ganharpresente ORDER BY id ASC";
$concorrentes = mysql_query($query_concorrentes, $dboferapp) or die(mysql_error());
$row_concorrentes = mysql_fetch_assoc($concorrentes);
$totalRows_concorrentes = mysql_num_rows($concorrentes);

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
<title>Administração da OferApp</title>
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>"><img  src="../images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
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
            	<a href="lojista-cadastrar.php" class="btn btn-primary">Novo Lojista</a>
            </div>
            </div>
            <div class="row">
            	<div class="col-md-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">Lista de Clientes Lojistas</div>
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
                	<div class="row">
                        <div class="col-md-12" style=" text-align:center; padding:10px;">
                            <?php
                            if(isset($_GET['action'])){
                                if($_GET['action'] == 'cadastrado'){
                                    echo '<div class="alert alert-success" role="alert">Lojista Cadastrado!</div>';
                                }
                                elseif($_GET['action'] == 'excluido'){
                                    echo '<div class="alert alert-success" role="alert">Lojista Excluido!</div>';
                                }
                                elseif($_GET['action'] == 'editado'){
                                    echo '<div class="alert alert-success" role="alert">Lojista Editado!</div>';
                                }
                                
                            }
                            ?>
                            
                        </div>
                        <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Ofertas cadatradas</div>
                            <div class="panel-body">
                            	<?php if($totalRows_ofertas == 0){?>
									<p> Não a Ofertas cadastradas</p>
                                <?php }else{?>
                                <h4><?php echo $totalRows_ofertas;?> <span class="glyphicon glyphicon-shopping-cart"></span></h4>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Tabloides cadastrados</div>
                                <div class="panel-body">
                                <?php if($totalRows_tabloides == 0){?>
									<p> Não a tabloides cadastradas</p>
                                <?php }else{?>
                                   <h4><?php echo $totalRows_tabloides;?> <span class="glyphicon glyphicon glyphicon-bullhorn"></span></h4>
                                   <?php } ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Presentes cadastrados</div>
                                <div class="panel-body">
                                <?php if($totalRows_presentes == 0){?>
									<p> Não a presentes cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_presentes;?> <span class="glyphicon glyphicon glyphicon glyphicon-gift"></span></h4>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Solicitações</div>
                                <p>Solicitações que foram cadastradas</p>
                                <div class="panel-body">
                                <?php if($totalRows_solicitacoes == 0){?>
									<p> Não a solicitacões cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_solicitacoes;?> <span class="glyphicon glyphicon-check"></span></h4> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Vendidos</div>
                                <p>Solicitações que foram vendidas</p>
                                <div class="panel-body">
                                 <?php if($totalRows_vendidos == 0){?>
									<p> Não a vendas cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_vendidos;?> <span class="glyphicon glyphicon-send"></span></h4> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Cliks em Presentes</div>
                                <p>Soma de cliks que concorre aos presentes</p>
                                <div class="panel-body">
                                <?php if($row_concorrentes['SUM(cliks)'] ==''){?>
									<p> Não a cliks em presentes</p>
                                <?php }else{?>
                                    <h4><?php echo $row_concorrentes['SUM(cliks)']?> <span class="glyphicon glyphicon-stats"></span></h4>
                                    <?php } ?> 
                                </div>
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

mysql_free_result($ofertas);

mysql_free_result($presentes);

mysql_free_result($tabloides);

mysql_free_result($solicitacoes);

mysql_free_result($vendidos);

mysql_free_result($concorrentes);

mysql_free_result($adminLojista);


?>
