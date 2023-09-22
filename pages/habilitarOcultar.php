<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
?>
  
                            <div id="ocultarHabilitar">
                            <input  type="radio" id="rad_si" name="radiobtn3" value="si" required>
                            <label  for="cargo">Habilitar filtros</label>
                            </div>
                            <div id="ocultarOculto" style="display:none;">
                            <input  type="radio" id="rad_no" name="radiobtn3" value="no" required>
                            <label  for="usuarios">Ocultar</label>
                            </div>
             
              
             

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
            document.getElementById('ocultarOculto').style.display = '';
            document.getElementById('ocultarHabilitar').style.display = 'none';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
             document.getElementById('ocultarOculto').style.display = 'none';
            document.getElementById('ocultarHabilitar').style.display = '';
            
        });
    });
</script>

<?php
}
?>
                          
