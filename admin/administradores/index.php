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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "admin")) {
  $insertSQL = sprintf("INSERT INTO `admin` (nome, email, login, senha, telefone, celular, cidade, `level`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['Telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['cidade'], "int"),
                       GetSQLValueString($_POST['level'], "text"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($insertSQL, $dboferapp) or die(mysql_error());

  $insertGoTo = "index.php?action=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_administradores = 10;
$pageNum_administradores = 0;
if (isset($_GET['pageNum_administradores'])) {
  $pageNum_administradores = $_GET['pageNum_administradores'];
}
$startRow_administradores = $pageNum_administradores * $maxRows_administradores;

mysql_select_db($database_dboferapp, $dboferapp);
$query_administradores = "SELECT * FROM `admin` WHERE id > 1";
$query_limit_administradores = sprintf("%s LIMIT %d, %d", $query_administradores, $startRow_administradores, $maxRows_administradores);
$administradores = mysql_query($query_limit_administradores, $dboferapp) or die(mysql_error());
$row_administradores = mysql_fetch_assoc($administradores);

if (isset($_GET['totalRows_administradores'])) {
  $totalRows_administradores = $_GET['totalRows_administradores'];
} else {
  $all_administradores = mysql_query($query_administradores);
  $totalRows_administradores = mysql_num_rows($all_administradores);
}
$totalPages_administradores = ceil($totalRows_administradores/$maxRows_administradores)-1;

mysql_select_db($database_dboferapp, $dboferapp);
$query_cidade = "SELECT * FROM cidade ORDER BY nome ASC";
$cidade = mysql_query($query_cidade, $dboferapp) or die(mysql_error());
$row_cidade = mysql_fetch_assoc($cidade);
$totalRows_cidade = mysql_num_rows($cidade);

$queryString_administradores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_administradores") == false && 
        stristr($param, "totalRows_administradores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_administradores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_administradores = sprintf("&totalRows_administradores=%d%s", $totalRows_administradores, $queryString_administradores);

if(isset($_GET['desativar']) && $_GET['desativar']!= ''){
	$updateSQL = sprintf("UPDATE admin SET  statos=%s WHERE id=%s",
                       GetSQLValueString('off', "text"),
					   GetSQLValueString($_GET['desativar'], "int")
					   );
	mysql_select_db($database_dboferapp, $dboferapp);
  	$Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());
	
	header('Location: /admin/administradores/');
}
if(isset($_GET['ativar']) && $_GET['ativar']!= ''){
	$updateSQL = sprintf("UPDATE admin SET  statos=%s WHERE id=%s",
                       GetSQLValueString('on', "text"),
					   GetSQLValueString($_GET['ativar'], "int")
					   );
	mysql_select_db($database_dboferapp, $dboferapp);
  	$Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());
	
	header('Location: /admin/administradores/');
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
            <?php ?>
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span>Administração</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <!-- ./col -->
              <div class="col-md-4">
              	<div class="panel panel-default">
                	<div class="panel-heading" align="left">Administradores</div>
                    
                  <table class="table">
                        <?php if($totalRows_administradores == 0){ ?>
                    <tr>
                          <td colspan="3" align="left">Nunhum administrador cadastrado</td>
                        </tr>
					    <?php }else{ ?>
                          <?php do { ?>
                        <tr>
                        	  <td width="8%" align="left"><?php if($row_administradores['statos'] == 'on'){ echo '<a href="?desativar='.$row_administradores['id'].'" class="btn btn-danger btn-xs" title="Desativar conta"><span class="glyphicon glyphicon-eye-close"></span></a>'; }else{ echo '<a href="?ativar='.$row_administradores['id'].'" class="btn btn-success btn-xs" title="Ativar conta"><span class="glyphicon glyphicon-eye-open"></span></a>';} ?></td>
                              <td align="left"><?php echo $row_administradores['nome']; ?></td>
                              <td width="8%"><a href="administrador-editar.php?id=<?php echo $row_administradores['id']; ?>" class="editar" title="Editar lojista"><span class="glyphicon glyphicon-pencil"></span></a></td>
                              <td width="8%"><a href="administrador-excluir.php?id=<?php echo $row_administradores['id']; ?>" title="Excluir lojista" class="excluir"><span class="glyphicon glyphicon-remove"></span></a></td>
                            </tr>
                            <?php } while ($row_administradores = mysql_fetch_assoc($administradores)); ?>
							<?php } ?>
                      </table>
                      <div class="panel-footer">
                      	<ul class="pagination">
                       
                        <li><a href="<?php printf("%s?pageNum_administradores=%d%s", $currentPage, max(0, $pageNum_administradores - 1), $queryString_administradores); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a><?php echo ($startRow_administradores + 1) ?> a <?php echo min($startRow_administradores + $maxRows_administradores, $totalRows_administradores) ?> de <?php echo $totalRows_administradores ?> </a></li>
                        <li><a href="<?php printf("%s?pageNum_administradores=%d%s", $currentPage, min($totalPages_administradores, $pageNum_administradores + 1), $queryString_administradores); ?>"><span class="glyphicon glyphicon-step-forward" ></span></a></li>
                        
                        </ul>
                      </div>
                </div>
              </div>
                          <?php
                          if(isset($_GET['action'])){
                              if($_GET['action'] == 'cadastrado'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Administrador Cadastrado!</div> </div>';
                              }
                              elseif($_GET['action'] == 'excluido'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Administrador Excluido!</div> </div>';
                              }
                              elseif($_GET['action'] == 'editado'){
                                  echo '<div class="col-md-8" style=" text-align:center; padding:10px;"><div class="alert alert-success" role="alert">Administrador Editado!</div></div>';
                              }
                              
                          }
                          ?>
                          
             
              <div class="col-md-8">
              <div class="panel panel-default">
              	<div class="panel-heading" align="left">Cadastro de Administradores</div>
                <div class="panel-body">
                <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal" name="admin">
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Nome:</label>
                      <div class="col-sm-9">
                      <input type="text" name="nome" class="form-control" required>
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Email</label>
                      <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Login</label>
                      <div class="col-sm-5">
                      <input type="text" name="login" class="form-control" required size="35">
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Senha</label>
                      <div class="col-sm-4">
                      <input type="password" name="senha" class="form-control" required>
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Telefone:</label>
                      <div class="col-sm-4">
                      <input type="tel" name="Telefone" class="form-control" required pattern="\([0-9]{2}\)[0-9]{4}-[0-9]{4}$" placeholder="ex(11)1111-1111">
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Celular:</label>
                      <div class="col-sm-4">
                        <input type="tel" name="celular" class="form-control" required pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" placeholder="ex(11)1111-1111">
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Cidade:</label>
                      <div class="col-sm-3">
                      	
                   	    <select class="form-control" name="cidade" >
                        <?php do { ?>
                      	    <option value="<?php echo $row_cidade['id']; ?>"><?php echo $row_cidade['nome']; ?></option>
                             <?php } while ($row_cidade = mysql_fetch_assoc($cidade)); ?>
               	        </select>
                      	 
                      </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label">Level:</label>
                      <div class="col-sm-3">
                      <select class="form-control" name="level">
                      	<option value="admin">Admin</option>
                      	<option value="superadmin">Super Adimin</option>
                      </select>
                      </div>
                      </div>
                      <div class="form-group">
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      
                      </div>
                      <input type="hidden" name="MM_insert" value="admin">
                  </form>
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
mysql_free_result($administradores);

mysql_free_result($cidade);
?>
