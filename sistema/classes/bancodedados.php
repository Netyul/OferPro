<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções do banco de dados.
 * versão 1.0
 */
 //namespace sistema\classes{
	 class bancodedados{
		 
		 public $executar;
		 
		 public function inserir($tabela, $campoValor){
			 $campos = implode(",", array_keys($campoValor));
			 $valor = "'".implode("', '", array_values($campoValor)) . "'";
			 
			 $sql = "INSERT INTO $tabela ($campos) VALUES($valor)";
			 
			 $executar = mysqli_query($sql);
			 return $executar;
		 }
		 public function selecionar($sql){
			 $executar = mysqli_query($sql);
			 return $executar;
		 }
		 public function alterar($tabela, $campos, $condicao){
			 $sql = "UPDATE $tabela SET $campos WHERE $condicao";
			 $executar = mysqli_query($sql);
			 return $executar;
		 }
		 public function excluir($tabela, $condicao){
			 $sql = "DELETE FROM $tabela WHERE $condicao";
			 $executar = mysqli_query($sql);
			 return $executar;
		 }
		
	 }
 //}