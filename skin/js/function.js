// JavaScript Documentos de funções oferapp
$(function(){
	carregar(0, 10, 'paginas/carregarpresentear.php');
	function carregar(init, max, url){
		var dados  = {init : init, max : max};
		
		$.post(url, dados, function(data){
			
			console.info(data);
			
		},"json");
	}
});