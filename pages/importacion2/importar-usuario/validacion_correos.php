<script> 
     window.onload=function(){
         //alert("Importado con éxito");
         document.forms["miformularioCorreos"].submit();
     }
</script>
                                                 
<form name="miformularioCorreos" action="correos" method="POST" onsubmit="procesar(this.action);" >
    <input type="hidden" name="validacionAgregar" value="1">
</form> 
<br>
    <center>
                            <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div class="preloader"></div> Cargando
                        </center> 
                        <!-- redireccionamos al evento correo, para evitar que se quede en correos-->