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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$imagetype = explode('/', $_FILES['img']['type']);				   
	$imagetemp = $_FILES['img']['tmp_name'];
	$strKey    = substr(md5(uniqid(microtime())),0, 28);
	$idAdmin   = $_POST['id_admin'];
	if($imagetype[1] =='jpeg'){
		$imagetype[1] = 'jpg';
	}
	
  $insertSQL = sprintf("INSERT INTO ofertas (titulo, tipo, descricao, quantidade, valor, img, id_lojista) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['quantidade'], "int"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($strKey.'.'.$imagetype[1], "text"),
					   GetSQLValueString($_POST['id_lojista'], "int"));
	
		$imgperfil = IMGOFERTAS;
		$img = new W3_Image();
		$img->create($imagetemp, 218, 147, '../../'.$imgperfil.$strKey.'.thumb.'.$imagetype[1]);
		$img->create($imagetemp, 570, 450, '../../'.$imgperfil.$strKey.'.'.$imagetype[1]); 
	
  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($insertSQL, $dboferapp) or die(mysql_error());
   
   $db = mysqli_connect($hostname_dboferapp,$username_dboferapp,$password_dboferapp,$database_dboferapp);
	$notificar ="SELECT * FROM rec_notificacao WHERE id_lojista = ".$_POST['id_lojista'];
	$rsnotificar = mysqli_query($db,$notificar);
	$rowsNotificar = mysqli_fetch_array($rsnotificar);
	$totalrsnotificar = mysqli_num_rows($rsnotificar);
	if($totalrsnotificar>0){
		$SelectOfertas="SELECT * FROM ofertas WHERE id_lojista = ".$_POST['id_lojista']." AND titulo= '".$_POST['titulo']."'";
		$RSselectOfertas = mysqli_query($db,$SelectOfertas);
		$rowSelectOfertas = mysqli_fetch_array($RSselectOfertas);
		
		$insertNotificar = "INSERT INTO notificacao(id_user, id_lojista, id_oferta, visualizado) VALUES (".$rowsNotificar['id_user'].",".$rowsNotificar['id_lojista'].",".$rowSelectOfertas['id'].",'not') ";
		$RSinsertNotificar = mysqli_query($db,$insertNotificar);
	}

  $insertGoTo = "ofertas.php?action=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$maxRows_lojista = 5;
$pageNum_lojista = 0;
if (isset($_GET['pageNum_lojista'])) {
  $pageNum_lojista = $_GET['pageNum_lojista'];
}
$startRow_lojista = $pageNum_lojista * $maxRows_lojista;

$colname_lojista = "-1";
if (isset($_GET['id'])) {
  $colname_lojista = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_lojista = sprintf("SELECT * FROM lojista WHERE id = %s", GetSQLValueString($colname_lojista, "int"));
$query_limit_lojista = sprintf("%s LIMIT %d, %d", $query_lojista, $startRow_lojista, $maxRows_lojista);
$lojista = mysql_query($query_limit_lojista, $dboferapp) or die(mysql_error());
$row_lojista = mysql_fetch_assoc($lojista);

if (isset($_GET['totalRows_lojista'])) {
  $totalRows_lojista = $_GET['totalRows_lojista'];
} else {
  $all_lojista = mysql_query($query_lojista);
  $totalRows_lojista = mysql_num_rows($all_lojista);
}
$totalPages_lojista = ceil($totalRows_lojista/$maxRows_lojista)-1;
  $maxRows_ofertas = 5;
$pageNum_ofertas = 0;
if (isset($_GET['pageNum_ofertas'])) {
  $pageNum_ofertas = $_GET['pageNum_ofertas'];
}
$startRow_ofertas = $pageNum_ofertas * $maxRows_ofertas;

$colname_ofertas = "-1";
if (isset($_GET['id'])) {
  $colname_ofertas = $_GET['id'];
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

$colname_solicitacoes = "-1";
if (isset($_GET['id'])) {
  $colname_solicitacoes = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacoes = sprintf("SELECT * FROM solicitacoes WHERE id_lojista = %s AND vendido = 'not' ORDER BY id ASC", GetSQLValueString($colname_solicitacoes, "int"));
$solicitacoes = mysql_query($query_solicitacoes, $dboferapp) or die(mysql_error());
$row_solicitacoes = mysql_fetch_assoc($solicitacoes);
$totalRows_solicitacoes = mysql_num_rows($solicitacoes);

$currentPage = $_SERVER["PHP_SELF"];

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
            <h2><span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administrar Ofertas </h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <div class="col-md-4">
                <div class="panel panel-default">
                	<div class="panel-heading" align="left">Ofertas Cadatradas</div>
                    <div class="panel-body">
                   	  <p align="left"><span style="color:#0A6340; font-weight:bold; font-style:italic">Usuário:</span> <?php echo $row_lojista['nomeFantasia'];?></p>
                      
                      	  <?php if($totalRows_ofertas == 0){?>
                          
                          	<p align="left">Não há ofertas cadastradas para esse lojista</p>
                          
                          <?php }else{?>
                          <table class="table">
						  <?php do { ?>
                          
                          <tr>
                            
                            <td width="33%" rowspan="2"><img src="<?php echo BASEURL.'/'.IMGOFERTAS. $row_ofertas['img']; ?>" class="img-rounded" width="110" height="76"></td>
                            <td colspan="2"><h4><?php echo $row_ofertas['titulo']; ?></h4></td>
                          </tr>
                          <tr>
                            <td colspan="2">Valor R$: <?php echo $row_ofertas['valor']; ?></br> Quantidade: <?php echo $row_ofertas['quantidade']; ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="57%" align="right"><a href="ofertas-editar.php?oferta=<?php echo $row_ofertas['id']; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td width="10%" align="center"><a href="ofertas-excluir.php?oferta=<?php echo $row_ofertas['id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                          </tr>
                          <?php } while ($row_ofertas = mysql_fetch_assoc($ofertas));} ?>
                      </table>
  				</div>
                <div class="panel-footer">
                     <ul class="pagination">
                     	
                        <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, max(0, $pageNum_ofertas - 1), $queryString_ofertas); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a><?php echo ($startRow_ofertas + 1) ?> a <?php echo min($startRow_ofertas + $maxRows_ofertas, $totalRows_ofertas) ?> de <?php echo $totalRows_ofertas ?> </a></li>
                        <li><a href="<?php printf("%s?pageNum_ofertas=%d%s", $currentPage, min($totalPages_ofertas, $pageNum_ofertas + 1), $queryString_ofertas); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        
                     </ul>
                </div>
                
            </div>
              </div>
              
            <div class="col-md-8" style="padding-bottom:7px;" align="right">
            	<a href="solicitacao.php?id=<?php echo $row_lojista['id']; ?>" class="btn btn-default">Solicitações <?php if($totalRows_solicitacoes > 0){ echo '<span class="badge">'.$totalRows_solicitacoes.'</span>';}?></a>
            	<a href="ofertas.php?id=<?php echo $row_lojista['id']; ?>" class="btn btn-Oferapp">Ofertas</a>
              	<a href="tabloides.php?id=<?php echo $row_lojista['id']; ?>" class="btn btn-Oferapp">Tablóides</a>
                <a href="presentes.php?id=<?php echo $row_lojista['id']; ?>" class="btn btn-Oferapp">Presentes</a>
                
            </div>
              <div class="col-md-8">
               <?php
			   			if(isset($_GET['action'])){
							if($_GET['action'] == 'cadastrado'){
								echo '<div class="alert alert-success" role="alert">Oferta Cadastrada!</div>';
							}
							elseif($_GET['action'] == 'excluido'){
								echo '<div class="alert alert-success" role="alert">Oferta Excluida!</div>';
							}
							elseif($_GET['action'] == 'editado'){
								echo '<div class="alert alert-success" role="alert">Oferta Editada!</div>';
							}
							
						}
			   ?>
              	<div class="panel panel-default">
                    <div class="panel-heading" align="left">Cadastrar ofertas</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                       		<div class="form-group">
                            <label for="titulo da oferta" class="col-sm-4 control-label">Título da Oferta:</label>
                            <div class="col-sm-8">
                            <input type="text" name="titulo" value="" size="150" class="form-control" required placeholder="Digite o título da oferta">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="tipo-oferta" class="col-sm-4 control-label">Tipo da Oferta:</label>
                            <div class="col-sm-3">
                            <select name="tipo" class="form-control">
                              <option value="serviço" <?php if (!(strcmp("serviço", ""))) {echo "SELECTED";} ?>>Serviço</option>
                              <option value="Produto" <?php if (!(strcmp("Produto", ""))) {echo "SELECTED";} ?>>Produto</option>
                            </select>
                            
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="descricao-oferta" class="col-sm-12">Descrição da oferta:</label>
                          </div>
                          <div class="form-group">
                          	<div class="col-sm-12">
                            <textarea name="descricao" cols="50" rows="5" class="form-control" required placeholder="Digite a descrição da oferta"></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="quantidade" class="col-sm-4 control-label">Quantidade:</label>
                            <div class="col-sm-3">
                            <input type="number" name="quantidade" value="" min="1" max="50" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-sm-4 control-label">Valor R$:</label>
                            <div class="col-sm-2">
                            <input type="text" name="valor" value="" size="32" class="form-control" required placeholder="00.00">
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
                       
                        <input type="hidden" name="id_lojista" value="<?php echo $row_lojista['id']; ?>">
                        <input type="hidden" name="MM_insert" value="form1">
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
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>
<?php
mysql_free_result($lojista);

mysql_free_result($ofertas);
?>
