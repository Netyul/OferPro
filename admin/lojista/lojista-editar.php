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
/* -- tabela que exibe lista de lojistas cadastrados --*/
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_RsLojistas = 15;
$pageNum_RsLojistas = 0;
if (isset($_GET['pageNum_RsLojistas'])) {
  $pageNum_RsLojistas = $_GET['pageNum_RsLojistas'];
}
$startRow_RsLojistas = $pageNum_RsLojistas * $maxRows_RsLojistas;

mysql_select_db($database_dboferapp, $dboferapp);
$query_RsLojistas = "SELECT * FROM lojista ORDER BY id DESC";
$query_limit_RsLojistas = sprintf("%s LIMIT %d, %d", $query_RsLojistas, $startRow_RsLojistas, $maxRows_RsLojistas);
$RsLojistas = mysql_query($query_limit_RsLojistas, $dboferapp) or die(mysql_error());
$row_RsLojistas = mysql_fetch_assoc($RsLojistas);

if (isset($_GET['totalRows_RsLojistas'])) {
  $totalRows_RsLojistas = $_GET['totalRows_RsLojistas'];
} else {
  $all_RsLojistas = mysql_query($query_RsLojistas);
  $totalRows_RsLojistas = mysql_num_rows($all_RsLojistas);
}
$totalPages_RsLojistas = ceil($totalRows_RsLojistas/$maxRows_RsLojistas)-1;


$queryString_RsLojistas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsLojistas") == false && 
        stristr($param, "totalRows_RsLojistas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsLojistas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsLojistas = sprintf("&totalRows_RsLojistas=%d%s", $totalRows_RsLojistas, $queryString_RsLojistas);
/*-- fim --*/

/*-- consultas --*/
$colname_EditeLojista = "-1";
if (isset($_GET['id'])) {
  $colname_EditeLojista = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_EditeLojista = sprintf("SELECT * FROM lojista WHERE id = %s", GetSQLValueString($colname_EditeLojista, "int"));
$EditeLojista = mysql_query($query_EditeLojista, $dboferapp) or die(mysql_error());
$row_EditeLojista = mysql_fetch_assoc($EditeLojista);
$totalRows_EditeLojista = mysql_num_rows($EditeLojista);

mysql_select_db($database_dboferapp, $dboferapp);
$query_editeLojistaCidade = "SELECT * FROM cidade ORDER BY nome ASC";
$editeLojistaCidade = mysql_query($query_editeLojistaCidade, $dboferapp) or die(mysql_error());
$row_editeLojistaCidade = mysql_fetch_assoc($editeLojistaCidade);
$totalRows_editeLojistaCidade = mysql_num_rows($editeLojistaCidade);

mysql_select_db($database_dboferapp, $dboferapp);
$query_AdminLojista = "SELECT * FROM `admin` WHERE id > 1 ORDER BY nome ASC";
$AdminLojista = mysql_query($query_AdminLojista, $dboferapp) or die(mysql_error());
$row_AdminLojista = mysql_fetch_assoc($AdminLojista);
$totalRows_AdminLojista = mysql_num_rows($AdminLojista);

$maxRows_adminLojista = 10;
$pageNum_adminLojista = 0;
if (isset($_GET['pageNum_adminLojista'])) {
  $pageNum_adminLojista = $_GET['pageNum_adminLojista'];
}
$startRow_adminLojista = $pageNum_adminLojista * $maxRows_adminLojista;

$colname_adminLojista = "-1";
if (isset($_SESSION['admin_id'])) {
  $colname_adminLojista = $_SESSION['admin_id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_adminLojista = sprintf("SELECT * FROM lojista WHERE id_admin = %s", GetSQLValueString($colname_adminLojista, "int"));
$query_limit_adminLojista = sprintf("%s LIMIT %d, %d", $query_adminLojista, $startRow_adminLojista, $maxRows_adminLojista);
$adminLojista = mysql_query($query_limit_adminLojista, $dboferapp) or die(mysql_error());
$row_adminLojista = mysql_fetch_assoc($adminLojista);

if (isset($_GET['totalRows_adminLojista'])) {
  $totalRows_adminLojista = $_GET['totalRows_adminLojista'];
} else {
  $all_adminLojista = mysql_query($query_adminLojista);
  $totalRows_adminLojista = mysql_num_rows($all_adminLojista);
}
$totalPages_adminLojista = ceil($totalRows_adminLojista/$maxRows_adminLojista)-1;

$queryString_adminLojista = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_adminLojista") == false && 
        stristr($param, "totalRows_adminLojista") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_adminLojista = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_adminLojista = sprintf("&totalRows_adminLojista=%d%s", $totalRows_adminLojista, $queryString_adminLojista);

/*-- fim consulta --*/

//enditar no banco de dados
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
		$imgperfil = IMGPRESENTES;
		$editeImg = explode('.',$row_EditeLojista['img']);
		$img = new W3_Image;
		$img->create($imagemTemp, 218, 147,'../../'.$imgperfil. $editeImg[0].'.thumb.'.$imagetype[1]);
		$img->create($imagemTemp, 570, 450,'../../'.$imgperfil. $editeImg[0].'.'. $imagetype[1]);
	}
  $updateSQL = sprintf("UPDATE lojista SET nomeEmpresa=%s, nomeResponsavel=%s, nomeFantasia=%s, email=%s, senha=%s, endereco=%s, bairro=%s, cidade=%s, cep=%s, tipoLojista=%s, cpf=%s, cnpj=%s, telefone=%s, celular=%s, img=%s, id_admin=%s WHERE id=%s",
                       GetSQLValueString($_POST['nomeEmpresa'], "text"),
                       GetSQLValueString($_POST['nomeResponsavel'], "text"),
                       GetSQLValueString($_POST['nomeFantasia'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cidade'], "int"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['tipoLojista'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['cnpj'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
					   GetSQLValueString($editeImg[0].'.'. $imagetype[1], "int"),
                       GetSQLValueString($_POST['id_admin'], "int"),
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
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administração</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <div class="row">
            	<div class="col-md-4">
                	<div class="panel panel-default">
                        <div class="panel-heading" align="left">Lista de clientes lojistas</div>
                       <?php if($level == 'admin'){ ?>
                        <div class="panel-body">
                            
                                  <?php if ($totalRows_adminLojista == 0) { // Show if recordset empty ?>
                                  
                                  <p align="left">Não há nenhum lojista cadastardo</p>
                                  
                                  <?php } // Show if recordset empty ?>
								  <table class="table">
                              		<tbody>
                                  <?php do { ?>
                                    <tr>
                                      <td width="16%"><?php if($row_adminLojista['statos'] == 'on'){ echo '<a href="index.php?desativar='.$row_adminLojista['id'].'" class="btn btn-danger btn-xs" title="Desativar conta"><span class="glyphicon glyphicon-eye-close"></span></a>'; }else{ echo '<a href="index.php?ativar='.$row_adminLojista['id'].'" class="btn btn-success btn-xs" title="Ativar conta"><span class="glyphicon glyphicon-eye-open"></span></a>';} ?></td>
                                      <td width="60%"><a href="ofertas.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_adminLojista['nomeEmpresa']; ?></a></td>
                                      <td width="8%"><a href="lojista-editar.php?id=<?php echo $row_adminLojista['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      <td width="8%"><a href="lojista-excluir.php?id=<?php echo $row_adminLojista['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_adminLojista = mysql_fetch_assoc($adminLojista)); ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, 0, $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, max(0, $pageNum_adminLojista - 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_adminLojista + 1) ?> a <?php echo min($startRow_adminLojista + $maxRows_adminLojista, $totalRows_adminLojista) ?> de <?php echo $totalRows_adminLojista ?> </a> </li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, min($totalPages_adminLojista, $pageNum_adminLojista + 1), $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                <li><a href="<?php printf("%s?pageNum_adminLojista=%d%s", $currentPage, $totalPages_adminLojista, $queryString_adminLojista); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                            </ul>
                        </div>
                        <?php }else{ ?>
                        <div class="panel-body">
                                  <?php if ($totalRows_RsLojistas == 0) { // Show if recordset empty ?>
                                  <tr>
                                  <p align="left">Não há nenhum lojista cadastardo</p>
                                  </tr>
                                  <?php } // Show if recordset empty ?>
                                  <table class="table">
                                	<tbody>
								  <?php do { ?>
                                    <tr>
                                      <td width="16%"><?php if($row_adminLojista['statos'] == 'on'){ echo '<a href="index.php?desativar='.$row_adminLojista['id'].'" class="btn btn-danger btn-xs" title="Desativar conta"><span class="glyphicon glyphicon-eye-close"></span></a>'; }else{ echo '<a href="index.php?ativar='.$row_adminLojista['id'].'" class="btn btn-dsuccess btn-xs" title="Ativar conta"><span class="glyphicon glyphicon-eye-open"></span></a>';} ?></td>
                                      <td width="60%" align="left"><a href="ofertas.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><?php echo $row_RsLojistas['nomeEmpresa']; ?></a></td>
                                      <td width="8%"><a href="lojista-editar.php?id=<?php echo $row_RsLojistas['id'];?>" title="Editar Lojista" class="editar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                      
                                      <td width="8%"><a href="lojista-excluir.php?id=<?php echo $row_RsLojistas['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                    <?php } while ($row_RsLojistas = mysql_fetch_assoc($RsLojistas)); ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, max(0, $pageNum_RsLojistas - 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                                <li> <a><?php echo ($startRow_RsLojistas + 1) ?> a <?php echo min($startRow_RsLojistas + $maxRows_RsLojistas, $totalRows_RsLojistas) ?> de <?php echo $totalRows_RsLojistas ?></a> </li>
                                <li><a href="<?php printf("%s?pageNum_RsLojistas=%d%s", $currentPage, min($totalPages_RsLojistas, $pageNum_RsLojistas + 1), $queryString_RsLojistas); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                                
                            </ul>
                        </div> 
                        <?php } ?>                  
                        </div>                        
                   
       			</div>
                <div class="col-md-8">
                    	<div class="panel panel-default">
                        	<div class="panel-heading" align="left">Editar Lojista</div>
                            <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                         <div class="form-group">
                            <label for="nome-da-empresa" class="col-sm-4 control-label">Empresa:</label>
                            <div class="col-sm-8">
                            <input type="text" name="nomeEmpresa" value="<?php echo htmlentities($row_EditeLojista['nomeEmpresa'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" required>
                          	</div>
                          </div>
                          <div class="form-group">
                            <label for="nome-reponsavel" class="col-sm-4 control-label">Responsavel:</label>
                            <div class="col-sm-8">
                            <input type="text" name="nomeResponsavel" value="<?php echo htmlentities($row_EditeLojista['nomeResponsavel'], ENT_COMPAT, 'utf-8'); ?>" class="form-control" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label for="nome-fabtasia" class="col-sm-4 control-label">Nome Fantasia:</label>
                            <div class="col-sm-8">
                            <input type="text" name="nomeFantasia" value="<?php echo htmlentities($row_EditeLojista['nomeFantasia'], ENT_COMPAT, 'utf-8'); ?>" size="150" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-8">
                            <input type="text" name="email" value="<?php echo htmlentities($row_EditeLojista['email'], ENT_COMPAT, 'utf-8'); ?>" size="100" class="form-control" required>
                            
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="senha" class="col-sm-4 control-label">Senha:</label>
                            <div class="col-sm-4">
                            <input type="text" name="senha" value="<?php echo htmlentities($row_EditeLojista['senha'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="endereco" class="col-sm-3 control-label">Endereco:</label>
                            <div class="col-sm-9">
                            <input type="text" name="endereco" value="<?php echo htmlentities($row_EditeLojista['endereco'], ENT_COMPAT, 'utf-8'); ?>" size="200" class="form-control"required >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="bairro" class="col-sm-3 control-label">Bairro:</label>
                            <div class="col-sm-6">
                            <input type="text" name="bairro" value="<?php echo htmlentities($row_EditeLojista['bairro'], ENT_COMPAT, 'utf-8'); ?>" size="100" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="cidade" class="col-sm-3 control-label">Cidade:</label>
                            <div class="col-sm-4">
                            <select name="cidade" class="form-control">
                              <?php 
								do {  
								?>
                              <option value="<?php echo $row_editeLojistaCidade['id']?>" <?php if (!(strcmp($row_editeLojistaCidade['id'], htmlentities($row_EditeLojista['cidade'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_editeLojistaCidade['nome']?></option>
                              <?php
								} while ($row_editeLojistaCidade = mysql_fetch_assoc($editeLojistaCidade));
								?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="cep" class="col-sm-3 control-label">CEP:</label>
                            <div class="col-sm-4">
                            <input type="text" name="cep" value="<?php echo htmlentities($row_EditeLojista['cep'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="tipo-lojista" class="col-sm-3 control-label">Tipo Lojista:</label>
                            <div class="col-sm-4">
                            <select name="tipoLojista" class="form-control">
                              <option value="fisica" <?php if (!(strcmp("fisica", htmlentities($row_EditeLojista['tipoLojista'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Fisica</option>
                              <option value="Juridica" <?php if (!(strcmp("Juridica", htmlentities($row_EditeLojista['tipoLojista'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Juridica</option>
                            </select>
                            </div>
                            </div>
                          <div class="form-group">
                            <label for="CPF" class="col-sm-3 control-label">CPF:</label>
                            <div class="col-sm-5">
                            <input type="text" name="cpf" value="<?php echo htmlentities($row_EditeLojista['cpf'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="CNPJ" class="col-sm-3 control-label">CNPJ:</label>
                            <div class="col-sm-5">
                            <input type="text" name="cnpj" value="<?php echo htmlentities($row_EditeLojista['cnpj'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="tel" class="col-sm-3 control-label">Telefone:</label>
                            <div class="col-sm-4">
                            <input type="text" name="telefone" value="<?php echo htmlentities($row_EditeLojista['telefone'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="cel" class="col-sm-3 control-label">Celular:</label>
                            <div class="col-sm-4">
                            <input type="text" name="celular" value="<?php echo htmlentities($row_EditeLojista['celular'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="image" class="col-sm-3 control-label">Imagem:</label>
                            <div class="col-sm-9" align="left">
                            <input type="file" name="img" id="file-original" value="<?php echo htmlentities($row_EditeLojista['img'], ENT_COMPAT, 'utf-8'); ?>" size="35" required>
                                <button type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="admin" class="col-sm-4 control-label">admin deste Lojista:</label>
                            <div class="col-sm-4">
                            <select name="id_admin" class="form-control">
                              <?php 
								do {  
								?>
                              <option value="<?php echo $row_AdminLojista['id']?>" <?php if (!(strcmp($row_AdminLojista['id'], htmlentities($row_EditeLojista['id_admin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_AdminLojista['nome']?></option>
                              <?php
								} while ($row_AdminLojista = mysql_fetch_assoc($AdminLojista));
								?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            
                            <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Editar</button> 
                            </div>
                          </div>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id" value="<?php echo $row_EditeLojista['id']; ?>">
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
<!-- InstanceEndEditable -->
<!-- InstanceEnd --></html>
<?php
mysql_free_result($EditeLojista);

mysql_free_result($editeLojistaCidade);

mysql_free_result($AdminLojista);
?>
