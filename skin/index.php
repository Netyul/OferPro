<!doctype html >
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OferApp as ofertas mais próximas em suas mãos!</title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="css/oferapp-boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/oferapp.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/respond.min.js"></script>
<script src="js/popup.js"></script>
</head>

<body>
<div id="popup-cadastrar-usuario"></div>
<div id="popup-login"></div>
<header id="header" role="banner">
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
                <a class="navbar-brand" href="#"><img  src="images/logo.png" alt="OferApp Ofertas de Produtos e serviços mais proximo de você"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse in" id="bs-example-navbar-collapse-1">
                <form class=" form-group navbar-form navbar-left" role="search">
        			<div class="input-group">
                    <div class="input-group-btn">	
                        <select class=" btn btn-default form-control" id="busca" name="busca">
                         
                        	<option class="form-control" value="1"><a>Ofertas</a></option>
                            <<option class="form-control"  value="2"><a>Tabloide</a></option>
                            <option class="form-control"  value="3"><a>Sorteios</a></option>
                            
                        </select>
                      </div>
                      <!-- /btn-group -->
                        <input type="text" class="form-control input-oferapp-busca" placeholder="Digite Sua Busca">
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-Oferapp">Buscar!</button>
                        </span>
                    </div>
      			</form>
                <ul class="nav navbar-nav navbar-right">
                	<li>
                    	<div class="btn-group btn-group-cidade" role="menuitem">
                            <span class="btn btn-default">Cidade: </span>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu" >
                                <li><a href="#">OferApp - Home</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Itabuna - BA</a></li>
                                <li><a href="#">Ilheus - BA</a></li>
                            </ul>
                    	</div>    
                    </li>
                	<li><a>Negócios</a></li>
                    <li><a href="#">Contato</a></li>
                    <li class="dropdown ">
                     <a href="#" class="dropdown-toggle cadastrar" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Cadastre-se<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="divider"></li>
                        <li><a href="#" class="cadastrarUser" data-toggle="modal" data-target="#cadastrarUser">Cadastra-se</a></li>
                        <li><a href="#" data-toggle="modal" data-target=".login-sm">Login</a></li>
                    </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav><!-- /.container-fluid -->
       
    </div>
</header><!--/#header-->
<section class="oa-principal">
	<div class="container">
    	<div class="row">
        	<div class="col-md-8">
            	<div class="Slogan">
					<h1 class="lead">As ofertas mais pr&oacute;ximas em suas m&atilde;os</h1>
                    
        		</div>
            </div>
            
            <div class="col-md-4">
            	<div class="img-section">
                	<p><a class="btn btn-primary btn-lg" href="#">Baixar App!</a></p>
                </div>
            </div>
           
        </div>
    	
	</div>
</section> 
<main>
	<div class="container">
    	<div class="area inicial">
        	<div class="top row ">
       			<div class="col-sm-4">
        			<h2><span class="glyphicon glyphicon-bookmark icon-destaque"></span> Destaques OferApp</h2>	
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4" id="cadastrolojista" >
                	
                </div>
            </div>
            <ul class="row">
  				<li class="col-sm-3 ">
                	<div class="well well-sm">
                        <div class="thumbnail destaque-images">
                            <img src="images/tabloide.jpg" alt="..."class="img-responsive">
                            <div class="overlay">
                            	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                            </div>
                            <h5> lorem lorem loremimpsum</h5>
                        </div>
                     </div>
                </li>
  			    <li class=" col-sm-3">
                	<div class="well well-sm">
                        <div class="thumbnail destaque-images">
                            <img src="images/tabloide.jpg" alt="..."class="img-responsive">
                            <div class="overlay">
                            	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                            </div>
                            <h5> lorem lorem loremimpsum</h5>
                        </div>
                    </div>
              </li>
              <li class="col-sm-3">
                	<div class="well well-sm">
                        <div class="thumbnail destaque-images">
                            <img src="images/tabloide.jpg" alt="..."class="img-responsive">
                            <div class="overlay">
                            	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                            </div>
                            <h5> lorem lorem loremimpsum</h5>
                        </div>
                    </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
              <li class="col-sm-3">
                  <div class="well well-sm">
                      <div class="thumbnail destaque-images">
                          <img src="images/tabloide.jpg" alt="..." class="img-responsive">
                          <div class="overlay">
                          	<p>lorel lorel lorel impsum impsum lorel lorel lorel impsum impsum</p>
                          </div>
                          <h5> lorem lorem loremimpsum</h5>
                      </div>
                  </div>
              </li>
            </ul>  
        </div>
    </div> 
</main> 
<footer>
	<div class="container">
    	<div class="row">
        	<div class="col-lg-4">
            	<h4 class="page-header">Sobre</h4>
                <ul>
                	<li><a href="#">Contate-nos</a></li>
                    <li><a href="#">Como funciona para o lojista?</a></li>
                    <li><a href="#">Como funciona para o cliente?</a></li>
                    <li><a href="#">Quem somos</a></li>
                    <li><a href="#">Termos de uso</a></li>
                    <li><a href="#">Política de privacidade</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
            	<h4 class="page-header">Siganos-nos</h4>
            </div>
            <div class="col-lg-4">
            	<h4 class="page-header">Parceiros</h4>
            </div>
        </div>
        <div class="footer">
        	
        </div>
    </div>
</footer>  
</body>
</html>