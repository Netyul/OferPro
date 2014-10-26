<?php require_once('../verificar-login.php');
mb_http_input("utf-8");
mb_http_output("utf-8");
?>
<?php require_once('../../Connections/dboferapp.php'); ?>
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

$colname_editaroferta = "-1";
if (isset($_GET['oferta'])) {
  $colname_editaroferta = $_GET['oferta'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_editaroferta = sprintf("SELECT * FROM ofertas WHERE id = %s", GetSQLValueString($colname_editaroferta, "int"));
$editaroferta = mysql_query($query_editaroferta, $dboferapp) or die(mysql_error());
$row_editaroferta = mysql_fetch_assoc($editaroferta);
$totalRows_editaroferta = mysql_num_rows($editaroferta);

$maxRows_ofertas = 5;
$pageNum_ofertas = 0;
if (isset($_GET['pageNum_ofertas'])) {
  $pageNum_ofertas = $_GET['pageNum_ofertas'];
}
$startRow_ofertas = $pageNum_ofertas * $maxRows_ofertas;

$colname_ofertas = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_ofertas = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_ofertas = sprintf("SELECT * FROM ofertas WHERE id_lojista = %s ORDER BY id DESC", GetSQLValueString($colname_ofertas, "int"));
$query_limit_ofertas = sprintf("%s LIMIT %d, %d", $query_ofertas, $startRow_ofertas, $maxRows_ofertas);
$ofertas = mysql_query($query_limit_ofertas, $dboferapp) or die(mysql_error());
$row_ofertas = mysql_fetch_assoc($ofertas);

if (isset($_GET['totalRows_ofertas'])) {
  $totalRows_ofertas = $_GET['totalRows_ofertas'];
} else {
  $all_ofertas = mysql_query($query_ofertas);
  $totalRows_ofertas = mysql_num_rows($all_ofertas);
}
$totalPages_ofertas = ceil($totalRows_ofertas/$maxRows_ofertas)-1;

$colname_lojista = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_lojista = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_lojista = sprintf("SELECT * FROM lojista WHERE id = %s", GetSQLValueString($colname_lojista, "int"));
$lojista = mysql_query($query_lojista, $dboferapp) or die(mysql_error());
$row_lojista = mysql_fetch_assoc($lojista);
$totalRows_lojista = mysql_num_rows($lojista);

$colname_solicitacoes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_solicitacoes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = sprintf("SELECT * FROM solicitacoes WHERE id_lojista = %s AND vendido = 'not'", GetSQLValueString($colname_solicitacoes, "int"));
$solicitacoes = mysql_query($query_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);

$queryString_ofertas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ofertas") == false && 
        stristr($param, "totalRows_ofertas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ofertas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ofertas = sprintf("&totalRows_ofertas=%d%s", $totalRows_ofertas, $queryString_ofertas);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

require_once('../../sistema/classes/W3_Image.class.php');
require_once('../../sistema/constantes.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$imagemTemp = $_FILES['img']['tmp_name'];
	$imagetype = explode('/', $_FILES['img']['type']);
	if($imagetype[1] =='jpeg'){
		$imagetype[1] = 'jpg';
	}
	if(!empty($imagemTemp)){
		$imgperfil = IMGOFERTAS;
		$editeImg = explode('.',$row_editaroferta['img']);
		$img = new W3_Image;
		$img->create($imagemTemp, 218, 147,'../../'.$imgperfil. $editeImg[0].'.thumb.'.$imagetype[1]);
		$img->create($imagemTemp, 570, 450,'../../'.$imgperfil. $editeImg[0].'.'. $imagetype[1]);
	}
  $updateSQL = sprintf("UPDATE ofertas SET titulo=%s, tipo=%s, descricao=%s, quantidade=%s, valor=%s, img=%s WHERE id=%s AND id_lojista=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['quantidade'], "int"),
					   GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($editeImg[0].'.'.$imagetype[1], "text"),
                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_SESSION['id_lojista'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());

  $updateGoTo = "index.php?id=" . $row_editaroferta['id_lojista'] . "&action=editado";
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
<title>Administração da OferApp Lojista</title>
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
            <h2><img src="../../skin/images/icon_menu_navegacao_usuario_01.png" width="29"> Editar ofertas e Promoções</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
                    </div>
                    <div class="col-md-6" align="right">
                        <ul class="nav nav-pills pull-right">
                          <li class="active"><a href="solicitacoes/">Solicitações <?php if($totalRows_RSsolicitar < 0){echo '<span class="badge pull-right">'.$totalRows_RSsolicitar.'</span>';} ?></a></li>
                          <li><a href="#">vendidos</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->

                <div class="col-md-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">Ofertas Cadatradas</div>
                        <div class="panel-body">
                            <p>Ofertas da loja: <?php echo $row_lojista['nomeFantasia'];?></p>
                            <table class="table">
								<?php if($totalRows_ofertas == 0){?>
                                <tr>
                                	<td colspan="3"><?php echo htmlentities('Não a ofertas cadastradas para esse lojista', ENT_COMPAT, 'utf-8'); ?></td>
                                </tr>
                                <?php }else{?>
								<?php do { ?>
                                <tr>    
                                	<td width="33%" rowspan="2"><img src="<?php echo BASEURL.'/'.IMGOFERTAS. $row_ofertas['img']; ?>" class="img-rounded" width="110" height="76"></td>
                                	<td colspan="2"><h4><?php echo htmlentities($row_ofertas['titulo'], ENT_COMPAT, 'utf-8'); ?></h4></td>
                                </tr>
                                <tr>
                                	<td colspan="2">Valor R$: <?php echo $row_ofertas['valor']; ?></br> Quantidade: <?php echo $row_ofertas['quantidade']; ?></td>
                                </tr>
                                <tr>
                                	<td>&nbsp;</td>
                                	<td width="57%" align="right"><a href="ofertas-editar.php?oferta=<?php echo $row_ofertas['id']; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                	<td width="10%" align="center"><a href="ofertas-excluir.php?oferta=<?php echo $row_ofertas['id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                                </tr>
                                <?php } while ($row_ofertas = mysql_fetch_assoc($ofertas)); ?>
								<?php } ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, 0, $queryString_ofertas); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, max(0, $pageNum_ofertas - 1), $queryString_ofertas); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li><a><?php echo ($startRow_ofertas + 1) ?> a <?php echo min($startRow_ofertas + $maxRows_ofertas, $totalRows_ofertas) ?> de <?php echo $totalRows_ofertas ?> </a></li>
                                <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, min($totalPages_ofertas, $pageNum_ofertas + 1), $queryString_ofertas); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, $totalPages_ofertas, $queryString_ofertas); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" style="padding:5px;" align="right">
            	<a href="solicitacao.php?id=<?php echo $row_lojista['id']; ?>" class="btn btn-default">Solicitações <?php if($totalRows_solicitacoes > 0){ echo '<span class="badge">'.$totalRows_solicitacoes.'</span>';}?></a>
              </div>
           	<div class="col-md-8">
                	<div class="panel panel-primary">
                    	<div class="panel-heading">Editar Oferta</div>
                        <div class="panel-body">
                            <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" >
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Titulo da Oferta:</label>
                                <div class="col-sm-8">
                                	<input type="text" class="form-control" name="titulo" required value="<?php echo htmlentities($row_editaroferta['titulo'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Tipo da Oferta:</label>
                                <div class="col-sm-3">
                                    <select name="tipo" class="form-control">
                                        <option value="serviço" <?php if (!(strcmp("serviço", htmlentities($row_editaroferta['tipo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Serviço</option>
                                        <option value="produtos" <?php if (!(strcmp("produtos", htmlentities($row_editaroferta['tipo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Produtos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-12">Descricao da Oferta:</label>
                            </div>
                            <div class="form-group">   
                                <div class="col-sm-12">
                                <textarea name="descricao" rows="5" class="form-control" required><?php echo htmlentities($row_editaroferta['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Quantidade:</label>
                                <div class="col-sm-3">
                                <input type="number" name="quantidade" required value="<?php echo htmlentities($row_editaroferta['quantidade'], ENT_COMPAT, 'utf-8'); ?>" min="1" max="50" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Valor R$:</label>
                                <div class="col-sm-3">
                                	<input type="text" name="valor" required value="<?php echo htmlentities($row_editaroferta['valor'], ENT_COMPAT, 'utf-8'); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Imagem</label>
                                <div class="col-sm-8">
                                <input type="file" name="img" required value="<?php echo htmlentities($row_editaroferta['img'], ENT_COMPAT, 'utf-8'); ?>" size="35">
                                </div>
                            </div>
                            
                            <div class="form-group">
                            	<button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                            <input type="hidden" name="MM_update" value="form1">
                            <input type="hidden" name="id" value="<?php echo $row_editaroferta['id']; ?>">
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
<footer>
<!-- InstanceBeginEditable name="footer" -->
 <div class="footer"></div>

</footer>
</body>
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>
<?php
mysql_free_result($editaroferta);

mysql_free_result($ofertas);

mysql_free_result($lojista);

mysql_free_result($solicitacoes);
?>
