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
  $updateSQL = sprintf("UPDATE lojista SET nomeEmpresa=%s, nomeFantasia=%s, nomeResponsavel=%s, email=%s, senha=%s, endereco=%s, bairro=%s, cidade=%s, cep=%s, cpf=%s, cnpj=%s, tipoLojista=%s, telefone=%s, celular=%s WHERE id=%s",
                       GetSQLValueString($_POST['nomeEmpresa'], "text"),
                       GetSQLValueString($_POST['nomeFantasia'], "text"),
                       GetSQLValueString($_POST['nomeResponsavel'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cidade'], "int"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['cnpj'], "text"),
                       GetSQLValueString($_POST['tipoLojista'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"), 
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
                  	<div class="panel-heading" align="left"> Edite seu perfil</div>
                    <div class="panel-body">
                      <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal">
                       <div class="form-group">
                            <label class="col-sm-4 control-label">Razão Social:</label>
                            <div class="col-sm-8">
                             <input type="text" title="Digite o nome da empresa" class="form-control" name="nomeEmpresa" value="<?php echo htmlentities($row_editarperfil['nomeEmpresa'], ENT_COMPAT, 'utf-8'); ?>" required>
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Nome Fantasia:</label>
                            <div class="col-sm-8">
                            	<input type="text" title="Digite o nome fantasia" class="form-control" name="nomeFantasia" value="<?php echo htmlentities($row_editarperfil['nomeFantasia'], ENT_COMPAT, 'utf-8'); ?>" required>
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Nomedo responsavel:</label>
                            <div class="col-sm-8">
                            	<input type="text" title="Digite o nome do responsavel" class="form-control" name="nomeResponsavel" value="<?php echo htmlentities($row_editarperfil['nomeResponsavel'], ENT_COMPAT, 'utf-8'); ?>" required>
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-8">
                            	<input type="email" title="Digite um Email valido" class="form-control" name="email" value="<?php echo htmlentities($row_editarperfil['email'], ENT_COMPAT, 'utf-8'); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Senha:</label>
                            <div class="col-sm-4">
                            	<input type="password" title="Digite uma senha" class="form-control" name="senha" value="<?php echo htmlentities($row_editarperfil['senha'], ENT_COMPAT, 'utf-8'); ?>" required>
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Endereco:</label>
                            <div class="col-sm-8">
                            <input type="text" title="Digite um emdereço" class="form-control" name="endereco" value="<?php echo htmlentities($row_editarperfil['endereco'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Bairro:</label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" title="Digite o bairro" name="bairro" value="<?php echo htmlentities($row_editarperfil['bairro'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Cidade:</label>
                            <div class="col-sm-3">
                            <select class="form-control" name="cidade">
                              <?php 
do {  
?>
                              <option class="form-control" value="<?php echo $row_cidade['id']?>" <?php if (!(strcmp($row_cidade['id'], htmlentities($row_editarperfil['cidade'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_cidade['nome']?> - <?php echo $row_cidade['sigla']?> </option>
                              <?php
} while ($row_cidade = mysql_fetch_assoc($cidade));
?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">CEP:</label>
                            <div class="col-sm-4">
                            	<input class="form-control" title="Digite um CEP valido 55555-555" pattern="[0-9]{5}-[0-9]{3}$" type="text" name="cep" value="<?php echo htmlentities($row_editarperfil['cep'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo do Lojista:</label>
                            <div class="col-sm-4">
                            	<select name="tipoLojista" class="form-control" id="tipoLojista">
                              		<option value="fisica" <?php if (!(strcmp("fisica", htmlentities($row_editarperfil['tipoLojista'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Fisica</option>
                              		<option value="Juridica" <?php if (!(strcmp("Juridica", htmlentities($row_editarperfil['tipoLojista'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Juridica</option>
                            	</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">CPF:</label>
                            <div class="col-sm-5">
                            <input class="form-control" title="Digite um CPF valido exemplo 111.111.111-11" type="text" name="cpf" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$" value="<?php echo htmlentities($row_editarperfil['cpf'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                          </div>
                          <div class="form-group" id="cnpj">
                            <label class="col-sm-4 control-label">CNPJ:</label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="cnpj" title="Digite um CNPJ valido exemplo 11.111.111/0001-01" pattern="[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}$" value="<?php echo htmlentities($row_editarperfil['cnpj'], ENT_COMPAT, 'utf-8'); ?>">
                          </div>
                          </div>
                          
                           <script type="text/javascript">
								
                            /* 
							$(document).ready(function(){
								var valor = $("#tipoLojista").val();
                                 if(valor == "Juridica"){
										$("div#cnpj").show();
										
                                          	$("div#cnpj input").attr({"required" : "required"});
											$("div#cnpj input").attr({
											"pattern":"[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}$",
											});  
                                        
									}else{
										$("div#cnpj").hide();
										$("div#cnpj input").attr({"value":" "});
										$("div#cnpj input").removeAttr("pattern");
										$("div#cnpj input").removeAttr("required");
									}   
								
								$("#tipoLojista").blur(function(){
									var valor = $(this).val();
									if(valor == "Juridica"){
										$("div#cnpj").show();
										$("div#cnpj input").attr("required");
										$("div#cnpj input").attr({
											"pattern":"[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}$",
											});
									}else{
										$("div#cnpj").hide();
										$("div#cnpj input").attr({"value":" "});
										$("div#cnpj input").removeAttr("pattern");
										$("div#cnpj input").removeAttr("required");
									}
									});
                                    
                            });*/
						  </script>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Telefone:</label>
                            <div class="col-sm-4">
                            	<input class="form-control" type="tel" name="telefone" pattern="\([0-9]{2}\)[0-9]{4}-[0-9]{4}$" value="<?php echo htmlentities($row_editarperfil['telefone'], ENT_COMPAT, 'utf-8'); ?>" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Celular:</label>
                            <div class="col-sm-4">
                            <input class="form-control" type="tel" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" name="celular" value="<?php echo htmlentities($row_editarperfil['celular'], ENT_COMPAT, 'utf-8'); ?>" required>
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
