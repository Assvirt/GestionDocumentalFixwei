<?php
require_once 'conexion/bd.php';
                    $validandoNotificacions='Usuarios';
                    ///////////// datos para traer el nombre del modulo en las notifiaciones
                    $nombreUsuario = $mysqli->query("SELECT * FROM notificaciones WHERE idUsuario ='1016050102' AND formulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $correoH = $col['correo'];
                    $plataformaH = $col['plataforma'];
                    /////////// fin proceso para traer el nombre del modulo en las notifiaciones
                    
                    //////////// datos para el correo
                    $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='1016050102' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreH = $col['nombres'];
                    $apellidoH = $col['apellidos'];
                    $correoH = $col['correo'];
                    //////////////// fin proceso datos para el correo
                    
                    /////////////// datos para traer validar el nombre del formulario
                    $nombreUsuario = $mysqli->query("SELECT id,nombre FROM formularios WHERE idFormulario='$validandoNotificacions' ")or die(mysqli_error());
                    $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombreNV = $col['nombre'];
                    /////////////// fin datos para traer validar el nombre del formulario
                    
                    
                    if($correoH == TRUE && $plataformaH == TRUE){
                        $usuarioID;
                        $validandoNotificacions;
                        $tituloA;
                        $fechaA;
                        $mensajeA;
                        echo 'tengo habilitado <b>ambas</b> en '.$nombreNV;
                        
                        //$agregarActividads= $mysqli->query("INSERT INTO actividades(idUsuario,iformulario,titulo,fecha,mensaje) VALUES('$usuarioID', '$formularioA', '$tituloA', '$fechaA','$mensajeA')")or die(mysqli_error($mysqli));
                        
                    }elseif($correoH == TRUE){
                        echo 'tengo habilitado el <b>correo</b> en '.$nombreNV;
                    }elseif($plataformaH == TRUE){
                        echo 'tengo habilitado <b>plataforma</b> en '.$nombreNV;
                    }
                        //echo '<script language="javascript">alert("Habilitado");
                        //window.location.href="myperfil"</script>';

?>