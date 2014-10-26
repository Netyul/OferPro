<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
if(isset($_POST['solicitar']) && $_POST['solicitar'] == 'solicitar'){
	$idOfertas  = $_POST['id_oferta'];
	$id_Lojista = $_POST['id_lojista'];
	$id_user    = $_POST['id_user'];
	$Query_quantidade = "SELECT * FROM ofertas WHERE id=".$idOfertas." AND id_lojista = ".$id_Lojista;
	$resultQuantidade = mysqli_query($dboferapp, $Query_quantidade);
	$resultQ = mysqli_fetch_array($resultQuantidade);
	$quantidade = $resultQ['quantidade'];
	$menosoli   = $quantidade - 1;
	
	$upQuantdade = "UPDATE ofertas SET quantidade = ".$menosoli." WHERE id = ".$idOfertas." AND id_lojista = ".$id_Lojista;
	$resultUpQuantidade = mysqli_query($dboferapp, $upQuantdade);
	if($resultUpQuantidade){
		$solicitacao = "INSERT INTO solicitacoes(id_oferta, id_cliente, id_lojista) VALUES(".$idOfertas.", ".$id_user.", ".$id_Lojista.")";
		$resultsolicitacao = mysqli_query($dboferapp, $solicitacao);
		if($resultsolicitacao){
			
			$msgSolicitacao = '<div class="alert alert-success" role="alert">Oferta Solicitada com sucesso!</div>';
       		$url->UrlJavaRedir(baseurl($pagina.'/'.$action.'/'.$subaction));
			$url->JavaRedir();
			
			
		}
	}
	
}
require_once('sistema/classes/texto.php');
$lojista = str_replace("-"," ", $perfilLojista);
$query_lojista = "SELECT * FROM lojista WHERE nomeFantasia ='".$lojista."' ORDER BY id DESC";
$Result_lojista = mysqli_query($dboferapp, $query_lojista);
$rows_lojista = mysqli_fetch_array($Result_lojista);

if(isset($perfilLojistaOfertas) && $subaction == $perfilLojistaOfertas){
		$lojistaOfertas = str_replace("-"," ", $perfilLojistaOfertas);
		$oferta_query = "SELECT o.id, o.titulo, o.descricao, o.valor,o.quantidade,o.tipo, o.img, o.id_lojista, l.nomeFantasia, l.endereco, l.bairro, c.nome AS cidade, e.sigla FROM ofertas AS o INNER JOIN lojista AS l ON l.id = o.id_lojista INNER JOIN cidade AS c ON c.id = l.cidade INNER JOIN estado AS e ON e.id = c.id_uf WHERE o.id_lojista =".$rows_lojista['id']." AND o.titulo = '".$lojistaOfertas."'";
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
						
                        echo '<div class="alert alert-warning" role="alert">Nenhum oferta cadastrado!</div>';
                    	
				}else{
                ?>
             
                <div class="col-xs-12 col-sm-6 col-md-8">
                	<img src="<?php baseurl(IMGOFERTAS. $OfertaRows['img']);?>" alt="<?php echo $OfertaRows['titulo']; ?>" class="img-thumbnail" style="max-height:479px;" width="100%">
                </div>
                <div class="col-xs-6 col-md-4" align="left">
                	<h3 class="page-header"> <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $OfertaRows['titulo']; ?></h3>
                    <p><strong>Valor:</strong> <?php echo $OfertaRows['valor']; ?></p>
                    <p><strong>Descrição: </strong><?php $descriccao = new texto($OfertaRows['descricao']); ?></p>
                    <p><strong>Loja:</strong> <?php echo $OfertaRows['nomeFantasia']; ?></p>
                    <p><strong>Tipo:</strong> <?php if($OfertaRows['tipo'] == 'serviço'){ echo 'Serviços';}else{echo 'Produtos';} ?></p>
                    <p><a href="#encontrenos" class="label label-default" style="font-size:14px">Encontre-nos!</a></p>
                    <?php
					if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !=''){ 
					$quantidade = $OfertaRows['quantidade'];
						if( $quantidade > 0){
							$soli_Query = "SELECT * FROM solicitacoes WHERE id_cliente =".$_SESSION['user_id'];
							$result_Soli = mysqli_query($dboferapp, $soli_Query);
							$rowSoli = mysqli_num_rows($result_Soli);
							if($rowSoli>0){
								echo '<div class="alert alert-success" role="alert">Oferta Solicitada com sucesso!</div>';
							}else{
					?>
                    <p>
                    <form action="<?php baseurl($perfilLojista.'/'.$action.'/'.$subaction); ?>" method="post" name="solicita" id="solicita" autocomplete="off">
                    	<input type="hidden" name="solicitar" value="solicitar"/>
                        <input type="hidden" name="id_lojista" value="<?php echo $OfertaRows['id_lojista']; ?>"/>
                        <input type="hidden" name="id_oferta" value="<?php echo $OfertaRows['id']; ?>"/>
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>"/>
                        <button type="submit" class="btn btn-Oferapp"><span class="glyphicon glyphicon-send"></span> Solicitar Oferta</button>
                    </form>
                    </p>
                    <?php
							}}else{
							?>
                            <p align="center" class="label label-warning" style="font-size:14px"> Oferta esgotada!</p>
                            <?php
						}
					}
					?>
                    <h5 class="page-header"><strong>Nosso Endereço </strong></h5>
                    <p id="endereco"><?php echo $OfertaRows['endereco']; ?> - <?php echo $OfertaRows['bairro']; ?>, <?php echo $OfertaRows['cidade']; ?> - <?php echo $OfertaRows['sigla']; ?></p>
                </div>
               
                 <div class="row">
                 <div class="col-md-12">
                 <h4 class="page-header text-left"><?php echo $OfertaRows['titulo']; ?> </h4>
                 <p class="text-left"><?php echo $OfertaRows['descricao']; ?></p>
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