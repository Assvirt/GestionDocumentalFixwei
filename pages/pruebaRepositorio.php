<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

Evento enviar<br><br><br>
<input type="checkbox" class="btn btn-primary" id="rad_mostrar" name="radiobtn" value="../../ruta">


<input  name="recibeID" id="recibeID" value="">

<script>
$(document).ready(function(){
    
            $('#rad_mostrar').click(function(){
                
                //alert('Entre');
                //document.getElementById('recibeID').style.display = '';
                document.getElementById("recibeID").value = document.getElementById("rad_mostrar").value;
                
            });

        });
</script>