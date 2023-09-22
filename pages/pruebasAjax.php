<html>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <h1>Prueba de envios AJAX</h1><br>
    
    <div id="mostrarDatos"></div>
    
                    <form method="post" onsubmit="return false">
                        <input id="nombre"  type="text" placeholder="Escriba su nombre">
                        <input id="edad" type="number" min="1" placeholder="Escriba su edad">
                        <input id="fecha" type="date">
                        <input id="foto" type="file">
                        <button id="js-consulta" >Enviar</button>
                    </form>
                    
                    
                    
                    
                    <script>
                     
                     //function recargarChat(){ //alert("Entra a la consulta constante.");
                       
                            $(document).on('click', '#js-consulta', function(e){ 
                            	e.preventDefault();
                            	var nombre = $('#nombre').val(),
                            	    edad = $('#edad').val(),
                            	    fecha = $('#fecha').val(),
                            	    foto = $('#foto').val();
                            	
                            	    /// imprimir captura de datos
                            	    /*
                            	    alert(nombre);
                            	    alert(edad);
                            	    alert(fecha);
                            	    alert(foto);
                            	    */
                            	    /// end
                            	
                                $.ajax({
                            		url: 'pruebasAjaxJS.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { nombre:nombre }, 
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(lista){
                            				$('#mostrarDatos').html(lista);
                            		}
                            	}); 
                            });
                        // END    
                        
                        // simulamos el click en el botón del formulario para traer los datos 
                        
                           /* $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#js-consulta").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#js-consulta').on('click',function() {
                               // console.log('action');
                              });
                            }); */
                          
                     //}
                     //setInterval("recargarChat()",1000);
                        // END
                    </script>  
</html>