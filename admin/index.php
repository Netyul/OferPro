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


/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/

require_once('../sistema/constantes.php');
require_once('../functions.php');
$urlloginadm = BASEURL.'/admin/login';
require_once('../sistema/core/connectdb.php');
require_once('verificar-login.php');

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
                <a class="navbar-brand" href="http://<?php echo BASEURL; ?>"><img  src="<?php SkinUrl('images/logo.png');?>" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right"> 
                	<?php 
					$level = LEVEL;
					if($level == 'superadmin'){
					?>
                	<li><a href="<?php baseurl('admin/cidade'); ?>">Cidades</a></li>
                    <li><a href="<?php baseurl('admin/administradores'); ?>">Administradores</a></li> 
                    <?php } ?>               
                    <li><a href="<?php baseurl('admin/lojista'); ?>">Lojistas</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo ADMNOME;?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php baseurl('admin/logout'); ?>">sair</a></li>
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
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administração</h2>
            <?php ?>
            </div>
            <div class="row">
                <div class="col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading"> Rank de Busca</div>
                        <table class="table">
                          <?php if ($totalRows_buscas == 0) { // Show if recordset empty ?>
                          <tr>
                            <td> Não a nenhuma busca registrada </td>
                          </tr>
                          <?php } // Show if recordset empty ?>
						  <?php do { ?>
                          <tr>
                            <td><?php echo $row_buscas['busca']; ?></td>
                            <td><?php echo $row_buscas['veses']; ?> <span class="glyphicon glyphicon-search" title="vezes buscado"></span></td>
                          </tr>
                            <?php } while ($row_buscas = mysql_fetch_assoc($buscas)); ?>
                        </table>

                    </div>
              </div>
                <div class="col-md-8">
                	<div class="col-md-4">
                    	<div class="panel panel-primary">
                       	  <div class="panel-heading">Usuarios Cadastrados</div>
                          <?php if ($totalRows_usuarios == 0) { // Show if recordset empty ?>
                          <p>nenhum usuario cadastrado</p>
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
                           <?php echo $totalRows_buscas;?> <span class="glyphicon glyphicon-stats"></span>
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
                       	<?php echo $totalRows_usuarios;?> <span class="glyphicon glyphicon-shopping-cart"></span>
                       </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
<?php
mysql_free_result($buscas);

mysql_free_result($usuarios);

mysql_free_result($lojistas);


?>