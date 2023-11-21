 <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <?php
                    if($foto != NULL){
                    ?>
                      <img class="profile-user-img img-fluid img-circle" src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>"  alt="User profile picture">
                    <?php
                    }else{  
                    ?>
                    <img class="profile-user-img img-fluid img-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU"  alt="User profile picture">
                    <?php
                    }
                    ?>
                </div>

                <h3 class="profile-username text-center"><?php echo $nombres." ".$apellidos; ?></h3>
                <?php
                require 'conexion/bd.php';
                    //////////// datos de los cargos
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreCargo= $row['nombreCargos'];
                    $nivelCargo= $row['nivelCargo'];
                    
                    //////////// datos de lider
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$lider'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreLider= $row['nombreCargos'];
                    //$nivelCargo= $row['nivelCargo'];
                    
                    //////////// datos del nivel del cargo
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM nivelcargo WHERE id='$nivelCargo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombreNivelCargo= $row['nivelCargo'];
                    
                ?>
                <p class="text-muted text-center"><?php ///echo $nombreCargo; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Cargo</b> <a class="float-right"><?php echo $nombreCargo; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Nivel cargo</b> <a class="float-right"><?php echo $nombreNivelCargo; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Líder</b> <a class="float-right"><?php if($nombreLider != NULL){ echo $nombreLider; }else{ echo 'N/A'; } ?></a>
                  </li>
                  <li class="list-group-item">
                      <?php
                      $idProcesoUsuario;
                      $nombreProcesoPerfil = $mysqli->query("SELECT * FROM procesos WHERE id ='$idProcesoUsuario'")or die(mysqli_error());
                      $col3ProcesoPerfil = $nombreProcesoPerfil->fetch_array(MYSQLI_ASSOC);
                      ?>
                      <b>Proceso</b> <a class="float-right"><?php echo $col3ProcesoPerfil['nombre']; ?></a>
                  </li>
                  <li  class="list-group-item">
                    <?php
                    if($root == 1){}else{
                    ?>  
                    <button Onclick="window.location='mensajeria'" class="btn btn-block btn-info btn-sm float-right"> <!-- chatValiando -->
                        <b>Chat</b>
                            <span id="notificacionChat"></span> 
                    </button> 
                    <?php
                    }
                    ?>
                    <script>
                      function recargar(){
                          $.ajax({
                                    url: "notificacionChatJs.php",
                                    type: "post",
                                    success: function(response){
                                        $("#notificacionChat").html(response);
                                    }
                                });
                      }
                            
                            //// realizamos un intervalo de recarga
                            setInterval("recargar()",1000);
                            // END
                      </script>
                  </li>
                </ul>

               <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>

<!-- mis pendientes -->
             <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                

                <h3 class="profile-username text-center">MIS PENDIENTES</h3>
                <p class="text-muted text-center"><?php ///echo $nombreCargo; ?></p>
                   <style>
                        ul {
                            padding:0px;
                        }
                        ul, li {
                            list-style:none;
                        }
                        .menu li ul {
                            display:none;
                        }
                        
                        .menu li:hover ul {
                            display:block;
                        }
                        .menu li {
                            position:relative;
                        }
                        .menu li a:hover {
                            color:red;
                        }
                    </style> 
                    <?php
                            include_once'menuGrupos.php';
                    
                    //if($menuPermisoListarSolicitudDocumentosPendientes == TRUE && $menuPermisoListarCreacionDocumentalPendientes == TRUE){
                    ?>
                    <div class="card card-primary collapsed-card">
                    
                        
                        
                      <div class="card-header">
                        <h3 class="card-title"><b>Gesti&oacute;n Documental</b></h3>
                                    <?php
                                        error_reporting(E_ERROR);
                                        ///////////// se trae el cargo del usuario
                                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$sesion'");
                                        $row = $query->fetch_array(MYSQLI_ASSOC);
                                        $cargoConteo= $row['cargo'];
                                        $consultaCedula= $row['cedula'];
                                        $consultaIdLider= $row['lider'];
                                        /////////// fin del proceso
                                        //////////conteo de solicitudes
                                        
                                        
                                        $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                                        //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                        while($grupoUsuario = $consultaGrupos->fetch_array()){
                                        $idGrupo=$grupoUsuario['idGrupo'];
                                        
                                            $consultaGruposNombreId = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo' ")or die(mysqli_error());
                                            $grupoUsuarioNombreId = $consultaGruposNombreId->fetch_array(MYSQLI_ASSOC);
                                            $idGrupoValidando=$grupoUsuarioNombreId['id'];
                                            $nombreGrupo=$grupoUsuarioNombreId['nombre'];
                                        
                                            $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='solicitudDocumentos' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                                            $grupoUsuarioNotificacion['plataforma'];
                                            if($grupoUsuarioNotificacion['plataforma']){
                                                 $validandoGrupo+=$grupoUsuarioNotificacion['plataforma']; 
                                            }else{
                                                //echo 'conteo: 0'; echo '<br>';
                                            }
                                        }
                                        
                                        $validandoGrupo;
                                        
                                        /// solicitud documento creacion, actualizacion, eliminacion
                                            //if($validandoGrupo >= '1'){
                                             
                                             
                                             
                                                $query = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo'   "); //AND estado IS NULL AND plataformaH='1'
                                                //$row = $query->fetch_array(MYSQLI_ASSOC);
                                                $conteoPorSiacaso='1';
                                                while($row = $query->fetch_array()){
                                                           
                                                           if($row['estado'] == null || $row['estado'] == 'Aprobado'){
                                    		                     
                                    		                 }else{
                                    		                     continue;
                                    		                 }
                                    		                
                                    		               if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                                           
                                                           
                                                           
                                                      $nombrecargoConteo=$conteoPorSiacaso++;
                                                }
                                              
                                                
                                                $sql2= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE QuienAprueba='$cc' AND estado='Rechazado' AND regresa='1'  "); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		    $contadorRegresoSolicitud='0';
                                    		    while($row = $sql2->fetch_assoc()){
                                    		           $contadorRegresoSolicitud++;     
                                    		    }  
                                                
                                            //}else{
                                            //    $nombrecargoConteo=0;
                                            //}
                                            
                                            if($validandoGrupo >= '1'){
                                                $nombrecargoConteoActualizacion=0;
                                                /*
                                                $queryActualizacoin = $mysqli->query("SELECT count(*) FROM solicitudDocumentos WHERE tipoSolicitud='2' AND encargadoAprobar='$cargoConteo' AND estado='Aprobado' ");
                                                $rowAct = $queryActualizacoin->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteoActualizacion= $rowAct['count(*)'];
                                                */
                                            }else{
                                                $nombrecargoConteoActualizacion=0;
                                            }
                                            
                                            if($validandoGrupo >= '1'){
                                                $nombrecargoConteoEliminacion=0;
                                                /*
                                                $queryEliminacion = $mysqli->query("SELECT count(*) FROM solicitudDocumentos WHERE tipoSolicitud='3' AND encargadoAprobar='$cargoConteo' AND estado='Aprobado' ");
                                                $rowEliminacion = $queryEliminacion->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteoEliminacion= $rowEliminacion['count(*)'];
                                                */
                                            }else{
                                                $nombrecargoConteoEliminacion=0;
                                            }
                                        /// END
                                        
                                        /// documento rechazado
                                            //if($validandoGrupo >= '1'){
                                                $query = $mysqli->query("SELECT count(*) FROM solicitudDocumentos WHERE quienSolicita='$sesion' AND estado='Rechazado'  AND rechazoSolicitud IS NULL AND regresa IS NULL OR regresa = '0' "); //AND plataformaH='1'
                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteoRechazado= $row['count(*)'];
                                            //}else{
                                            //    $nombrecargoConteoRechazado=0;
                                            //}
                                        // END   
                                            
                                            
                                            
                                            ///////////////// esta es para la funci��n de las notificaciones de creaci��n, aprobaci��n y rechazo
                                            $consultaGrupos2 = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                                            while($grupoUsuario2 = $consultaGrupos2->fetch_array()){
                                            $idGrupo2=$grupoUsuario2['idGrupo'];
                                        
                                            $consultaGruposNombreId2 = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo2' ")or die(mysqli_error());
                                            $grupoUsuarioNombreId2 = $consultaGruposNombreId2->fetch_array(MYSQLI_ASSOC);
                                            $idGrupoValidando2=$grupoUsuarioNombreId2['id'];
                                            $nombreGrupo=$grupoUsuarioNombreId2['nombre'];
                                        
                                            $consultaGruposNotificacion2 = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando2' AND formulario='creacionDoc' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacion2 = $consultaGruposNotificacion2->fetch_array(MYSQLI_ASSOC);
                                            $grupoUsuarioNotificacion2['plataforma'];
                                            if($grupoUsuarioNotificacion2['plataforma']){
                                                 $validandoGrup2o+=$grupoUsuarioNotificacion2['plataforma']; 
                                            }else{
                                                //echo 'conteo: 0'; echo '<br>';
                                            }
                                        }
                                        
                                        $validandoGrup2o;
                                        
                                        //if($validandoGrup2o >= '1'){
                                                $query = $mysqli->query("SELECT * FROM documento  "); //WHERE plataformaH='1'
                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteo2= $row['count(*)'];
                                        //    }else{
                                        //        $nombrecargoConteo2=0;
                                        //    }
                                            /////////////////////////////////
                                        ///////// fin del proceso
                                    
                                    
                                     ////////////////////////////----------------------------------------------------------------------------------------------- Inicia elaboraciones 
                                    //////////// los que elaboran EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                                    ///////////// se trae la tabla de documento
                                     
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Pendiente'  "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1' AND plataformaH='1'
                                        
                                        $conteo = 0;
                                        $conteoC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDElaborador =  json_decode($row['elabora']);
                                        $longitud = count($personalIDElaborador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDElaborador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDElaborador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteo++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cnc = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cnc > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoC++;
                                                    }
                                                }
                                            } 
                		                }
                		                
                		               // if($validandoGrup2o >= 1){ 
                		                    $conteo;
                		                    $conteoC;
                		                //}else{
                		                //    $conteo='0';
                		                //    $conteoC='0';
                		                //}
                		           
                                    //////// fin proceso de elaboracion EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                                    
                                    //////////// los que elaboran en acutalizar AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                    ///////////// se trae la tabla de documento
                                    
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Pendiente'  "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1' AND plataformaH='1'
                                        
                                        $conteoActualizar = 0;
                                        $conteoCActualizar = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDElaborador =  json_decode($row['elaboraActualizar']);
                                        $longitud = count($personalIDElaborador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDElaborador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDElaborador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoActualizar++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cnc = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cnc > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoCActualizar++;
                                                    }
                                                }
                                            } 
                		                }
                		                
                		               // if($validandoGrup2o >= 1){ 
                		                    $conteoActualizar;
                		                    $conteoCActualizar;
                		               // }else{
                		               //     $conteoActualizar='0';
                		               //     $conteoCActualizar='0';
                		               // }
                		           
                                    //////// fin proceso de elaboracion del actualizar  AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                    
                                    
                                    //////////// los que elaboran en acutalizar AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                    ///////////// se trae la tabla de documento
                                    
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Pendiente' "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1'  AND plataformaH='1'
                                        
                                        $conteoEliminar = 0;
                                        $conteoCEliminar = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDElaborador =  json_decode($row['elaboraElimanar']);
                                        $longitud = count($personalIDElaborador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDElaborador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDElaborador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoEliminar++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cnc = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cnc > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoCEliminar++;
                                                    }
                                                }
                                            } 
                		                }
                		                
                		               // if($validandoGrup2o >= 1){ 
                		                    $conteoEliminar;
                		                    $conteoCEliminar;
                		               // }else{
                		               //     $conteoEliminar='0';
                		               //     $conteoCEliminar='0';
                		               // }
                		           
                                    //////// fin proceso de elaboracion del eliminar  DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDddddd
                                    
                                    
                                    
                                    ////////////////////////////----------------------------------------------------------------------------------------------- Fin elaboraciones 
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    //////////// los que revisan --------------------------------------------------------------------------------------------- Revisar
                                    ///////////// EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Elaborado'  "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1' AND plataformaHRevisa='1'
                                        
                                        $conteoRC = 0;
                                        $conteoRCC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDRevisar =  json_decode($row['revisa']);
                                        $longitud = count($personalIDRevisar);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDRevisar as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDRevisar[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRC++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRCC++;
                                                    }
                                                }
                                            } 
                		                }
                		           //////////////// EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                		           
                		           ///////////// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Elaborado'  "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1' AND plataformaHRevisa='1'
                                        
                                        $conteoRCActualizar = 0;
                                        $conteoRCCActualizar = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDRevisar =  json_decode($row['revisaActualizar']);
                                        $longitud = count($personalIDRevisar);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDRevisar as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDRevisar[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRCActualizar++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRCCActualizar++;
                                                    }
                                                }
                                            } 
                		                }
                		           //////////////// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                		           
                		           
                		           ///////////// DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Elaborado'  "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1' AND plataformaHRevisa='1'
                                        
                                        $conteoRCElimina = 0;
                                        $conteoRCCElimina = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDRevisar =  json_decode($row['revisaElimanar']);
                                        $longitud = count($personalIDRevisar);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDRevisar as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDRevisar[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRCElimina++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRCCElimina++;
                                                    }
                                                }
                                            } 
                		                }
                		           //////////////// DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDdd
                                    //////// ---------------------------------------------------------------------------------------------------------------------fin proceso de revisan
                                    
                                    
                                    
                                    
                                    
                                    
                                    //////////// ----------------------------------------------------------------------------------------------------------------- los que aprueban 
                                    //////////// EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Revisado'  "); //SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                        
                                        $conteoRA = 0;
                                        $conteoRAC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDAprobador =  json_decode($row['aprueba']);
                                        $longitud = count($personalIDAprobador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDAprobador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDAprobador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRA++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRAC++;
                                                    }
                                                }
                                            } 
                		                }
                		            /////////// EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                		            
                		            //////////// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Revisado'  "); //SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                        
                                        $conteoRAActualizar = 0;
                                        $conteoRACActualizar = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDAprobador =  json_decode($row['apruebaActualizar']);
                                        $longitud = count($personalIDAprobador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDAprobador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDAprobador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRAActualizar++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRACActualizar++;
                                                    }
                                                }
                                            } 
                		                }
                		            /////////// AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAa
                		            
                		            
                		            //////////// DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDddd
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Revisado'  "); //SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                        
                                        $conteoRAElimina = 0;
                                        $conteoRACElimina = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalIDAprobador =  json_decode($row['apruebaElimanar']);
                                        $longitud = count($personalIDAprobador);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalIDAprobador as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalIDAprobador[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    //echo $nombreE = $columna['nombres'];
                                                    
                                                    //echo $cadena_formateada = trim($nombreE);
                                                    $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRAElimina++;
                                                    }
                                                    //$conteo++;
                                                    
                                                }
                                             
                                            }else{
                                                ////////////// traer conteo de cargos
                                                for($i=0; $i<$longitud; $i++){
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombrecargo);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRACElimina++;
                                                    }
                                                }
                                            } 
                		                }
                		            /////////// DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDdddd
                                    //////// fin proceso de aprueban
                                    
                                //// agregaos le contador de notificación para la visualización de cantidades desde revisión documental
                                
                                $contadorRevisionDOcumental=0;
                                $contadorRevisionDOcumentalB=0;
                                $sqlNotificaciones= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado IS NULL"); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                while($row = $sqlNotificaciones->fetch_assoc()){
                                    		                
                                    		                /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT documento.*, comnetariosRevision.* FROM documento INNER JOIN comnetariosRevision WHERE comnetariosRevision.idDocumento='".$row['nombreDocumento']."' AND documento.revisado='1' AND documento.vigente='1' ");
                                    		                $extraerNombreNotidicacion=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		               
                                    		                
                                    		                
                                    		                    '<br>Notificar a: '.$notificarEnviarNotificacion=$extraerNombreNotidicacion['notificar'];
                                    		                    '<br>Notificar Quien: '.$notificarQuienEnviarNotificaion=$extraerNombreNotidicacion['notificarQuien'];
                                    		                    if($notificarEnviarNotificacion == 'usuarios'){
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviarNotificaion);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){ // echo 'Entra: '.$arrayNotificar[$i];
                                                                        $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayNotificar[$i]'  ")or die(mysqli_error()); //AND cedula='$cc'
                                                                        while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                                        $nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                                            if($usuariosCargo['cedula'] == $cc){ //echo ' - suma - ';
                                                                                $confirmandoIdDocumentoSoloMostrarNotificacionNotificaciones=1;
                                                                                $contadorRevisionDOcumental++;
                                                                            }
                                                                        }
                                                                     }
                                    		                    }
                                    		                    if($notificarEnviarNotificacion == 'cargos'){
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviarNotificaion);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){   'Entra: '.$arrayNotificar[$i];
                                                                        $queryNombresNotificacioness = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$arrayNotificar[$i]' ");
                                                                        $nombresNotificacioness = $queryNombresNotificacioness->fetch_array(MYSQLI_ASSOC); 
                                                                        $extraerUsuariosNotificaciones = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresNotificacioness['id_cargos']."'  ")or die(mysqli_error());
                                                                        while($usuariosCargoNotificaciones = $extraerUsuariosNotificaciones->fetch_array()){
                                                                        $nombredelUsuario=utf8_encode($usuariosCargoNotificaciones['nombres'].' '.$usuariosCargoNotificaciones['apellidos']);
                                                                            if($usuariosCargoNotificaciones['cargo'] == $cargo){
                                                                                $confirmandoIdDocumentoSoloMostrarNotificacionNotificaciones=1;
                                                                                $contadorRevisionDOcumentalB++;
                                                                            }
                                                                        }
                                                                     }
                                    		                    }
                                    		                if($extraerNombreNotidicacion['idDocumento'] == $row['nombreDocumento'] && $confirmandoIdDocumentoSoloMostrarNotificacionNotificaciones == 1){  //echo 'Debe contar aca';
                                    		                
                                    		                }else{
                                    		                    continue;
                                    		                }
                                    		                
                                    		                
                                    		                 if($row['estado'] == null || $row['estado'] == 'Aprobado'){
                                    		                     
                                    		                 }else{
                                    		                     continue;
                                    		                 }
                                    		                
                                    		                if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     
                                    		                     $nombreDocumento=$idDocumento=$row['nombreDocumento2'];
                                    		                     
                                    		                }
                                    		               
                                                	    
                                                        }
                                //// END
                                      ' - Usyua: '.$contadorRevisionDOcumental;
                                      '<br>Cargo: '.$contadorRevisionDOcumentalB;
                                ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php echo $suma=$nombrecargoConteo+$nombrecargoConteoActualizacion+$nombrecargoConteoEliminacion+$nombrecargoConteoRechazado+$conteo+$conteoC+$conteoRC+$conteoRCC+$conteoRA+$conteoRAC+$conteoActualizar+$conteoCActualizar+$conteoRCActualizar+$conteoRCCActualizar+$conteoRAActualizar+$conteoRACActualizar+$conteoEliminar+$conteoCEliminar+$conteoRCElimina+$conteoRCCElimina+$conteoRAElimina+$conteoRACElimina+$contadorRegresoSolicitud+$contadorRevisionDOcumentalB+$contadorRevisionDOcumental; ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      
                      
                      
                      
                      
                      <!-- /.card-header -->
                      <div class="card-body">
                            
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <?php 
                                    if($menuPermisoListarSolicitudDocumentosPendientes == TRUE){
                                    ?>
                                    <li class="list-group-item"><b>Solicitudes rechazadas </b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $nombrecargoConteoRechazado ?></a>
                                        <ul>
                                            <!-- Alertar para cuando la solicitud es rechazada -----------------  -->
                                            <?php 
                                                
                                                ///// la validacion la usamos para mostrar o no la informaci��n de las notificaciones de solicitud
                                              //  if($validandoGrupo >= 1){
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE quienSolicita='$sesion' AND estado='Rechazado'  AND rechazoSolicitud IS NULL AND regresa IS NULL OR regresa = '0' "); //AND plataformaH='1'
                                    		            while($row = $sql->fetch_assoc()){
                                    		                
                                    		                 /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT * FROM documento WHERE id_solicitud='".$row['id']."' ");
                                    		                $extraerNombre=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                $enviarNombreDocyumentoActual=$extraerNombre['nombres'];
                                    		                
                                    		                
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$nombreDocumento=$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$nombreDocumento =$row['nombreDocumento2'];
                                    		                     
                                    		                     /* $nombreDocumento
                                    		                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    		                     $nombreDocumento = $mysqli->query("SELECT nombres FROM `documento` WHERE id = '$idDocumento' ");
                                                                 $documentoC = $nombreDocumento->fetch_array(MYSQLI_ASSOC);
                                                                 $nombreDocumento = $documentoC['nombres'];*/
                                    		                }
                                    		                
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <a style="color:red;text-decoration:none;" class="float-right">
                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </a>
                                                            <b>*</b><a style="color:black;text-decoration:none;" ><font color="red"><?php echo $nombreDocumento; ?></font><a/>
                                                            <br>(<?php echo $ImprimirTipoSolicitud; ?>)<br>
                                                            
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" readonly name="rechazoAplicar" value="1">
                                                            
                                                        </form>
                                                    </li>   
                                                    
                                                    <?php
                                                        }
                                                //}  //// fin de la validaci��n del if
                                            ?>
                                        </ul>
                                    </li>
                                    
                                    <li class="list-group-item"><b>Solicitud </b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $conteoSolicitudes=$nombrecargoConteo+$nombrecargoConteoActualizacion+$nombrecargoConteoEliminacion+$contadorRegresoSolicitud+$contadorRevisionDOcumentalB+$contadorRevisionDOcumental; //$nombrecargoConteoRechazado ?></a>
                                        <ul><?php 
                                                
                                               
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo'  "); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		            while($row = $sql->fetch_assoc()){
                                    		                
                                    		                /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT * FROM documento WHERE id_solicitud='".$row['id']."' ");
                                    		                $extraerNombre=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                $enviarNombreDocyumentoActual=$extraerNombre['nombres'];
                                    		                
                                    		                 if($row['estado'] == null || $row['estado'] == 'Aprobado'){
                                    		                     
                                    		                 }else{
                                    		                     continue;
                                    		                 }
                                    		                
                                    		                if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     
                                    		                     $nombreDocumento=$idDocumento=$row['nombreDocumento2'];
                                    		                     /*
                                    		                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    		                     $nombreDocumento = $mysqli->query("SELECT nombres FROM `documento` WHERE id = '$idDocumento' ");
                                                                 $documentoC = $nombreDocumento->fetch_array(MYSQLI_ASSOC);
                                                                 $nombreDocumento = $documentoC['nombres'];
                                                                 */
                                    		                }
                                    		               
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <?php if($tipoSolicitud == 1){
                                    		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 } 
                                    		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                    		                 ?>
                                    		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </a>
                                    		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDocumento; ?></a><br><br>
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" readonly name="tipoSolicitud" value="<?php echo $row['tipoSolicitud'];?>">
                                                        </form>
                                                    </li>
                                                    
                                                    
                                                    <?php
                                                        } /// fin notificaci��n para la creaci��n
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql2= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE QuienAprueba='$cc' AND estado='Rechazado' AND regresa='1'  "); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		            while($row = $sql2->fetch_assoc()){
                                    		                
                                    		                
                                    		                 /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT * FROM documento WHERE id_solicitud='".$row['id']."' ");
                                    		                $extraerNombre=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                $enviarNombreDocyumentoActual=$extraerNombre['nombres'];
                                    		                
                                    		                if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    //continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    //continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   //continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;//$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$nombreDocumento=$idDocumento=$row['nombreDocumento2'];
                                    		                    
                                    		                }
                                    		               
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <?php if($tipoSolicitud == 1){
                                    		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 } 
                                    		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                    		                 ?>
                                    		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </a>
                                    		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo '<font color="black"><b><i>Solicitud regresada</i></b></font><br>'.$nombreDocumento; ?> </a><br><br>
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" readonly name="documentoRegresa" value="1">
                                                        </form>
                                                    </li>
                                                    
                                                    
                                                    <?php
                                                        }  
                                                        
                                                        /*
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado IS NULL "); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		            while($row = $sql->fetch_assoc()){
                                    		                
                                    		                /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT documento.*, comnetariosRevision.*, comnetariosRevision.id AS idComentariosRevision FROM documento INNER JOIN comnetariosRevision WHERE comnetariosRevision.idDocumento='".$row['nombreDocumento']."' AND documento.revisado='1' AND documento.vigente='1' ");
                                    		                $extraerNombre=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                $enviarNombreDocyumentoActual=$extraerNombre['nombres'];
                                    		                
                                    		                 //echo $extraerNombre['idComentariosRevision'].' - ';
                                    		                     '<br>Notificar a: '.$notificarEnviar=$extraerNombre['notificar'];
                                    		                     '<br>Notificar Quien: '.$notificarQuienEnviar=$extraerNombre['notificarQuien'];
                                    		                
                                    		                    if($notificarEnviar == 'usuarios'){
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviar);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){   'Entra: '.$arrayNotificar[$i];
                                                                        $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayNotificar[$i]' ")or die(mysqli_error()); // AND cedula='$cc'
                                                                        while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                                        $nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                                            if($usuariosCargo['cedula'] == $cc){ //echo '<br>identificado';
                                                                                $idUsuarioMostrarRD=$usuariosCargo['id']; 
                                                                                $confirmandoIdDocumentoSoloMostrar=1;
                                                                            }
                                                                        }
                                                                     }
                                    		                    }
                                    		                    if($notificarEnviar == 'cargos'){
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviar);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){  'Entra: '.$arrayNotificar[$i];
                                                                        $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$arrayNotificar[$i]' ");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombres['id_cargos']."'  ")or die(mysqli_error());
                                                                        while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                                        $nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                                        $confirmandoIdDocumentoSoloMostrar=1;
                                                                        }
                                                                     }
                                    		                    }
                                    		                    
                                    		                    //echo '<br>id: '.$extraerNombre['idDocumento'];
                                    		                    //echo '<br>id 2: '.$row['nombreDocumento'];
                                    		                    //echo '<br>act: '.$confirmandoIdDocumentoSoloMostrar;
                                    		                    echo $idUsuarioMostrarRD; echo '<br>';
                                    		                    
                                    		                if($extraerNombre['idDocumento'] == $row['nombreDocumento'] && $confirmandoIdDocumentoSoloMostrar == 1){  
                                    		                    //echo '<br>Debe entrar aca';
                                    		                    echo '<br>identificado';
                                    		                    
                                    		                    
                                    		                    
                                    		                    
                                    		                }else{
                                    		                    continue;
                                    		                }
                                    		                
                                    		                
                                    		                 if($row['estado'] == null || $row['estado'] == 'Aprobado'){
                                    		                     
                                    		                 }else{
                                    		                     continue;
                                    		                 }
                                    		                
                                    		                if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     
                                    		                     $nombreDocumento=$idDocumento=$row['nombreDocumento2'];
                                    		                     
                                    		                }
                                    		               
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <?php if($tipoSolicitud == 1){
                                    		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 } 
                                    		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                    		                 ?>
                                    		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </a>
                                    		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDocumento.'<br><font color="green">(revisión documental)</font>'; ?></a><br><br>
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" name="revisionDocumental" value="1" >
                                                            <input type="hidden" readonly name="tipoSolicitud" value="<?php echo $row['tipoSolicitud'];?>">
                                                        </form>
                                                    </li>
                                                    
                                                    
                                                    <?php
                                                        }
                                                        */
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql= $mysqli->query("SELECT * FROM documento WHERE revisado='1' AND vigente='1' "); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		            while($row = $sql->fetch_assoc()){
                                    		                
                                    		                $ConsultaNmbre=$mysqli->query("SELECT * FROM comnetariosRevision  WHERE idDocumento='".$row['id']."' ");
                                    		                $extraerNombre=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                '<br>Notificar a: '.$notificarEnviar=$extraerNombre['notificar'];
                                    		                '<br>Notificar Quien: '.$notificarQuienEnviar=$extraerNombre['notificarQuien'];
                                    		                     
                                    		                if($enviarNombreDocyumentoActual=$extraerNombre['id'] != NULL){
                                    		                    
                                    		                }else{
                                    		                    continue;
                                    		                }
                                    		                
                                    		                if($notificarEnviar == 'usuarios'){
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviar);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){   
                                                                         
                                                                         'Entra: '.$arrayNotificar[$i]; 
                                                                         '<br>';
                                                                        
                                                                        if($idparaChat == $arrayNotificar[$i]){
                                                                            $enviaridRD=$arrayNotificar[$i];
                                                                            $confirmandoIdDocumentoSoloMostrar=1;
                                                                            $ConsultaNmbreSolicitudDocumental=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='".$row['id']."' "); //estado IS NULL
                                    		                                $extraerNombreSolicitudDocumental=$ConsultaNmbreSolicitudDocumental->fetch_array(MYSQLI_ASSOC);
                                                                            	?>
                                                                                <li>
                                                                                    <form action="solicitudDocumentosSeguimiento" method="POST">
                                                                                        <?php if($tipoSolicitud == 1){
                                                                		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 }elseif($tipoSolicitud == 2){
                                                                		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 }elseif($tipoSolicitud == 3){
                                                                		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 } 
                                                                		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                                                		                 ?>
                                                                		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                                            <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                        </a>
                                                                		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $row['nombres'].'<br><font color="green">(revisión documental)</font>'; ?></a><br><br>
                                                                                        <input type="hidden" readonly name="id" value="<?php echo $extraerNombreSolicitudDocumental['id'];?>">
                                                                                        <input type="hidden" name="revisionDocumental" value="1" >
                                                                                        <input type="hidden" readonly name="tipoSolicitud" value="<?php '2';//echo $row['tipoSolicitud'];?>">
                                                                                    </form>
                                                                                </li>
                                                                                
                                                                                
                                                                                <?php
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                     }
                                    		                }
                                    		                if($notificarEnviar == 'cargos'){ 
                                    		                
                                    		                        $arrayNotificar = json_decode($notificarQuienEnviar);
                                                                    $longitudNotificar = count($arrayNotificar);
                                                                     for($i=0; $i<$longitudNotificar; $i++){   
                                                                         
                                                                         'Entra: '.$arrayNotificar[$i]; 
                                                                         '<br>';
                                                                        
                                                                        if($cargo == $arrayNotificar[$i]){
                                                                            $enviaridRD=$arrayNotificar[$i];
                                                                            $confirmandoIdDocumentoSoloMostrar=1;
                                                                            $ConsultaNmbreSolicitudDocumental=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='".$row['id']."' "); //estado IS NULL
                                    		                                $extraerNombreSolicitudDocumental=$ConsultaNmbreSolicitudDocumental->fetch_array(MYSQLI_ASSOC);
                                                                            	?>
                                                                                <li>
                                                                                    <form action="solicitudDocumentosSeguimiento" method="POST">
                                                                                        <?php if($tipoSolicitud == 1){
                                                                		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 }elseif($tipoSolicitud == 2){
                                                                		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 }elseif($tipoSolicitud == 3){
                                                                		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                                                		                 } 
                                                                		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                                                		                 ?>
                                                                		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                                            <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                        </a>
                                                                		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $row['nombres'].'<br><font color="green">(revisión documental)</font>'; ?></a><br><br>
                                                                                        <input type="hidden" readonly name="id" value="<?php echo $extraerNombreSolicitudDocumental['id'];?>">
                                                                                        <input type="hidden" name="revisionDocumental" value="1" >
                                                                                        <input type="hidden" readonly name="tipoSolicitud" value="<?php '2';//echo $row['tipoSolicitud'];?>">
                                                                                    </form>
                                                                                </li>
                                                                                
                                                                                
                                                                                <?php
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                     }
                                    		                
                                    		                    
                                    		                }
                                    		                
                                    		            }
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sqlLider= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado IS NULL"); //AND estado='Aprobado' OR AND plataformaH='1' estado IS NULL
                                    		            while($row = $sqlLider->fetch_assoc()){
                                    		                
                                    		                /// reeemplazamos el nnombre
                                    		                $ConsultaNmbre=$mysqli->query("SELECT documento.*, comnetariosRevision.* FROM documento INNER JOIN comnetariosRevision WHERE comnetariosRevision.idDocumento='".$row['nombreDocumento']."' AND documento.revisado='1' AND documento.vigente='1' ");
                                    		                $extraerNombreLider=$ConsultaNmbre->fetch_array(MYSQLI_ASSOC);
                                    		                $enviarNombreDocyumentoActual=$extraerNombreLider['nombres'];
                                    		                
                                    		                
                                    		                
                                    		                    '<br>Notificar lider: '.$notificarEnviarLider=$extraerNombreLider['lider'];
                                    		                    $arrayLider = json_decode(($extraerNombreLider['lider']));
                                                                //var_dump($array);
                                                                'Cantidad: '.$longitudLider = count($arrayLider);
                                                                if($longitudLider > 0){ 
                                    		                    for($i=0; $i<$longitudLider; $i++){
                                                                    $queryNombresLideres = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$arrayLider[$i]%' ");
                                                                    $nombresLideres = $queryNombresLideres->fetch_array(MYSQLI_ASSOC); 
                                                                    
                                                                	   "*".$nombresLideres['id_cargos']."<br><br>";
                                                                	
                                                                	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresLideres['id_cargos']."' AND cedula='$cc' ")or die(mysqli_error());
                                                                    while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                                     'EL USUARIO: <b>'.$nombredelUsuario=utf8_encode($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                                      $confirmandoIdDocumentoSoloMostrarlider=1;
                                                                    }
                                                                }
                                                                }
                                    		                   
                                    		                        
                                    		                    
                                    		                if($extraerNombreLider['idDocumento'] == $row['nombreDocumento'] && $confirmandoIdDocumentoSoloMostrarlider == 1){   'Debe entrar aca';
                                    		                
                                    		                }else{
                                    		                    continue;
                                    		                }
                                    		                
                                    		                
                                    		                 if($row['estado'] == null || $row['estado'] == 'Aprobado'){
                                    		                     
                                    		                 }else{
                                    		                     continue;
                                    		                 }
                                    		                
                                    		                if($row['tipoSolicitud'] == '3' || $row['tipoSolicitud'] == '2'){
                                    		                     //// validación para mantener la notificación
                                    		                     
                                    		                     
                                    		                     if( $row['tipoSolicitud'] == '2'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."'  AND estadoActualiza IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento'] && $row['estado'] != NULL){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     if( $row['tipoSolicitud'] == '3'){ 
                                        		                     $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id='".$row['nombreDocumento']."' AND estadoElimina IS NOT NULL ");
                                            		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                            		                 $capturandoVariables=$extraerConsultaSolicitud['id'];
                                            		                 if($extraerConsultaSolicitud['id'] == $row['nombreDocumento']){
                                            		                    continue;
                                            		                 }else{
                                            		                   
                                            		                 } 
                                    		                     }
                                    		                     
                                        		               
                                        		                 /// end
                                    		                }else{
                                        		                 //// validación para mantener la notificación
                                        		                 $consltaSolicitud=$mysqli->query("SELECT * FROM `documento` WHERE id_solicitud='".$row['id']."' ");
                                        		                 $extraerConsultaSolicitud=$consltaSolicitud->fetch_array(MYSQLI_ASSOC);
                                        		                 $capturandoVariables=$extraerConsultaSolicitud['id_solicitud'];
                                        		                 if($extraerConsultaSolicitud['id_solicitud'] == $row['id']){
                                        		                   continue;
                                        		                 }else{
                                        		                     
                                        		                 } 
                                        		                 /// end
                                    		                }
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                 
                                    		                 
                                    		                 
                                    		                 if($tipoSolicitud == 1){
                                    		                     $ImprimirTipoSolicitud='Creaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     $ImprimirTipoSolicitud='Actualizaci&oacute;n de un documento';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     $ImprimirTipoSolicitud='Eliminaci&oacute;n de un documento';
                                    		                 }
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     if($enviarNombreDocyumentoActual != NULL){
                                    		                         $enviarNombreDocyumentoActual=$enviarNombreDocyumentoActual;
                                    		                     }else{
                                    		                         $enviarNombreDocyumentoActual=$row['nombreDocumento2'];
                                    		                     }
                                    		                     $nombreDocumento=$enviarNombreDocyumentoActual;
                                    		                     //$row['nombreDocumento2'];
                                    		                
                                    		                }else{
                                    		                     
                                    		                     $nombreDocumento=$idDocumento=$row['nombreDocumento2'];
                                    		                     /*
                                    		                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    		                     $nombreDocumento = $mysqli->query("SELECT nombres FROM `documento` WHERE id = '$idDocumento' ");
                                                                 $documentoC = $nombreDocumento->fetch_array(MYSQLI_ASSOC);
                                                                 $nombreDocumento = $documentoC['nombres'];
                                                                 */
                                    		                }
                                    		               
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <?php if($tipoSolicitud == 1){
                                    		                     echo '<font color="green">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 2){
                                    		                     echo '<font color="blue">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 }elseif($tipoSolicitud == 3){
                                    		                     echo '<font color="red">'.$ImprimirTipoSolicitud.'</font>';
                                    		                 } 
                                    		                 //echo 'tipo de sol: '.$row['tipoSolicitud'].'(ID1): '.$row['nombreDocumento'].' -- (ID2): '.$capturandoVariables;
                                    		                 ?>
                                    		                <a style="color:red;text-decoration:none;" class="float-right">
                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </a>
                                    		                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDocumento.'<br><font color="green">(revisión documental lider)</font>'; ?></a><br><br>
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <input type="hidden" name="revisionDocumental" value="1" >
                                                            <input type="hidden" readonly name="tipoSolicitud" value="<?php echo $row['tipoSolicitud'];?>">
                                                        </form>
                                                    </li>
                                                    
                                                    
                                                    <?php
                                                        }
                                                        
                                               
                                            ?>
                                            
                                        </ul>
                                    </li>
                                    <?php
                                    }else{ echo 'No tiene permisos para visualizar la solicitud'; }
                                    
                                    if($menuPermisoListarCreacionDocumentalPendientes == TRUE){
                                    ?>
                                    <li class="list-group-item"><b>Elaboraci&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php  echo $creacion=$conteo+$conteoC+$conteoActualizar+$conteoCActualizar+$conteoEliminar+$conteoCEliminar;   ?></a>
                                        <ul> <!-- Inicia para qui��n crea -->
                                           <?php
                                           
                                           //// inicio de la notificaci��n
                                           //if($validandoGrup2o >= 1){
                                           
                                           
                                                                //////////// los que elaboran
                                                        ///////////// se trae la tabla de documento
                                                            $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Pendiente'   "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1' AND plataformaH='1'
                                                            
                                                            $conteo = 0;
                                                            
                                                            
                                                            while($row = $sql->fetch_assoc()){
                                    		                
                                                            $personalIDElaborador =  json_decode($row['elabora']);
                                                            $longitud = count($personalIDElaborador);
                                                            
                                                            
                                                            //echo $personalID[0];
                                                            
                                                            foreach($personalIDElaborador as $dato){
                                                               // echo $dato; echo "<br>";
                                                            }
                                                            
                                                            
                                                                if($personalIDElaborador[0] == 'usuarios'){
                                                                    
                                                                    
                                                                    for($i=0; $i<$longitud; $i++){
                                                                        ///////////// para traer conteo de los usuarios
                                                                        
                                                                        $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        //echo $nombreE = $columna['nombres'];
                                                                        
                                                                        //echo $cadena_formateada = trim($nombreE);
                                                                        $cn = mysqli_num_rows($nombreuser);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT solicitud FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="revisaDocRoles" method="POST">
                                                                                    <font color="green">Creaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?></a><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                   
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                        //$conteo++;
                                                                        
                                                                    }
                                                                 
                                                                }else{
                                                                    ////////////// traer conteo de cargos
                                                                    for($i=0; $i<$longitud; $i++){
                                                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $columna['nombreCargos'];
                                                                    $cn = mysqli_num_rows($nombrecargo);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT solicitud FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="revisaDocRoles" method="POST">
                                                                                    <font color="green">Creaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?></a><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                    }
                                                                } 
                                    		                }
                                    		           
                                                        //////// fin proceso de elaboracion
                                    
                                    
                                    
                                           //} ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                            
                                        </ul> <!-- Finaliza para qui��n crea -->
                                        
                                        
                                        
                                        <ul> <!-- Inicia para qui��n actualiza -->
                                           <?php
                                           
                                           //// inicio de la notificaci��n
                                           //if($validandoGrup2o >= 1){
                                           
                                           
                                                                //////////// los que elaboran
                                                        ///////////// se trae la tabla de documento
                                                            $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Pendiente'   "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1' AND plataformaH='1'
                                                            
                                                            $conteo = 0;
                                                            
                                                            
                                                            while($row = $sql->fetch_assoc()){
                                    		                
                                                            $personalIDElaborador =  json_decode($row['elaboraActualizar']);
                                                            $longitud = count($personalIDElaborador);
                                                            
                                                            
                                                            //echo $personalID[0];
                                                            
                                                            foreach($personalIDElaborador as $dato){
                                                               // echo $dato; echo "<br>";
                                                            }
                                                            
                                                            
                                                                if($personalIDElaborador[0] == 'usuarios'){
                                                                    
                                                                    
                                                                    for($i=0; $i<$longitud; $i++){
                                                                        ///////////// para traer conteo de los usuarios
                                                                        
                                                                        $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        //echo $nombreE = $columna['nombres'];
                                                                        
                                                                        //echo $cadena_formateada = trim($nombreE);
                                                                        $cn = mysqli_num_rows($nombreuser);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                        //$conteo++;
                                                                        
                                                                    }
                                                                 
                                                                }else{
                                                                    ////////////// traer conteo de cargos
                                                                    for($i=0; $i<$longitud; $i++){
                                                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $columna['nombreCargos'];
                                                                    $cn = mysqli_num_rows($nombrecargo);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                     
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                    }
                                                                } 
                                    		                }
                                    		           
                                                        //////// fin proceso de elaboracion
                                    
                                    
                                    
                                           //} ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                            
                                        </ul> <!-- Finaliza para qui��n actualiza -->
                                        
                                        
                                        <ul> <!-- Inicia para qui��n elimina -->
                                           <?php
                                           
                                           //// inicio de la notificaci��n
                                           //if($validandoGrup2o >= 1){
                                           
                                           
                                                                //////////// los que elaboran
                                                        ///////////// se trae la tabla de documento
                                                            $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Pendiente'   "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1' AND plataformaH='1'
                                                            
                                                            $conteo = 0;
                                                            
                                                            
                                                            while($row = $sql->fetch_assoc()){
                                    		                
                                                            $personalIDElaborador =  json_decode($row['elaboraElimanar']);
                                                            $longitud = count($personalIDElaborador);
                                                            
                                                            
                                                            //echo $personalID[0];
                                                            
                                                            foreach($personalIDElaborador as $dato){
                                                               // echo $dato; echo "<br>";
                                                            }
                                                            
                                                            
                                                                if($personalIDElaborador[0] == 'usuarios'){
                                                                    
                                                                    
                                                                    for($i=0; $i<$longitud; $i++){
                                                                        ///////////// para traer conteo de los usuarios
                                                                        
                                                                        $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDElaborador[$i]' AND cedula='$sesion' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        //echo $nombreE = $columna['nombres'];
                                                                        
                                                                        //echo $cadena_formateada = trim($nombreE);
                                                                        $cn = mysqli_num_rows($nombreuser);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                        //$conteo++;
                                                                        
                                                                    }
                                                                 
                                                                }else{
                                                                    ////////////// traer conteo de cargos
                                                                    for($i=0; $i<$longitud; $i++){
                                                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDElaborador[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $columna['nombreCargos'];
                                                                    $cn = mysqli_num_rows($nombrecargo);
                                                                        
                                                                        //echo $cn; echo "<br>";
                                                                        if($cn > 0){
                                                                            /// se imprime el id
                                                                            $iddocumentoDepersonaAelaborar=$row['id'];
                                                                            $idSolicitud=$row['id_solicitud'];
                                                                            $nombreCreacion=$row['nombres'];
                                                                            
                                                                            $conteo++;
                                                                            //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                            $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                            $solicitudAelaborar = $columna['solicitud'];
                                                                            $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                    }
                                                                } 
                                    		                }
                                    		           
                                                        //////// fin proceso de elaboracion
                                    
                                    
                                    
                                           //} ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                            
                                        </ul> <!-- Finaliza para qui��n elimina -->
                                    </li>
                                    
                                    
                                    <li class="list-group-item"><b>Revisi&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $revision=$conteoRC+$conteoRCC+$conteoRCActualizar+$conteoRCCActualizar+$conteoRCElimina+$conteoRCCElimina;   ?></a>
                                        <ul>
                                    <?php
                                            
                                    //// inicio de la notificaci��n
                                          // if($validandoGrup2o >= 1){
        
                                            //////////// los que revisan
                                                ///////////// se trae la tabla de documento
                                                    $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Elaborado' "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1'   AND plataformaHRevisa='1'
                                                    
                                                    $conteo = 0;
                                                    
                                                    
                                                    while($row = $sql->fetch_assoc()){
                            		                
                                                    $personalIDRevisar =  json_decode($row['revisa']);
                                                    $longitud = count($personalIDRevisar);
                                                    
                                                    
                                                    //echo $personalID[0];
                                                    
                                                    foreach($personalIDRevisar as $dato){
                                                       // echo $dato; echo "<br>";
                                                    }
                                                    
                                                    
                                                        if($personalIDRevisar[0] == 'usuarios'){
                                                            
                                                            
                                                            for($i=0; $i<$longitud; $i++){
                                                                ///////////// para traer conteo de los usuarios
                                                                
                                                                $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                //echo $nombreE = $columna['nombres'];
                                                                
                                                                //echo $cadena_formateada = trim($nombreE);
                                                                $cn = mysqli_num_rows($nombreuser);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT solicitud FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    ?>
                                                                    
                                                                    <li>
                                                                        <form action="revisaDocRoles" method="POST">
                                                                            <font color="green">Creaci&oacute;n de un documento</font>
                                                                            <a style="color:red;text-decoration:none;" class="float-right">
                                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                            </a>
                                                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                            <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                           
                                                                        </form>
                                                                    </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                                //$conteo++;
                                                                
                                                            }
                                                         
                                                        }else{
                                                            ////////////// traer conteo de cargos
                                                            for($i=0; $i<$longitud; $i++){
                                                            $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombreCargos'];
                                                            $cn = mysqli_num_rows($nombrecargo);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT solicitud FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    ?>
                                                                    
                                                                    <li>
                                                                        <form action="revisaDocRoles" method="POST">
                                                                            <font color="green">Creaci&oacute;n de un documento</font>
                                                                            <a style="color:red;text-decoration:none;" class="float-right">
                                                                                <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                            </a>
                                                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                            <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                           
                                                                        </form>
                                                                    </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                            }
                                                        } 
                            		                }
                            		           
                                                //////// fin proceso de revisa
                                                
                                           // } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                        
                                        <!-- notificaci��n cuando el documento es actualizar -->
                                        <ul>
                                    <?php
                                            
                                    //// inicio de la notificaci��n
                                         //  if($validandoGrup2o >= 1){
        
                                            //////////// los que revisan
                                                ///////////// se trae la tabla de documento
                                                    $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Elaborado' "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1'   AND plataformaHRevisa='1'
                                                    
                                                    $conteo = 0;
                                                    
                                                    
                                                    while($row = $sql->fetch_assoc()){
                            		                
                                                    $personalIDRevisar =  json_decode($row['revisaActualizar']);
                                                    $longitud = count($personalIDRevisar);
                                                    
                                                    
                                                    //echo $personalID[0];
                                                    
                                                    foreach($personalIDRevisar as $dato){
                                                       // echo $dato; echo "<br>";
                                                    }
                                                    
                                                    
                                                        if($personalIDRevisar[0] == 'usuarios'){
                                                            
                                                            
                                                            for($i=0; $i<$longitud; $i++){
                                                                ///////////// para traer conteo de los usuarios
                                                                
                                                                $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                //echo $nombreE = $columna['nombres'];
                                                                
                                                                //echo $cadena_formateada = trim($nombreE);
                                                                $cn = mysqli_num_rows($nombreuser);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                                //$conteo++;
                                                                
                                                            }
                                                         
                                                        }else{
                                                            ////////////// traer conteo de cargos
                                                            for($i=0; $i<$longitud; $i++){
                                                            $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombreCargos'];
                                                            $cn = mysqli_num_rows($nombrecargo);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                   
                                                                                </form>
                                                                            </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                            }
                                                        } 
                            		                }
                            		           
                                                //////// fin proceso de revisa
                                                
                                           // } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                        
                                        
                                        <!-- notificaci��n cuando el documento es eliminar -->
                                        <ul>
                                    <?php
                                            
                                    //// inicio de la notificaci��n
                                          // if($validandoGrup2o >= 1){
        
                                            //////////// los que revisan
                                                ///////////// se trae la tabla de documento
                                                    $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Elaborado'  "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1'  AND plataformaHRevisa='1'
                                                    
                                                    $conteo = 0;
                                                    
                                                    
                                                    while($row = $sql->fetch_assoc()){
                            		                
                                                    $personalIDRevisar =  json_decode($row['revisaElimanar']);
                                                    $longitud = count($personalIDRevisar);
                                                    
                                                    
                                                    //echo $personalID[0];
                                                    
                                                    foreach($personalIDRevisar as $dato){
                                                       // echo $dato; echo "<br>";
                                                    }
                                                    
                                                    
                                                        if($personalIDRevisar[0] == 'usuarios'){
                                                            
                                                            
                                                            for($i=0; $i<$longitud; $i++){
                                                                ///////////// para traer conteo de los usuarios
                                                                
                                                                $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDRevisar[$i]' AND cedula='$sesion' ");
                                                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                //echo $nombreE = $columna['nombres'];
                                                                
                                                                //echo $cadena_formateada = trim($nombreE);
                                                                $cn = mysqli_num_rows($nombreuser);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                                //$conteo++;
                                                                
                                                            }
                                                         
                                                        }else{
                                                            ////////////// traer conteo de cargos
                                                            for($i=0; $i<$longitud; $i++){
                                                            $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDRevisar[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombreCargos'];
                                                            $cn = mysqli_num_rows($nombrecargo);
                                                                
                                                                //echo $cn; echo "<br>";
                                                                if($cn > 0){
                                                                    /// se imprime el id
                                                                    $iddocumentoDepersonaAelaborar=$row['id'];
                                                                    $idSolicitud=$row['id_solicitud'];
                                                                    $nombreCreacion=$row['nombres'];
                                                                    $conteo++;
                                                                    //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                    $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    $solicitudAelaborar = $columna['solicitud'];
                                                                    $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                     
                                                                                </form>
                                                                            </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                            }
                                                        } 
                            		                }
                            		           
                                                //////// fin proceso de revisa
                                                
                                           // } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li class="list-group-item"><b>Aprobaci&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php  echo $aprobacion=$conteoRA+$conteoRAC+$conteoRAActualizar+$conteoRACActualizar+$conteoRAElimina+$conteoRACElimina;   ?></a>
                                        <ul>
                                            <?php
                                            
                                            //// inicio de la notificaci��n
                                         //  if($validandoGrup2o >= 1){
                                            
                                            
                                            
                                                    //////////// los que aprueban
                                                    ///////////// se trae la tabla de documento
                                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Revisado' "); /// SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                                        
                                                        $conteo = 0;
                                                        
                                                        
                                                        while($row = $sql->fetch_assoc()){
                                		                
                                                        $personalIDAprobador =  json_decode($row['aprueba']);
                                                        $longitud = count($personalIDAprobador);
                                                        
                                                        
                                                        //echo $personalID[0];
                                                        
                                                        foreach($personalIDAprobador as $dato){
                                                           // echo $dato; echo "<br>";
                                                        }
                                                        
                                                        
                                                            if($personalIDAprobador[0] == 'usuarios'){
                                                                
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    ///////////// para traer conteo de los usuarios
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $nombreE = $columna['nombres'];
                                                                    
                                                                    //echo $cadena_formateada = trim($nombreE);
                                                                    $cn = mysqli_num_rows($nombreuser);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud'  ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        ?>
                                                                        
                                                                        <li>
                                                                            <form action="revisaDocRoles" method="POST">
                                                                                <font color="green">Creaci&oacute;n de un documento</font>
                                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                </a>
                                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                 
                                                                            </form>
                                                                        </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                    //$conteo++;
                                                                    
                                                                }
                                                             
                                                            }else{
                                                                ////////////// traer conteo de cargos
                                                                for($i=0; $i<$longitud; $i++){ // SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'
                                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                //echo $columna['nombreCargos'];
                                                                $cn = mysqli_num_rows($nombrecargo);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT solicitud FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        ?>
                                                                        
                                                                        <li>
                                                                            <form action="revisaDocRoles" method="POST">
                                                                                <font color="green">Creaci&oacute;n de un documento</font>
                                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                </a>
                                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                <input type="hidden" readonly name="idDocumento" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                
                                                                            </form>
                                                                        </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                }
                                                            } 
                                		                }
                                		           
                                                    //////// fin proceso de aprueban
                                                    
                                          // } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                        
                                        <!-- la notificaci��n cuando el documento es actualizar -->
                                        
                                        <ul>
                                            <?php
                                            
                                            //// inicio de la notificaci��n
                                         //  if($validandoGrup2o >= 1){
                                            
                                            
                                            
                                                    //////////// los que aprueban
                                                    ///////////// se trae la tabla de documento
                                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoActualiza='Revisado' "); /// SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                                        
                                                        $conteo = 0;
                                                        
                                                        
                                                        while($row = $sql->fetch_assoc()){
                                		                
                                                        $personalIDAprobador =  json_decode($row['apruebaActualizar']);
                                                        $longitud = count($personalIDAprobador);
                                                        
                                                        
                                                        //echo $personalID[0];
                                                        
                                                        foreach($personalIDAprobador as $dato){
                                                           // echo $dato; echo "<br>";
                                                        }
                                                        
                                                        
                                                            if($personalIDAprobador[0] == 'usuarios'){
                                                                
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    ///////////// para traer conteo de los usuarios
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $nombreE = $columna['nombres'];
                                                                    
                                                                    //echo $cadena_formateada = trim($nombreE);
                                                                    $cn = mysqli_num_rows($nombreuser);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud'  ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                   
                                                                                </form>
                                                                            </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                    //$conteo++;
                                                                    
                                                                }
                                                             
                                                            }else{
                                                                ////////////// traer conteo de cargos
                                                                for($i=0; $i<$longitud; $i++){ // SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'
                                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                //echo $columna['nombreCargos'];
                                                                $cn = mysqli_num_rows($nombrecargo);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="actualizarDocRoles" method="POST">
                                                                                    <font color="blue">Actualizaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDoc" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                   
                                                                                </form>
                                                                            </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                }
                                                            } 
                                		                }
                                		           
                                                    //////// fin proceso de aprueban
                                                    
                                        //   } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                        
                                        
                                        <!-- la notificaci��n cuando el documento es eliminar -->
                                        
                                        <ul>
                                            <?php
                                            
                                            //// inicio de la notificaci��n
                                       //    if($validandoGrup2o >= 1){
                                            
                                            
                                            
                                                    //////////// los que aprueban
                                                    ///////////// se trae la tabla de documento
                                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estadoElimina='Revisado' "); /// SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1' AND plataformaHAprueba='1'
                                                        
                                                        $conteo = 0;
                                                        
                                                        
                                                        while($row = $sql->fetch_assoc()){
                                		                
                                                        $personalIDAprobador =  json_decode($row['apruebaElimanar']);
                                                        $longitud = count($personalIDAprobador);
                                                        
                                                        
                                                        //echo $personalID[0];
                                                        
                                                        foreach($personalIDAprobador as $dato){
                                                           // echo $dato; echo "<br>";
                                                        }
                                                        
                                                        
                                                            if($personalIDAprobador[0] == 'usuarios'){
                                                                
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    ///////////// para traer conteo de los usuarios
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalIDAprobador[$i]' AND cedula='$sesion' ");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                    //echo $nombreE = $columna['nombres'];
                                                                    
                                                                    //echo $cadena_formateada = trim($nombreE);
                                                                    $cn = mysqli_num_rows($nombreuser);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud'  ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                    //$conteo++;
                                                                    
                                                                }
                                                             
                                                            }else{
                                                                ////////////// traer conteo de cargos
                                                                for($i=0; $i<$longitud; $i++){ // SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'
                                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAprobador[$i]' 
                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                //echo $columna['nombreCargos'];
                                                                $cn = mysqli_num_rows($nombrecargo);
                                                                    
                                                                    //echo $cn; echo "<br>";
                                                                    if($cn > 0){
                                                                        /// se imprime el id
                                                                        $iddocumentoDepersonaAelaborar=$row['id'];
                                                                        $idSolicitud=$row['id_solicitud'];
                                                                        $nombreCreacion=$row['nombres'];
                                                                        $conteo++;
                                                                        //////////// se coloca los nombres para traer el ID y mostar el nombre de la tabla
                                                                        $nombreuser = $mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE id = '$idSolicitud' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                        $solicitudAelaborar = $columna['solicitud'];
                                                                        $iDsolicitudAelaborar = $columna['id'];
                                                                            
                                                                            ?>
                                                                            
                                                                            <li>
                                                                                <form action="eliminarDocRoles" method="POST">
                                                                                    <font color="red">Eliminaci&oacute;n de un documento</font>
                                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                    </a>
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/><br><br>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="idSolicitud" value="<?php echo $iDsolicitudAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    
                                                                                </form>
                                                                            </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                }
                                                            } 
                                		                }
                                		           
                                                    //////// fin proceso de aprueban
                                                    
                                         //  } ////Fin de la validaci��n del if de notificaciones
                                           ?>
                                        </ul>
                                    </li>
                                    <?php
                                    }else{ echo '<br><br><br>No tiene permisos para gestionar el flujo'; }
                                    ?>
                                    
                                    
                                    
                                    
                                </ul>
                            </nav>
                        
                      </div>
                      
                      
                    </div>
                    <?php
                    //}
                    ?>
                    
                    <!--   Acá empieza las notificaciones de repositorio   -->
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Repositorio</b></h3>
                        <?php
                           $sqlActasRepositorios= $mysqli->query("SELECT * FROM repositorioCarpetaSolicitud WHERE estado='Pendiente'  ");
                            $conteoSolicitudS=0;
                            while($rowRepositorio = $sqlActasRepositorios->fetch_assoc()){
        		               $id=$rowRepositorio['id'];
        		               $idprincipalrepositorio=$rowRepositorio['idRepositorio'];
        		                                $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE id='$idprincipalrepositorio' AND usuario='$idparaChat' ");
                                                $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
                                                $extraeIDArchivoSolicitud['id'];
                                                if($extraeIDArchivoSolicitud['id'] == NULL){
                                                    continue;
                                                }
                                                
        		                    $conteoSolicitudS++;
                            } /// cierre del while
        		           
        		           //  validacion cuando no existe notificaciones manda 0
                               if($conteoSolicitudS > 0){
                                   $conteoSolicitudS;
                               }else{
                                   $conteoSolicitudS=0;
                               }
                           //end
                           
                           
                           
                           ///// entramos a la notificacion para los archivos
        		            $sqlActasRepositorios= $mysqli->query("SELECT * FROM repositorioArchivoSolicitud WHERE estado='Pendiente'  ");
                            $conteoSolicitudSB=0;
                            while($rowRepositorio = $sqlActasRepositorios->fetch_assoc()){
        		               $id=$rowRepositorio['id'];
        		               $idprincipalrepositorio=$rowRepositorio['idRepositorio'];
        		                                $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioRegistro WHERE id='$idprincipalrepositorio' AND realiza='$idparaChat' ");
                                                $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
                                                if($extraeIDArchivoSolicitud['id'] == NULL){
                                                    continue;
                                                }
                                                
                                                $conteoSolicitudSB++;
                                                
                            } /// cierre del while
        		            //  validacion cuando no existe notificaciones manda 0
                               if($conteoSolicitudSB > 0){
                                   $conteoSolicitudSB;
                               }else{
                                   $conteoSolicitudSB=0;
                               }
                           //end
                           
                           
                           
                           
                           
                           
                           // totales de la sumatoria
                            $totalesrespositorio=$conteoSolicitudS+$conteoSolicitudSB;
                           // end
                           
                           // validacion cuando no existe notificaciones manda 0
                               if($totalesrespositorio > 0){
                                   $totalesrespositorio=$conteoSolicitudS+$conteoSolicitudSB;
                               }else{
                                   $totalesrespositorio=0;
                               }
                           // end
                        ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php echo $totalesrespositorio; ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Solicitud pendiente</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalesrespositorio; ?></a>
                                        <ul>
                            <?php
                            $sqlActasRepositorios= $mysqli->query("SELECT * FROM repositorioCarpetaSolicitud WHERE estado='Pendiente'  ");
                            // conteo para carpetas
                            $conteoSolicitud=0;
                            $conteoSolicitudA=0;
                            $conteoSolicitudB=0;
                            $conteoSolicitudC=0;
                            
                            // envio de ID
                            $conteoSolicitudId=0;
                            $conteoSolicitudIdd=0;
                            $conteoSolicitudIdA=0;
                            $conteoSolicitudIdB=0;
                            while($rowRepositorio = $sqlActasRepositorios->fetch_assoc()){
        		               $id=$rowRepositorio['id'];
        		               $idprincipalrepositorio=$rowRepositorio['idRepositorio'];
        		                                $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE id='$idprincipalrepositorio' AND usuario='$idparaChat' ");
                                                $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
                                                $extraeIDArchivoSolicitud['id'];
                                                if($extraeIDArchivoSolicitud['id'] == NULL){
                                                    continue;
                                                }
                                                
                                                
                                                /// traemos los datos de la persona que está solicitando
                                                    $consultandodatosSolicitante=$rowRepositorio['solicitante'];
                                                    $consultaUsuarioDolisitante=$mysqli->query("SELECT * FROM usuario WHERE id='$consultandodatosSolicitante' ");
                                                    $extraerConsultaUsuariSolicitante=$consultaUsuarioDolisitante->fetch_array(MYSQLI_ASSOC);
                                                    $nombresSolicitante=$extraerConsultaUsuariSolicitante['nombres'];
                                                    $apellidowSolcitante=$extraerConsultaUsuariSolicitante['apellidos'];
                                                    $idCargoSolicitante=$extraerConsultaUsuariSolicitante['cargo'];
                                                    $consultaCargoSolicitante=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idCargoSolicitante' ");
                                                    $extracargosolicitante=$consultaCargoSolicitante->fetch_array(MYSQLI_ASSOC);
                                                    $nombreCargosSolicitante=$extracargosolicitante['nombreCargos'];
                                                /// end
                                                
                                                if( $extraeIDArchivoSolicitud['visualizar'] == 'cargo'){
                                                    $enviarCargoUsuarioVisualizar=$extraerConsultaUsuariSolicitante['cargo'];
                                                }elseif($extraeIDArchivoSolicitud['visualizar'] == 'usuario'){
                                                    $enviarCargoUsuarioVisualizar=$extraerConsultaUsuariSolicitante['id'];
                                                }else{
                                                    //// habilitar los grupos
                                                    $consultarGrupoUsuarioRepositorio=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$sesion' ");
                                                    $extraerIdGrupoUsuarioRepositorio=$consultarGrupoUsuarioRepositorio->fetch_array(MYSQLI_ASSOC);
                                                    $enviarCargoUsuarioVisualizar=$extraerIdGrupoUsuarioRepositorio['idGrupo']; 
                                                }
        		            ?>
                                        <li>
                                           
                                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo 'El usuario '.mb_strtoupper($nombresSolicitante).' '.mb_strtoupper($apellidowSolcitante).' con el cargo '.mb_strtoupper($nombreCargosSolicitante).' solicita permiso de visualización para la carpeta '.mb_strtoupper(substr($extraeIDArchivoSolicitud['ruta'], 10)).'. Motivo: '.$rowRepositorio['motivo']; ?>' >
                                        <input type='hidden' id='capturaVariableID<?php echo $contadorIdVariable++;?>'  value= '<?php echo $extraeIDArchivoSolicitud['id'];?>' >
                                        <input type='hidden' id='capturaVariableSS<?php echo $contadorVaribleSS++;?>'  value= '<?php echo $enviarCargoUsuarioVisualizar;?>' >
                                        <input type='hidden' id='capturaVariableSolicitanteUnico<?php echo $contadorVaribleSolicitanteInico++;?>'  value= '<?php echo $consultandodatosSolicitante;?>' >
                                        
                                        <a onclick='funcionFormula<?php echo $contador1++;?>()' data-toggle='modal' data-target='#modal-dangerSolicitud' style="width:35px;color:white;text-decoration:none;" class="btn btn-block btn-primary btn-sm float-right"><i class="fas fa-eye"></i></a>
                                        <script>
                                            function funcionFormula<?php echo $contador2++;?>() {
                                              //alert("entra");
                                              dato1C= document.getElementById("solicitar").value = document.getElementById("capturaVariable<?php echo $contador3Carpeta++;?>").value;
                                              dato2C= document.getElementById("idSolicitar").value = document.getElementById("capturaVariableID<?php echo $contador4Carpeta++;?>").value;
                                              dato3C= document.getElementById("idSolicitaSolicitante").value = document.getElementById("capturaVariableSS<?php echo $contador5Carpeta++;?>").value;
                                              dato4C= document.getElementById("idSolicitaSolicitanteUnico").value = document.getElementById("capturaVariableSolicitanteUnico<?php echo $contador5CarpetaUnico++;?>").value;
                                              //alert(dato1C + ' <br> ' + dato2C + ' <br>' + dato3C);
                                            }
                                        </script>
                                                
                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud de visualización de carpeta: '.$extraeIDArchivoSolicitud['nombre']; ?><a/><br><br>
                                            <!-- Al dar clic en el botón, envía la pretición al archivo myperfil.php donde se muestra el mensaje enla línea del 81 al 115-->    
                                            
                                        </li>
                                        
                            <?php
                            } /// cierre del while
        		            
        		            
        		            
        		            ///// entramos a la notificacion para los archivos
        		            $sqlActasRepositorios= $mysqli->query("SELECT * FROM repositorioArchivoSolicitud WHERE estado='Pendiente'  ");
                            $conteoSolicitudS=0;
                            $conteoSolicitudAS=0;
                            $conteoSolicitudBS=0;
                            $conteoSolicitudCS=0;
                            
                            $conteoSolicitudIdS=0;
                            $conteoSolicitudIddS=0;
                            $conteoSolicitudIdAS=0;
                            $conteoSolicitudIdBS=0;
                            while($rowRepositorio = $sqlActasRepositorios->fetch_assoc()){
        		               $id=$rowRepositorio['id'];
        		               $idprincipalrepositorio=$rowRepositorio['idRepositorio'];
        		                                $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioRegistro WHERE id='$idprincipalrepositorio' AND realiza='$idparaChat' ");
                                                $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
                                                if($extraeIDArchivoSolicitud['id'] == NULL){
                                                    continue;
                                                }
                                                
                                                /// traemos los datos de la persona que está solicitando
                                                    $consultandodatosSolicitante=$rowRepositorio['solicitante'];
                                                    $consultaUsuarioDolisitante=$mysqli->query("SELECT * FROM usuario WHERE id='$consultandodatosSolicitante' ");
                                                    $extraerConsultaUsuariSolicitante=$consultaUsuarioDolisitante->fetch_array(MYSQLI_ASSOC);
                                                    $nombresSolicitante=$extraerConsultaUsuariSolicitante['nombres'];
                                                    $apellidowSolcitante=$extraerConsultaUsuariSolicitante['apellidos'];
                                                    $idCargoSolicitante=$extraerConsultaUsuariSolicitante['cargo'];
                                                    $consultaCargoSolicitante=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idCargoSolicitante' ");
                                                    $extracargosolicitante=$consultaCargoSolicitante->fetch_array(MYSQLI_ASSOC);
                                                    $nombreCargosSolicitante=$extracargosolicitante['nombreCargos'];
                                                /// end
                                                if( $extraeIDArchivoSolicitud['visualizar'] == 'cargo'){
                                                    $enviarCargoUsuarioVisualizar=$extraerConsultaUsuariSolicitante['cargo'];
                                                }elseif($extraeIDArchivoSolicitud['visualizar'] == 'usuario'){
                                                    $enviarCargoUsuarioVisualizar=$extraerConsultaUsuariSolicitante['id'];
                                                }else{
                                                    //// habilitar los grupos
                                                    $consultarGrupoUsuarioRepositorio=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$sesion' ");
                                                    $extraerIdGrupoUsuarioRepositorio=$consultarGrupoUsuarioRepositorio->fetch_array(MYSQLI_ASSOC);
                                                    $enviarCargoUsuarioVisualizar=$extraerIdGrupoUsuarioRepositorio['idGrupo']; 
                                                }
        		            ?>
                                        <li>
                                           
                                                <input type='hidden' id='capturaVariableS<?php echo $conteoSolicitudS++;?>'  value= '<?php echo 'El usuario '.mb_strtoupper($nombresSolicitante).' '.mb_strtoupper($apellidowSolcitante).' con el cargo '.mb_strtoupper($nombreCargosSolicitante).' solicita permiso de visualización para el archivo '.mb_strtoupper($extraeIDArchivoSolicitud['nombre']).'.'.mb_strtoupper($extraeIDArchivoSolicitud['extension']).'. Motivo: '.$rowRepositorio['motivo']; ?>' > <!-- substr($extraerConsultaUsuariSolicitante['nombre']) -->
                                                <input type='hidden' id='capturaVariableIDS<?php echo $conteoSolicitudIdS++;?>'  value= '<?php echo $extraeIDArchivoSolicitud['id'];?>' >
                                                <input type='hidden' id='capturaVariableSSS<?php echo $conteoSolicitudIddS++;?>'  value= '<?php echo $enviarCargoUsuarioVisualizar;?>' >
                                                <input type='hidden' id='capturaVariableSolicitanteUnicoA<?php echo $contadorVaribleSolicitanteInico++;?>'  value= '<?php echo $consultandodatosSolicitante;?>' >
                                                <!-- $rowRepositorio['solicitante']; -->
                                                
                                                <a onclick='funcionFormulaS<?php echo $conteoSolicitudAS++;?>()' data-toggle='modal' data-target='#modal-dangerSolicitudArchivos' style="width:35px;color:white;text-decoration:none;" class="btn btn-block btn-primary btn-sm float-right"><i class="fas fa-eye"></i></a>
                                                <script>
                                                        function funcionFormulaS<?php echo $conteoSolicitudBS++;?>() {
                                                            //alert("entre");
                                                          document.getElementById("solicitarS").value = document.getElementById("capturaVariableS<?php echo $conteoSolicitudCS++;?>").value;
                                                          document.getElementById("idSolicitarS").value = document.getElementById("capturaVariableIDS<?php echo $conteoSolicitudIdAS++;?>").value;
                                                          document.getElementById("idSolicitaSolicitanteS").value = document.getElementById("capturaVariableSSS<?php echo $conteoSolicitudIdBS++;?>").value;
                                                          document.getElementById("idSolicitaSolicitanteUnicoA").value = document.getElementById("capturaVariableSolicitanteUnicoA<?php echo $contador5CarpetaUnico++;?>").value;
                                                          
                                                        
                                                            
                                                        }
                                                </script>
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud de visualización de un documento: '.$extraeIDArchivoSolicitud['nombre']; ?><a/><br><br>
                                                <!-- Al dar clic en el botón, envía la pretición al archivo myperfil.php donde se muestra el mensaje enla línea del 81 al 115-->    
                                            
                                        </li>
                                        
                            <?php
                            } /// cierre del while
        		            
        		            ?>
                                      
                                      
                                      
                                            
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    
                    
                    <!-- aca empieza las notificaciones de los indicadores ----------------------------------------  -->
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Indicadores</b></h3>
                        <?php
                              $consultaGruposComprasIndicadores = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula'  ")or die(mysqli_error());
                                        while($grupoUsuarioComprasIndicadores = $consultaGruposComprasIndicadores->fetch_array()){
                                        $idGrupoIndicadores=$grupoUsuarioComprasIndicadores['idGrupo'];
                                        
                                            $consultaGruposNombreIdIndicadores = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoIndicadores' ")or die(mysqli_error());
                                            $grupoUsuarioNombreIdIndicadores = $consultaGruposNombreIdIndicadores->fetch_array(MYSQLI_ASSOC);
                                            $idGrupoValidandoIndicadores=$grupoUsuarioNombreIdIndicadores['id'];
                                            $grupoUsuarioNombreIdIndicadores['nombre'];
                                        
                                            $consultaGruposNotificacionIndicadores = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoIndicadores' AND formulario='indicadores' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacionIndicadores = $consultaGruposNotificacionIndicadores->fetch_array(MYSQLI_ASSOC);
                                            $grupoUsuarioNotificacionIndicadores['plataforma'];
                                            if($grupoUsuarioNotificacionIndicadores['plataforma']){
                                                 $validandoGrupoIndicadores+=$grupoUsuarioNotificacionIndicadores['plataforma']; 
                                            }else{
                                                //echo 'conteo: 0'; echo '<br>';
                                            }
                                        }
                                        
                                        $validandoGrupoIndicadores;
                                        
                            //// validacion del permiso para mostrar o no la notificaci��n
                            
                            if($validandoGrupoIndicadores > 0){
                                        
                                        
                             //////////// validacion para los compromisos listos para aprobar  
                            $sqlIndicadores= $mysqli->query("SELECT * FROM indicadores  "); //Where plataformaH='1'
                            $conteIndicadorsA = 0;
                            $conteoIndicadorCA = 0;
        		            while($row = $sqlIndicadores->fetch_assoc()){
        		                $idActa = $row['id'];
        		                $tipoPersonal = $row['radioIndicador'];
        		                $personalID =  json_decode($row['resposableIndicador']);
                                $longitud = count($personalID);
                                
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteIndicadorsA++;    
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $conteoIndicadorCA++;    
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while responsables del indicador
        		            
        		            
        		            $sqlIndicadoresC= $mysqli->query("SELECT * FROM indicadores  "); //WHERE plataformaH='1'
                            $conteIndicadorsAC = 0;
                            $conteoIndicadorCAC = 0;
        		            while($row = $sqlIndicadoresC->fetch_assoc()){
        		                $idActaC = $row['id'];
        		                $tipoPersonalC = $row['radioCalculo'];
        		                $personalIDC =  json_decode($row['responsableCalculo']);
                                $longitudC = count($personalIDC);
                                
                            if($tipoPersonalC == 'usuario'){
                                    
                                    for($i=0; $i<$longitudC; $i++){
                                        
                                        $nombreActasC = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalIDC[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActasC->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActasC);
                                        
                                        if($cn > 0){
                                        $conteIndicadorsAC++;    
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonalC == 'cargo'){
                                    
                                    for($i=0; $i<$longitudC; $i++){
                                    $nombrecargoC = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDC[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargoC->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargoC);
                                        
                                        if($cn > 0){
                                        $conteoIndicadorCAC++;    
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while responsables del calculo
        		            
        		            
        		            $totalConteoIndicador=$conteIndicadorsA+$conteoIndicadorCA+$conteIndicadorsAC+$conteoIndicadorCAC;
        		             
        		            
                            }
        		            
        		           
        		            
                                ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php if($totalConteoIndicador > 0){ echo $totalConteoIndicador; }else{ echo '0'; } ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Responsable del indicador</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalRI=$conteIndicadorsA+$conteoIndicadorCA; ?></a>
                                        <ul>
                                            <?php
                                            
                            if($validandoGrupoIndicadores > 0){ /// validacion para mostrar o no las notificaciones                
                                            
                            $sqlActas= $mysqli->query("SELECT * FROM indicadores   "); //WHERE plataformaH='1'
                            $conteoActas = 0;
                            $conteoActasC = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $quienCrea=$row['quienCrea'];
        		                $id = $row['id'];
        		                $tipoPersonal = $row['radioIndicador'];
        		                $personalID =  json_decode($row['resposableIndicador']);
                                $longitud = count($personalID);
                                
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActas++;
                                        $nombreResponsableCalculo = $row['nombre'];
                                                        
                                        ?>
                                        <li>
                                            <form action="indicadoresGestionar" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreResponsableCalculo; ?><a/><br><br>
                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $id; ?>' >
                                              
                                               
                                            </form>
                                        </li>
                                        <?php
                                           
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $conteoActasC++;    
                                         $nombreResponsableCalculo = $row['nombre'];
                                        ?>
                                        <li>
                                            <form action="indicadoresGestionar" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreResponsableCalculo; ?><a/><br><br>
                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $id; ?>' >
                                             
                                            </form>
                                        </li>
                                        <?php
                                          
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            $totalConteoActas=$conteoActas+$conteoActasC;
        		            
                            }
                                ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    <li class="list-group-item"><b>Responsable del calculo</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalRC=$conteIndicadorsAC+$conteoIndicadorCAC; ?></a>
                                        <ul>
                                            <?php
                                
                                 if($validandoGrupoIndicadores > 0){ /// validacion para mostrar o no las notificaciones   
                                            
                                /////// validacion para sacar el estado pendiente y rechazado
                            $sqlActasC= $mysqli->query("SELECT * FROM indicadores  "); //WHERE plataformaH='1'
                             
        		            while($row = $sqlActasC->fetch_assoc()){
        		                $quienCrea=$row['quienCrea'];
        		                $id=$row['id'];
        		                $tipoPersonalC = $row['radioCalculo'];
        		                $personalIDC =  json_decode($row['responsableCalculo']);
        		                $longitudC = count($personalIDC);
        		              
                            if($tipoPersonalC == 'usuario'){
                                    
                                    for($i=0; $i<$longitudC; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalIDC[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActas++;
                                        $nombreResponsableCalculo = $row['nombre'];
                                        
                                        ?>
                                        <li>
                                            <form action="indicadoresGestionar" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreResponsableCalculo; ?><a/><br><br>
                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $id; ?>' >
                                          
                                            </form>
                                        </li>
                                        
                                        <?php
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonalC == 'cargo'){
                                    
                                    for($i=0; $i<$longitudC; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDC[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $conteoActasC++;    
                                        $nombreResponsableCalculo = $row['nombre'];
                                        
                                        ?>
                                        <li>
                                            <form action="indicadoresGestionar" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreResponsableCalculo; ?><a/><br><br>
                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $id; ?>' >
                                             
                                            </form>
                                        </li>
                                        
                                        <?php
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
                                 
                                     
                                 }        
                            ?>           
                                         </ul>
                                    </li>
                                    
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    <!-- ac�� terminan las notificaciones de los indicadores -->
                    
                    
                    <!-- ac�� empieza las notificaciones de las Actas e informes ---------------------------------------- -->
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Actas</b></h3>
                        <?php
                         //// notificaciones para la aprobación de comprmisos
                            
                            
                            $sqlActas= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' ");
                            $conteoUsuariosA=0;
                            $conteoUsuariosB=0;
                                        while($row = $sqlActas->fetch_assoc()){
                    		                $idActa = $row['idActa'];
                    		                $idCompromisoValidando=$row['id'];
                    		                $nombreCompromisoAprobacion=$row['compromiso'];
                    		                
                    		                                             $personalresponsabledID =  json_decode($row['responsableID']);
                                                                         $longitudresponsable = count($personalresponsabledID);
                                                    
                    		                                            // validamos el compromiso individual
                    		                                            $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT *,count(*) FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromisoValidando' AND (estado='Ejecutado' OR estado='Aprobado') ");
                                                                        $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                                        
                    		                                            '<br>'.$datoActasCompromisoIndividualValidando['count(*)'];
                    		                                            //echo '-'.$datoActasCompromisoIndividualValidando['id_compromiso'];
                    		                                            '-'.$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                                            
                    		                                            if($datoActasCompromisoIndividualValidando['count(*)'] == $longitudresponsable){
                    		                                               
                    		                                            }else{
                    		                                                 continue;
                    		                                            }
                    		                    
                    		                
                        		                $tipoPersonal = $row['entregarA'];
                        		                $personalID =  json_decode($row['entregarAID']);
                                                $longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                                $conteoUsuariosA++;
                                                                //echo 'imprime usuario';
                                                                
                                                            }
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                if($tipoPersonal == 'cargo'){
                                                        
                                                        for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){
                                                                $conteoUsuariosB++;
                                                                //echo 'imprime cargos';
                                                               
                                                            }
                                                        } //// for
                                                    } /// cierre if
                    		                
                    		                
                    		            }
                    	$totalesAprobacionComprimisos=$conteoUsuariosA+$conteoUsuariosB;
                    	
                    	
                        //// END     
                    
                        
                        
                        /// gestión de compromisos
                                        $sqlActas= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente'  ");
                                        $gestionCompromisoConteoU=0;
                                        while($rowG = $sqlActas->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='usuario' AND responsableId='$idparaChat' AND NOT ( estado='Ejecutado' OR estado='Aprobado')  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa']; 
                                                           // validamos el compromiso individual
                                		                    
                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }else{
                                                                                $gestionCompromisoConteoU++;
                                                                            }
                                                                            
                                                                          
                                                            
                                                            //}
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                
                                                    /// cierre if
                                            }
                                            
                                        $sqlActasCargo= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente'  ");
                                        $gestionCompromisoConteoC=0;
                                        while($rowGCargo = $sqlActasCargo->fetch_assoc()){
                    		                $idCompromiso = $rowGCargo['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='cargo' AND responsableId='$cargo' AND NOT ( estado='Ejecutado' OR estado='Aprobado')  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                    if($tipoPersonal == 'cargo'){ 
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){ 
                                                            $idacta = $rowGCargo['idActa'];
                                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }else{
                                                                                $gestionCompromisoConteoC++;
                                                                            }
                                                             
                                                            }
                                                        //} //// for
                                                    } 
                                                    
                                                    
                                                
                                                    /// cierre if
                                            } 
                                            
                                            
                                         $sqlActasAprobadoUsuarios= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' OR estado='Aprobado' ");
                                        $gestionCompromisoConteoUUsuarios=0;
                                        while($rowG = $sqlActasAprobadoUsuarios->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='usuario' AND responsableId='$idparaChat' AND estado='Aprobado' AND mensaje='1'  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa']; 
                                                           // validamos el compromiso individual
                                		                    
                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }else{
                                                                                $gestionCompromisoConteoUUsuarios++;
                                                                            }
                                                                            
                                                                          
                                                            
                                                            //}
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                
                                                    /// cierre if
                                            }
                                            
                                        $sqlActasCargoAprobadosCargos= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' OR estado='Aprobado' ");
                                        $gestionCompromisoConteoCCargos=0;
                                        while($rowGCargo = $sqlActasCargoAprobadosCargos->fetch_assoc()){
                    		                $idCompromiso = $rowGCargo['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='cargo' AND responsableId='$cargo' AND estado='Aprobado' AND mensaje='1'  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                    if($tipoPersonal == 'cargo'){ 
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){ 
                                                            $idacta = $rowGCargo['idActa'];
                                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }else{
                                                                                $gestionCompromisoConteoCCargos++;
                                                                            }
                                                             
                                                            }
                                                        //} //// for
                                                    } 
                                                    
                                                    
                                                
                                                    /// cierre if
                                            } 
                    		            
                    	        // END
                    	      //echo 'U:'.$gestionCompromisoConteoU;
                    	      //echo 'C:'.$gestionCompromisoConteoC;
                    	           $totalesGestionCompromisos=$gestionCompromisoConteoU+$gestionCompromisoConteoC+$gestionCompromisoConteoCCargos+$gestionCompromisoConteoUUsuarios;
                    	        
                    	        
                    	        
                    	        
                    	  ///// aprobacion del acta en estado pendiente o rechazado      
                    	$sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Pendiente' AND finalizada = 1 ");
                    	$aprobacionActaConteoPendienteU=0;
                    	$aprobacionActaConteoPendienteC=0;
                            while($row = $sqlActas->fetch_assoc()){
        		                
        		                $ValidacionEstado=$row['estado'];
        		                
        		                $validacionFinalizada=$row['notificacionAct'];
        		                    $tipoPersonal = $row['quienAprueba'];
                		            $personalID =  json_decode($row['quienApruebaId']);
                                    $longitud = count($personalID);
        		              
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $aprobacionActaConteoPendienteU++;
                                        
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $aprobacionActaConteoPendienteC++;
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while 
        		            $aprobacionActaEstadoPendienteUC=$aprobacionActaConteoPendienteU+$aprobacionActaConteoPendienteC;
        		            
        		            $sqlActasrechazado= $mysqli->query("SELECT * FROM actas WHERE estado='Rechazado' AND finalizada = 1 ");
        		            $aprobacionActaRechazadoU=0;
        		            $aprobacionActaRechazadoC=0;
                            while($rowRechazado = $sqlActasrechazado->fetch_assoc()){
        		                
        		                $ValidacionEstado=$rowRechazado['estado'];
        		                
        		                $validacionFinalizada=$rowRechazado['notificacionAct'];
        		                
        		               
        		                         
                                    $tipoPersonal = $rowRechazado['quienElabora'];
                		            $personalID =  json_decode($rowRechazado['quienElaboraID']);
                                    $longitud = count($personalID);
        		              
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                            $aprobacionActaRechazadoU++;
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                            $aprobacionActaRechazadoC++;
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            $aprobacionActaEstadoRechazado=$aprobacionActaRechazadoU+$aprobacionActaRechazadoC;
        		            
        		            
                    	$totalesAprobacionActas=$aprobacionActaEstadoPendienteUC+$aprobacionActaEstadoRechazado;
                        /// END
                                ?>
                      
                               
                            
                        
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php echo $totalConteoActasGenerales=$totalesAprobacionComprimisos+$totalesGestionCompromisos+$totalesAprobacionActas; ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Aprobaci&oacute;n de compromisos</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalesAprobacionComprimisos; ?></a>
                                        <br>
                                        <ul>
                                <?php
                                     
                                        $sqlActas= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' ");
                                        while($row = $sqlActas->fetch_assoc()){
                    		                $idActa = $row['idActa'];
                    		                $idCompromisoValidando=$row['id'];
                    		                $nombreCompromisoAprobacion=$row['compromiso'];
                    		                
                    		               
                        		               
                        		                $personalresponsabledID =  json_decode($row['responsableID']);
                                                $longitudresponsable = count($personalresponsabledID);
                                                    
                    		                                            // validamos el compromiso individual
                    		                                            $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT *,count(*) FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromisoValidando' AND (estado='Ejecutado' OR estado='Aprobado') ");
                                                                        $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                                        
                    		                                            '<br>'.$datoActasCompromisoIndividualValidando['count(*)'];
                    		                                            //echo '-'.$datoActasCompromisoIndividualValidando['id_compromiso'];
                    		                                            '-'.$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                                            
                    		                                            if($datoActasCompromisoIndividualValidando['count(*)'] == $longitudresponsable){
                    		                                               
                    		                                            }else{
                    		                                                 continue;
                    		                                            }
                                                                        
                                                
                        		                $tipoPersonal = $row['entregarA'];
                        		                $personalID =  json_decode($row['entregarAID']);
                                                $longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                               
                                                            $idActa = $row['idActa'];
                                                            
                                                            
                                                                            $nombreActasD = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idActa'  ");
                                                                            $datoActas = $nombreActasD->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDatoActas = $datoActas['nombreActa'];
                                                                            $idDatoActas = $datoActas['id'];
                                                                            $actaCargada = $datoActas['actaCargada'];
                                                                            $estadoActaCompromiso=$datoActas['estado'];
                                                                            
                                                                            
                                                            ?>
                                                            <li>
                                                                <?php  /*if($actaCargada == 1){  ?>
                                                                <form action="seguimientoActasEntrega" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $nombreCompromisoAprobacion;?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="border-color:green;background:green;width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*aActa:</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $row['compromiso']; ?>
                                                                    
                                                                </form>
                                                            <?php
                                                                }else{ */
                                                            ?>
                                                                <form action="seguimientoActasEntrega" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $nombreCompromisoAprobacion;?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="border-color:green;background:green;width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>"><br>
                                                                    <b>-Compromiso:</b> <?php echo $row['compromiso']; ?>
                                                                   
                                                                </form>
                                                            <?php
                                                               // } /// cierre de la comparación si es 1 o 0 
                                                            ?>
                                                            </li><br>
                                                            <?php    
                                                            }
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                if($tipoPersonal == 'cargo'){
                                                        
                                                        for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){
                                                                
                                                            $idActa = $row['idActa'];
                                                                            $nombreActasD = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idActa' ");
                                                                            $datoActas = $nombreActasD->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDatoActas = $datoActas['nombreActa'];
                                                                            $idDatoActas = $datoActas['id'];
                                                                            $actaCargada = $datoActas['actaCargada'];
                                                                            $estadoActaCompromiso=$datoActas['estado'];
                                                                            
                                                                            
                                                            ?>
                                                            <li>
                                                                <?php /* if($actaCargada == 1){  ?>
                                                                <form action="seguimientoActasEntrega" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $nombreCompromisoAprobacion;?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="border-color:green;background:green;width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*aActa:</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                                   <b>-Compromiso:</b> <?php echo $row['compromiso']; ?>
                                                                    
                                                                </form>
                                                            <?php
                                                              */ // }else{
                                                            ?>
                                                                <form action="seguimientoActasEntrega" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $nombreCompromisoAprobacion;?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="border-color:green;background:green;width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $row['compromiso']; ?>
                                                                    
                                                                </form>
                                                            <?php
                                                                //} /// cierre de la comparación si es 1 o 0
                                                            ?>
                                                            </li><br>
                                                            <?php
                                                            }
                                                        } //// for
                                                    } /// cierre if
                    		                
                    		                
                    		            }
                    		            
                                ?>
                                            
                                        </ul>
                                    </li>
                                    <li class="list-group-item"><b>Gesti&oacute;n de compromisos</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalesGestionCompromisos; ?></a>
                                        <br>
                                        <ul>
                                <?php
                                $sqlActas= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente'  ");
                                while($rowG = $sqlActas->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='usuario' AND responsableId='$idparaChat' AND NOT ( estado='Ejecutado' OR estado='Aprobado')  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa']; 
                                                           // validamos el compromiso individual
                                		                    
                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }
                                                            ?>
                                                            <li>
                                                                <form action="seguimientoActas" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $rowG['compromiso'];?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDelActa; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idacta; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $rowG['compromiso']; ?>
                                                                    
                                                                </form>
                                                            </li><br>
                                                            <?php                
                                                                          
                                                            
                                                            //}
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                
                                                    /// cierre if
                                            }
                                $sqlActas= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente'  ");
                                while($rowG = $sqlActas->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='cargo' AND responsableId='$cargo' AND NOT ( estado='Ejecutado' OR estado='Aprobado')  ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                
                                                    
                                                    
                                                if($tipoPersonal == 'cargo'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa'];
                                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }
                                                            ?>
                                                            <li>
                                                                <form action="seguimientoActas" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $rowG['compromiso'];?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDelActa; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idacta; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $rowG['compromiso']; ?>
                                                                    
                                                                </form>
                                                            </li><br>
                                                            <?php 
                                                            }
                                                        //} //// for
                                                    } 
                                                    /// cierre if
                                            }
                                            
                                
                                $sqlActasAprobadoUsuario= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' OR estado='Aprobado' ");
                                while($rowG = $sqlActasAprobadoUsuario->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='usuario' AND responsableId='$idparaChat' AND estado='Aprobado' AND mensaje='1' ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                if($tipoPersonal == 'usuario'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                            
                                                            $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID' AND cedula='$sesion' ");
                                                            $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                            //echo $columna['nombres'];
                                                            
                                                            $cn = mysqli_num_rows($nombreActas);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa']; 
                                                           // validamos el compromiso individual
                                		                    
                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }
                                                            ?>
                                                            <li>
                                                                <form action="seguimientoActas" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $rowG['compromiso'];?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDelActa; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idacta; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $rowG['compromiso']; ?> <font color="green">Aprobado</font>
                                                                    
                                                                </form>
                                                            </li><br>
                                                            <?php                
                                                                          
                                                            
                                                            //}
                                                            
                                                        } //// cierre del for
                                                    } //// cierre del if
                                                    
                                                    
                                                
                                                    /// cierre if
                                            }            
                                $sqlActasAprobdoCargo= $mysqli->query("SELECT * FROM compromisos WHERE estado='Pendiente' OR estado='Aprobado' ");
                                while($rowG = $sqlActasAprobdoCargo->fetch_assoc()){
                    		                $idCompromiso = $rowG['id'];
                    		                
                    		                    
                    		                                $nombreActasCompromisoIndividualValidando = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND responsable='cargo' AND responsableId='$cargo' AND estado='Aprobado' AND mensaje='1' ");
                                                            $datoActasCompromisoIndividualValidando = $nombreActasCompromisoIndividualValidando->fetch_array(MYSQLI_ASSOC);
                                                            //$estadoActaCompromisoIndividualValidando=$datoActasCompromisoIndividualValidando['estado'];
                    		                
                                    		                $tipoPersonal =$datoActasCompromisoIndividualValidando['responsable'];
                                    		                $personalID =$datoActasCompromisoIndividualValidando['responsableId'];
                                                            //$longitud = count($personalID);
                                                
                                                
                                                    
                                                    
                                                if($tipoPersonal == 'cargo'){
                                                        
                                                        //for($i=0; $i<$longitud; $i++){
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                            
                                                            if($cn > 0){
                                                            $idacta = $rowG['idActa'];
                                                                            
                                                                            //// validación para el compromiso individual
                                                                            $nombreActasCompromisoIndividual = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idacta'  ");
                                                                            $datoActasCompromisoIndividual = $nombreActasCompromisoIndividual->fetch_array(MYSQLI_ASSOC);
                                                                            $nombreDelActa=$datoActasCompromisoIndividual['nombreActa'];
                                                                            
                                                                            if($datoActasCompromisoIndividual['estado'] == 'Pendiente' || $datoActasCompromisoIndividual['estado'] == 'Rechazado'){
                                                                                continue;
                                                                            }
                                                            ?>
                                                            <li>
                                                                <form action="seguimientoActas" method="POST">
                                                                    <input name="nombreCompromiso" type="hidden" readonly value="<?php echo $rowG['compromiso'];?>">
                                                                    <a style="color:red;text-decoration:none;" class="float-right">
                                                                        <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                    </a>
                                                                    <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDelActa; ?><a/><br>
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idacta; ?>">
                                                                    <b>-Compromiso:</b> <?php echo $rowG['compromiso']; ?> <font color="green">Aprobado</font>
                                                                    
                                                                </form>
                                                            </li><br>
                                                            <?php 
                                                            }
                                                        //} //// for
                                                    } 
                                                    /// cierre if
                                            }
                    		                
                                ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    <li class="list-group-item"><b>Aprobaci&oacute;n Actas</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalesAprobacionActas; ?></a>
                                        <ul>
                            <?php
                                /////// validacion para sacar el estado pendiente y rechazado
                            $sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Pendiente' AND finalizada = 1 ");
                            while($row = $sqlActas->fetch_assoc()){
        		                
        		                $ValidacionEstado=$row['estado'];
        		                
        		                $validacionFinalizada=$row['notificacionAct'];
        		                
        		                
        		               
        		                         
                                    $tipoPersonal = $row['quienAprueba'];
                		            $personalID =  json_decode($row['quienApruebaId']);
                                    $longitud = count($personalID);
        		              
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];
                                        
                                        if($actaCargada == 1){
                                        ?>
                                        <li>
                                            <form action="verActaC" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                
                                            </form>
                                        </li><br>
                                        <?php
                                        }else{
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                
                                            </form>
                                        </li><br>
                                        
                                        <?php
                                        }
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];
                                        
                                        if($actaCargada == 1){
                                        ?>
                                        <li>
                                            <form action="verActaC" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                               
                                            </form>
                                        </li><br>
                                        <?php
                                         }else{
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                               
                                            </form>
                                        </li><br>
                                        
                                        <?php
                                         }
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		                        
                                            
                                            
                             /////// validacion para sacar el estado pendiente y rechazado
                            $sqlActasrechazado= $mysqli->query("SELECT * FROM actas WHERE estado='Rechazado' AND finalizada = 1 ");
                            while($rowRechazado = $sqlActasrechazado->fetch_assoc()){
        		                
        		                $ValidacionEstado=$rowRechazado['estado'];
        		                
        		                $validacionFinalizada=$rowRechazado['notificacionAct'];
        		                
        		               
        		                         
                                    $tipoPersonal = $rowRechazado['quienElabora'];
                		            $personalID =  json_decode($rowRechazado['quienElaboraID']);
                                    $longitud = count($personalID);
        		              
                                    
                                    
                                    
                            
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $idDatoActas = $rowRechazado['id'];
                                        $nombreDatoActas = $rowRechazado['nombreActa'];
                                        $actaCargada = $rowRechazado['actaCargada'];
                                        
                                        if($actaCargada == 1){
                                        ?>
                                        <li>
                                            <form action="verActaC" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$rowRechazado['estado']; ?></b>
                                                
                                            </form>
                                        </li><br>
                                        <?php
                                        }else{
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$rowRechazado['estado']; ?></b>
                                                
                                            </form>
                                        </li><br>
                                        <?php
                                        }
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $idDatoActas = $rowRechazado['id'];
                                        $nombreDatoActas = $rowRechazado['nombreActa'];
                                        $actaCargada = $rowRechazado['actaCargada'];
                                        
                                        if($actaCargada == 1){
                                        ?>
                                        <li>
                                            <form action="verActaC" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$rowRechazado['estado']; ?></b>
                                               
                                            </form>
                                        </li><br>
                                        <?php
                                        }else{
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <b>*Acta: </b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/><br>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$rowRechazado['estado']; ?></b>
                                               
                                            </form>
                                        </li><br>
                                        <?php
                                        }
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            
                                                       
        		            //$totalConteoActas=$conteoActas+$conteoActasC;
        		            
                                ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    <!-- ac�� finaliza las notificaciones de las actas e informes --------------------------- -->
                    
                    
                    
                    <!-- ac�� empieza las notificaciones para compras -------------------------------------  -->
                    
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Compras</b></h3>
                        <?php
                        $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERE notificacion='Pendiente' ");
                        $notificacionComprasU='0';
                        $notificacionComprasC='0';
                        while($extraerConsulta=$consultaProveedor->fetch_array()){
                            $extraerConsulta['razonSocial']; 
                            
                            $radiobtn=$extraerConsulta['radio'];
                            $arrayEncargado=json_decode($extraerConsulta['aprobador']);
                            $nombreDocEnviar=$extraerConsulta['razonSocial'];
                            if($radiobtn == 'usuario'){ 
                                $longitud = count($arrayEncargado); 
                                for($i=0; $i<$longitud; $i++){
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' AND id='$idparaChat' ");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    $cn = mysqli_num_rows($nombreuser);
                                    $nombreResponsable=utf8_encode($columna['nombres']);    
                                    
                                    if($cn > 0){
                                        $notificacionComprasU++;
                                    }
                                    
                                }
                            }
            
                            if($radiobtn == 'cargo'){
                            
                                $longitud = count($arrayEncargado);
                                for($i=0; $i<$longitud; $i++){ 
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$arrayEncargado[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos'];
                                    $cn = mysqli_num_rows($nombrecargo);
                                     if($cn > 0){
                                        $notificacionComprasC++;
                                    }
                                }
                            }
                            
                        }
                        
                        
                        $consultaProveedorR=$mysqli->query("SELECT * FROM proveedores WHERE notificacion='Rechazado' AND realizador='$idparaChat' ");
                        $notificacionComprasUR='0';
                        $notificacionComprasCR='0';
                        while($extraerConsultaR=$consultaProveedorR->fetch_array()){
                            $extraerConsulta['razonSocial']; 
                            
                            $radiobtn=$extraerConsultaR['radio'];
                            $arrayEncargado=json_decode($extraerConsultaR['aprobador']);
                            $nombreDocEnviar=$extraerConsultaR['razonSocial'];
                            $notificacionComprasUR++;
                            /*
                            if($radiobtn == 'usuario'){ 
                                $longitud = count($arrayEncargado); 
                                for($i=0; $i<$longitud; $i++){
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' AND id='$idparaChat' ");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    $cn = mysqli_num_rows($nombreuser);
                                    $nombreResponsable=utf8_encode($columna['nombres']);    
                                    
                                    if($cn > 0){
                                        $notificacionComprasUR++;
                                    }
                                    
                                }
                            }
                            
                            if($radiobtn == 'cargo'){
                            
                                $longitud = count($arrayEncargado);
                                for($i=0; $i<$longitud; $i++){ 
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$arrayEncargado[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos'];
                                    $cn = mysqli_num_rows($nombrecargo);
                                     if($cn > 0){
                                        $notificacionComprasCR++;
                                    }
                                }
                            } */
                            
                        }
                        
                        $solicituCompras=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE estado='pendiente' AND idUsuario='$idparaChat' ");
                        $solicitudComprasConteo='0';
                        while($extraerConsultaR=$solicituCompras->fetch_array()){
                            
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario ");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    $cn = mysqli_num_rows($nombreuser);
                                   
                                    if($cn > 0){
                                        $solicitudComprasConteo++;
                                    }
                                    
                        }
                        
                        $solicituComprasCedula=$mysqli->query("SELECT * FROM solicitudCompra WHERE idUsuario='$cc' ");
                        $solicitudComprasConteoCedula='0';
                        while($extraerConsultaR=$solicituComprasCedula->fetch_array()){
                            
                                    $nombreuserContadorC = $mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$extraerConsultaR['id']."' AND estado='rechazado' ");
                                    $columnaContadorC = $nombreuserContadorC->fetch_array(MYSQLI_ASSOC);
                                    $cnCC = mysqli_num_rows($nombreuserContadorC);
                                   
                                    if($cnCC > 0){
                                        $solicitudComprasConteoCedula++;
                                    }
                                    
                        }
                        
                        $solicituComprasCedula=$mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Orden de compra' ");
                        $solicitudComprasConteoComprador='0';
                        while($extraerConsultaR=$solicituComprasCedula->fetch_array()){
                                    //solicitudComprador
                                    $nombreuserComprador = $mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE idUsuario='$idparaChat' AND estado='pendiente'  AND estadoAprobador IS NULL AND idSolicitud='".$extraerConsultaR['id']."' ");
                                    $columnaComprador = $nombreuserComprador->fetch_array(MYSQLI_ASSOC);
                                    $cnComprador = mysqli_num_rows($nombreuserComprador);
                                   
                                    if($cnComprador > 0){
                                        $solicitudComprasConteoComprador++;
                                    }
                                    
                        }
                        
                        $solicituComprasCedulaVerificacion=$mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Orden de compra' ");
                        $solicitudComprasConteoCompradorVerificacion='0';
                        while($extraerConsultaRVerificacion=$solicituComprasCedulaVerificacion->fetch_array()){
                                    //solicitudComprador
                                    $nombreuserCompradorVerificacion = $mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE aprobador='$idparaChat' AND estadoAprobador='Pendiente' AND idSolicitud='".$extraerConsultaRVerificacion['id']."' ");
                                    $columnaCompradorVerificacion = $nombreuserCompradorVerificacion->fetch_array(MYSQLI_ASSOC);
                                    $cnCompradorVerificacion = mysqli_num_rows($nombreuserCompradorVerificacion);
                                   
                                    if($cnCompradorVerificacion > 0){
                                        $solicitudComprasConteoCompradorVerificacion++;
                                    }
                                    
                        }
                        
                        
                        $totalNotificacionProveedor=$notificacionComprasU+$notificacionComprasC+$notificacionComprasUR+$notificacionComprasCR+$solicitudComprasConteo+$solicitudComprasConteoCedula+$solicitudComprasConteoComprador+$solicitudComprasConteoCompradorVerificacion;
                        $totalNotificacionProveedorA=$notificacionComprasU+$notificacionComprasC+$notificacionComprasUR+$notificacionComprasCR;
                        
                        ?>
                          
        		            
        		                       
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"> <?php echo $totalNotificacionProveedor; ?> </font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Aprobación de proveedor</b><a style="color:red;text-decoration:none;" class="float-right"> <?php echo $totalNotificacionProveedorA; ?> </a>
                                        <ul>
                        <?php
                        $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERE notificacion='Pendiente' ");
                        while($extraerConsulta=$consultaProveedor->fetch_array()){
                            $extraerConsulta['razonSocial']; 
                            $id=$extraerConsulta['id'];
                            $radiobtn=$extraerConsulta['radio'];
                            $arrayEncargado=json_decode($extraerConsulta['aprobador']);
                            $nombreDocEnviar=$extraerConsulta['razonSocial'];
                            if($radiobtn == 'usuario'){ 
                                $longitud = count($arrayEncargado); 
                                for($i=0; $i<$longitud; $i++){
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' AND id='$idparaChat' ");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    $cn = mysqli_num_rows($nombreuser);
                                    $nombreResponsable=utf8_encode($columna['nombres']);    
                                    
                                    if($cn > 0){
                                    ?>
                                                    <li>
                                                          
                                                            <form action="proveedorDocumetosCarpetasB" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Proveedor '.$nombreDocEnviar; ?><a/>
                                                                <input type="hidden" name="idProveedor" value="<?php echo $id; ?>" >
                                                               
                                                                
                                                                
                                                              
                                                            </form>
                                                        </li><br>
                                     <?php  
                                    }
                                    
                                }
                            }
            
                            if($radiobtn == 'cargo'){
                            
                                $longitud = count($arrayEncargado);
                                for($i=0; $i<$longitud; $i++){ 
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$arrayEncargado[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos'];
                                    $cn = mysqli_num_rows($nombrecargo);
                                     if($cn > 0){
                                     ?>
                                        <li>
                                                          
                                                            <form action="proveedorDocumetosCarpetasB" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Proveedor '.$nombreDocEnviar; ?><a/>
                                                                <input type="hidden" name="idProveedor" value="<?php echo $id; ?>" >
                                                                
                                                                
                                                                
                                                              
                                                            </form>
                                        </li><br>
                                     <?php  
                                     }
                                }
                            }
                            
                        }
                       
                        $consultaProveedor=$mysqli->query("SELECT * FROM proveedores WHERE notificacion='Rechazado' AND realizador='$idparaChat' ");
                        while($extraerConsulta=$consultaProveedor->fetch_array()){
                            $extraerConsulta['razonSocial']; 
                            $id=$extraerConsulta['id'];
                            $radiobtn=$extraerConsulta['radio'];
                            $arrayEncargado=json_decode($extraerConsulta['aprobador']);
                            $nombreDocEnviar=$extraerConsulta['razonSocial'];
                            //if($radiobtn == 'usuario'){ 
                                $longitud = count($arrayEncargado); 
                                //for($i=0; $i<$longitud; $i++){
                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' AND id='$idparaChat' ");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    $cn = mysqli_num_rows($nombreuser);
                                    $nombreResponsable=utf8_encode($columna['nombres']);    
                                    
                                    //if($cn > 0){
                                    ?>
                                                    <li>
                                                          
                                                            <form action="proveedorDocumetosCarpetas" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Proveedor '.$nombreDocEnviar; ?><a/><br>
                                                                <font color="red">Documentos rechazados</font>
                                                                <input type="hidden" name="idProveedor" value="<?php echo $id; ?>" >
                                                               
                                                                
                                                                
                                                              
                                                            </form>
                                                        </li><br>
                                     <?php  
                                    //}
                                    
                                //}
                            //}
                        /*
                            if($radiobtn == 'cargo'){
                            
                                $longitud = count($arrayEncargado);
                                for($i=0; $i<$longitud; $i++){ 
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$arrayEncargado[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos'];
                                    $cn = mysqli_num_rows($nombrecargo);
                                     if($cn > 0){
                                     ?>
                                        <li>
                                                          
                                                            <form action="proveedorDocumetosCarpetas" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Proveedor '.$nombreDocEnviar; ?><a/>
                                                                <input type="hidden" name="idProveedor" value="<?php echo $id; ?>" >
                                                                
                                                                
                                                                
                                                              
                                                            </form>
                                        </li><br>
                                     <?php  
                                     }
                                }
                            }
                         */  
                        }
                        ?>
                                                    
                                                        
                                        
                                            
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li class="list-group-item"><b>Solicitud</b><a style="color:red;text-decoration:none;" class="float-right"> <?php echo $solicitudComprasConteo+$solicitudComprasConteoCedula; ?> </a>
                                        <ul>
                        <?php
                        $consultaProveedor=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE estado='pendiente' AND idUsuario='$idparaChat' ");
                        while($extraerConsulta=$consultaProveedor->fetch_array()){
                          
                                
                                    ?>
                                                    <li>
                                                          
                                                            <form action="solicitudCompraGestionar" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud #  '.$extraerConsulta['idSolicitud']; ?><a/>
                                                                <br>
                                                                <?php
                                                                if($extraerConsulta['rol'] == '1'){
                                                                ?>
                                                                <font color="green">Revisar solicitud</font>
                                                                <?php
                                                                }else{
                                                                ?>
                                                                <font color="green">Aprobar solicitud</font>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" name="idOrdenCompra" value="<?php echo $extraerConsulta['idSolicitud']; ?>" >
                                                               
                                                                
                                                                
                                                              
                                                            </form>
                                                        </li><br>
                                                        
                                     <?php  
                                    
                              
                        }
                       
                     
                        $solicituComprasCedula=$mysqli->query("SELECT * FROM solicitudCompra WHERE idUsuario='$cc' ");
                       
                        while($extraerConsultaR=$solicituComprasCedula->fetch_array()){
                            
                                    $nombreuserContadorC = $mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$extraerConsultaR['id']."' AND estado='rechazado' ");
                                    $columnaContadorC = $nombreuserContadorC->fetch_array(MYSQLI_ASSOC);
                                    $cnCC = mysqli_num_rows($nombreuserContadorC);
                                   
                                    if($cnCC > 0){
                                        ?>
                                         <li>
                                                          
                                                            <form action="registroProductos" method="POST">
                                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                </a>
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud #  '.$extraerConsultaR['id']; ?><a/>
                                                                <br><font color="red">Solicitud rechazada</font>
                                                                <input type="hidden" name="idOrdenCompra" value="<?php echo $extraerConsultaR['id']; ?>" >
                                                               
                                                                
                                                                
                                                              
                                                            </form>
                                                        </li><br>
                                        <?php
                                    }
                                    
                        }
                        
                        
                        
                        ?>
                          
                                                    
                                                        
                                        
                                            
                                        </ul>
                                    </li>
                                    
                                <li class="list-group-item"><b>Orden de compra</b><a style="color:red;text-decoration:none;" class="float-right"> <?php echo $solicitudComprasConteoComprador; ?> </a>
                                        <ul>   
                                <?php  
                                 $solicituComprasCedulComprador=$mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Orden de compra' ");
                               
                                while($extraerConsultaComprador=$solicituComprasCedulComprador->fetch_array()){
                                            
                                            //// solicitudComprador
                                            $nombreuserComprador = $mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE idUsuario='$idparaChat' AND estado='pendiente' AND estadoAprobador IS NULL AND idSolicitud='".$extraerConsultaComprador['id']."' ");
                                            $columnaComprador = $nombreuserComprador->fetch_array(MYSQLI_ASSOC);
                                            $cnComprador = mysqli_num_rows($nombreuserComprador);
                                           
                                            if($cnComprador > 0){
                                                $count='1';
                                                 $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                                $string="";
                                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                                    
                                                    if($extraerConsecutivo['aplicado'] == '1'){
                                                        $string.=($columnaComprador['id']);
                                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                                        $string.=($columnaComprador['fechaActivada']);
                                                    }else{
                                                      
                                                     $string.=($extraerConsecutivo['caracter']);
                                                    }
                                                    $string .= "-";
                                                }
                                                $newStrinG=trim($string, '-');
                                                $enviarOrdenCOmpra=$newStrinG;
                                                //$count++;
                                                ?>
                                                 <li>
                                                                  
                                                                    <form action="solicitudCompradorVer" method="POST">
                                                                        <a style="color:red;text-decoration:none;" class="float-right">
                                                                            <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                        </a>
                                                                        <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud #  '.$extraerConsultaComprador['id']; ?><a/><br>
                                                                         <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Orden de compra # '.$columnaComprador['id']; '-'.$count++; //$enviarOrdenCOmpra?><a/>
                                                                        <br><font color="red"><?php echo $columnaComprador['estado'];?></font>
                                                                        <input type="hidden" name="idOrdenCompra" value="<?php echo $extraerConsultaComprador['id']; ?>" >
                                                                       
                                                                        
                                                                        
                                                                      
                                                                    </form>
                                                                </li><br>
                                                <?php
                                            }
                                            
                                }
                                ?>
                                </ul>
                                    </li>
                                    
                                    
                                    
                                <li class="list-group-item"><b>Verificar Orden de compra</b><a style="color:red;text-decoration:none;" class="float-right"> <?php echo $solicitudComprasConteoCompradorVerificacion; ?> </a>
                                        <ul>   
                                <?php  
                                 $solicituComprasCedulComprador=$mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Orden de compra' ");
                               
                                while($extraerConsultaComprador=$solicituComprasCedulComprador->fetch_array()){
                                            //solicitudComprador
                                            $nombreuserComprador = $mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE aprobador='$idparaChat' AND estadoAprobador='Pendiente' AND idSolicitud='".$extraerConsultaComprador['id']."' ");
                                            $columnaComprador = $nombreuserComprador->fetch_array(MYSQLI_ASSOC);
                                            $cnComprador = mysqli_num_rows($nombreuserComprador);
                                           
                                            if($cnComprador > 0){
                                                 $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                                $string="";
                                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                                    
                                                    if($extraerConsecutivo['aplicado'] == '1'){
                                                        $string.=($columnaComprador['id']);
                                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                                        $string.=($columnaComprador['fechaActivada']);
                                                    }else{
                                                     $string.=($extraerConsecutivo['caracter']);
                                                    }
                                                    $string .= "-";
                                                }
                                                $newStrinG=trim($string, '-');
                                                $enviarOrdenCOmpra=$newStrinG;
                                                ?>
                                                 <li>
                                                                  
                                                                    <form action="verificarSolicitudVer" method="POST"> <!-- solicitudCompradorVer -->
                                                                        <a style="color:red;text-decoration:none;" class="float-right">
                                                                            <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                        </a>
                                                                        <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Solicitud #  '.$extraerConsultaComprador['id']; ?><a/><br>
                                                                         <b>*</b><a style="color:black;text-decoration:none;" ><?php echo 'Orden de compra #  '.$columnaComprador['id']; //$enviarOrdenCOmpra; ?><a/>
                                                                        <br><font color="red"><?php echo $columnaComprador['estado'];?></font>
                                                                        <input type="hidden" name="idOrdenCompra" value="<?php echo $extraerConsultaComprador['id']; ?>" >
                                                                       
                                                                        
                                                                        
                                                                      
                                                                    </form>
                                                                </li><br>
                                                <?php
                                            }
                                            
                                }
                                ?>
                                </ul>
                                    </li>
                                    
                                    
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    
                    
                    
              
                 



                    
                </div>
              <!-- /.card-body -->
            </div>
            <!-- fin mis pendientes -->
            
            
            
            
            <div class="card card-primary">
              <div class="card-header">
                
                <h3 class="card-title"><b>Presupuesto Asignado</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  
                  
                  <?php  
                  /////////////////// conteo para presupuesto
                                                $consultaGruposComprasPresupuesto = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula'  ")or die(mysqli_error());
                                                while($grupoUsuarioComprasPresupuesto = $consultaGruposComprasPresupuesto->fetch_array()){
                                                    $idGrupoPresupuesto=$grupoUsuarioComprasPresupuesto['idGrupo'];
                                                
                                                    $consultaGruposNombreIdPresupuesto = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoPresupuesto' ")or die(mysqli_error());
                                                    $grupoUsuarioNombreIdPresupuesto = $consultaGruposNombreIdPresupuesto->fetch_array(MYSQLI_ASSOC);
                                                    $idGrupoValidandoPresupuesto=$grupoUsuarioNombreIdPresupuesto['id'];
                                                    $grupoUsuarioNombreIdPresupuesto['nombre'];
                                                
                                                    $consultaGruposNotificacionPresupuesto = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoPresupuesto' AND formulario='presupuesto' ")or die(mysqli_error());
                                                    $grupoUsuarioNotificacionPresupuesto = $consultaGruposNotificacionPresupuesto->fetch_array(MYSQLI_ASSOC);
                                                    $grupoUsuarioNotificacionPresupuesto['plataforma'];
                                                    if($grupoUsuarioNotificacionPresupuesto['plataforma']){
                                                         $validandoGrupoPresupuesto+=$grupoUsuarioNotificacionPresupuesto['plataforma'];
                                                    }else{
                                                        //echo 'conteo: 0';
                                                    }
                                                }
                                                
                                               $validandoGrupoPresupuesto; //'<br>Permiso politicas:'
                            
                            if($validandoGrupoPresupuesto > 0){
                                                
                            $sqlActas= $mysqli->query("SELECT * FROM presupuestoGestionar  "); //WHERE plataformaH='1'
                            $conteoActas = 0;
                            $conteoActasC = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                
        		                 
        		                $tipoPersonal = $row['tipoResponsable'];
        		                $personalID =  json_decode($row['responsable']);
                                $longitud = count($personalID);  
        		                
        		               
                                
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActas++;
                                        $idDatoActas = $row['idPresupuesto'];
                                        //$nombreDatoActas = $row['nombreActa'];
                                        $queryNombrePresupuesto = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idDatoActas' ");
                                        $datosNombrePresupuesto = $queryNombrePresupuesto->fetch_array(MYSQLI_ASSOC);
                                        $nombreDatoActas=$datosNombrePresupuesto['nombre'];
                                        ?>
                                        <strong><i class="fas fa-book mr-1"></i> <?php echo $nombreDatoActas; ?></strong>
                                        <form action="presupuestoGestionar" method="POST">
                                                <input type="hidden" readonly name="idPresupuesto" value="<?php echo $idDatoActas; ?>">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                        </form>
                                        <p class="text-muted">
                                        <?php
                                        ///////////// se traen los datos para el nombre del proceso o costo
                                        $tipoProcesoCosto=$row['tipoProcesoCosto'];
                                        $procesoCostoDatos=json_decode($row['procesoCosto']);
                                        $longitudP = count($procesoCostoDatos);
                                        if($tipoProcesoCosto == 'proceso'){
                                            
                                            for($i=0; $i<$longitudP; $i++){
                                                
                                                $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id = '$procesoCostoDatos[$i]'");
                                                $columnaP = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                             echo $columnaP['nombre'];echo "<br>";
                                             
                                            } 
                                         
                                        }else{
                                            
                                            for($i=0; $i<$longitud; $i++){
                                            $nombreCentro = $mysqli->query("SELECT * FROM centroCostos WHERE id = '$procesoCostoDatos[$i]'");
                                            $columnaC = $nombreCentro->fetch_array(MYSQLI_ASSOC);
                                            
                                            echo $columnaC['nombre']; echo "<br>"; 
                                            
                                            }
                                        }
                                        ///// fn del proceso
                                        ?>
                                            </p>
                                            
                                       
                                        
                                        <?php
                                        }
                                        
                                    } //// cierre del for
                                } //// cierre del if
                                
                                
                                if($tipoPersonal == 'cargo'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    //echo $columna['nombreCargos'];
                                    
                                    $cn = mysqli_num_rows($nombrecargo);
                                        
                                        if($cn > 0){
                                        $conteoActasC++;    
                                        $idDatoActas = $row['idPresupuesto'];
                                        //$nombreDatoActas = $row['nombreActa'];
                                        $queryNombrePresupuesto = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idDatoActas' ");
                                        $datosNombrePresupuesto = $queryNombrePresupuesto->fetch_array(MYSQLI_ASSOC);
                                        $nombreDatoActas=$datosNombrePresupuesto['nombre'];
                                                       
                                        ?>
                                        <strong><i class="fas fa-book mr-1"></i> <?php echo $nombreDatoActas; ?></strong>
                                            <form action="presupuestoGestionar" method="POST">
                                                <input type="hidden" readonly name="idPresupuesto" value="<?php echo $idDatoActas; ?>">
                                                <a style="color:red;text-decoration:none;" class="float-right">
                                                    <button type="submit" style="width:35px;" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                </a>
                                            </form>
                                        <p class="text-muted">
                                         <?php
                                        ///////////// se traen los datos para el nombre del proceso o costo
                                        $tipoProcesoCosto=$row['tipoProcesoCosto'];
                                        $procesoCostoDatos=json_decode($row['procesoCosto']);
                                        $longitudP = count($procesoCostoDatos);
                                        if($tipoProcesoCosto == 'proceso'){
                                            
                                            for($i=0; $i<$longitudP; $i++){
                                                
                                                $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id = '$procesoCostoDatos[$i]'");
                                                $columnaP = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                             echo $columnaP['nombre'];echo "<br>";
                                             
                                            } 
                                         
                                        }else{
                                            
                                            for($i=0; $i<$longitud; $i++){
                                            $nombreCentro = $mysqli->query("SELECT * FROM centroCostos WHERE id = '$procesoCostoDatos[$i]'");
                                            $columnaC = $nombreCentro->fetch_array(MYSQLI_ASSOC);
                                            
                                            echo $columnaC['nombre']; echo "<br>"; 
                                            
                                            }
                                        }
                                        ///// fn del proceso
                                        ?>
                                        </p>
                                            
                                        
                                        
                                        <?php
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            
        		    } /// cierre si la notificacion esta activada o no        
                    ?>
                  
                  
                  
                  
                  
               

                <hr>
<!--
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
              </div>
              <!-- /.card-body -->
            </div>