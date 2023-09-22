<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<br>
<input type="radio" id="rad_cargo" name="radiobtn" value="cargo">
<label for="cargo">Cargo</label>
<input type="radio" id="rad_usuario" name="radiobtn" vaue="radio">
<label for="usuarios">Usuarios</label><br>


<div><select class="form-control" name="select_encargado" id="select_encargado"></select></div>

<script>
    $(document).ready(function(){
        $('#rad_cargo').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargado").html(data);
            }); 
        });
        $('#rad_usuario').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargado").html(data);
            }); 
        });
    });
</script>    