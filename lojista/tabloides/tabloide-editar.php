<?php require_once('../../Connections/dboferapp.php'); ?>
<?php require_once('../verificar-login.php');
mb_http_input("utf-8");
mb_http_output("utf-8");
?>
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

$maxRows_tabloide = 5;
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

$colname_editartabloide = "-1";
if (isset($_GET['tabloide'])) {
  $colname_editartabloide = $_GET['tabloide'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_editartabloide = sprintf("SELECT * FROM tabloide WHERE id = %s AND id_lojista=%s", 
										GetSQLValueString($colname_editartabloide, "int"),
										GetSQLValueString($_SESSION['id_lojista'], "int"));
$editartabloide = mysql_query($query_editartabloide, $dboferapp) or die(mysql_error());
$row_editartabloide = mysql_fetch_assoc($editartabloide);
$totalRows_editartabloide = mysql_num_rows($editartabloide);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$imagemTemp = $_FILES['img']['tmp_name'];
	$imagetype = explode('/', $_FILES['img']['type']);
	if($imagetype[1] =='jpeg'){
		$imagetype[1] = 'jpg';
	}
	if(!empty($imagemTemp)){
		$imgperfil = IMGTABLOIDE;
		$editeImg = explode('.',$row_editartabloide['img']);
		$img = new W3_Image();
		$img->create($imagemTemp, 218, 147,'../../'.$imgperfil. $editeImg[0].'.thumb.'.$imagetype[1]);
		$img->create($imagemTemp, 570, 450,'../../'.$imgperfil. $editeImg[0].'.'. $imagetype[1]);
	}
  $updateSQL = sprintf("UPDATE tabloide SET titulo=%s, descricao=%s, img=%s WHERE id=%s AND id_lojista=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($editeImg[0].'.'. $imagetype[1], "text"),
                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_SESSION['id_lojista'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());

  $updateGoTo = "index.php?action=editado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html dir="ltr" lang='pt'><!-- InstanceBegin template="/Templates/modelolojista.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo htmlentities('OferApp Lojista Tabloides de ofertas e promoções', ENT_COMPAT, 'utf-8'); ?></title>
<!-- InstanceEndEditable -->
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/lojista"><img  src="../../admin/images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                	
                	<li><a href="<?php echo BASEURL; ?>/lojista/ofertas">Ofertas</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/tabloides">Tabloides</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/presentes">Presentes</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo LNOME; ?> <span class="caret"></span></a>
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
            <!-- InstanceBeginEditable name="tituloPagina" -->
            <?php 
				
			?>
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo htmlentities('Editar Tabloide de ofertas e promoções', ENT_COMPAT, 'utf-8'); ?></h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              
              <div class="col-md-4">
              <div class="panel panel-default">
                	<div class="panel-heading">Tabloides Cadatrados</div>
                    <div class="panel-body">
               
                      <table class="table">
                      	  <?php if($totalRows_tabloide == 0){?>
                          <tr>
                          	<td colspan="3">Não a Tabloides cadastradas para esse lojista</td>
                          </tr>
                          <?php }else{ ?>
                          <?php do { ?>
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
                     	<li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, 0, $queryString_tabloide); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, max(0, $pageNum_tabloide - 1), $queryString_tabloide); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a><?php echo ($startRow_tabloide + 1) ?> a <?php echo min($startRow_tabloide + $maxRows_tabloide, $totalRows_tabloide) ?> de <?php echo $totalRows_tabloide ?></a></li>
                        <li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, min($totalPages_tabloide, $pageNum_tabloide + 1), $queryString_tabloide); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_tabloide=%d%s", $currentPage, $totalPages_tabloide, $queryString_tabloide); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                     </ul>
                </div>
            </div>
              </div>
              <div class="col-md-8">
              	<div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Tabloide</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Titulo do Taboide:</label>
                            <div class="col-sm-8">
                            <input type="text" name="titulo" class="form-control" value="<?php echo htmlentities($row_editartabloide['titulo'], ENT_COMPAT, 'utf-8'); ?>" required>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-12">Descricao:</label>
                        </div>
                            <div class="form-group">
                            <div class="col-sm-12">
                            <textarea name="descricao" class="form-control" cols="50" rows="5" required><?php echo htmlentities($row_editartabloide['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>
                            </div>
                            </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Imagem:</label>
                            <div class="col-sm-8">
                            <input type="file" name="img" value="<?php echo htmlentities($row_editartabloide['img'], ENT_COMPAT, 'utf-8'); ?>"  required>
                            </div>
                        </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                         </div>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id" value="<?php echo $row_editartabloide['id']; ?>">
                      </form>
                      
                    </div>
                </div>
            </div>
            <!-- InstanceEndEditable -->
            </div>
        </div>
    </div>
</main>
<footer>
<!-- InstanceBeginEditable name="footer" -->
 <div class="footer"></div>

</footer>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>
<?php


mysql_free_result($tabloide);

mysql_free_result($editartabloide);
?>
