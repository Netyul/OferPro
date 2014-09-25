<?php
/* - função autoload para classes - */
function __autoload( $class ){
 $class = RAIZDIR . '/' . str_replace('\\', '/' , $class ) . '.php';
    
    if( ! file_exists($class)){
        throw new Exception("A Classe: '{$class}' que estar tentando usar não existe");
   }
    require_once ($class);
   
}