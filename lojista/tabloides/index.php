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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$imagetype = explode('/', $_FILES['img']['type']);				   
	$imagetemp = $_FILES['img']['tmp_name'];
	$strKey    = substr(md5(uniqid(microtime())),0, 28);
	$idAdmin   = $_POST['id_admin'];
	if($imagetype[1] =='jpeg'){
		$imagetype[1] = 'jpg';
	}
	
  $insertSQL = sprintf("INSERT INTO tabloide (titulo, descricao, img, id_lojista) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($strKey.'.'.$imagetype[1], "text"),
                       GetSQLValueString($_POST['id_lojista'], "int"));

		$imgperfil = IMGTABLOIDE;
		$img = new W3_Image();
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

$maxRows_tabloide = 10;
$pageNum_tabloide = 0;
if (isset($_GET['pageNum_tabloide'])) {
  $pageNum_tabloide = $_GET['pageNum_tabloide'];
}
$startRow_tabloide = $pageNum_tabloide * $maxRows_tabloide;

$colname_tabloide = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_tabloide = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_tabloide = sprintf("SELECT * FROM tabloide WHERE id_lojista = %s ORDER BY id DESC", GetSQLValueString($colname_tabloide, "int"));
$query_limit_tabloide = sprintf("%s LIMIT %d, %d", $query_tabloide, $startRow_tabloide, $maxRows_tabloide);
$tabloide = mysql_query($query_limit_tabloide, $dboferapp) or die(mysql_error());
$row_tabloide = mysql_fetch_assoc($tabloide);

if (isset($_GET['totalRows_tabloide'])) {
  $totalRows_tabloide = $_GET['totalRows_tabloide'];
} else {
  $all_tabloide = mysql_query($query_tabloide);
  $totalRows_tabloide = mysql_num_rows($all_tabloide);
}
$totalPages_tabloide = ceil($totalRows_tabloide/$maxRows_tabloide)-1;

$queryString_tabloide = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tabloide") == false && 
        stristr($param, "totalRows_tabloide") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tabloide = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tabloide = sprintf("&totalRows_tabloide=%d%s", $totalRows_tabloide, $queryString_tabloide);
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
<title>Administração da OferApp Lojista</title>
<!-- InstanceEndEditable -->
<link href="../../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
<link href="../../admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../admin/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../../admin/css/oferapp.css" rel="stylesheet" type="text/css" />
<link href="../../admin/css/oferapp-boilerplate.css" rel="stylesheet" type="text/css" />
<link href="../../admin/css/oferapp-admin.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../../skin/js/jquery.min.js"></script>
<script src="../../skin/js/bootstrap.min.js"></script>
<script src="../../skin/js/respond.min.js"></script>
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/lojista/ofertas"><img  src="../../admin/images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            	 <ul class="nav navbar-nav">
                    <li><a href="../../lojista/"  style=""><img src="../../skin/images/estatisticas.jpg" width="39"> Ofer Estatísticas</a></li>                    
                  </ul>
                <ul class="nav navbar-nav navbar-right">
                	
                	<li><a href="<?php echo BASEURL; ?>/lojista/ofertas" title="Ofertas" ><img src="../../skin/images/icon_menu_navegacao_usuario_01.png" width="39"> Ofertas</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/tabloides" title="Tabloides"><img src="../../skin/images/icon_menu_navegacao_usuario_04.png" width="39"> Tablóides</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/presentes" title="Presentes"><img src="../../skin/images/icon_menu_navegacao_usuario_03.png" width="39"> Presentes</a></li>
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
            <h2><img src="../../skin/images/icon_menu_navegacao_usuario_04.png" width="29">Tablóides de ofertas e promoções</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
                    </div>
                    <div class="col-md-6">
                        <ul class="nav nav-pills align" style="margin-top:0px;">
                          <li class="active"><a href="../ofertas/solicitacoes/">Solicitações <?php if($totalRows_RSsolicitar < 0){echo '<span class="badge pull-right">'.$totalRows_RSsolicitar.'</span>';} ?></a></li>
                          <li><a href="../ofertas/solicitacoes/solicitacoes-vendidas.php">vendidos</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <div class="col-md-4">
                <div class="panel panel-default">
                	<div class="panel-heading" align="left">Tablóides Cadatrados</div>
                    <div class="panel-body">
               
                      
                      	  <?php if($totalRows_tabloide == 0){?>
                          
                          	<p align="left">Não há tablóides cadastradas para você.</p>
                          
                          <?php }else{ ?>
                          <?php do { ?>
                          <table class="table">
                          <tr>
                            
                            
                            <td width="33%"><img src="<?php echo BASEURL.'/'.IMGTABLOIDE. $row_tabloide['img']; ?>" class="img-rounded" width="110" height="76"></td>
                            <td colspan="2"><h4><?php echo $row_tabloide['titulo']; ?></h4></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="57%" align="right"><a href="tabloide-editar.php?tabloide=<?php echo $row_tabloide['id']; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td width="10%" align="center"><a href="tabloide-excluir.php?tabloide=<?php echo $row_tabloide['id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            
                          </tr>
                          <?php } while ($row_tabloide = mysql_fetch_assoc($tabloide)); ?>
                          <?php } ?>
                      </table>
  				</div>
                <div class="panel-footer">
                     <ul class="pagination">
                     	
                        <li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, max(0, $pageNum_tabloide - 1), $queryString_tabloide); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a><?php echo ($startRow_tabloide + 1) ?> a <?php echo min($startRow_tabloide + $maxRows_tabloide, $totalRows_tabloide) ?> de <?php echo $totalRows_tabloide ?> </a></li>
                        <li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, min($totalPages_tabloide, $pageNum_tabloide + 1), $queryString_tabloide); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        
                     </ul>
                </div>
            </div>
              </div>
              <div class="col-md-8">
               <?php
			   			if(isset($_GET['action'])){
							if($_GET['action'] == 'cadastrado'){
								echo '<div class="alert alert-success" role="alert">Tabloide Cadastrado!</div>';
							}
							elseif($_GET['action'] == 'excluido'){
								echo '<div class="alert alert-success" role="alert">Tabloide Excluido!</div>';
							}
							elseif($_GET['action'] == 'editado'){
								echo '<div class="alert alert-success" role="alert">Tabloide Editado!</div>';
							}
							
						}
			   ?>
              	<div class="panel panel-default">
                    <div class="panel-heading" align="left">Cadastrar Tablóides</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" class="form-horizontal">
                       		<div class="form-group">
                            <label for="titulo da oferta" class="col-sm-4 control-label">Título do Tablóides:</label>
                            <div class="col-sm-8">
                            <input type="text" name="titulo" value="" size="150" class="form-control" required placeholder="Digite o título do tablóide">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="descricao-oferta" class="col-sm-12">Descrição do Tablóides:</label>
                          </div>
                          <div class="form-group">
                          	<div class="col-sm-12">
                            <textarea name="descricao" cols="50" rows="5" class="form-control" required placeholder="Digite a descrição do tablóide"></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="imagem" class="col-sm-4 control-label">Imagem:</label>
                            <div class="col-sm-8" align="left">
                            	<input type="file" name="img" id="file-original" required>
                                <button type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button>
                            </div>
                          </div>
                          <div class="form-group" style="padding:15px">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                          </div>
                       
                        <input type="hidden" name="id_lojista" value="<?php echo $colname_tabloide; ?>">
                        <input type="hidden" name="MM_insert" value="form1">
                      </form>
                      
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
mysql_free_result($tabloide);
?>
