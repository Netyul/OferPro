
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="pt" dir="ltr">
<head>
<meta charset="utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Administração da OferApp</title>
<!-- TemplateEndEditable -->
<link href="../admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/oferapp.css" rel="stylesheet" type="text/css">
<link href="../admin/css/oferapp-boilerplate.css" rel="stylesheet" type="text/css" />
<link href="../admin/css/oferapp-admin.css" rel="stylesheet" type="text/css" />

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../admin/js/jquery.min.js"></script>
<script src="../admin/js/bootstrap.min.js"></script>
<script src="../admin/js/respond.min.js"></script>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
                <a class="navbar-brand" href="<?php echo BASEURL; ?>"><img  src="../admin/images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você" title="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                	<?php 
					$level = LEVEL;
					if($level == 'superadmin'){
					?>                 
                    <li><a href="<?php echo BASEURL; ?>/admin/cidade">Cidades</a></li>
                    <li><a href="<?php echo BASEURL; ?>/admin/administradores">Administradores</a></li>
                    <?php } ?>
                    <li><a href="<?php echo BASEURL; ?>/admin/lojista">Lojistas</a></li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo ADMNOME; ?> <span class="caret"></span></a>
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
            <div class="top page-header">
            <!-- TemplateBeginEditable name="tituloPagina" -->
            <?php 
				
			?>
            <h2> <span class="glyphicon glyphicon-bookmark icon-destaque"></span>Administração</h2>
            <?php ?>
            <!-- TemplateEndEditable -->
            </div>
            <div class="row">
            <!-- TemplateBeginEditable name="conteudo" -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3> 150 </h3>
                    <p> New Orders </p>
                  </div>
                  <div class="icon"> <i class="ion ion-bag"></i> </div>
                  <a href="#" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i> </a> </div>
              </div>
              <!-- ./col -->
              <div class="col-md-8"></div>
              <div class="col-md-4"></div>
            <!-- TemplateEndEditable -->
            </div>
        </div>
    </div>
</main>
<footer>
<!-- TemplateBeginEditable name="footer" -->
 <div class="footer"></div>

</footer>
</body>
<!-- TemplateEndEditable -->
</html>
