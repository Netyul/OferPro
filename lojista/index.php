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

$colname_ofertas = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_ofertas = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_ofertas = sprintf("SELECT * FROM ofertas WHERE id_lojista = %s", GetSQLValueString($colname_ofertas, "int"));
$ofertas = mysql_query($query_ofertas, $dboferapp) or die(mysql_error());
$row_ofertas = mysql_fetch_assoc($ofertas);
$totalRows_ofertas = mysql_num_rows($ofertas);

$colname_tabloides = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_tabloides = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_tabloides = sprintf("SELECT * FROM tabloide WHERE id_lojista = %s", GetSQLValueString($colname_tabloides, "int"));
$tabloides = mysql_query($query_tabloides, $dboferapp) or die(mysql_error());
$row_tabloides = mysql_fetch_assoc($tabloides);
$totalRows_tabloides = mysql_num_rows($tabloides);

$colname_presentes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_presentes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_presentes = sprintf("SELECT * FROM presentes WHERE id_lojista = %s", GetSQLValueString($colname_presentes, "int"));
$presentes = mysql_query($query_presentes, $dboferapp) or die(mysql_error());
$row_presentes = mysql_fetch_assoc($presentes);
$totalRows_presentes = mysql_num_rows($presentes);

$colname_solicitacoes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_solicitacoes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = sprintf("SELECT * FROM solicitacoes WHERE id_lojista = %s", GetSQLValueString($colname_solicitacoes, "int"));
$solicitacoes = mysql_query($query_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);

$colname_vendidos = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_vendidos = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_vendidos = sprintf("SELECT * FROM solicitacoes WHERE id_lojista = %s AND vendido ='yes'", GetSQLValueString($colname_vendidos, "int"));
$vendidos = mysql_query($query_vendidos, $dboferapp) or die(mysql_error());
$row_vendidos = mysql_fetch_assoc($vendidos);
$totalRows_vendidos = mysql_num_rows($vendidos);

mysql_select_db($database_dboferapp, $dboferapp);
$query_buscas = "SELECT * FROM busca ORDER BY veses DESC";
$buscas = mysql_query($query_buscas, $dboferapp) or die(mysql_error());
$row_buscas = mysql_fetch_assoc($buscas);
$totalRows_buscas = mysql_num_rows($buscas);

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


?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html dir="ltr" lang='pt'><!-- InstanceBegin template="/Templates/modelolojista.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>OferApp para Lojista</title>
<!-- InstanceEndEditable -->
<link href="../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
<link href="../admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/oferapp.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/oferapp-boilerplate.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/oferapp-admin.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../skin/js/jquery.min.js"></script>
<script src="../skin/js/bootstrap.min.js"></script>
<script src="../skin/js/respond.min.js"></script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<?php
mysql_select_db($database_dboferapp, $dboferapp);
$query_RSsolicitar = "SELECT * FROM solicitacoes WHERE vendido = 'not'";
$RSsolicitar = mysql_query($query_RSsolicitar, $dboferapp) or die(mysql_error());
$row_RSsolicitar = mysql_fetch_assoc($RSsolicitar);
$totalRows_RSsolicitar = mysql_num_rows($RSsolicitar);
?>

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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/lojista/ofertas"><img  src="../admin/images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            	 <ul class="nav navbar-nav">
                    <li><a href="../lojista/"  style=""><img src="../skin/images/estatisticas.jpg" width="39"> Ofer Estatísticas</a></li>                    
                  </ul>
                <ul class="nav navbar-nav navbar-right">
                	
                	<li><a href="<?php echo BASEURL; ?>/lojista/ofertas" title="Ofertas" ><img src="../skin/images/icon_menu_navegacao_usuario_01.png" width="39"> Ofertas</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/tabloides" title="Tabloides"><img src="../skin/images/icon_menu_navegacao_usuario_04.png" width="39"> Tablóides</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/presentes" title="Presentes"><img src="../skin/images/icon_menu_navegacao_usuario_03.png" width="39"> Presentes</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown" style="padding-top: 17px !important; padding-bottom: 16px !important;"><span class="glyphicon glyphicon-user"></span> <?php echo LNOME; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        	<li><a href="<?php echo BASEURL; ?>/lojista/perfil">Perfil</a></li>
                            <li><a href="<?php echo BASEURL; ?>/lojista/logout">sair</a></li>
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
                <div class="row">
                    <div class="col-md-6">
                    <!-- InstanceBeginEditable name="tituloPagina" -->
            <?php 
				
			?>
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administração Lojista</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
                    </div>
                    <div class="col-md-6">
                        <ul class="nav nav-pills align" style="margin-top:0px;">
                          <li class="active"><a href="ofertas/solicitacoes/">Solicitações <?php if($totalRows_RSsolicitar < 0){echo '<span class="badge pull-right">'.$totalRows_RSsolicitar.'</span>';} ?></a></li>
                          <li><a href="ofertas/solicitacoes/solicitacoes-vendidas.php">vendidos</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              
              <div class="col-md-4">
              <div class="panel panel-default">
                    	<div class="panel-heading" align="left"> Feedback de Pesquisas <span class="glyphicon glyphicon-search"></span></div>
                        <table class="table">
                          <?php if ($totalRows_buscas == 0) { // Show if recordset empty ?>
                          <tr>
                            <td align="left">Não há nenhuma busca registrada</td>
                          </tr>
                          <?php }else{ // Show if recordset empty ?>
						  <?php do { ?>
                          <tr>
                            <td align="left"><?php echo $row_buscas['busca']; ?> </td>
                            <td align="right"><?php echo $row_buscas['veses']; ?> <span class="glyphicon glyphicon-stats" title="vezes buscado"></span></td>
                          </tr>
                            <?php } while ($row_buscas = mysql_fetch_assoc($buscas)); ?>
                            <?php } ?>
                        </table>

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
									<p>Não há Ofertas cadastradas</p>
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
									<p>Não há tabloides cadastradas</p>
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
									<p>Não há presentes cadastradas</p>
                                <?php }else{?>
                                    <h4><?php echo $totalRows_presentes;?> <span class="glyphicon glyphicon glyphicon glyphicon-gift"></span></h4>
                                    <?php } ?> 
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
            <!-- InstanceEndEditable -->
            </div>
        </div>
    </div>
</main>
<?php
mysql_free_result($RSsolicitar);
?>
<footer>

<!-- InstanceBeginEditable name="footer" -->
 <div class="footer"></div>

</footer>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>
<?php
mysql_free_result($ofertas);

mysql_free_result($tabloides);

mysql_free_result($presentes);

mysql_free_result($solicitacoes);

mysql_free_result($vendidos);

mysql_free_result($buscas);

mysql_free_result($BuscaEncontrada);

mysql_free_result($BuscaNaoEncontradas);
?>
