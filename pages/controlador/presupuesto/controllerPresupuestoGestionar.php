<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){

$idPresupuesto=$_POST['idPresupuesto'];

$radioTipo=$_POST['radioTipo'];

$procesoCC=$_POST['procesoCC'];
$selectCentro = json_encode($_POST['select_centroE']);    

$costosGastos=$_POST['costosGastos'];
$selectGrupo = json_encode($_POST['select_grupoE']);
$selectSubgrupo = json_encode($_POST['select_subgrupoE']);

$presupuesto=$_POST['presupuesto'];

$radiobtn = $_POST['radiobtn'];
$select = $_POST['select_encargadoE'];
json_encode($select);



if($radiobtn == 'usuario'){ //////////////// validando la notificacion cuando es usuario
    $longitud = count($select);
        for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$select[$i]' ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
            echo $extraerCC=$columna['cedula']; echo '<br>';
           
           
           
            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$extraerCC' ")or die(mysqli_error());
              //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
              while($usuariosCargo = $extraerUsuarios->fetch_array()){
                echo 'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargo['nombres'].''.$usuariosCargo['apellidos'].' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                $consultaCedula=$usuariosCargo['cedula'];
                
                            ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                            $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                            //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                            while($grupoUsuario = $consultaGrupos->fetch_array()){
                            $idGrupo=$grupoUsuario['idGrupo'];
                            $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                            echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                            
                                //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                $consultaGruposNombreId = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo' ")or die(mysqli_error());
                                $grupoUsuarioNombreId = $consultaGruposNombreId->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNombreId['nombre'] != NULL && $grupoUsuarioNombreId['id'] != NULL){
                                        $nombreValidandoGrupo=$grupoUsuarioNombreId['nombre'];
                                        $idGrupoValidando=$grupoUsuarioNombreId['id'];
                                    }else{
                                        $nombreValidandoGrupo='<b>No existe el id del grupo</b>';
                                        $idGrupoValidando='<b>No existe el id del grupo</b>';
                                    }
                                    echo 'Nombre del grupo: '.$nombreValidandoGrupo.' y su id: <b>'.$idGrupoValidando.'</b><br>';
                                
                                    //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                    $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='presupuesto' ")or die(mysqli_error());
                                    $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                                    if($grupoUsuarioNotificacion['plataforma'] != NULL && $grupoUsuarioNotificacion['correo'] != NULL){
                                        $aceptoPlataforma+=$grupoUsuarioNotificacion['plataforma'];
                                        echo 'Plataforma: <b>'.$grupoUsuarioNotificacion['plataforma'].'</b>';
                                        echo '<br>';
                                        $aceptoCorreo+=$grupoUsuarioNotificacion['correo'];
                                        echo 'Correo: <b>'.$grupoUsuarioNotificacion['correo'].'</b>';
                                        
                                    }else{
                                        echo 'Plataforma: <b>No existe</b>';
                                        echo '<br>';
                                        echo 'Correo: <b>No existe</b><br><br>';        
                                    }
                                
                            }
                
                //////////////// al terminar la validaci車n pasamos a quienes se le envia el correo
                
                            
                            
                            
                  ///////// Enter para que no salga la informaci車n por usuario pegado                
                  echo '<br><br>';
              }   //// cierre del while
              
              
              if($aceptoCorreo > 0){
                      echo '<br>sale plataforma: '.$aceptoPlataforma;
                      echo '<br>sale correo: '.$aceptoCorreo;
                      echo '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacions='presupuesto';
                                    $plataformaH =$aceptoPlataforma;
                                    $correoH = $aceptoCorreo;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaCedula' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($col = mysqli_fetch_array( $nombreUsuario )) {
                                    $nombreU = $col['nombres'];
                                    $apellidoU = $col['apellidos'];
                                    echo '<br>'.$correoU = $col['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioH=$nombreU." ".$apellidoU;
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormulario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                                    $col = $datosDelFormulario->fetch_array(MYSQLI_ASSOC);
                                    $nombreNV = $col['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoH > 0 && $plataformaH > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitada1='1';
                                        ////// fin
                                       
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env赤an los datos de creaci車n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                       
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuaci車n la aprobaci車n de presupuesto asignado de  $ '$presupuesto' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                        /////////// Fin se env赤an los datos de creaci車n de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env赤an los datos de creaci車n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica ";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head><meta charset="gb18030">
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuaci車n la aprobaci車n de presupuesto asignado de  $ '$presupuesto' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreo == 0){
                     
                      echo'<br>cargo: '.$confirmacionNotificaciones='0';
                      echo '<br>sale plataforma: '.$aceptoPlataforma;
                      echo '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaH =$aceptoPlataforma;
                                    if($plataformaH > 0){
                                        $plataformaHabilitada2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
              
              
              
              
              
              
              
              
              
              
        } ///////////// cierre del for
        
        
}else{ ////////////////////////////// validando la notificaci車n cuando es cargo
    echo 'cargos';
    $longitud = count($select);
    for($i=0; $i<$longitud; $i++){
            $nombreuser = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos AS idElcargo,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$select[$i]' AND cargos.id_cargos=usuario.cargo ");
            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
            echo $columna['nombreCargos']; echo '<br>';
            $estraerIdCargo=$columna['idElcargo'];
                
                    $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$estraerIdCargo' ")or die(mysqli_error());
                  //$usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                  while($usuariosCargo = $extraerUsuarios->fetch_array()){
                    echo 'EL USUARIO: <b>'.$nombredelUsuario=$usuariosCargo['nombres'].''.$usuariosCargo['apellidos'].' tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                    $consultaCedula=$usuariosCargo['cedula'];
                    
                                ///////// luego se consulta con la cc del usuario a esta tabla para traer los id de los grupos por usuario
                                $consultaGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario ='$consultaCedula' ")or die(mysqli_error());
                                //$grupoUsuario = $consultaGrupos->fetch_array(MYSQLI_ASSOC);
                                while($grupoUsuario = $consultaGrupos->fetch_array()){
                                $idGrupo=$grupoUsuario['idGrupo'];
                                $validarUsuarioMensaje=$grupoUsuario['idUsuario'];
                                echo '<br><br>Id de la tabla usuarioGrupo: <b>'.$idGrupo.'</b><br>';
                                
                                    //////// luego con el id de la tabla usuarioGrupo se consulta la otra tabla para traer los nombres de los grupos y sus id del grupo para validar
                                    $consultaGruposNombreId = $mysqli->query("SELECT * FROM grupo WHERE id ='$idGrupo' ")or die(mysqli_error());
                                    $grupoUsuarioNombreId = $consultaGruposNombreId->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNombreId['nombre'] != NULL && $grupoUsuarioNombreId['id'] != NULL){
                                            $nombreValidandoGrupo=$grupoUsuarioNombreId['nombre'];
                                            $idGrupoValidando=$grupoUsuarioNombreId['id'];
                                        }else{
                                            $nombreValidandoGrupo='<b>No existe el id del grupo</b>';
                                            $idGrupoValidando='<b>No existe el id del grupo</b>';
                                        }
                                        echo 'Nombre del grupo: '.$nombreValidandoGrupo.' y su id: <b>'.$idGrupoValidando.'</b><br>';
                                    
                                        //////////// Luego vamos a consultar en los permisos de notificacion por el id del grupo del usuario
                                        $consultaGruposNotificacion = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo ='$idGrupoValidando' AND formulario='presupuesto' ")or die(mysqli_error());
                                        $grupoUsuarioNotificacion = $consultaGruposNotificacion->fetch_array(MYSQLI_ASSOC);
                                        if($grupoUsuarioNotificacion['plataforma'] != NULL && $grupoUsuarioNotificacion['correo'] != NULL){
                                            $aceptoPlataforma+=$grupoUsuarioNotificacion['plataforma'];
                                            echo 'Plataforma: <b>'.$grupoUsuarioNotificacion['plataforma'].'</b>';
                                            echo '<br>';
                                            $aceptoCorreo+=$grupoUsuarioNotificacion['correo'];
                                            echo 'Correo: <b>'.$grupoUsuarioNotificacion['correo'].'</b>';
                                            
                                        }else{
                                            echo 'Plataforma: <b>No existe</b>';
                                            echo '<br>';
                                            echo 'Correo: <b>No existe</b><br><br>';        
                                        }
                                    
                                }
                    
                    //////////////// al terminar la validaci車n pasamos a quienes se le envia el correo
                    ///////// Enter para que no salga la informaci車n por usuario pegado                
                      echo '<br><br>';
                  }       /// cierre del while
                  
                  
                  
                  
  
                  if($aceptoCorreo > 0){
                      echo '<br>sale plataforma: '.$aceptoPlataforma;
                      echo '<br>sale correo: '.$aceptoCorreo;
                      echo '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      
                      /*
                      if($aceptoPlataforma > 0 && $aceptoCorreo > 0){
                          echo '<br>Sale enviar plataforma'.$aceptoPlataforma.' y correo'.$aceptoCorreo;
                      }elseif($aceptoCorreo > 0){
                          echo '<br>Sale enviar correo';
                      } 
                       */
                  
                 //////////////////// se agrega este campo para las actividades
                                    /////////// actividades de traer nombre de modulos de notificaciones
                                    $validandoNotificacions='presupuesto';
                                    $plataformaH =$aceptoPlataforma;
                                    $correoH = $aceptoCorreo;
                                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                                    
                                    //////////// datos para el correo
                                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cargo='$estraerIdCargo' ")or die(mysqli_error());
                                    //$col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                                    while ($col = mysqli_fetch_array( $nombreUsuario )) {
                                    $nombreU = $col['nombres'];
                                    $apellidoU = $col['apellidos'];
                                    echo '<br>'.$correoU = $col['correo']; echo'<br>';
                                    //$correoU = $col['correo'];
                                    $usuarioH=$nombreU." ".$apellidoU;
                                    //////////////// fin proceso datos para el correo
                                    
                                    /////////////// datos para traer validar el nombre del formulario
                                    $datosDelFormulario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                                    $col = $datosDelFormulario->fetch_array(MYSQLI_ASSOC);
                                    $nombreNV = $col['nombre'];
                                    /////////////// fin datos para traer validar el nombre del formulario
                                    
                                    
                                    if($correoH > 0 && $plataformaH > 0){
                                        
                                        /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas
                                        $plataformaHabilitada1='1';
                                        ////// fin
                                       
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env赤an los datos de creaci車n de usuario a ese usuario
                                        /*
                                        $to = $correoU;
                                        $subject = "Se le notifica ser aprobador a la nueva politica";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuaci車n la aprobaci車n de presupuesto asignado de  $ '$presupuesto' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                        */
                                        /////////// Fin se env赤an los datos de creaci車n de usuario a ese usuario
                                    }elseif($correoH > 0){
                                        
                                       // echo 'estos son los correos: '.$correoU; echo '<br>';
                                        $minimo2=number_format($minimo,0,'.',',');
                                        $maximo2=number_format($maximo,0,'.',',');
                                        /////////// se env赤an los datos de creaci車n de usuario a ese usuario
                                       /*
                                        $to = $correoU;
                                        $subject = "Se notifica presupuesto asignado ";
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                         
                                        $message = "
                                        <html>
                                        <head>
                                        <title>HTML</title>
                                        </head>
                                        <body>
                                        <img src='http://fixwei.com/plataforma/dist/img/fondoLogin2.jpg' width='200px' height='100px'><br>
                                        
                                        <p>Estimado/a. <b>'$usuarioH'</b>.
                                        <br><br>Se detalla a continuaci車n la aprobaci車n de presupuesto asignado de  $ '$presupuesto' 
                                        <br><br>
                                        Cualquier inquietud sobre la misma, por favor contactar a la empresa prestadora de servicio <a target='_black' href='http://fixwei.com/plataforma/pages/examples/login'>Fixwei</a>
                                        <br><br>
                                        Atentamente, FIXWEI.
                                        <br><br>Importante. Este es un <b>aviso</b> enviado por la plataforma, por favor NO lo responda.
                                        </p>
                                        </body>
                                        </html>";
                                         
                                        mail($to, $subject, $message, $headers);
                                       */
                                    }
                                    
                                    
                                    }
                        ////////// fin del proceso   
                    
                      
                  }elseif($aceptoCorreo == 0){
                     
                      echo'<br>cargo: '.$confirmacionNotificaciones='0';
                      echo '<br>sale plataforma: '.$aceptoPlataforma;
                      echo '<br>sale cargo: '.$confirmacionNotificaciones=$encargado;
                      /*
                      if($aceptoPlataforma > 0 ){
                          echo '<br>Sale solamente enviar plataforma';
                      } */
                            /////// esta variable se usa para habilitar o desabilitar las notificaciones y diferenciar las solicitudes viejas con las nuevas 
                                    $plataformaH =$aceptoPlataforma;
                                    if($plataformaH > 0){
                                        $plataformaHabilitada2='1';
                                    }
                            ////// fin
                  } //////// finaliza la validacion del if AND elseif
                  
                  
                  
                  
                  
                  
                  
            
        }
}


///////////  variable para almacenar
  
  if($plataformaHabilitada1 > 0){
      $plataformaHabilitada=$plataformaHabilitada1;
  }
  
  if($plataformaHabilitada2 > 0){
      $plataformaHabilitada=$plataformaHabilitada2;
  }
  
  if($plataformaHabilitada1 == 0 && $plataformaHabilitada2 == 0){
      $plataformaHabilitada='0';
  }
  
  echo '<br>Habilitado: '.$plataformaHabilitada;
  //////





//$radiobtn=$_POST['radiobtn'];
//$select = json_encode($_POST['select_encargadoE']);




    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE tipo = '$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
       // echo '<script language="javascript">alert("El nombre del presupueso ya existe");
        //window.location.href="../../presupuesto"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("La gesti籀n del presupuesto ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestion" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        $select2 = json_encode($_POST['select_encargadoE']);
        $mysqli->query("INSERT INTO presupuestoGestionar (idPresupuesto, tipo, totalPresupuesto, totalEjecutado, tipoProcesoCosto, procesoCosto, tipoCostoGasto, CostoGastoGrupo, CostoGastoSubgrupo, tipoResponsable, responsable, participacion, avance, plataformaH)
        VALUES('$idPresupuesto','$radioTipo','$presupuesto','0','$procesoCC','$selectCentro','$costosGastos','$selectGrupo','$selectSubgrupo','$radiobtn','$select2','1','2','$plataformaHabilitada') ")or die(mysqli_error($mysqli));
        //header ('location: ../../presupuesto
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Agregado con 矇xito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../presupuestoGestionar" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }

}elseif(isset($_POST['Editar'])){

$id= $_POST['idPresupuestoGestionarCosto'];
    
$idPresupuesto=$_POST['idPresupuesto'];

$radioTipo=$_POST['radioTipo'];

$procesoCC=$_POST['procesoCC'];
$selectCentro = json_encode($_POST['select_centroE']);    

$costosGastos=$_POST['costosGastos'];
$selectGrupo = json_encode($_POST['select_grupoE']);
$selectSubgrupo = json_encode($_POST['select_subgrupoE']);

$presupuesto=$_POST['presupuesto'];

$radiobtn=$_POST['radiobtn'];
$select = json_encode($_POST['select_encargadoE']);
    
    
  
        $mysqli->query("UPDATE presupuestoGestionar SET tipo='$radioTipo', totalPresupuesto='$presupuesto', totalEjecutado='0', 
        tipoProcesoCosto='$procesoCC', procesoCosto='$selectCentro', tipoCostoGasto='$costosGastos', CostoGastoGrupo='$selectGrupo', 
        CostoGastoSubgrupo='$selectSubgrupo', tipoResponsable='$radiobtn', responsable='$select', participacion='1', avance='2' WHERE id='$id'  ")or die(mysqli_error($mysqli));
        //header ('location: ../../presupuesto
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Actualizado con exito");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../presupuestoGestionar" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    


}elseif(isset($_POST['Eliminar'])){
                        $idPresupuesto = $_POST['idPresupuesto'];
                        $idPresupuestoGestionar = $_POST['idPresupuestoGestionar'];
                        $mysqli->query("DELETE from presupuestoGestionar  WHERE id = '$idPresupuestoGestionar'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">alert("El presupuesto fue eliminado");
                        //window.location.href="../../presupuesto"</script>';
                        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Eliminado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../presupuestoGestionar" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
                    
    
}
?>