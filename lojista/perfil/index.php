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

$colname_lojista = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_lojista = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_lojista = sprintf("SELECT l.id, l.nomeEmpresa, l.nomeResponsavel, l.nomeFantasia, l.email, l.endereco, l.bairro, c.nome AS nomeCidade, e.nome AS estado, e.sigla, l.cep, l.tipoLojista, l.telefone, l.celular, l.img FROM lojista AS l INNER JOIN cidade AS c ON c.id = l.cidade INNER JOIN estado AS e ON e.id = c.id_uf WHERE l.id = %s", GetSQLValueString($colname_lojista, "int"));
$lojista = mysql_query($query_lojista, $dboferapp) or die(mysql_error());
$row_lojista = mysql_fetch_assoc($lojista);
$totalRows_lojista = mysql_num_rows($lojista);
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
<title>OferApp Perfil Lojista</title>
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
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Perfil</h2>
            <?php ?>
            <!-- InstanceEndEditable -->
            </div>
            <div class="row">
            <!-- InstanceBeginEditable name="conteudo" -->
              
              <div class="col-md-3">
              <table class="table">
                  <tr>
                    <td colspan="3" align="center"><a href=""><img src="<?php echo BASEURL.'/'.IMGPERFIL. $row_lojista['img']; ?>" width="218" height="147" class="img-rounded"></a></td>
                  </tr>
                  <tr>
                    <td colspan="3"><a href="editar-perfil.php" class="btn btn-primary"> Editar Perfil <span class="glyphicon glyphicon-user"></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>

              </div>
              <div class="col-md-9">
              
             
                  <dl class="dl-horizontal">
                      <dt>Nome Razão Social:</dt>
                      <dd><?php echo $row_lojista['nomeEmpresa']; ?></dd>
                      <dt>Nome Fantasia:</dt>
                      <dd><?php echo $row_lojista['nomeFantasia']; ?></dd>
                      <dt>Nome Responsavel:</dt>
                      <dd><?php echo $row_lojista['nomeResponsavel']; ?></dd>
                      <dt>Email:</dt>
                      <dd><?php echo $row_lojista['email']; ?></dd>
                      <dt>Endereço:</dt>
                      <dd><?php echo $row_lojista['endereco']; ?>.</dd>
                      <dt>Bairro:</dt>
                      <dd><?php echo $row_lojista['bairro']; ?></dd>
                      <dt>cidade:</dt>
                      <dd><?php echo $row_lojista['nomeCidade']; ?> - <?php echo $row_lojista['sigla']; ?></dd>
                      <dt>CEP:</dt>
                      <dd><?php echo $row_lojista['cep']; ?></dd>
                      <dt>Tipo Lojista:</dt>
                      <dd><?php echo $row_lojista['tipoLojista']; ?></dd>
                      <dt>Telefone:</dt>
                      <dd><?php echo $row_lojista['telefone']; ?></dd>
                      <dt>Celular:</dt>
                      <dd><?php echo $row_lojista['celular']; ?></dd>

                  </dl>
                  
                  
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
mysql_free_result($lojista);
?>
