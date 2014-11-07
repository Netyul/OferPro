<?php require_once('../../verificar-login.php');?>
<?php require_once('../../../Connections/dboferapp.php'); ?>
<?php 
require_once('../../../sistema/classes/W3_Image.class.php');
require_once('../../../sistema/constantes.php');
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

$maxRows_solicitacoes = 10;
$pageNum_solicitacoes = 0;
if (isset($_GET['pageNum_solicitacoes'])) {
  $pageNum_solicitacoes = $_GET['pageNum_solicitacoes'];
}
$startRow_solicitacoes = $pageNum_solicitacoes * $maxRows_solicitacoes;

$colname_solicitacoes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_solicitacoes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = sprintf("SELECT s.id, s.vendido, o.titulo, o.descricao, o.valor, o.img, u.img as imguser,u.nome,u.celular,u.email, l.id AS id_lojista, l.nomeFantasia FROM solicitacoes AS s INNER JOIN ofertas AS o ON o.id = s.id_oferta INNER JOIN lojista AS l ON l.id = s.id_lojista INNER JOIN usuario AS u ON u.id = s.id_cliente WHERE s.id_lojista = %s AND s.vendido = 'yes'", GetSQLValueString($colname_solicitacoes, "int"));
$query_limit_solicitacoes = sprintf("%s LIMIT %d, %d", $query_solicitacoes, $startRow_solicitacoes, $maxRows_solicitacoes);
$solicitacoes = mysql_query($query_limit_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);

if (isset($_GET['totalRows_solicitacoes'])) {
  $totalRows_solicitacoes = $_GET['totalRows_solicitacoes'];
} else {
  $all_solicitacoes = mysql_query($query_solicitacoes);
  $totalRows_solicitacoes = mysql_num_rows($all_solicitacoes);
}
$totalPages_solicitacoes = ceil($totalRows_solicitacoes/$maxRows_solicitacoes)-1;

$queryString_solicitacoes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_solicitacoes") == false && 
        stristr($param, "totalRows_solicitacoes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_solicitacoes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_solicitacoes = sprintf("&totalRows_solicitacoes=%d%s", $totalRows_solicitacoes, $queryString_solicitacoes);
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
<title><?php echo htmlentities('OferApp Lojista Solicitações vendidas', ENT_COMPAT, 'utf-8'); ?></title>
<!-- InstanceEndEditable -->
<link href="../../../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
<link href="../../../admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../../admin/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../../../admin/css/oferapp.css" rel="stylesheet" type="text/css" />
<link href="../../../admin/css/oferapp-boilerplate.css" rel="stylesheet" type="text/css" />
<link href="../../../admin/css/oferapp-admin.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../../../skin/js/jquery.min.js"></script>
<script src="../../../skin/js/bootstrap.min.js"></script>
<script src="../../../skin/js/respond.min.js"></script>
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/lojista/ofertas"><img  src="../../../admin/images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            	 <ul class="nav navbar-nav">
                    <li><a href="../../../lojista/"  style=""><img src="../../../skin/images/estatisticas.jpg" width="39"> Ofer Estatísticas</a></li>                    
                  </ul>
                <ul class="nav navbar-nav navbar-right">
                	
                	<li><a href="<?php echo BASEURL; ?>/lojista/ofertas" title="Ofertas" ><img src="../../../skin/images/icon_menu_navegacao_usuario_01.png" width="39"> Ofertas</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/tabloides" title="Tabloides"><img src="../../../skin/images/icon_menu_navegacao_usuario_04.png" width="39"> Tablóides</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/presentes" title="Presentes"><img src="../../../skin/images/icon_menu_navegacao_usuario_03.png" width="39"> Presentes</a></li>
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
            <h2> <span class="glyphicon glyphicon-send"></span> Solicitações vendidas</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
                    </div>
                    <div class="col-md-6">
                        <ul class="nav nav-pills align" style="margin-top:0px;">
                          <li class="active"><a href="../solicitacoes/">Solicitações <?php if($totalRows_RSsolicitar < 0){echo '<span class="badge pull-right">'.$totalRows_RSsolicitar.'</span>';} ?></a></li>
                          <li><a href="solicitacoes-vendidas.php">vendidos</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
               <div class="col-md-12">
            <?php
			   			if(isset($_GET['action'])){
							
							if($_GET['action'] == 'excluido'){
								echo '<div class="alert alert-success" role="alert">Venda Excluida!</div>';
							}
							
							
						}
			   ?>
            </div>
              <div class="col-md-12">
              	<div class="panel panel-default">
                	<div class="panel-heading" align="left">
                    	Vendas da Loja <?php echo $row_solicitacoes['nomeFantasia']; ?>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                            <th width="44%" scope="col">Ofertas</th>
                            <th width="52%" scope="col">Clientes</th>
                            <th width="4%" align="center" scope="col">Ação</th>
                            </tr>
                            <?php if($totalRows_solicitacoes == 0){?>
                            <tr>
                            <td colspan="3" align="left">Nenhuma Venda Efetuada</td>
                            </tr>
                            <?php } else{do { ?>
                            <tr>
                                <td>
                                  <table border="0" class="table">
                                    <tr>
                                      <td rowspan="3"><img src="<?php echo BASEURL.'/'.IMGOFERTAS. $row_solicitacoes['img']; ?>" class="img-rounded" width="120"></td>
                                      <td><?php echo $row_solicitacoes['titulo']; ?></td>
                                    </tr>
                                    <tr>
                                      <td>Valor R$: <?php echo $row_solicitacoes['valor']; ?></td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table>
                                </td>
                                <td>
                                <table width="89%" border="0" class="table">
                                  <tr>
                                    <td width="36%" rowspan="3"><img src="<?php if(empty($row_solicitacoes['imguser'])){ echo IMGSISTEMA;}else{echo 'http://'. BASEURL.'/' . IMGPERFIL. $row_solicitacoes['imguser'];} ?>" class="img-rounded" width="120"></td>
                                    <td><?php echo $row_solicitacoes['nome']; ?></td>
                                  </tr>
                                  <tr>
                                    <td><span class="glyphicon glyphicon-phone" title="Celular"></span> <?php echo $row_solicitacoes['celular']; ?></td>
                                  </tr>
                                  <tr>
                                    <td><span class="glyphicon glyphicon-envelope" title="Email"></span> <?php echo $row_solicitacoes['email']; ?></td>
                                  </tr>
                                  </table>
                                </td>
                                <td align="center"><a href="solicitacao-excluir.php?solicitacao2=<?php echo $row_solicitacoes['id']; ?>" class="btn btn-danger btn-sm" title="Excluir solicitação"><span class="glyphicon glyphicon-remove"></span></a></td>
                              </tr>
                              <?php } while ($row_solicitacoes = mysql_fetch_assoc($solicitacoes));} ?>
                        </table>

                    </div>
                    <div class="panel-footer">
                    	<ul class="pagination">
                        	<li><a href="<?php printf("%s?pageNum_solicitacoes=%d%s", $currentPage, max(0, $pageNum_solicitacoes - 1), $queryString_solicitacoes); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
							<li><a><?php echo ($startRow_solicitacoes + 1) ?> a <?php echo min($startRow_solicitacoes + $maxRows_solicitacoes, $totalRows_solicitacoes) ?> de <?php echo $totalRows_solicitacoes ?> </a></li>
                            <li><a href="<?php printf("%s?pageNum_solicitacoes=%d%s", $currentPage, min($totalPages_solicitacoes, $pageNum_solicitacoes + 1), $queryString_solicitacoes); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        </ul>
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