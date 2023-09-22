 <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>"  alt="User profile picture">
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
                    <b>Lider</b> <a class="float-right"><?php echo $nombreLider; ?></a>
                  </li>
                  <li  class="list-group-item">
                    <button Onclick="window.location='chat'" class="btn btn-block btn-info btn-sm float-right"><b>Chat</b></button>
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
                                        
                                        if($validandoGrupo >= '1'){
                                                $query = $mysqli->query("SELECT count(*) FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo' AND estado IS NULL AND plataformaH='1' ");
                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteo= $row['count(*)'];
                                            }else{
                                                $nombrecargoConteo=0;
                                            }
                                            
                                            
                                            ///////////////// esta es para la función de las notificaciones de creación, aprobación y rechazo
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
                                        
                                        if($validandoGrup2o >= '1'){
                                                $query = $mysqli->query("SELECT * FROM documento WHERE plataformaH='1' ");
                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                $nombrecargoConteo2= $row['count(*)'];
                                            }else{
                                                $nombrecargoConteo2=0;
                                            }
                                            /////////////////////////////////
                                        ///////// fin del proceso
                                    
                                    
                                    //////////// los que elaboran
                                    ///////////// se trae la tabla de documento
                                    
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Pendiente' "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1'
                                        
                                        $conteo = 0;
                                        $conteoC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalID =  json_decode($row['elabora']);
                                        $longitud = count($personalID);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalID as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalID[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
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
                		           
                                    //////// fin proceso de elaboracion
                                    
                                    
                                    
                                    //////////// los que revisan
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Elaborado' "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1'
                                        
                                        $conteoRC = 0;
                                        $conteoRCC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalID =  json_decode($row['revisa']);
                                        $longitud = count($personalID);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalID as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalID[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
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
                		           
                                    //////// fin proceso de revisan
                                    
                                    
                                    
                                    
                                    
                                    
                                    //////////// los que aprueban
                                    ///////////// se trae la tabla de documento
                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Revisado' "); //SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1'
                                        
                                        $conteoRA = 0;
                                        $conteoRAC = 0;
                                        
                                        while($row = $sql->fetch_assoc()){
                		                
                                        $personalID =  json_decode($row['aprueba']);
                                        $longitud = count($personalID);
                                        
                                        
                                        //echo $personalID[0];
                                        
                                        foreach($personalID as $dato){
                                           // echo $dato; echo "<br>";
                                        }
                                        
                                        
                                            if($personalID[0] == 'usuarios'){
                                                
                                                
                                                for($i=0; $i<$longitud; $i++){
                                                    ///////////// para traer conteo de los usuarios
                                                    
                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo");
                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                //echo $columna['nombreCargos'];
                                                $cn = mysqli_num_rows($nombreuser);
                                                    
                                                    //echo $cn; echo "<br>";
                                                    if($cn > 0){
                                                        /// se imprime el id
                                                        $row['id'];
                                                        $conteoRAC++;
                                                    }
                                                }
                                            } 
                		                }
                		           
                                    //////// fin proceso de aprueban
                                    
                                    
                                    
                                ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php echo $suma=$nombrecargoConteo+$conteo+$conteoC+$conteoRC+$conteoRCC+$conteoRA+$conteoRAC; ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Solicitud</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $nombrecargoConteo; ?></a>
                                        <ul><?php 
                                                
                                                ///// la validacion la usamos para mostrar o no la información de las notificaciones de solicitud
                                                if($validandoGrupo >= 1){
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo' AND estado IS NULL AND plataformaH='1' ");
                                    		            while($row = $sql->fetch_assoc()){
                                    		                 
                                    		                 $tipoSolicitud=$row['tipoSolicitud'];
                                    		                
                                    		                if($tipoSolicitud == 1){
                                    		                     
                                    		                     $nombreDocumento=$row['nombreDocumento'];
                                    		                
                                    		                }else{
                                    		                     
                                    		                     $idDocumento=$row['nombreDocumento'];
                                    		                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    		                     $nombreDocumento = $mysqli->query("SELECT nombres FROM `documento` WHERE id = '$idDocumento' ");
                                                                 $documentoC = $nombreDocumento->fetch_array(MYSQLI_ASSOC);
                                                                 $nombreDocumento = $documentoC['nombres'];
                                    		                }
                                    		                
                                                	?>
                                                    <li>
                                                        <form action="solicitudDocumentosSeguimiento" method="POST">
                                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDocumento; ?><a/>
                                                            <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                                            <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                        </form>
                                                    </li>
                                                    
                                                    <?php
                                                        }
                                                }  //// fin de la validación del if
                                            ?>
                                        </ul>
                                    </li>
                                    
                                    <li class="list-group-item"><b>Creaci&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php  if($validandoGrup2o >= 0){ echo $creacion=$conteo+$conteoC; }else{ echo $creacion='0'; } ?></a>
                                        <ul>
                                           <?php
                                           
                                           //// inicio de la notificación
                                         //  if($validandoGrup2o >= 1){
                                           
                                           
                                                                //////////// los que elaboran
                                                        ///////////// se trae la tabla de documento
                                                            $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Pendiente'  "); //SELECT * FROM documento WHERE estado='Pendiente' AND plataformaH='1'
                                                            
                                                            $conteo = 0;
                                                            
                                                            
                                                            while($row = $sql->fetch_assoc()){
                                    		                
                                                            $personalID =  json_decode($row['elabora']);
                                                            $longitud = count($personalID);
                                                            
                                                            
                                                            //echo $personalID[0];
                                                            
                                                            foreach($personalID as $dato){
                                                               // echo $dato; echo "<br>";
                                                            }
                                                            
                                                            
                                                                if($personalID[0] == 'usuarios'){
                                                                    
                                                                    
                                                                    for($i=0; $i<$longitud; $i++){
                                                                        ///////////// para traer conteo de los usuarios
                                                                        
                                                                        $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                                                <form action="revisaDoc" method="POST">
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
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
                                                                    $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
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
                                                                                <form action="revisaDoc" method="POST">
                                                                                    <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                                    <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                    <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                    <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                                </form>
                                                                            </li>
                                                                            
                                                                            <?php
                                                                            //////////// fin del proceso de los nombres por medio del id
                                                                            
                                                                        }
                                                                    }
                                                                } 
                                    		                }
                                    		           
                                                        //////// fin proceso de elaboracion
                                    
                                    
                                    
                                           //} ////Fin de la validación del if de notificaciones
                                           ?>
                                            
                                        </ul>
                                    </li>
                                    <li class="list-group-item"><b>Revis&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php if($validandoGrup2o >= 0){ echo $revision=$conteoRC+$conteoRCC; }else{ echo $revision='0'; }  ?></a>
                                        <ul>
                                    <?php
                                            
                                    //// inicio de la notificación
                                          // if($validandoGrup2o >= 0){
        
                                            
                                            
                                            
                                            
                                                //////////// los que revisan
                                                ///////////// se trae la tabla de documento
                                                    $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Elaborado'  "); //SELECT * FROM documento WHERE estado='Elaborado' AND plataformaH='1' 
                                                    
                                                    $conteo = 0;
                                                    
                                                    
                                                    while($row = $sql->fetch_assoc()){
                            		                
                                                    $personalID =  json_decode($row['revisa']);
                                                    $longitud = count($personalID);
                                                    
                                                    
                                                    //echo $personalID[0];
                                                    
                                                    foreach($personalID as $dato){
                                                       // echo $dato; echo "<br>";
                                                    }
                                                    
                                                    
                                                        if($personalID[0] == 'usuarios'){
                                                            
                                                            
                                                            for($i=0; $i<$longitud; $i++){
                                                                ///////////// para traer conteo de los usuarios
                                                                
                                                                $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                                        <form action="revisaDoc" method="POST">
                                                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                            <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                            <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                            <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
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
                                                            $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalID[$i]' 
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
                                                                        <form action="revisaDoc" method="POST">
                                                                            <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                            <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                            <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                            <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                        </form>
                                                                    </li>
                                                                    
                                                                    <?php
                                                                    //////////// fin del proceso de los nombres por medio del id
                                                                    
                                                                }
                                                            }
                                                        } 
                            		                }
                            		           
                                                //////// fin proceso de revisa
                                                
                                           /// } ////Fin de la validación del if de notificaciones
                                           ?>
                                        </ul>
                                    </li>
                                    <li class="list-group-item"><b>Aprobaci&oacute;n</b><a style="color:red;text-decoration:none;" class="float-right"><?php if($validandoGrup2o >= 0){ echo $aprobacion=$conteoRA+$conteoRAC; }else{ echo $aprobacion='0'; }  ?></a>
                                        <ul>
                                            <?php
                                            
                                            //// inicio de la notificación
                                         //  if($validandoGrup2o >= 0){
                                            
                                            
                                            
                                                    //////////// los que aprueban
                                                    ///////////// se trae la tabla de documento
                                                        $sql= $mysqli->query("SELECT * FROM documento WHERE estado='Revisado' "); /// SELECT * FROM documento WHERE estado='Revisado' AND plataformaH='1'
                                                        
                                                        $conteo = 0;
                                                        
                                                        
                                                        while($row = $sql->fetch_assoc()){
                                		                
                                                        $personalID =  json_decode($row['aprueba']);
                                                        $longitud = count($personalID);
                                                        
                                                        
                                                        //echo $personalID[0];
                                                        
                                                        foreach($personalID as $dato){
                                                           // echo $dato; echo "<br>";
                                                        }
                                                        
                                                        
                                                            if($personalID[0] == 'usuarios'){
                                                                
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    ///////////// para traer conteo de los usuarios
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT nombres FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
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
                                                                            <form action="revisaDoc" method="POST">
                                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                                <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
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
                                                                $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
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
                                                                            <form action="revisaDoc" method="POST">
                                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreCreacion; ?><a/>
                                                                                <input type="hidden" readonly name="idDocumento" value="<?php echo $iddocumentoDepersonaAelaborar; ?>">
                                                                                <input type="hidden" readonly name="solicitud" value="<?php echo $solicitudAelaborar; ?>">
                                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                            </form>
                                                                        </li>
                                                                        
                                                                        <?php
                                                                        //////////// fin del proceso de los nombres por medio del id
                                                                        
                                                                    }
                                                                }
                                                            } 
                                		                }
                                		           
                                                    //////// fin proceso de aprueban
                                                    
                                         //   } ////Fin de la validación del if de notificaciones
                                           ?>
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    
                    
                    
                    
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Actas e Informes</b></h3>
                        <?php
                          /*  $sqlActas= $mysqli->query("SELECT * FROM compromisos where estado != 'Aprobado' ");
                            $conteoActas = 0;
                            $conteoActasC = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $idActa = $row['idActa'];
        		                /////////////////  validacion de estados del acta parala notificacion del compromiso
        		                                        $validandoActaEstado = $mysqli->query("SELECT estado FROM `actas` WHERE id='$idActa' ");
                                                        $datoActasValidandoActaEstado = $validandoActaEstado->fetch_array(MYSQLI_ASSOC);
                                                        $validandoEstadoActa = $datoActasValidandoActaEstado['estado'];
                                                        
                                                        if($validandoEstadoActa == 'Pendiente'){
                                                            continue;
                                                        }
        		                /////////////////  validacion de estados del acta parala notificacion del compromiso
        		                $tipoPersonal = $row['responsableCompromiso'];
        		                $personalID =  json_decode($row['responsableID']);
                                $longitud = count($personalID);
                                
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActas++;    
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
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while */
        		            
        		            
                             //////////// validacion para los compromisos listos para aprobar  
                            $sqlActas= $mysqli->query("SELECT * FROM compromisos where estado='Pendiente' ");
                            $conteoActasA = 0;
                            $conteoActasCA = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $idActa = $row['idActa'];
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
                                        $conteoActasA++;    
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
                                        $conteoActasCA++;    
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            
        		            
        		            
        		             //////////// validacion pra aprobar actas generales quienes el estado es rechazado
                            $sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Rechazado' AND finalizada = 1");
                            $conteoActasAGS = 0;
                            $conteoActasCAGS = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $idActa = $row['idActa'];
        		                $ValidacionEstado=$row['estado'];
        		                
        		                $validacionFinalizada=$row['notificacionAct'];
        		                
        		                    $tipoPersonal = $row['quienElabora'];
            		                $personalID =  json_decode($row['quienElaboraID']);
                                    $longitud = count($personalID); 
        		                 
        		               
        		                
                                
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActasAGS++;    
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
                                        $conteoActasCAGS++;    
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            //////////////// en esta parte de las actas son para los que estan en pendiete
        		            
        		            $sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Pendiente' AND finalizada = 1");
                            $conteoActasAGP = 0;
                            $conteoActasCAGP = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $idActa = $row['idActa'];
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
                                        $conteoActasAGP++;    
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
                                        $conteoActasCAGP++;    
                                        }
                                        
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            $conteoActasAG=$conteoActasAGS+$conteoActasAGP;
        		            $conteoActasCAG=$conteoActasCAGS+$conteoActasCAGP;
        		           
        		            
        		            
        		            
        		            //$totalConteoActasCompromisos=$conteoActas+$conteoActasC;
        		            $totalConteoActasAprobador=$conteoActasA+$conteoActasCA;
        		            $totalConteoActasAprobadorGenerales=$conteoActasAG+$conteoActasCAG;
        		            $totalConteoActas=$totalConteoActasAprobador+$totalConteoActasAprobadorGenerales;
        		            
        		            
        		            
        		            
        		            /////////////////////////////////////// validaciones para las compras
        		            
        		           
        		            
        		           
        		            
                                ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"><?php echo $totalConteoActas; ?></font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Aprobaci&oacute;n compromiso</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalConteoActasAprobador; ?></a>
                                        <ul>
                                            <?php
                            $sqlActas= $mysqli->query("SELECT * FROM compromisos where estado='Pendiente'  ");
                            $conteoActas = 0;
                            $conteoActasC = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                $idActa = $row['idActa'];
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
                                        $conteoActas++;
                                        $idActa = $row['idActa'];
                                                        $nombreActasD = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idActa' ");
                                                        $datoActas = $nombreActasD->fetch_array(MYSQLI_ASSOC);
                                                        $nombreDatoActas = $datoActas['nombreActa'];
                                                        $idDatoActas = $datoActas['id'];
                                                        $actaCargada = $datoActas['actaCargada'];
                                        ?>
                                        <li>
                                            <?php  if($actaCargada == 1){  ?>
                                            <form action="verActaC" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        <?php
                                            }else{
                                        ?>
                                            <form action="seguimientoActas" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>"><br>
                                                *<?php echo $row['compromiso']; ?>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        </li>
                                        <?php
                                            } /// cierre de la comparaci贸n si es 1 o 0
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
                                        $idActa = $row['idActa'];
                                                        $nombreActasD = $mysqli->query("SELECT * FROM `actas` WHERE id = '$idActa' ");
                                                        $datoActas = $nombreActasD->fetch_array(MYSQLI_ASSOC);
                                                        $nombreDatoActas = $datoActas['nombreActa'];
                                                        $idDatoActas = $datoActas['id'];
                                                        $actaCargada = $datoActas['actaCargada'];
                                        ?>
                                        <li>
                                            <?php  if($actaCargada == 1){  ?>
                                            <form action="verActaC" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>"><br>
                                               *<?php echo $row['compromiso']; ?>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        <?php
                                            }else{
                                        ?>
                                            <form action="seguimientoActas" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        </li>
                                        <?php
                                            } /// cierre de la comparaci贸n si es 1 o 0
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            $totalConteoActas=$conteoActas+$conteoActasC;
        		            
                                ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    <li class="list-group-item"><b>Aprobaci&oacute;n Actas</b><a style="color:red;text-decoration:none;" class="float-right"><?php echo $totalConteoActasAprobadorGenerales; ?></a>
                                        <ul>
                                            <?php
                                /////// validacion para sacar el estado pendiente y rechazado
                            $sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Pendiente' AND finalizada = 1 ");
                            $conteoActas = 0;
                            $conteoActasC = 0;
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
                                        $conteoActas++;
                                        $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
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
                                         $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];               
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        </li>
                                        
                                        <?php
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		                        
                                            
                                            
                             /////// validacion para sacar el estado pendiente y rechazado
                            $sqlActas= $mysqli->query("SELECT * FROM actas WHERE estado='Rechazado' AND finalizada = 1 ");
                            $conteoActas = 0;
                            $conteoActasC = 0;
        		            while($row = $sqlActas->fetch_assoc()){
        		                
        		                $ValidacionEstado=$row['estado'];
        		                
        		                $validacionFinalizada=$row['notificacionAct'];
        		                
        		               
        		                         
                                    $tipoPersonal = $row['quienElabora'];
                		            $personalID =  json_decode($row['quienElaboraID']);
                                    $longitud = count($personalID);
        		              
                                    
                                    
                                    
                            
                            if($tipoPersonal == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreActas = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalID[$i]' AND cedula='$sesion' ");
                                        $columna = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                        //echo $columna['nombres'];
                                        
                                        $cn = mysqli_num_rows($nombreActas);
                                        
                                        if($cn > 0){
                                        $conteoActas++;
                                        $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
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
                                         $idDatoActas = $row['id'];
                                        $nombreDatoActas = $row['nombreActa'];
                                        $actaCargada = $row['actaCargada'];               
                                        ?>
                                        <li>
                                            <form action="verActa" method="POST">
                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $nombreDatoActas; ?><a/>
                                                <input type="hidden" readonly name="idActa" value="<?php echo $idDatoActas; ?>">
                                                <b><?php echo $ValidacionEstado=$row['estado']; ?></b>
                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                            </form>
                                        </li>
                                        
                                        <?php
                                        }
                                    } //// for
                                } /// cierre if
        		            } /// cierre del while
        		            
                                                       
        		            $totalConteoActas=$conteoActas+$conteoActasC;
        		            
                                ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </ul>
                            </nav>
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                    
                    
                    
                    
                    <!-- acá empieza las notificaciones para compras -------------------------------------  -->
                    
                    <div class="card card-primary collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title"><b>Compras</b></h3>
                        <?php
                          
        		            
        		                        $consultaGruposComprasAprobar = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula'  ")or die(mysqli_error());
                                        while($grupoUsuarioComprasAprobador = $consultaGruposComprasAprobar->fetch_array()){
                                        $idGrupoAprobador=$grupoUsuarioComprasAprobador['idGrupo'];
                                        
                                            $consultaGruposNombreIdAprobador = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoAprobador' ")or die(mysqli_error());
                                            $grupoUsuarioNombreIdAprobador = $consultaGruposNombreIdAprobador->fetch_array(MYSQLI_ASSOC);
                                            $idGrupoValidandoAprobador=$grupoUsuarioNombreIdAprobador['id'];
                                            $grupoUsuarioNombreIdAprobador['nombre'];
                                        
                                            $consultaGruposNotificacionAprobador = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoAprobador' AND formulario='solicitudCom' ")or die(mysqli_error());
                                            $grupoUsuarioNotificacionAprobador = $consultaGruposNotificacionAprobador->fetch_array(MYSQLI_ASSOC);
                                            $grupoUsuarioNotificacionAprobador['plataforma'];
                                            if($grupoUsuarioNotificacionAprobador['plataforma']){
                                                 $validandoGrupoAprobador+=$grupoUsuarioNotificacionAprobador['plataforma']; 
                                            }else{
                                                //echo 'conteo: 0'; echo '<br>';
                                            }
                                        }
                                        
                                        $validandoGrupoAprobador;
                            
                                        
                                        /// validamos la info del usuario de lider que inicia la sesion para que muestre las solicitudes de compra
                                            $validacionLiderConteo = $mysqli->query("SELECT * FROM usuario WHERE lider ='$consultaIdLider' ")or die(mysqli_error());
                                            $datoLiderConteo = $validacionLiderConteo->fetch_array(MYSQLI_ASSOC);
                                            $validandoCCConteo=$datoLiderConteo['cedula'];
                                        
                                        
                                        ///// fin del proceso
                                        
                                      
                                                ////////////////// conteo para las solicitudes
                                                $conteoSolitidCompra=0;
                                                $sqlSolicitudComprasConteo= $mysqli->query("SELECT * FROM solicitudCompra where estado = 'Pendiente' AND idUsuario='$validandoCCConteo' AND plataformaH='1' ");
                                                while($rowSolicitudComprasConteo = $sqlSolicitudComprasConteo->fetch_assoc()){
                            		                
                                                    if($validandoGrupoAprobador >= '1'){
                                                        $conteoSolitidCompra++;
                                    
                                                    }else{
                                                        //echo 'No existe';
                                                    }
                                                
                                                
                                                } /// cierre del while
                                                $conteoSolitidCompra;
                                                
                                                /////////////////// conteo para las politicas
                                                $consultaGruposComprasPolitica = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula'  ")or die(mysqli_error());
                                                while($grupoUsuarioComprasPolitica = $consultaGruposComprasPolitica->fetch_array()){
                                                    $idGrupoPolitica=$grupoUsuarioComprasPolitica['idGrupo'];
                                                
                                                    $consultaGruposNombreIdPolitica = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupoPolitica' ")or die(mysqli_error());
                                                    $grupoUsuarioNombreIdPolitica = $consultaGruposNombreIdPolitica->fetch_array(MYSQLI_ASSOC);
                                                    $idGrupoValidandoPolitica=$grupoUsuarioNombreIdPolitica['id'];
                                                    $grupoUsuarioNombreIdPolitica['nombre'];
                                                
                                                    $consultaGruposNotificacionPolitica = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidandoPolitica' AND formulario='politicas' ")or die(mysqli_error());
                                                    $grupoUsuarioNotificacionPolitica = $consultaGruposNotificacionPolitica->fetch_array(MYSQLI_ASSOC);
                                                    $grupoUsuarioNotificacionPolitica['plataforma'];
                                                    if($grupoUsuarioNotificacionPolitica['plataforma']){
                                                         $validandoGrupoPolitica+=$grupoUsuarioNotificacionPolitica['plataforma'];
                                                    }else{
                                                        //echo 'conteo: 0';
                                                    }
                                                }
                                                
                                                $validandoGrupoPolitica; //'<br>Permiso politicas:'
                                                
                                                
                                                if($validandoGrupoPolitica > 0){ 
                                                
                                                
                                                            $sqlPoliticas= $mysqli->query("SELECT * FROM politicas where plataformaH='1' ");
                                                            $contadorPoliticasU='0';
                                                            $contadorPoliticasC='0';
                                                            while($rowPoliticas = $sqlPoliticas->fetch_assoc()){
                                        		                $tipoPersonalPolitica = $rowPoliticas['tipoAprobador'];
                                        		                $montoMinimo = $rowPoliticas['minimo'];
                                        		                $montoMaximo = $rowPoliticas['maximo'];
                                        		                $personalIDPolitica =  json_decode($rowPoliticas['aprobador']);
                                                                $longitudPolitica = count($personalIDPolitica);  
                    		                
                    		                                    /// validacion politicas
                                                                    if($tipoPersonalPolitica == 'usuario'){
                                                                            
                                                                            for($i=0; $i<$longitudPolitica; $i++){
                                                                                
                                                                                $nombrePlitica = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalIDPolitica[$i]' AND cedula='$sesion' ");
                                                                                $columna = $nombrePlitica->fetch_array(MYSQLI_ASSOC);
                                                                                //echo $columna['nombres'];
                                                                                
                                                                                $cn = mysqli_num_rows($nombrePlitica);
                                                                                
                                                                                if($cn > 0){
                                                                                $contadorPoliticasU++;    
                                                                                }
                                                                                
                                                                            } // cierre del for
                                                                                
                                                                    } //// cierre del if
                                                                    
                                                                    if($tipoPersonalPolitica == 'cargo'){
                                                                            
                                                                            for($i=0; $i<$longitudPolitica; $i++){
                                                                                
                                                                                $nombrePlitica = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDPolitica[$i]' 
                                                                                AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                                                $columna = $nombrePlitica->fetch_array(MYSQLI_ASSOC);
                                                                                //echo $columna['nombreCargos'];
                                                                                
                                                                                $cn = mysqli_num_rows($nombrePlitica);
                                                                                
                                                                                if($cn > 0){
                                                                                  $contadorPoliticasC++;  
                                                                                }
                                                                                
                                                                            } // cierre del for
                                                                                
                                                                    } //// cierre del if
                                            	                
                                                            } /// cierre del while
                                                            $totalContadorPoliticas=$contadorPoliticasU+$contadorPoliticasC;
                                                }else{  $totalContadorPoliticas='0';   }
                                        
                                        
                                        
                                        /// el total de compras
                                        $totalCompras=$conteoSolitidCompra+$totalContadorPoliticas;
                                        ?>
                        <div class="card-tools">
                          <button type="button" style="color:green;" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button><font color="red"> <?php if($totalCompras > 0){ echo $totalCompras; }else{ echo '0'; }  ?> </font>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <nav class="menu">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Solicitud</b><a style="color:red;text-decoration:none;" class="float-right"> <?php if ($conteoSolitidCompra > 0){ echo $conteoSolitidCompra; }else{ echo '0';} ?> </a>
                                        <ul>
                                        <?php 
                                        
                                        /// validamos la info del usuario de lider que inicia la sesion para que muestre las solicitudes de compra
                                            $validacionLider = $mysqli->query("SELECT * FROM usuario WHERE lider ='$consultaIdLider' ")or die(mysqli_error());
                                            $datoLider = $validacionLider->fetch_array(MYSQLI_ASSOC);
                                            $validandoLider=$datoLider['lider'];
                                            $validandoCC=$datoLider['cedula'];
                                        
                                        
                                        ///// fin del proceso
                                        
                                      
                                        
                                                
                                                $sqlSolicitudCompras= $mysqli->query("SELECT * FROM solicitudCompra where estado = 'Pendiente' AND idUsuario='$validandoCC' AND plataformaH='1' ");
                                                while($rowSolicitudCompras = $sqlSolicitudCompras->fetch_assoc()){
                            		                $idUsuarioCompras = $rowSolicitudCompras['idUsuario'];
                            		                $tipoSolicitud = $rowSolicitudCompras['tipoSolicitud'];
                            		                $estadoTipoSolicitud = $rowSolicitudCompras['estado'];
                            		                $fechaEstimada = $rowSolicitudCompras['fechaEstimada'];
                            		             
                            		                    ///// se trae la subconsulta el tipo de solicitud
                            		                        $subconsultaTipoSolicitud = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id ='$tipoSolicitud' ")or die(mysqli_error());
                                                            $datoTipoSolicitud = $subconsultaTipoSolicitud->fetch_array(MYSQLI_ASSOC);
                                                            $tipoSoliitud=$datoTipoSolicitud['tipo'];
                                                        /// fin del proceso
                            		            
                                                    if($validandoGrupoAprobador >= '1'){
                                                        
                                        ?>
                                                    
                                                        <li>
                                                          
                                                            <form action="" method="POST">
                                                                <b>*</b><a style="color:black;text-decoration:none;" ><?php echo $tipoSoliitud; ?><a/>
                                                                <input type="hidden" readonly name="idActa" value="id"><br>
                                                                <b>*</b><?php echo $estadoTipoSolicitud; ?><br>
                                                                <b>*</b><font color='blue'><?php echo $fechaEstimada; ?></font>
                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                            </form>
                                                        </li>
                                        <?php
                                                    }else{
                                                        //echo 'No existe';
                                                    }
                                                
                                                
                                                } /// cierre del while
                                        
                                        
                                       
                                        ?>
                                            
                                        </ul>
                                    </li>
                                    
                                    
                                    <li class="list-group-item"><b>Pol&iacute;ticas</b><a style="color:red;text-decoration:none;" class="float-right"> <?php if ($totalContadorPoliticas > 0){ echo $totalContadorPoliticas; }else{ echo '0';} ?> </a>
                                        <ul>
                                        <?php 
                                        
                                        if($validandoGrupoPolitica > 0){
                                        
                                        
                                                
                                                $sqlPoliticas= $mysqli->query("SELECT * FROM politicas where plataformaH='1' ");
                                                while($rowPoliticas = $sqlPoliticas->fetch_assoc()){
                            		                $tipoPersonalPolitica = $rowPoliticas['tipoAprobador'];
                            		                $montoMinimo = $rowPoliticas['minimo'];
                            		                $montoMaximo = $rowPoliticas['maximo'];
                            		                $personalIDPolitica =  json_decode($rowPoliticas['aprobador']);
                                                    $longitudPolitica = count($personalIDPolitica);  
        		                
        		                                    /// validacion politicas
                                
                                                        if($tipoPersonalPolitica == 'usuario'){
                                                                
                                                                for($i=0; $i<$longitudPolitica; $i++){
                                                                    
                                                                    $nombrePlitica = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$personalIDPolitica[$i]' AND cedula='$sesion' ");
                                                                    $columna = $nombrePlitica->fetch_array(MYSQLI_ASSOC);
                                                                    //echo '<b>Usuario '.$columna['nombres'].'</b>';
                                                                    
                                                                    $cn = mysqli_num_rows($nombrePlitica);
                                                                    
                                                                    if($cn > 0){
                                                                        ?>
                                                                        <li>
                                                                            <form action="" method="POST">
                                                                                <? echo '<b>Usuario '.$columna['nombres'].'</b>'; ?><br>
                                                                                <b>*</b><a style="color:black;text-decoration:none;" >Pol&iacute;ticas<a/>
                                                                                <input type="hidden" readonly name="idActa" value="id"><br>
                                                                                <b>*</b>Monto m&iacute;nimo: $ <?php echo number_format($montoMinimo,0,'.',','); ?><br>
                                                                                <b>*</b>Monto m&aacute;ximo: $ <?php echo number_format($montoMaximo,0,'.',','); ?>
                                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                            </form>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                    
                                                                } // cierre del for
                                                                    
                                                        } //// cierre del if
                                                        
                                                        if($tipoPersonalPolitica == 'cargo'){
                                                                
                                                                for($i=0; $i<$longitudPolitica; $i++){
                                                                    
                                                                    $nombrePlitica = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDPolitica[$i]' 
                                                                    AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                                    $columna = $nombrePlitica->fetch_array(MYSQLI_ASSOC);
                                                                    //echo '<b>Cargo '.$columna['nombreCargos'].'</b>';
                                                                    
                                                                    $cn = mysqli_num_rows($nombrePlitica);
                                                                    
                                                                    if($cn > 0){
                                                                        ?>
                                                                        <li>
                                                                            <form action="" method="POST">
                                                                                <? echo '<b>Cargo '.$columna['nombreCargos'].'</b>'; ?><br>
                                                                                <b>*</b><a style="color:black;text-decoration:none;" >Pol&iacute;ticas<a/>
                                                                                <input type="hidden" readonly name="idActa" value="id"><br>
                                                                                <b>*</b>Monto m&iacute;nimo: $ <?php echo number_format($montoMinimo,0,'.',','); ?><br>
                                                                                <b>*</b>Monto m&aacute;ximo: $ <?php echo number_format($montoMaximo,0,'.',','); ?>
                                                                                <button type="submit" class="btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                                                            </form>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                    
                                                                } // cierre del for
                                                                    
                                                        } //// cierre del if
                                	                
                                                } /// cierre del while
                                        
                                        } /// cierre validación si esta habilitado o no la notificacion
                                       
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
                <h3 class="card-title"><b>Presupuesto Asigado</b></h3>
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
                                                
                            $sqlActas= $mysqli->query("SELECT * FROM presupuestoGestionar WHERE plataformaH='1' ");
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
                                            <form action="presupuestoGestionar" method="POST">
                                                <input type="hidden" readonly name="idPresupuesto" value="<?php echo $idDatoActas; ?>">
                                                <button type="submit" class="btn btn-block btn-primary btn-sm" style='width:50%;'><i class="fas fa-eye"></i></button>
                                            </form>
                                       
                                        
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
                                            <form action="presupuestoGestionar" method="POST">
                                                <input type="hidden" readonly name="idPresupuesto" value="<?php echo $idDatoActas; ?>">
                                                <button type="submit" class="btn btn-block btn-primary btn-sm" style='width:50%;'><i class="fas fa-eye"></i></button>
                                            </form>
                                        
                                        
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