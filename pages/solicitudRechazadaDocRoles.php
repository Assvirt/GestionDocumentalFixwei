<script> 
                     window.onload=function(){
                        // document.forms["envioRechazado"].submit();
                     }
                     setTimeout(clickbuttonArchivoPerfil, 2000); 
                     function clickbuttonArchivoPerfil() { 
                        document.forms["envioRechazado"].submit();
                     }
                </script>
                 
                <form name="envioRechazado" action="solicitudRechazada" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $_POST['idSolicitud']; ?>">
                    <input type="hidden" name='idDoc' value='<?php echo $_POST['idDoc'];?>'>
                    <input type="hidden" name="solicitud" value="<?php echo $_POST['solicitud']; ?>">
                    <input type="hidden" value="<?php echo $_POST['comentarios'];?>" class="form-control" id="comentarios2"  name="comentarios" >
                    <!--<input type="submit" >-->
                </form>
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