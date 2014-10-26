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
$colname_Presenteseditar = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_Presenteseditar = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_Presenteseditar = sprintf("SELECT * FROM presentes WHERE id_lojista = %s", GetSQLValueString($colname_Presenteseditar, "int"));
$Presenteseditar = mysql_query($query_Presenteseditar, $dboferapp) or die(mysql_error());
$row_Presenteseditar = mysql_fetch_assoc($Presenteseditar);
$totalRows_Presenteseditar = mysql_num_rows($Presenteseditar);

$colname_presentes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_presentes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_presentes = sprintf("SELECT * FROM presentes WHERE id_lojista = %s", GetSQLValueString($colname_presentes, "int"));
$presentes = mysql_query($query_presentes, $dboferapp) or die(mysql_error());
$row_presentes = mysql_fetch_assoc($presentes);
$totalRows_presentes = mysql_num_rows($presentes);

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
		$imgperfil = IMGPRESENTES;
		$editeImg = explode('.',$row_Presenteseditar['img']);
		$img = new W3_Image;
		$img->create($imagemTemp, 218, 147,'../../'.$imgperfil. $editeImg[0].'.thumb.'.$imagetype[1]);
		$img->create($imagemTemp, 570, 450,'../../'.$imgperfil. $editeImg[0].'.'. $imagetype[1]);
	}
  $updateSQL = sprintf("UPDATE presentes SET titulo=%s, descricao=%s, img=%s, datatermino=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($editeImg[0].'.'.$imagetype[1], "text"),
                       GetSQLValueString(date('d/m/Y', strtotime($_POST['datatermino'])), "text"),
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


?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html dir="ltr" lang='pt'><!-- InstanceBegin template="/Templates/modelolojista.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>OferApp Lojista editar presentes </title>
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
                	
                	<li><a href="<?php echo BASEURL; ?>/lojista/ofertas" title="Ofertas" ><img src="../../skin/images/icon_menu_navegacao_usuario_01.png" class=" pull-left" width="39"> Ofertas</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/tabloides" title="Tabloides"><img src="../../skin/images/icon_menu_navegacao_usuario_04.png" class=" pull-left" width="39"> Tabloides</a></li>
                    <li><a href="<?php echo BASEURL; ?>/lojista/presentes" title="Presentes"><img src="../../skin/images/icon_menu_navegacao_usuario_03.png" width="39" class=" pull-left"> Presentes</a></li>
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
                <div class="row">
                    <div class="col-md-6">
                    <!-- InstanceBeginEditable name="tituloPagina" -->
            <?php 
				
			?>
            <h2><img src="../../skin/images/icon_menu_navegacao_usuario_03.png" width="29"> Editar Presentes</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
                    </div>
                    <div class="col-md-6" align="right">
                        <ul class="nav nav-pills pull-right">
                          <li class="active"><a href="../ofertas/solicitacoes/">Solicitações <?php if($totalRows_RSsolicitar < 0){echo '<span class="badge pull-right">'.$totalRows_RSsolicitar.'</span>';} ?></a></li>
                          <li><a href="#">vendidos</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              
              <div class="col-md-4">
              	<div class="panel panel-default">
                	<div class="panel-heading">
                    	Presente Cadastrado
                    </div>
                    <div class="panel-body">
                        <table class="table">
                        	<?php if($totalRows_presentes == 0){?>
                        	<tr>
                            	<td colspan="3"><?php echo htmlentities('não a nenhum presente cadastrado', ENT_COMPAT, 'utf-8'); ?></td>
                            </tr>
                            <?php }else{?>
                            
                            <tr>
                                <td width="31%" rowspan="3"><img src="<?php echo BASEURL .'/'.IMGPRESENTES. $row_presentes['img']; ?>" class="img-rounded" width="120"></td>
                                <td colspan="2"><?php echo htmlentities($row_presentes['titulo'], ENT_COMPAT, 'utf-8'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Data Termino: <?php echo $row_presentes['datatermino']; ?></td>
                            </tr>
                            <tr>
                              <td width="39%">&nbsp;</td>
                                <td width="30%"><a href="presentes-editar.php?id=<?php echo $row_presentes['id_lojista']; ?>&action=editar" class="btn btn-primary btn-sm" title="Editar Presente"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            </tr>
                            <?php }?>
                        </table>

                    </div>
                </div> 
              </div>
              <div class="col-md-8">
              	<div class="panel panel-default">
                	<div class="panel-heading">Editar Presente</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                        <div class="form-group">
                           <label class="col-sm-4 control-label" >Titulo do Presente:</label>
                           <div class="col-sm-8">
                            <input class="form-control" type="text" name="titulo" value="<?php echo htmlentities($row_Presenteseditar['titulo'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-12">Descricao:</label>
                          </div>
                          <div class="form-group">
                          <div class="col-sm-12">
                          <textarea class="col-sm-12 form-control" name="descricao" required><?php echo htmlentities($row_Presenteseditar['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>
                          </div>
                          </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label">Imagen:</label>
                            <div class="col-sm-7">
                            <input class="form-control" type="file" name="img" value="<?php echo htmlentities($row_Presenteseditar['img'], ENT_COMPAT, 'utf-8'); ?>" required>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Data do termino:</label>
                            <div class="col-sm-4">
                            <input type="date" name="datatermino" value="<?php echo date('Y-m-d', strtotime(str_replace('/','-', $row_Presenteseditar['datatermino']))); ?>" size="32" required>
                            </div>
                        </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                          </tr>
                        </table>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id" value="<?php echo $row_Presenteseditar['id']; ?>">
                      </form>
                      <p>&nbsp;</p>
                    </div>
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
mysql_free_result($Presenteseditar);

mysql_free_result($presentes);
?>
