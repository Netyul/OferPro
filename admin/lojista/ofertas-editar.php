<?php require_once('../verificar-login.php');?>
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

$colname_editaroferta = "-1";
if (isset($_GET['oferta'])) {
  $colname_editaroferta = $_GET['oferta'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_editaroferta = sprintf("SELECT * FROM ofertas WHERE id = %s", GetSQLValueString($colname_editaroferta, "int"));
$editaroferta = mysql_query($query_editaroferta, $dboferapp) or die(mysql_error());
$row_editaroferta = mysql_fetch_assoc($editaroferta);
$totalRows_editaroferta = mysql_num_rows($editaroferta);


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
  $updateSQL = sprintf("UPDATE ofertas SET titulo=%s, tipo=%s, descricao=%s, quantidade=%s, valor=%s, img=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['quantidade'], "int"),
					   GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($editeImg[0].'.'.$imagetype[1], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());

  $updateGoTo = "ofertas.php?id=" . $row_editaroferta['id_lojista'] . "&action=editado";
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
<html lang="pt" dir="ltr"><!-- InstanceBegin template="/Templates/ModeloOferappAdm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administração da OferApp</title>
<!-- InstanceEndEditable -->
<link href="../../skin/images/favicon.png" rel="icon" type="image/x-icon"/>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../css/oferapp.css" rel="stylesheet" type="text/css">
<link href="../css/oferapp-boilerplate.css" rel="stylesheet" type="text/css" />
<link href="../css/oferapp-admin.css" rel="stylesheet" type="text/css" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/respond.min.js"></script>
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>/admin/lojista/"><img  src="../images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            	<ul class="nav navbar-nav">
                    <li><a href="../../admin/"><img src="../../skin/images/estatisticas.jpg" width="39"> Ofer Estatísticas (BR)</a></li>                    
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
            <div class="top page-header" style="padding-left:17px">
            <!-- InstanceBeginEditable name="tituloPagina" -->
            <?php 
				
			?>
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Editar Ofertas</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
            	<div class="col-md-12" style="padding:5px;" align="right">
                <a href="ofertas.php?id=<?php echo $row_editaroferta['id_lojista']; ?>" class="btn btn-Oferapp">Ofertas</a>
                <a href="tablides.php?id=<?php echo $row_editaroferta['id_lojista']; ?>" class="btn btn-Oferapp">Tablóides</a>
                <a href="presentes.php?id=<?php echo $row_editaroferta['id_lojista']; ?>" class="btn btn-Oferapp">Presentes</a>
            </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                	<div class="panel panel-primary">
                    	<div class="panel-heading">Editar Oferta</div>
                        <div class="panel-body">
                            <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" >
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Título da Oferta:</label>
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
                                <div class="col-sm-8" align="left">
                               <input type="file" name="img" id="file-original"  value="<?php echo htmlentities($row_editaroferta['img'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" size="35">
                                <button type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button>
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
                <div class="col-md-2">
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

?>
