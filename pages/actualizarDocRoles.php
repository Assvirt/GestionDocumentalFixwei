<?php error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
    //require_once 'inactividad.php';
    require_once 'conexion/bd.php';
    
    /*Variables de sesion*/
    $celdulaUser = $_SESSION['session_username']; 
    $cargoID = $_SESSION['session_cargo']; 
    $idUsuario = $_SESSION['session_idUsuario'];
    
    $rolFlujo = $_POST['rol'];
    $idDoc = $_POST['idDoc'];
    $idSolicitudActualizar = $_POST['idSolicitud'];
    
    
    /// VALIDAMOS SI DETECTA VACIA LA VARIABLE

        
        $acentos = $mysqli->query("SET NAMES 'utf8'");
        $querySol = $mysqli->query("SELECT codificacion FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
        $datosSol = $querySol->fetch_assoc();
        
        $codDoc = $datosSol['codificacion'];
        $acentos = $mysqli->query("SET NAMES 'utf8'");
        $query3 = $mysqli->query("SELECT MAX(id) as idDocumento FROM documento WHERE codificacion = '$codDoc'")or die(mysqli_error($mysqli));
        $datos3 = $query3->fetch_assoc();
        
        
        $idDocumento = $datos3['idDocumento'];
         'id documento: '.$idDoc;
        $acentos = $mysqli->query("SET NAMES 'utf8'");
        $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
        $datosDoc = $queryDoc->fetch_assoc();
        
    /*if($datosDoc['vigente'] == '1'){
                ?>    
                    <script> 
                         window.onload=function(){
                            // document.forms["miformularioListadoMaestro"].submit();
                         }
                         setTimeout(clickbuttonArchivoEditable, 1000);
                         function clickbuttonArchivoEditable() { 
                            //document.forms["miformularioListadoMaestro"].submit();
                         }
                    </script>
                     
                    <form name="miformularioListadoMaestro" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="listadoMaestro" value="1">
                    </form>
                <?php  
    }else{*/
        
        /*Validacion de que algun asuario ya se encargara de la solicitud*/
        if($datosDoc['asumeFlujo'] == NULL){
        
            $update = $mysqli->query("UPDATE documento SET asumeFlujo = '$idUsuario' WHERE id = '$idDoc' ");
                ?>    
                    <script> 
                         window.onload=function(){
                             document.forms["miformularioA"].submit();
                         }
                         setTimeout(clickbuttonArchivoEditable, 1000);
                         function clickbuttonArchivoEditable() { 
                            document.forms["miformularioA"].submit();
                         }
                    </script>
                     
                    <form name="miformularioA" action="actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <?php
                        if($_POST['validacionAgregar'] != NULL){
                        ?>
                         <input type="hidden" name="validacionAgregar" value="1">
                        <?php
                        }
                        ?>
                        <input type="hidden" name="idDoc" value="<?php echo $idDoc;?>">
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
                         setTimeout(clickbuttonArchivoEditable, 1000);
                         function clickbuttonArchivoEditable() { 
                            document.forms["miformularioA"].submit();
                         }
                    </script>
                     
                    <form name="miformularioA" action="actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                        <?php
                        if($_POST['validacionAgregar'] != NULL){
                        ?>
                         <input type="hidden" name="validacionAgregar" value="1">
                        <?php
                        }
                        ?>
                        <input type="hidden" name="idDoc" value="<?php echo $idDoc;?>">
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