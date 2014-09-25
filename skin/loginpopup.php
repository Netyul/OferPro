<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções de login ultilizadas no sistema Oferapp.
 * versão 1.0
 */	
 
 	
 if(isset($msg)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $(".loginUser").click();
    });</script>';

 }

?>
<div id="popup-login ">
<div class=" modal fade login-sm in" tabindex="-1" id="login" role="dialog" aria-labelledby="loginModal" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
            	<?php if(isset($msg)){ echo $msg; }?>
            	<form class="form-horizontal" role="form" action="http://<?php  echo $urlpost; ?>" method="post">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email: </label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" name="login" id="login" value="<?php  echo $login; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Senha: </label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $senha; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="lembrar" id="lembrar" <?php if($lembrar != false){ echo'checked';}?> >Lembrar-me
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="enviar" id="enviar">Entrar</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> 