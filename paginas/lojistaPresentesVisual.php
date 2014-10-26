<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/

if(isset($_POST['presentiar']) && $_POST['presentiar'] == 'presentiar'){
	$ganhar_Query = "SELECT * FROM clicado WHERE id_user_clik =".$_POST['id_usuario']." AND id_user_clicado =".$_SESSION['user_id']." AND id_ganhar_presente =".$_POST['id_presente'];
	$result_ganhar = mysqli_query($dboferapp, $ganhar_Query);
	$rowGanhar = mysqli_num_rows($result_ganhar);
	if($rowGanhar == 1){
		$msgPresentiar = '<div class="label label-warning">Você já presentiou este usuario!</div>';
	}
	else{
	$id_usuario  = $_POST['id_usuario'];
	$id_presente = $_POST['id_presente'];
	$id_user    = $_POST['id_user'];
	$Query_clik = "SELECT * FROM ganharpresente WHERE id_usuario=".$id_usuario." AND id_presente = ".$id_presente;
	$resultclik = mysqli_query($dboferapp, $Query_clik);
	$resultclik = mysqli_fetch_array($resultclik);
	$quantidade = $resultclik['cliks'];
	$maisum   = $quantidade + 1;
	
	$upQuantdade = "UPDATE ganharpresente SET cliks = ".$maisum." WHERE id_usuario = ".$id_usuario." AND id_presente = ".$id_presente;
	$resultUpQuantidade = mysqli_query($dboferapp, $upQuantdade);
	if($resultUpQuantidade){
		$solicitacao = "INSERT INTO clicado(id_user_clik, id_user_clicado, id_ganhar_presente) VALUES(".$id_user.", ".$id_usuario.", ".$id_presente.")";
		$resultsolicitacao = mysqli_query($dboferapp, $solicitacao);
		
	}
	}
}
if(isset($_POST['ganhar']) && $_POST['ganhar'] =='ganhar'){
	$ganhar_Query = "SELECT * FROM ganharpresente WHERE id_usuario =".$_SESSION['user_id'];
	$result_ganhar = mysqli_query($dboferapp, $ganhar_Query);
	$rowGanhar = mysqli_num_rows($result_ganhar);
	if($rowGanhar == 1){
		$msgGanhar = '<div class="alert alert-warning" role="alert">Você já se cadastrado a este presente!</div>';
	}
	else{
		$idOfertas  = $_POST['id_presente'];
		$id_Lojista = $_POST['id_lojista'];
		$id_user    = $_POST['id_user'];
		$ganharpresente = "INSERT INTO ganharpresente(id_presente, id_usuario) VALUES(".$idOfertas.", ".$id_user.")";
		$resultsolicitacao = mysqli_query($dboferapp, $ganharpresente);
		
	}
	
}

require_once('sistema/classes/texto.php');
$lojista = str_replace("-"," ", $perfilLojista);
$query_lojista = "SELECT * FROM lojista WHERE nomeFantasia ='".$lojista."' ORDER BY id DESC";
$Result_lojista = mysqli_query($dboferapp, $query_lojista);
$rows_lojista = mysqli_fetch_array($Result_lojista);

if(isset($perfilLojistaOfertas) && $subaction == $perfilLojistaOfertas){
		$lojistaOfertas = str_replace("-"," ", $perfilLojistaOfertas);
		$oferta_query = "SELECT p.id, p.titulo, p.descricao, p.img, p.id_lojista, l.nomeFantasia, l.endereco, l.bairro, c.nome AS cidade, e.sigla FROM presentes AS p INNER JOIN lojista AS l ON l.id = p.id_lojista INNER JOIN cidade AS c ON c.id = l.cidade INNER JOIN estado AS e ON e.id = c.id_uf WHERE p.id_lojista =".$rows_lojista['id']." AND p.titulo = '".$lojistaOfertas."'";
		$resultOferta = mysqli_query($dboferapp, $oferta_query);
		$totalRowsOfertas = mysqli_num_rows($resultOferta);
		$OfertaRows = mysqli_fetch_array($resultOferta);
	
?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
        
            <div class="row">
				<?php
                if($totalRowsOfertas <=0){
						
                        echo '<div class="alert alert-warning" role="alert">Nenhum presnete cadastrado!</div>';
                    	
				}else{
                ?>
             
                <div class="col-xs-12 col-sm-6 col-md-8">
                	<img src="<?php baseurl(IMGPRESENTES. $OfertaRows['img']);?>" alt="<?php echo $OfertaRows['titulo']; ?>" class="img-thumbnail" style="max-height:479px;" width="100%">
                </div>
                <div class="col-xs-6 col-md-4" align="left">
                	<h3 class="page-header"> <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $OfertaRows['titulo']; ?></h3>
                    <p><strong>Descrição: </strong><?php $descriccao = new texto($OfertaRows['descricao']); ?></p>
                    <p><strong>Loja:</strong> <?php echo $OfertaRows['nomeFantasia']; ?></p>
                    <p><a href="#encontrenos" class="label label-default" style="font-size:14px">Encontre-nos!</a></p>
                    <?php
					if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !=''){
							if(isset($msgGanhar)){
								echo $msgGanhar;
							}else{
							$soli_Query = "SELECT * FROM ganharpresente WHERE id_usuario =".$_SESSION['user_id'];
							$result_Soli = mysqli_query($dboferapp, $soli_Query);
							$rowSoli = mysqli_num_rows($result_Soli);
							if($rowSoli>0){
								echo '<div class="alert alert-success" role="alert">Você esta concorrendo a este presente!</div>';
							}else{
					?>
                    <p>
                    <form action="<?php baseurl($perfilLojista.'/'.$action.'/'.$subaction); ?>" method="post" name="solicita" id="solicita" autocomplete="off">
                    	<input type="hidden" name="ganhar" value="ganhar"/>
                        <input type="hidden" name="id_lojista" value="<?php echo $OfertaRows['id_lojista']; ?>"/>
                        <input type="hidden" name="id_presente" value="<?php echo $OfertaRows['id']; ?>"/>
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>"/>
                        <button type="submit" class="btn btn-Oferapp"><span class="glyphicon glyphicon-gift"></span> Concorre a este presente</button>
                    </form>
                    </p>
                    <?php
							}}
							?>
                    <?php        
					}
					?>
                    <h5 class="page-header"><strong>Nosso Endereço </strong></h5>
                    <p id="endereco"><?php echo $OfertaRows['endereco']; ?> - <?php echo $OfertaRows['bairro']; ?>, <?php echo $OfertaRows['cidade']; ?> - <?php echo $OfertaRows['sigla']; ?></p>
                </div>
               <script type="text/javascript" src="<?php SkinUrl('js/function.js'); ?>"></script>
                 <div class="row">
                 <div class="col-md-12">
                 <h4 class="page-header text-left"><?php echo $OfertaRows['titulo']; ?> </h4>
                 <p class="text-left"><?php echo $OfertaRows['descricao']; ?></p>
                 <div class="panel panel-default">
                 	<div class="panel-heading" align="left">Presentiar Algem</div>
            			<?php
							$query = "SELECT g.id, u.nome, g.id_usuario, g.id_presente FROM ganharpresente AS g INNER JOIN usuario AS u ON u.id = g.id_usuario WHERE g.id_presente =".$OfertaRows['id'];
							$queryResult = mysqli_query($dboferapp,$query);
							
						?>
                     	<table class="table">
  						<tr>
                        <?php 
						while($rowQuery = mysqli_fetch_array($queryResult)){
							?>
                        <td valign="middle" align="left"><?php echo $rowQuery['nome']; ?> </td>
                        <td  align="right">
                         <?php
						if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !=''){
							if(isset($msgPresentiar)){
								echo $msgPresentiar;
							}else{
							$soli_Query = "SELECT * FROM clicado WHERE id_user_clicado =".$_SESSION['user_id'];
							$result_Soli = mysqli_query($dboferapp, $soli_Query);
							$rowSoli = mysqli_num_rows($result_Soli);
							if($rowSoli>0){
								echo '<div class="label label-success">Você presentiou este usuario!</div>';
							}else{
						?>
                        <form action="<?php baseurl($perfilLojista.'/'.$action.'/'.$subaction); ?>" method="post" name="presentear" id="presentear" autocomplete="off">
                    	<input type="hidden" name="presentiar" value="presentiar"/>
                        <input type="hidden" name="id_usuario" value="<?php echo $rowQuery['id_usuario']; ?>"/>
                        <input type="hidden" name="id_presente" value="<?php echo $rowQuery['id_presente']; ?>"/>
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>"/>
                        <button type="submit" class="btn btn-Oferapp btn-xs"><span class="glyphicon glyphicon-gift"></span> presentiar</button>
                   		</form>
                        <?php 
							}
							}
						}
						?>
                        </td>
                        <?php
						}?>
                        </tr>
  						</table>
                   
                 </div>
                 <div id="encontrenos" style="padding-top:30px"/>
                 <h4 class="page-header">Encontre-nos</h4>
                 	<div id="mapa" style="height: 400px; width: 100%">
                    </div>
                     <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
                    <script type="text/javascript">
					$(document).ready(function() {
                        var geocoder;
						var map;
						function initialize() {
						  geocoder = new google.maps.Geocoder();
						  var latlng = new google.maps.LatLng(-23.6867266, -46.79065109999999);
						  var mapOptions = {
							zoom: 17,
							center: latlng
						  }
						  map = new google.maps.Map(document.getElementById('mapa'), mapOptions);
						}
						
						function codeAddress() {
						  var address = $("#endereco").text();
						  geocoder.geocode( { 'address': address + ', Brasil', 'region': 'BR'}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
							  map.setCenter(results[0].geometry.location);
							  var marker = new google.maps.Marker({
								  map: map,
								  position: results[0].geometry.location,
								  icon: 'http://'+window.location.host+'/skin/images/iconmaps.png'
							  });
							} else {
							  alert('Geocode was not successful for the following reason: ' + status);
							}
						  });
						}
						
						google.maps.event.addDomListener(window, 'load', initialize);
						google.maps.event.addDomListener(window, 'load', codeAddress);
						 }); 
                    </script>      
                 </div>
                </div>
                <?php }?>
        	</div>
		</div>
	</div>
</main>
<?php
} else{
		require_once('paginas/erro-404.php');
}
?>