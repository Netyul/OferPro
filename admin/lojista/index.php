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

$colname_ofertas = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_ofertas = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_ofertas = sprintf("SELECT a.id, l.nomeFantasia, o.id AS id_ofertas FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN ofertas AS o ON l.id = o.id_lojista WHERE a.id  = %s", GetSQLValueString($colname_ofertas, "int"));
$ofertas = mysql_query($query_ofertas, $dboferapp) or die(mysql_error());
$row_ofertas = mysql_fetch_assoc($ofertas);
$totalRows_ofertas = mysql_num_rows($ofertas);

$colname_presentes = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_presentes = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_presentes = sprintf("SELECT a.id, l.nomeFantasia, p.id AS id_presentes FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN presentes AS p ON l.id = p.id_lojista WHERE a.id = %s", GetSQLValueString($colname_presentes, "int"));
$presentes = mysql_query($query_presentes, $dboferapp) or die(mysql_error());
$row_presentes = mysql_fetch_assoc($presentes);
$totalRows_presentes = mysql_num_rows($presentes);

$colname_tabloides = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_tabloides = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_tabloides = sprintf("SELECT a.id, l.nomeFantasia, t.id AS id_tabloide FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN tabloide AS t ON l.id = t.id_lojista WHERE a.id = %s", GetSQLValueString($colname_tabloides, "int"));
$tabloides = mysql_query($query_tabloides, $dboferapp) or die(mysql_error());
$row_tabloides = mysql_fetch_assoc($tabloides);
$totalRows_tabloides = mysql_num_rows($tabloides);

$colname_solicitacoes = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_solicitacoes = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = sprintf("SELECT a.id, l.nomeFantasia, s.id AS id_solicita, s.vendido FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN solicitacoes AS s ON l.id = s.id_lojista WHERE s.vendido = 'not' AND a.id = %s", GetSQLValueString($colname_solicitacoes, "int"));
$solicitacoes = mysql_query($query_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);

$colname_vendidos = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_vendidos = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_vendidos = sprintf("SELECT a.id, l.nomeFantasia, s.id AS id_solicita, s.vendido FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN solicitacoes AS s ON l.id = s.id_lojista WHERE s.vendido = 'yes' AND a.id = %s", GetSQLValueString($colname_vendidos, "int"));
$vendidos = mysql_query($query_vendidos, $dboferapp) or die(mysql_error());
$row_vendidos = mysql_fetch_assoc($vendidos);
$totalRows_vendidos = mysql_num_rows($vendidos);

$colname_concorrentes = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_concorrentes = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_concorrentes = sprintf("SELECT a.id, SUM(g.cliks) FROM admin AS a INNER JOIN lojista AS l ON a.id = l.id_admin INNER JOIN presentes AS p ON l.id = p.id_lojista INNER JOIN ganharpresente AS g ON g.id_presente = p.id WHERE a.id = %s ORDER BY id ASC", GetSQLValueString($colname_concorrentes, "int"));
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

if(isset($_GET['desativar']) && $_GET['desativar']!= ''){
	$updateSQL = sprintf("UPDATE lojista SET  statos=%s WHERE id=%s",
                       GetSQLValueString('off', "text"),
					   GetSQLValueString($_GET['desativar'], "int")
					   );
	mysql_select_db($database_dboferapp, $dboferapp);
  	$Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());
	header('Location: /admin/administradores/');
}
if(isset($_GET['ativar']) && $_GET['ativar']!= ''){
	$updateSQL = sprintf("UPDATE lojista SET  statos=%s WHERE id=%s",
                       GetSQLValueString('on', "text"),
					   GetSQLValueString($_GET['ativar'], "int")
					   );
	mysql_select_db($database_dboferapp, $dboferapp);
  	$Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());
	header('Location: /admin/administradores/');
}
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
<link href="../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/admin/lojista/"><img  src="../images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            	<ul class="nav navbar-nav">
                    <li><a href="<?php echo BASEURL; ?>/admin/"><img src="../../skin/images/estatisticas.jpg" width="39"> Ofer Estatísticas (BR)</a></li>                    
                  </ul>
                <ul class="nav navbar-nav navbar-right">
                	<?php 
					$level = LEVEL;
					if($level == 'superadmin'){
					?>                 
                    <li><a href="<?php echo BASEURL; ?>/admin/cidade" style="padding-top: 17px !important; padding-bottom: 16px !important;">Cidades</a></li>
                    <li><a href="<?php echo BASEURL; ?>/admin/administradores" style="padding-top: 17px !important; padding-bottom: 16px !important;">Administradores</a></li>
                    <?php }else{
						$colname_admin = "-1";
						if (isset($_SESSION['admin_id'])) {
						  $colname_admin = $_SESSION['admin_id'];
						}
						mysql_select_db($database_dboferapp, $dboferapp);
						$query_admin = sprintf("SELECT a.id, c.nome, e.sigla FROM admin AS a INNER JOIN cidade AS c ON a.cidade = c.id INNER JOIN estado AS e ON c.id_uf = e.id WHERE a.id = %s", GetSQLValueString($colname_admin, "int"));
						$admin = mysql_query($query_admin, $dboferapp) or die(mysql_error());
						$row_admin = mysql_fetch_assoc($admin); 
						$Ecidade =  $row_admin['nome'].'-'.$row_admin['sigla'];
						$LinkCidade = str_replace(" ","-", $row_admin['nome']);
						$link = $LinkCidade.'-'.$row_admin['sigla'];
					?>
                    <li>
                    	<div class="btn-group btn-group-cidade" role="menuitem" style="padding: 13px">
            				<a class="btn btn-default">Cidade: <?php echo $Ecidade; ?></a>
            
            			</div>
                    </li>
                    <?php } ?>
                    <li><a href="<?php echo BASEURL; ?>/admin/lojista" style="padding-top: 17px !important; padding-bottom: 16px !important;">Meus Lojistas</a></li>
                    
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown" style="padding-top: 17px !important; padding-bottom: 16px !important;"><span class="glyphicon glyphicon-user"></span> <?php echo ADMNOME; ?> <span class="caret"></span></a>
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
            <div class="col-md-6" style="padding-left:0px">
            	<h2 style="padding-left:0px"><span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administrar Meus Lojista</h2>
            </div>
            <div class="col-md-6 align">
            	<a href="lojista-cadastrar.php" class="btn btn-primary">Novo Lojista</a>
            </div>
            </div>
            <div class="row">
            	<div class="col-md-4">
                	<div class="panel panel-default">
                        <div class="panel-heading" align="left">Lista de Clientes Lojistas</div>
                        <?php if($level == 'admin'){ ?>
                        <div class="panel-body">
                            
                                  <?php if ($totalRows_adminLojista == 0) { // Show if recordset empty ?>
                                 
                                  <p align="left">Não há nenhum lojista cadastardo</p>
                                  
                                  <?php }else{ // Show if recordset empty ?>
								  <table class="table">
                              		<tbody>
                                  <?php do { ?>
                                  
                                    <tr>
                                      <td width="13%"><?php if($row_adminLojista['statos'] == 'on'){ echo '<a href="?desativar='.$row_adminLojista['id'].'" class="btn btn-danger btn-xs" title="Desativar conta"><span class="glyphicon glyphicon-eye-close"></span></a>'; }else{ echo '<a href="?ativar='.$row_adminLojista['id'].'" class="btn btn-success btn-xs" title="Ativar conta"><span class="glyphicon glyphicon-eye-open"></span></a>';} ?></td>
                                      <td width="67%" align="left"><a href="ofertas.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_adminLojista['nomeEmpresa']; ?></a></td>
                                      <td width="10%"><a href="lojista-editar.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      <td width="10%"><a href="lojista-excluir.php?id=<?php echo $row_adminLojista['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_adminLojista = mysql_fetch_assoc($adminLojista)); ?>
                                    <?php } ?>
                              </tbody>
                            </table>
    
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, max(0, $pageNum_adminLojista - 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_adminLojista + 1) ?> a <?php echo min($startRow_adminLojista + $maxRows_adminLojista, $totalRows_adminLojista) ?> de <?php echo $totalRows_adminLojista ?> </a> </li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, min($totalPages_adminLojista, $pageNum_adminLojista + 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                
                            </ul>
                        </div>
                        <?php }else{ ?>
                        <div class="panel-body">
                            
                                  <?php if ($totalRows_RsLojistas == 0) { // Show if recordset empty ?>
                                  <tr>
                                  <p align="left">Não há nenhum lojista cadastardo</p>
                                  </tr>
                                  <?php } // Show if recordset empty ?>
                                  <table class="table">
                                	<tbody>
								  <?php do { ?>
                                    <tr>
                                      <td width="16%"><?php if($row_adminLojista['statos'] == 'on'){ echo '<a href="?desativar='.$row_adminLojista['id'].'" class="btn btn-danger btn-xs" title="Desativar conta"><span class="glyphicon glyphicon-eye-close"></span></a>'; }else{ echo '<a href="?ativar='.$row_adminLojista['id'].'" class="btn btn-success btn-xs" title="Ativar conta"><span class="glyphicon glyphicon-eye-open"></span></a>';} ?></td>
                                      <td width="60%" align="left"><a href="ofertas.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_RsLojistas['nomeEmpresa']; ?></a></td>
                                      <td width="8%"><a href="lojista-editar.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      
                                      <td width="8%"><a href="lojista-excluir.php?id=<?php echo $row_RsLojistas['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_RsLojistas = mysql_fetch_assoc($RsLojistas)); ?>
                                    
                                </tbody>
                            </table>
    
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, max(0, $pageNum_RsLojistas - 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_RsLojistas + 1) ?> a <?php echo min($startRow_RsLojistas + $maxRows_RsLojistas, $totalRows_RsLojistas) ?> de <?php echo $totalRows_RsLojistas ?></a> </li>
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, min($totalPages_RsLojistas, $pageNum_RsLojistas + 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                
                            </ul>
                        </div> 
                        <?php } ?>                       
                    </div>
       			</div>
                <div class="col-md-8">
                	<div class="row">
                        
                            <?php
                            if(isset($_GET['action'])){
                                if($_GET['action'] == 'cadastrado'){
                                    echo '<div class="col-md-12" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Lojista Cadastrado!</div></div>';
                                }
                                elseif($_GET['action'] == 'excluido'){
                                    echo '<div class="col-md-12" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Lojista Excluido!</div></div>';
                                }
                                elseif($_GET['action'] == 'editado'){
                                    echo '<div class="col-md-12" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Lojista Editado!</div></div>';
                                }
                                
                            }
                            ?>
                            
                        
                        <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Ofertas cadatradas</div>
                            <div class="panel-body">
                            	<?php if($totalRows_ofertas == 0){?>
									<p> Não há Ofertas cadastradas</p>
                                <?php }else{?>
                                <h4><?php echo $totalRows_ofertas;?> <span class="glyphicon glyphicon-shopping-cart"></span></h4>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Tablóides cadastrados</div>
                                <div class="panel-body">
                                <?php if($totalRows_tabloides == 0){?>
									<p> Não há tablóides cadastradas</p>
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
									<p> Não há presentes cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_presentes;?> <span class="glyphicon glyphicon glyphicon glyphicon-gift"></span></h4>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Solicitações</div>
                                <div class="panel-body">
                                <p>Solicitações que foram cadastradas</p>
                                <?php if($totalRows_solicitacoes == 0){?>
									<p> Não há solicitacões cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_solicitacoes;?> <span class="glyphicon glyphicon-check"></span></h4> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Vendidos</div>
                                <div class="panel-body">
                                
                                <p>Solicitações que foram vendidas</p>
                                 <?php if($totalRows_vendidos == 0){?>
									<p> Não há vendas cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_vendidos;?> <span class="glyphicon glyphicon-send"></span></h4> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Cliks em Presentes</div>
                                <div class="panel-body">
                                
                                <p>Soma de cliks que concorre aos presentes</p>
                                <?php if($row_concorrentes['SUM(g.cliks)'] ==''){?>
									<p> Não há cliks em presentes</p>
                                <?php }else{?>
                                    <h4><?php echo $row_concorrentes['SUM(g.cliks)']?> <span class="glyphicon glyphicon-stats"></span></h4>
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
