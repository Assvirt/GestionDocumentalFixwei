<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container1">
    
    <div>
        
        <input type="text" class="form-control" name="convocadosEXT" id="mytext[]" placeholder="nombre">
        <select class="form-control" name="tipoEmpresaEXT" id="mytext2[]">
            <option value="0">Seleccione Tipo Empresa:</option>
            <option value="cliente">Cliente</option>
            <option value="proovedor">Proovedor</option>
            <option value="clienteP">Cliente prospecto</option>
            <option value="otro">Otro</option>
        </select>
        <input type="text" class="form-control" name="nombreEmpresa" placeholder="empresa" id="mytext3[]">
        <input type="text" class="form-control" name="cargoEXT" placeholder="cargo" id="mytext4[]">
        
    </div>
</div>

<script>
$(document).ready(function() {
    var max_fields = 10;
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<div><input type="text" id="mytext[]"/><a href="#" class="delete">Delete</a></div>'); //add input box
            $(wrapper).append('<div><select  id="mytext2[]"> </select><a href="#" class="delete">Delete</a></div>');
            $(wrapper).append('<div><input type="text" id="mytext3[]"/><a href="#" class="delete">Delete</a></div>');
            $(wrapper).append('<div><input type="text" id="mytext3[]"/><a href="#" class="delete">Delete</a></div>');
        } else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
});
</script>
<!--  script para evento mas mas, Convocados externos -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script>
                                                            $(document).ready(function() {
                                                            var iCnt = 0;
                                                    
                                                    // Crear un elemento div añadiendo estilos CSS
                                                            var container = $(document.createElement('div')).css({
                                                                padding: '0px', margin: '0px', width: '100%', border: '0px dashed',
                                                                borderTopColor: '#999', borderBottomColor: '#999',
                                                                borderLeftColor: '#999', borderRightColor: '#999'
                                                            });
                                                    
                                                            $('#btAdd').click(function() {
                                                                if (iCnt <= 20) {
                                                    
                                                                    iCnt = iCnt + 1;
                                                    
                                                                    // Añadir caja de texto.
                                                                    $(container).append('<input type=text class="form-control" placeholder="Convocados" name="convocadosEXT'+ iCnt + '" id=tb' + iCnt + ' ' +
                                                                                ' ><select class="form-control" name="tipoEmpresaEXT'+ iCnt + '" id=tb' + iCnt + ' ' +'" required><option value="0">Seleccionar...</option><option value="cliente">Cliente</option><option value="proveedor">Proveedor</option><option value="clienteP">Cliente prospecto</option><option value="otro">Otro</option></select><input type=text class="form-control" placeholder="Nombre Empresa" name="nombreEmpresa'+ iCnt + '" id=tb' + iCnt + ' ' +' ><input type=text class="form-control" placeholder="Cargo" name="cargoEXT'+ iCnt + '" id=tb' + iCnt + ' ' +' ><br>');
                                                    
                                                                    if (iCnt == 1) {   
                                                    // funcion del ++ por cada click
                                                     var divSubmit = $(document.createElement('div'));
                                                                        $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                'id=btSubmit value=Enviar /> -->');
                                                    
                                                                    }
                                                    
                                                     $('#main').after(container, divSubmit); 
                                                                }
                                                                else {      //se establece un limite para añadir elementos, 20 es el limite
                                                                    
                                                                    $(container).append('<label>Limite Alcanzado</label>'); 
                                                                    $('#btAdd').attr('class', 'bt-disable'); 
                                                                    $('#btAdd').attr('disabled', 'disabled');
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                            
                                                                if (iCnt == 0) { $(container).empty(); 
                                                            
                                                                    $(container).remove(); 
                                                                    $('#btSubmit').remove(); 
                                                                    $('#btAdd').removeAttr('disabled'); 
                                                                    $('#btAdd').attr('class', 'bt') 
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor
                                                            
                                                                $(container).empty(); 
                                                                $(container).remove(); 
                                                                $('#btSubmit').remove(); iCnt = 0; 
                                                                $('#btAdd').removeAttr('disabled'); 
                                                                $('#btAdd').attr('class', 'bt');
                                                    
                                                            });
                                                        });
                                                    
                                                        // Obtiene los valores de los textbox al dar click en el boton "Enviar"
                                                        var divValue, values = '';
                                                    
                                                        function GetTextValue() {
                                                    
                                                            $(divValue).empty(); 
                                                            $(divValue).remove(); values = '';
                                                    
                                                            $('.input').each(function() {
                                                                divValue = $(document.createElement('div')).css({
                                                                    padding:'5px', width:'200px'
                                                                });
                                                                values += this.value + '<br />'
                                                            });
                                                    
                                                            $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
                                                            $('body').append(divValue);
                                                    
                                                        }
                                                </script>
<!-- Fin -->