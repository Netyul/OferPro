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
		$imgperfil = IMGPERFIL;
		$editeImg = explode('.',$row_EditeLojista['img']);
		$img = new W3_Image;
		$img->create($imagemTemp, 218, 147,'../../'.$imgperfil. $editeImg[0].'.thumb.'.$imagetype[1]);
		$img->create($imagemTemp, 570, 450,'../../'.$imgperfil. $editeImg[0].'.'. $imagetype[1]);
	}
  $updateSQL = sprintf("UPDATE lojista SET img=%s WHERE id=%s",
                       GetSQLValueString($editeImg[0].'.'. $imagetype[1], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());

  $updateGoTo = "index.php?action=editado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editarperfil = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_editarperfil = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_editarperfil = sprintf("SELECT * FROM lojista WHERE id = %s", GetSQLValueString($colname_editarperfil, "int"));
$editarperfil = mysql_query($query_editarperfil, $dboferapp) or die(mysql_error());
$row_editarperfil = mysql_fetch_assoc($editarperfil);
$totalRows_editarperfil = mysql_num_rows($editarperfil);

mysql_select_db($database_dboferapp, $dboferapp);
$query_cidade = "SELECT c.id, c.nome, e.sigla FROM cidade AS c INNER JOIN estado AS e ON e.id = c.id_uf ORDER BY c.nome ASC";
$cidade = mysql_query($query_cidade, $dboferapp) or die(mysql_error());
$row_cidade = mysql_fetch_assoc($cidade);
$totalRows_cidade = mysql_num_rows($cidade);
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
<title>OferApp Lojista</title>
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
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Editar Perfil</h2>
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
              
              <div class="col-md-3">
              	<table class="table">
                  <tr>
                    <td colspan="3" align="center"><a href=""><img src="<?php echo BASEURL.'/'.IMGPERFIL.$row_editarperfil['img']; ?>" width="218" height="147" class="img-rounded"></a></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><a href="editar-perfil.php" class="btn btn-primary" title="editar perfil"><span class="glyphicon glyphicon-user"></span></a> <a href="editar-imagem.php" class="btn btn-primary" title="editar imagem"><span class="glyphicon glyphicon-picture"></span></a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-9">
                  <div class="panel panel-primary">
                  	<div class="panel-heading" align="left"> Edite imagem do perfil</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                          <div class="form-group">
                            <label class="col-sm-6 control-label">Imagem:</label>
                            <div class="col-sm-6" align="left">
                           		<input type="file" name="img" id="file-original" value="<?php echo htmlentities($row_editarperfil['img'], ENT_COMPAT, 'utf-8'); ?>" required>
                                <button type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button>
                          </div>
                          </div>
                         <div class="form-group">
                           <button type="submit" class="btn btn-primary">Salvar</button>
                          </div>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id" value="<?php echo $row_editarperfil['id']; ?>">
                      </form>
                      <p>&nbsp;</p>
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
mysql_free_result($editarperfil);

mysql_free_result($cidade);
?>
