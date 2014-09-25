// JavaScript Documentos de funções oferapp


$("#celular").mask("(99)9999-9999");
$(function(){
	
	function carregar(init, max, url){
		var dados  = {init : init, max : max};
		
		$.post(url, dados, function(data){
			
			console.info(data);
			
		},"json");
	}
});