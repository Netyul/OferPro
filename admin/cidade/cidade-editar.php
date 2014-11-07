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
  $insertSQL = sprintf("INSERT INTO cidade (nome, id_uf) VALUES (%s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['estado'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($insertSQL, $dboferapp) or die(mysql_error());

  $insertGoTo = "index.php?action=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cidade SET nome=%s, id_uf=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['id_uf'], "int"),
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Cidade = 10;
$pageNum_Cidade = 0;
if (isset($_GET['pageNum_Cidade'])) {
  $pageNum_Cidade = $_GET['pageNum_Cidade'];
}
$startRow_Cidade = $pageNum_Cidade * $maxRows_Cidade;

mysql_select_db($database_dboferapp, $dboferapp);
$query_Cidade = "SELECT c.id, c.nome, e.sigla FROM cidade AS c INNER JOIN estado AS e ON e.id = c.id_uf ORDER BY nome ASC";
$query_limit_Cidade = sprintf("%s LIMIT %d, %d", $query_Cidade, $startRow_Cidade, $maxRows_Cidade);
$Cidade = mysql_query($query_limit_Cidade, $dboferapp) or die(mysql_error());
$row_Cidade = mysql_fetch_assoc($Cidade);

if (isset($_GET['totalRows_Cidade'])) {
  $totalRows_Cidade = $_GET['totalRows_Cidade'];
} else {
  $all_Cidade = mysql_query($query_Cidade);
  $totalRows_Cidade = mysql_num_rows($all_Cidade);
}
$totalPages_Cidade = ceil($totalRows_Cidade/$maxRows_Cidade)-1;

mysql_select_db($database_dboferapp, $dboferapp);
$query_estado = "SELECT * FROM estado ORDER BY nome ASC";
$estado = mysql_query($query_estado, $dboferapp) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

$colname_EditarCidade = "-1";
if (isset($_GET['id'])) {
  $colname_EditarCidade = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_EditarCidade = sprintf("SELECT * FROM cidade WHERE id = %s", GetSQLValueString($colname_EditarCidade, "int"));
$EditarCidade = mysql_query($query_EditarCidade, $dboferapp) or die(mysql_error());
$row_EditarCidade = mysql_fetch_assoc($EditarCidade);
$totalRows_EditarCidade = mysql_num_rows($EditarCidade);

$queryString_Cidade = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Cidade") == false && 
        stristr($param, "totalRows_Cidade") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Cidade = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Cidade = sprintf("&totalRows_Cidade=%d%s", $totalRows_Cidade, $queryString_Cidade);
@mysql_query($dboferapp, "SET NAMES 'utf8'");
@mysql_query($dboferapp, 'SET character_set_connection=utf8');
@mysql_query($dboferapp, 'SET charecter_set_client=utf8');
@mysql_query($dboferapp, 'SET charecter_set_results=utf8');
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
            <h2><span class="glyphicon glyphicon-bookmark icon-destaque"></span> Editar Cidade</h2>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <div class="col-md-4">
       			<div class="panel panel-default">
                	<div class="panel-heading" align="left">Cidades</div>
                    
                  <table class="table">
                        <?php if($totalRows_Cidade == 0){ ?>
                    <tr>
                          <td colspan="3" align="left">Nunhuma Cidade cadastrado</td>
                    </tr>
					    <?php }else{ ?>
                          <?php do { ?>
                        <tr>
                              <td align="left"><?php echo $row_Cidade['nome']; ?> - <?php echo $row_Cidade['sigla']; ?></td>
                              <td width="8%"><a href="cidade-editar.php?id=<?php echo $row_Cidade['id']; ?>" class="editar" title="Editar "><span class="glyphicon glyphicon-pencil"></span></a></td>
                              <td width="8%"><a href="cidade-excluir.php?id=<?php echo $row_Cidade['id']; ?>" title="Excluir " class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                          </tr>
                            <?php } while ($row_Cidade = mysql_fetch_assoc($Cidade)); ?>
							<?php } ?>
                </table>
                      <div class="panel-footer">
                      	<ul class="pagination">
                        <li><a href="<?php printf("%s?pageNum_Cidade=%d%s", $currentPage, 0, $queryString_Cidade); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_Cidade=%d%s", $currentPage, max(0, $pageNum_Cidade - 1), $queryString_Cidade); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a><?php echo ($startRow_Cidade + 1) ?> a <?php echo min($startRow_Cidade + $maxRows_Cidade, $totalRows_Cidade) ?> de <?php echo $totalRows_Cidade ?> </a></li>
                        <li><a href="<?php printf("%s?pageNum_Cidade=%d%s", $currentPage, min($totalPages_Cidade, $pageNum_Cidade + 1), $queryString_Cidade); ?>"><span class="glyphicon glyphicon-step-forward" ></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_Cidade=%d%s", $currentPage, $totalPages_Cidade, $queryString_Cidade); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                        </ul>
                      </div>
            </div>
              </div>
              
                          <?php
                          if(isset($_GET['action'])){
                              if($_GET['action'] == 'cadastrado'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Cidade Cadastrada!</div></div>';
                              }
                              elseif($_GET['action'] == 'excluido'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Cidade Excluida!</div></div>';
                              }
                              elseif($_GET['action'] == 'editado'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Cidade Editada!</div> </div>';
                              }
                              
                          }
                          ?>
                          
              
              <div class="col-md-8">
              	 <div class="panel panel-default">
              	<div class="panel-heading" align="left">Cadastro de Administradores</div>
                <div class="panel-body">
                  <form method="post" name="form1" action="<?php echo $editFormAction; ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="nome" value="<?php echo htmlentities($row_EditarCidade['nome'], ENT_COMPAT, 'utf-8'); ?>"  required >
                      </div>
                      </div>
                     <div class="form-group">
                     <label class="col-sm-3 control-label">Estado:</label>
                     <div class="col-sm-4">
                      <select name="id_uf" class="form-control">
                          <?php 
							do {  
							?>
                          <option value="<?php echo $row_estado['id']?>" <?php if (!(strcmp($row_estado['id'], htmlentities($row_EditarCidade['id_uf'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_estado['nome']?> - <?php echo $row_estado['sigla']?></option>
                          <?php
							} while ($row_estado = mysql_fetch_assoc($estado));
							?>
                        </select>
                        </div>
                        </div>
                      
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                     
                    <input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="id" value="<?php echo $row_EditarCidade['id']; ?>">
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
mysql_free_result($Cidade);



mysql_free_result($estado);

mysql_free_result($EditarCidade);
?>
