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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "presentes")) {
	
	$imagetype = explode('/', $_FILES['img']['type']);				   
	$imagetemp = $_FILES['img']['tmp_name'];
	$strKey    = substr(md5(uniqid(microtime())),0, 28);
	if($imagetype[1] =='jpeg'){
		$imagetype[1] = 'jpg';
	}
  $insertSQL = sprintf("INSERT INTO presentes (titulo, descricao, img, id_lojista, datatermino) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($strKey.'.'.$imagetype[1], "text"),
                       GetSQLValueString($_POST['idlojista'], "int"),
                       GetSQLValueString(date('d/m/Y', strtotime($_POST['data'])), "text"));
  
  		$imgperfil = IMGPRESENTES;
		$img = new W3_Image();
		$img->create($imagetemp, 218, 147, '../../'.$imgperfil.$strKey.'.thumb.'.$imagetype[1]);
		$img->create($imagetemp, 570, 450, '../../'.$imgperfil.$strKey.'.'.$imagetype[1]); 
  
  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($insertSQL, $dboferapp) or die(mysql_error());

  $insertGoTo = "presentes.php?action=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_presentes = "-1";
if (isset($_GET['id'])) {
  $colname_presentes = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_presentes = sprintf("SELECT * FROM presentes WHERE id_lojista = %s", GetSQLValueString($colname_presentes, "int"));
$presentes = mysql_query($query_presentes, $dboferapp) or die(mysql_error());
$row_presentes = mysql_fetch_assoc($presentes);
$totalRows_presentes = mysql_num_rows($presentes);

$maxRows_ganhapresente = 20;
$pageNum_ganhapresente = 0;
if (isset($_GET['pageNum_ganhapresente'])) {
  $pageNum_ganhapresente = $_GET['pageNum_ganhapresente'];
}
$startRow_ganhapresente = $pageNum_ganhapresente * $maxRows_ganhapresente;

$colname_ganhapresente = "-1";
if (isset($_GET['id'])) {
  $colname_ganhapresente = $_GET['id'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_ganhapresente = sprintf("SELECT g.id AS idg, g.cliks, g.datacadidatura, u.id AS iduser, u.nome, u.email, u.sexo, u.celular, u.datanascimento, u.img, p.id AS idpre, p.id_lojista FROM ganharpresente AS g INNER JOIN usuario AS u ON u.id = g.id_usuario INNER JOIN presentes AS p ON p.id = g.id_presente WHERE p.id_lojista = %s ORDER BY g.cliks DESC", GetSQLValueString($colname_ganhapresente, "int"));
$query_limit_ganhapresente = sprintf("%s LIMIT %d, %d", $query_ganhapresente, $startRow_ganhapresente, $maxRows_ganhapresente);
$ganhapresente = mysql_query($query_limit_ganhapresente, $dboferapp) or die(mysql_error());
$row_ganhapresente = mysql_fetch_assoc($ganhapresente);

if (isset($_GET['totalRows_ganhapresente'])) {
  $totalRows_ganhapresente = $_GET['totalRows_ganhapresente'];
} else {
  $all_ganhapresente = mysql_query($query_ganhapresente);
  $totalRows_ganhapresente = mysql_num_rows($all_ganhapresente);
}
$totalPages_ganhapresente = ceil($totalRows_ganhapresente/$maxRows_ganhapresente)-1;

$queryString_ganhapresente = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ganhapresente") == false && 
        stristr($param, "totalRows_ganhapresente") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ganhapresente = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ganhapresente = sprintf("&totalRows_ganhapresente=%d%s", $totalRows_ganhapresente, $queryString_ganhapresente);
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
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Administrar Presentes</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              <div class="col-md-4">
              	<div class="panel panel-default">
                	<div class="panel-heading" align="left">
                    	Presente Cadastrado
                    </div>
                    <div class="panel-body">
                        
                        	<?php if($totalRows_presentes == 0){?>
                        	
                            	<p align="left">não há nenhum presente cadastrado</p>
                           
                            <?php }else{?>
                            <table class="table">
                            <tr>
                                <td width="31%" rowspan="3"><img src="<?php echo BASEURL .'/'.IMGPRESENTES. $row_presentes['img']; ?>" class="img-rounded" width="120"></td>
                                <td colspan="2"><?php echo $row_presentes['titulo']; ?></td>
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
             <div class="col-md-8" style="padding-bottom:7px;" align="right">
            	
            	<a href="ofertas.php?id=<?php echo $colname_presentes; ?>" class="btn btn-Oferapp">Ofertas</a>
              	<a href="tabloides.php?id=<?php echo $colname_presentes; ?>" class="btn btn-Oferapp">Tablóides</a>
                <a href="presentes.php?id=<?php echo $colname_presentes; ?>" class="btn btn-Oferapp">Presentes</a>
                
            </div>
              <!-- ./col -->
            <div class="col-md-8">
				<?php if($totalRows_presentes == 0){?>
                <div class="panel panel-default">
                	<div class="panel-heading" align="left"> Cadastre um Presente</div>
                    <div class="panel-body">
                   	  <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="presentes" class="form-horizontal">
                        	<div class="form-group">
                            	<label class="col-sm-4 control-label">Título do Presnte</label>
                                <div class="col-sm-8">
                                	<input type="text" name="nome" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-12">Descrição</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                	<textarea class="form-control" name="descricao" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Data de Vencimento:</label>
                                <div class="col-sm-4">
                                	<input type="date" name="data" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label">Imagem:</label>
                                <div class="col-sm-8" align="left">
                                	<input type="file" name="img" id="file-original" required>
                                <button type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button>
                                </div>
                            </div>
                            <div class="form-group">
                            	<button type="submit" name="submit" class="btn btn-primary">Salver</button>
                            </div>
                            <input type="hidden" name="idlojista" value="<?php echo $colname_presentes; ?>">
                            <input type="hidden" name="MM_insert" value="presentes">
                        </form>
                  </div>
                </div>
                <?php 
				}
				elseif($totalRows_presentes == 1){
				?>
                 <?php
			   			if(isset($_GET['action'])){
							if($_GET['action'] == 'cadastrado'){
								echo '<div class="alert alert-success" role="alert">Presente Cadastrado!</div>';
							}
							elseif($_GET['action'] == 'excluido'){
								echo '<div class="alert alert-success" role="alert">Concorente Excluido!</div>';
							}
							elseif($_GET['action'] == 'editado'){
								echo '<div class="alert alert-success" role="alert">Presente Editado!</div>';
							}
							
						}
			   ?>
                <div class="panel panel-default">
                	<div class="panel-heading" align="left">Usuarios concorrendo ao Presente</div>
                    <div class="panel-body">
                    <table class="table">
                      <tr>
                        <td align="center">Usuarios</td>
                          <td width="9%" align="center">Ação</td>
                      </tr>
                      <?php if($totalRows_ganhapresente ==0){?>
                      <tr>
                      <td colspan="2">Nenhum usuario comcorrendo a esse Presente</td>
                      </tr>
                      <?php }else{ do { ?>
                      <tr>
                        <td><table border="0" class="table">
                          <tr>
                            <td width="35%" rowspan="2"><img src="<?php if(empty($row_ganhapresente['img'])){ echo IMGSISTEMA;}else{echo  BASEURL.'/' . IMGPERFIL. $row_ganhapresente['img'];} ?>" alt="usuario" width="120" class="img-rounded">
                              <?php  ?></td>
                            <td colspan="2"><?php echo $row_ganhapresente['nome']; ?></td>
                          </tr>
                          <tr>
                            <td width="28%">Sexo: <?php echo $row_ganhapresente['sexo']; ?></td>
                            <td width="37%"><span class="glyphicon glyphicon-thumbs-up" title="cliks"> </span><?php echo $row_ganhapresente['cliks']; ?></td>
                          </tr>
                          <tr>
                            <td><span class="glyphicon glyphicon-envelope" title="Email"></span> <?php echo $row_ganhapresente['email']; ?></td>
                            <td><span class="glyphicon glyphicon-phone" title="Celular"></span> <?php echo $row_ganhapresente['celular']; ?></td>
                            <td> Nascimento:<?php echo $row_ganhapresente['datanascimento']; ?></td>
                          </tr>
                        </table></td>
                        <td align="center"><a href="ganharpresente-excluir.php?id=<?php echo $row_ganhapresente['id_lojista']; ?>&ganharpresente=<?php echo $row_ganhapresente['idg']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" title="Exluir Concorrente"></span></a></td>
                      </tr>
                        <?php } while ($row_ganhapresente = mysql_fetch_assoc($ganhapresente));} ?>
                      <tr>
                        <td colspan="2">
                        
                        </td>
                      </tr>
                    </table>

                    </div>
                    <div class="panel-footer">
                     <ul class="pagination">
                     	<li><a href="<?php printf("%s?pageNum_ganhapresente=%d%s", $currentPage, 0, $queryString_ganhapresente); ?>"><span class="glyphicon glyphicon-backward"></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_ganhapresente=%d%s", $currentPage, max(0, $pageNum_ganhapresente - 1), $queryString_ganhapresente); ?>"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a> Registros <?php echo ($startRow_ganhapresente + 1) ?> a <?php echo min($startRow_ganhapresente + $maxRows_ganhapresente, $totalRows_ganhapresente) ?> de <?php echo $totalRows_ganhapresente ?> </a></li>
                        <li><a href="<?php printf("%s?pageNum_ganhapresente=%d%s", $currentPage, min($totalPages_ganhapresente, $pageNum_ganhapresente + 1), $queryString_ganhapresente); ?>"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="<?php printf("%s?pageNum_ganhapresente=%d%s", $currentPage, $totalPages_ganhapresente, $queryString_ganhapresente); ?>"><span class="glyphicon glyphicon-forward" ></span></a></li>
                     </ul>
                </div>
                </div>
                <?php }?>
                
                
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
mysql_free_result($presentes);

mysql_free_result($ganhapresente);
?>
