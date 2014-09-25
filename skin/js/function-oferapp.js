// JavaScript Documentos de funções oferapp
$(function(){
	
	function carregar(init, max, url){
		var dados  = {init : init, max : max};
		
		$.post(url, dados, function(data){
			
			console.info(data);
			
		},"json");
	}
});