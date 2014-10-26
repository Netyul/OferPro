<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina CONTATO do sistema Oferapp.
 * versão 1.0
 */
 if(isset($_POST['submit'])){
	 require_once('skin/section.phtml');
 	if(isset($_POST['tipo']) && $_POST['tipo'] == "ofertas"){
		$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
		$buscaresult = mysqli_query($dboferapp, $query_busca);
		$totalBusca = mysqli_num_rows($buscaresult);
		$row_busca = mysqli_fetch_array($buscaresult);
			if($totalBusca>0){
				$vezes = $row_busca['veses'];
				$soma = $vezes +1;
				$up_busca = "UPDATE busca SET veses=".$soma." WHERE id = ".$row_busca['id'];
				$RSupBusca = mysqli_query($dboferapp, $up_busca);
			}else{
				$insert_busca = "INSERT INTO busca(busca, veses) VALUES ('".$_POST['buscar']."', 1)";
				$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
			}
		
		
 ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_01.png'); ?>" width="39"> Busca de Ofertas </a></li>
                </ul>
            </div>
            <ul class="row">
				<?php
				$home_query = "SELECT * FROM ofertas WHERE titulo LIKE '%".$_POST['buscar']."%'  ORDER BY id DESC";
				$resultHome = mysqli_query($dboferapp, $home_query);
				$totalRows = mysqli_num_rows($resultHome); 
                if($totalRows <=0){
                echo '<div class="alert alert-warning" role="alert">Nenhum oferta encontrada!</div>';
                }
                while($homeRows = mysqli_fetch_array($resultHome)){
                ?>
                <li class="col-md-3 ">
                    <div class="well well-sm">
                        <div class="thumbnail destaque-images">
                            <img src="<?php baseurl(IMGOFERTAS. $homeRows['img']);?>" alt="<?php echo $homeRows['titulo']; ?>" style="width:218px; height:147px;">
                            <div class="overlay">
                                <p><?php echo $homeRows['descricao'];?></p>
                                <p><a href="#<?php echo $homeRows['id']; ?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
                            </div>
                            <h5><?php echo $homeRows['titulo'];?></h5>
                        </div>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
</main>
<?php 
	}
	if(isset($_POST['tipo']) && $_POST['tipo'] == "tabloides"){
		
 ?>
 <main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_04.png'); ?>" width="39"> Busca de Tabloides</a></li>
                </ul>
            </div>
            <ul class="row">
				<?php 
				$Tabloide_query = "SELECT * FROM tabloide WHERE titulo LIKE '%".$_POST['buscar']."%' ORDER BY id DESC";
				$resultTabloide = mysqli_query($dboferapp, $Tabloide_query);
				$totalRows = mysqli_num_rows($resultTabloide);
                if($totalRows <=0){
                	echo '<div class="alert alert-warning" role="alert">Nenhum tabloide encontrado!</div>';
                }
                while($tabloideRows = mysqli_fetch_array($resultTabloide)){
                ?>
                <li class="col-md-3 ">
                    <div class="well well-sm">
                    <div class="thumbnail destaque-images">
                    <img src="<?php baseurl(IMGTABLOIDE. $tabloideRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" style="width:218px; height:147px;">
                    <div class="overlay">
                    <p><?php echo $tabloideRows['descricao'];?></p>
                    <p><a href="#<?php echo $tabloideRows['id']; ?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
                    </div>
                    <h5><?php echo $tabloideRows['titulo'];?></h5>
                    </div>
                    </div>
                    <div class="modal fade" id="<?php echo $tabloideRows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalOfertas" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <h4 class="modal-title" id="myModalLabel"><?php echo $tabloideRows['titulo'];?> </h4>
                              </div>
                              <div class="modal-body">
                                  ...
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
</main>
 <?php 
 }
 if(isset($_POST['tipo']) && $_POST['tipo'] == "presentes"){
	 
 ?>
 <main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_03.png'); ?>" width="39"> Busca de Presentes</a></li>
                </ul>
            </div>
                <ul class="row">
					<?php 
					$presentes_query = "SELECT * FROM presentes WHERE titulo LIKE '%".$_POST['buscar']."%' ORDER BY id DESC";
					$resultPresentes = mysqli_query($dboferapp, $presentes_query);
					$totalRows = mysqli_num_rows($resultPresentes);
                    if($totalRows <=0){
                            echo '<div class="alert alert-warning" role="alert">Nenhum presente encontrado!</div>';
                        }
                    while($presentesRows = mysqli_fetch_array($resultPresentes)){
                    ?>
                    <li class="col-md-3 ">
                        <div class="well well-sm">
                            <div class="thumbnail destaque-images">
                                <img src="<?php baseurl(IMGPRESENTES. $presentesRows['img']);?>" alt="<?php echo $presentesRows['titulo'];?>" style="width:218px; height:147px;">
                                <div class="overlay">
                                    <p><?php echo $presentesRows['descricao'];?></p>
                                </div>
                                <h5><?php echo $presentesRows['titulo'];?></h5>
                            </div>
                        </div>
                    </li>
                    <?php }?>
            
            </ul> 
        </div>
    </div>
</main>  
<?php } 
}
else{
	require_once('skin/section.phtml');
?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-search"></span>Busca </h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="alert alert-warning" role="alert">Nenhum busca foi feita!</div>
                </div>
            </div>
        </div>
    </div>
</main>  
<?php		
	}
?>            