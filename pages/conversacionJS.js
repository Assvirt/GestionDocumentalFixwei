                    /* 
                    var capturandoDatoRecibe = $("#quienEscribo").val();
                    //alert(capturandoDato);
                    
                    capturandoDato = 'capturandoDatoRecibe='+capturandoDatoRecibe;
                   
                    //var url = "conversacionMensajes.php";
                    $.ajax({                        
                               type: "post",                 
                               url: "conversacionMensajes.php",                    
                               data: capturandoDato,
                               success: function(data)            
                               {
                                   alert("Ha sido ejecutada la acción.");
                                   alert(data); //recuperando las variables
                                   
                                 //alert(`Si${capturandoDato}`); //concatenar en JS  
                                 //$('#resp').html(data);
                                 //document.getElementById("resp").value = data
                                 
                               }
                    });
                     */        
                    
                    
                    
                        function recargar(){
                                $.ajax({
                                    url: "conversacionMensajes.php",
                                    type: "post",
                                    success: function(response){
                                        $("#mensajes").html(response);
                                    }
                                });
                                $.ajax({
                                    url: "conversacionMensajesUsuarios.php",
                                    type: "post",
                                    success: function(response){
                                        $("#usuarios").html(response);
                                    }
                                });
                            }
                            
                           
                           function check(e){
                               if(e.which==13){
                                    datos()
                               }
                           }
                           
                            
                        function datos(){ 
                            
                                /// se crea las variables para los id que se atrapan en los input
                                var mensaje = $("#msg").val();
                                var mensajeArchivo = $("#archivo").val();
                                var mensajeArchivo = $("#archivo").val();
                                var mensajeQuienEscribo = $("#quienEscribo").val();
                                // end
                                
                                /// cargamos los parametros que son los id de los input y se envia al otro archivo que recibe los datos por post
                                var parametros = {
                                    "mensaje" : mensaje,
                                    "mensajeArchivo" : mensajeArchivo,
                                    "mensajeQuienEscribo" : mensajeQuienEscribo
                                };
                                //// END
                                $.ajax({
                                    /// enviamos todos los datos al otro archivo que nos almacena por el metodo POST
                                    type: "post",
                                    data: parametros,
                                    url: "conversacionEnviar.php", // conversacionMensajes  conversacionEnviar
                                    // END
                                    
                                    /// recargamos el formulario y colocamos en blanco los campos
                                    success: function(response){ 
                                        $("#hide").html(response);
                                        $("#msg").val(''),
                                        $("#archivo").val(''),
                                        recargar();
                                    } 
                                    /// END
                                });
                                
                            }
                        
                            //// realizamos un intervalo de recarga
                            setInterval("recargar()",1000);
                            // END
                        
                      