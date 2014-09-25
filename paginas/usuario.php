<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
	if(isset($pagina) && isset($action) && $action =='configurar-acesso'){
		require_once('paginas/usuario/configurar-acesso.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='notificar'){
		require_once('paginas/usuario/notificar.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='minhas-ofertas'){
		require_once('paginas/usuario/minhas-ofertas.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='meus-sorteios'){
		require_once('paginas/usuario/meus-sorteios.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='perfil'){
		require_once('paginas/usuario/perfil.php');
	}
	elseif(isset($pagina) && $pagina == 'usuario'){
?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($pagina == 'usuario'){
					$perfilUser = 'Perfil - '. $_SESSION['usuario'];
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $perfilUser; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</main>
<?php
	}
}			
else{
	$url->UrlJavaRedir('http://'.BASEURL);
	$url->JavaRedir();
}
?>