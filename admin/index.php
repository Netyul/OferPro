<?php 
require_once('verificar-login.php');
require_once('../sistema/constantes.php');
?>
<?php require_once('../Connections/dboferapp.php'); ?>
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
$colname_admin = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_admin = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_admin = sprintf("SELECT a.id, c.nome, e.sigla FROM admin AS a INNER JOIN cidade AS c ON a.cidade = c.id INNER JOIN estado AS e ON c.id_uf = e.id WHERE a.id = %s", GetSQLValueString($colname_admin, "int"));
$admin = mysql_query($query_admin, $dboferapp) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);
 
$maxRows_buscas = 10;
$pageNum_buscas = 0;

if (isset($_GET['pageNum_buscas'])) {
  $pageNum_buscas = $_GET['pageNum_buscas'];
}
$startRow_buscas = $pageNum_buscas * $maxRows_buscas;

mysql_select_db($database_dboferapp, $dboferapp);

$query_buscas = "SELECT * FROM busca ORDER BY veses DESC";
$query_limit_buscas = sprintf("%s LIMIT %d, %d", $query_buscas, $startRow_buscas, $maxRows_buscas);
$buscas = mysql_query($query_limit_buscas, $dboferapp) or die(mysql_error());
$row_buscas = mysql_fetch_assoc($buscas);

if (isset($_GET['totalRows_buscas'])) {
  $totalRows_buscas = $_GET['totalRows_buscas'];
} else {
  $all_buscas = mysql_query($query_buscas);
  $totalRows_buscas = mysql_num_rows($all_buscas);
}
$totalPages_buscas = ceil($totalRows_buscas/$maxRows_buscas)-1;

mysql_select_db($database_dboferapp, $dboferapp);
$query_usuarios = "SELECT * FROM usuario";
$usuarios = mysql_query($query_usuarios, $dboferapp) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_dboferapp, $dboferapp);
$query_lojistas = "SELECT * FROM lojista";
$lojistas = mysql_query($query_lojistas, $dboferapp) or die(mysql_error());
$row_lojistas = mysql_fetch_assoc($lojistas);
$totalRows_lojistas = mysql_num_rows($lojistas);

$maxRows_BuscaEncontrada = 5;
$pageNum_BuscaEncontrada = 0;
if (isset($_GET['pageNum_BuscaEncontrada'])) {
  $pageNum_BuscaEncontrada = $_GET['pageNum_BuscaEncontrada'];
}
$startRow_BuscaEncontrada = $pageNum_BuscaEncontrada * $maxRows_BuscaEncontrada;

mysql_select_db($database_dboferapp, $dboferapp);
$query_BuscaEncontrada = "SELECT busca, veseencontradas FROM busca ORDER BY veseencontradas DESC";
$query_limit_BuscaEncontrada = sprintf("%s LIMIT %d, %d", $query_BuscaEncontrada, $startRow_BuscaEncontrada, $maxRows_BuscaEncontrada);
$BuscaEncontrada = mysql_query($query_limit_BuscaEncontrada, $dboferapp) or die(mysql_error());
$row_BuscaEncontrada = mysql_fetch_assoc($BuscaEncontrada);

if (isset($_GET['totalRows_BuscaEncontrada'])) {
  $totalRows_BuscaEncontrada = $_GET['totalRows_BuscaEncontrada'];
} else {
  $all_BuscaEncontrada = mysql_query($query_BuscaEncontrada);
  $totalRows_BuscaEncontrada = mysql_num_rows($all_BuscaEncontrada);
}
$totalPages_BuscaEncontrada = ceil($totalRows_BuscaEncontrada/$maxRows_BuscaEncontrada)-1;

$maxRows_BuscaNaoEncontradas = 5;
$pageNum_BuscaNaoEncontradas = 0;
if (isset($_GET['pageNum_BuscaNaoEncontradas'])) {
  $pageNum_BuscaNaoEncontradas = $_GET['pageNum_BuscaNaoEncontradas'];
}
$startRow_BuscaNaoEncontradas = $pageNum_BuscaNaoEncontradas * $maxRows_BuscaNaoEncontradas;

mysql_select_db($database_dboferapp, $dboferapp);
$query_BuscaNaoEncontradas = "SELECT busca, vesenaoencontradas FROM busca ORDER BY vesenaoencontradas DESC";
$query_limit_BuscaNaoEncontradas = sprintf("%s LIMIT %d, %d", $query_BuscaNaoEncontradas, $startRow_BuscaNaoEncontradas, $maxRows_BuscaNaoEncontradas);
$BuscaNaoEncontradas = mysql_query($query_limit_BuscaNaoEncontradas, $dboferapp) or die(mysql_error());
$row_BuscaNaoEncontradas = mysql_fetch_assoc($BuscaNaoEncontradas);

if (isset($_GET['totalRows_BuscaNaoEncontradas'])) {
  $totalRows_BuscaNaoEncontradas = $_GET['totalRows_BuscaNaoEncontradas'];
} else {
  $all_BuscaNaoEncontradas = mysql_query($query_BuscaNaoEncontradas);
  $totalRows_BuscaNaoEncontradas = mysql_num_rows($all_BuscaNaoEncontradas);
}
$totalPages_BuscaNaoEncontradas = ceil($totalRows_BuscaNaoEncontradas/$maxRows_BuscaNaoEncontradas)-1;


/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/



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
<link href="../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="css/oferapp-boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/oferapp.css" rel="stylesheet" type="text/css">
<link href="css/oferapp-admin.css" rel="stylesheet" type="text/css">
<link href="css/ionicons.min.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/respond.min.js"></script>

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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/admin/lojista"><img  src="<?php echo BASEURL.'/skin/images/logo.png'; ?>" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
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
                	<li><a href="<?php echo BASEURL;?>/admin/cidade" style="padding-top: 17px !important; padding-bottom: 16px !important;">Cidades</a></li>
                    <li><a href="<?php echo BASEURL; ?>/admin/administradores" style="padding-top: 17px !important; padding-bottom: 16px !important;">Administradores</a></li> 
                    <?php }else{ 
						$Ecidade =  $row_admin['nome'].'-'.$row_admin['sigla'];
						//$LinkCidade = str_replace(" ","-", $row_admin['nome']);
						//$link = $LinkCidade.'-'.$row_admin['sigla'];
					?> 
                    	 <li>
                    	<div class="btn-group btn-group-cidade" role="menuitem" style="padding: 13px">
            				<a class="btn btn-default">Cidade: <?php echo $Ecidade; ?></a>
            
            			</div>
                    </li>
                    <?php } ?>              
                    <li><a href="<?php echo BASEURL; ?>/admin/lojista" style="padding-top: 17px !important; padding-bottom: 16px !important;">Meus Lojistas</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown" style="padding-top: 17px !important; padding-bottom: 16px !important;"><span class="glyphicon glyphicon-user"></span> <?php echo ADMNOME;?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo BASEURL;?>/admin/logout">sair</a></li>
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
            <div class="top page-header">
            <?php 
				
			?>
            	<h2 style="padding-left:13px"><span class="glyphicon glyphicon-bookmark icon-destaque"></span> OferApp Estatísticas (BR)</h2>
            <?php ?>
            </div>
            <div class="row">
                <div class="col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading"> Feedback de Pesquisas</div>
                        <table class="table">
                          <?php if ($totalRows_buscas == 0) { // Show if recordset empty ?>
                          <tr>
                            <td> Não há nenhuma busca registrada </td>
                          </tr>
                          <?php }else{ $total = 0; // Show if recordset empty ?>
						  <?php  do { ?>
                          <tr>
                            <td align="left"><?php echo $row_buscas['busca']; ?></td>
                            <td align="right"><?php echo $row_buscas['veses']; ?> <span class="glyphicon glyphicon-search" title="vezes buscado"></span></td>
                          </tr>
                            <?php $total =  $total + ($row_buscas['veses'] + $row_buscas['veseencontradas'] + $row_buscas['vesenaoencontradas']); ?>
                            <?php } while ($row_buscas = mysql_fetch_assoc($buscas)); ?>
                            <?php } ?>
                        </table>

                    </div>
              </div>
                <div class="col-md-8">
                	<div class="col-md-4">
                    	<div class="panel panel-primary">
                       	  <div class="panel-heading">Usuários Cadastrados</div>
                          <?php if ($totalRows_usuarios == 0) { // Show if recordset empty ?>
                          <p>nenhum usuário cadastrado</p>
                          <?php } // Show if recordset empty ?>
                        <div class="bg-primary" style="font-size:24px; padding:10px; ">
                   	<?php echo $totalRows_usuarios;?> <span class="glyphicon glyphicon-user"></span>
                		</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="panel panel-primary">
                   	  <div class="panel-heading">Buscas Realizadas</div>
                      <?php if ($totalRows_buscas == 0) { // Show if recordset empty ?>
                      <p>nenhum Buscas Realizadas</p>
                      <?php } // Show if recordset empty ?>
                    	<div class="bg-primary" style="font-size:24px; padding:10px; ">
                           <?php  echo $total; ?> <span class="glyphicon glyphicon-stats"></span>
                           </div>
                       </div>
                    </div>
                    <div class="col-md-4">
                    <div class="panel panel-primary">
                   	  <div class="panel-heading">Lojistas Cadastrados</div>
                      <?php if ($totalRows_lojistas == 0) { // Show if recordset empty ?>
                          <p>nenhum lojista cadastrado</p>
                          <?php } // Show if recordset empty ?>
                        <div class="bg-primary" style="font-size:24px; padding:10px; ">
                       	<?php echo $totalRows_lojistas;?> <span class="glyphicon glyphicon-shopping-cart"></span>
                       </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        	<div class="panel panel-default">
                                <div class="panel-heading" align="left"> Pesquisas encontradas <span class="glyphicon glyphicon-search"></span></div>
                                <table class="table">
                                  <?php if ($totalRows_BuscaEncontrada == 0) { // Show if recordset empty ?>
                                  <tr>
                                    <td align="left">Não há nenhuma busca registrada</td>
                                  </tr>
                                  <?php }else{ // Show if recordset empty ?>
                                  <?php do { ?>
                                  <?php if( $row_BuscaEncontrada['veseencontradas']> 0){?>
                                  <tr>
                                    <td align="left"><?php echo $row_BuscaEncontrada['busca']; ?> </td>
                                    <td align="right"><?php echo $row_BuscaEncontrada['veseencontradas']; $totalencontradas = +$row_BuscaEncontrada['veseencontradas'];?> <span class="glyphicon glyphicon-stats" title="vezes buscado"></span></td>
                                  </tr>
                                  	<?php } ?>
                                    <?php } while ($row_BuscaEncontrada = mysql_fetch_assoc($BuscaEncontrada)); ?>
                                    <?php } ?>
                                </table>
        
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" align="left">Pesquisas não encontradas <span class="glyphicon glyphicon-search"></span></div>
                                <table class="table">
                                  <?php if ($totalRows_BuscaNaoEncontradas == 0) { // Show if recordset empty ?>
                                  <tr>
                                    <td align="left">Não há nenhuma busca registrada</td>
                                  </tr>
                                  <?php }else{ // Show if recordset empty ?>
                                  <?php do { ?>
                                  <?php if($row_BuscaNaoEncontradas['vesenaoencontradas'] > 0){ ?>
                                  <tr>
                                    <td align="left"><?php echo $row_BuscaNaoEncontradas['busca']; ?> </td>
                                    <td align="right"><?php echo $row_BuscaNaoEncontradas['vesenaoencontradas']; ?> <span class="glyphicon glyphicon-stats" title="vezes buscado"></span></td>
                                  </tr>
                                  <?php } ?>
                                    <?php } while ($row_BuscaNaoEncontradas = mysql_fetch_assoc($BuscaNaoEncontradas)); ?>
                                    <?php } ?>
                                </table>
        
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>

<!-- TemplateBeginEditable name="footer" -->
 <div class="footer"></div>

</footer>
</body>
</html>
<?php


mysql_free_result($buscas);

mysql_free_result($usuarios);

mysql_free_result($lojistas);

mysql_free_result($BuscaEncontrada);

mysql_free_result($BuscaNaoEncontradas);

mysql_free_result($admin);


?>