<?php error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{

    require_once 'conexion/bd.php';
    
    
    /*Variables de sesion*/
    $celdulaUser = $_SESSION['session_username']; 
    $cargoID = $_SESSION['session_cargo']; 
    $idUsuario = $_SESSION['session_idUsuario'];
    
    $rolFlujo = $_POST['rol'];
    $idDocumento = $_POST['idDocumento'];
    $idSolicitudEliminar = $_POST['idSolicitud'];
    
    
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    
    /*if($datosDoc['vigente'] == '1'){
                ?>    
                    <script> 
                         window.onload=function(){
                             document.forms["miformularioListadoMaestro"].submit();
                         }
                         setTimeout(clickbuttonArchivoEditable, 1000);
                         function clickbuttonArchivoEditable() { 
                            document.forms["miformularioListadoMaestro"].submit();
                         }
                    </script>
                     
                    <form name="miformularioListadoMaestro" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="listadoMaestro" value="1">
                    </form>
                <?php  
    }else{ */
        /*Validacion de que algun asuario ya se encargara de la solicitud*/
        if($datosDoc['asumeFlujo'] == NULL){
        
            $update = $mysqli->query("UPDATE documento SET asumeFlujo = '$idUsuario' WHERE id = '$idDocumento' ");
                ?>    
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformularioA"].submit();
                         }
                         setTimeout(clickbuttonFormularioA, 0999);
                         function clickbuttonFormularioA() { 
                            document.forms["miformularioA"].submit();
                         }
                    </script>
                     
                    <form name="miformularioA" action="eliminarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                        <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>">
                        <input type="hidden" name="idSolicitud" value="<?php echo $_POST['idSolicitud'];?>">
                        <input type="hidden" name="solicitud" value="<?php echo $_POST['solicitud'];?>">
                    </form>
                <?php
            
        }else{
            
            if($datosDoc['asumeFlujo'] == $idUsuario){//sE VALIDA QUE SEA EL USUARIO QUE TOMO PRIMERO LA SOLICITUD. 
                 ?>    
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformularioA"].submit();
                         }
                         setTimeout(clickbuttonFormularioA, 0999);
                         function clickbuttonFormularioA() { 
                            document.forms["miformularioA"].submit();
                         }
                    </script>
                     
                    <form name="miformularioA" action="eliminarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                        <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>">
                        <input type="hidden" name="idSolicitud" value="<?php echo $_POST['idSolicitud'];?>">
                        <input type="hidden" name="solicitud" value="<?php echo $_POST['solicitud'];?>">
                    </form>
                <?php
        
            }else{
                ?>    
                    <script> 
                         window.onload=function(){
                       
                             document.forms["sacarDelFlujo"].submit();
                         }
                         setTimeout(clickbuttonScarFlujo, 1000);
                         function clickbuttonScarFlujo() { 
                            document.forms["sacarDelFlujo"].submit();
                         }
                    </script>
                     
                    <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input name="documentoAsignado" value="<?php echo $idDocumento;?>" type="hidden">
                        <input type="hidden" name="validacionUsuario" value="1">
                    </form>
            <?php    
               // echo '<script language="javascript">alert("Un usuario ya se encargo de la solicitud.");
               // window.location.href="creacionDocumental.php"</script>';
                
            }
            
        }
    //}
?>
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
<?php
}
?>