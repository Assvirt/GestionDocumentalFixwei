<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['AgregarGC'])){
    
$nombre = utf8_decode($_POST['nombre']);
$idPresupuesto = $_POST['idPresupuesto'];

    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE nombreGC = '$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
       // echo '<script language="javascript">alert("El grupo de costo ya existe");
        // window.location.href="../../agregarPresupuestoGestionarGC"</script>';
         ?>
                            <script>
                                    window.onload=function(){
                                        alert("El grupo de gastos ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO presupuestoGruposGastos (nombreGC,modulo,idPresupesto) VALUES('$nombre','grupo','$idPresupuesto') ")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarPresupuestoGestionarGC');
        
        ?>
                            <script>
                                    window.onload=function(){
                                        
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    }

}elseif(isset($_POST['AgregarSGC'])){

$grupo = utf8_decode($_POST['grupo']);    
$nombre = utf8_decode($_POST['nombre']);
$idPresupuesto = $_POST['idPresupuesto'];

    
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE nombreSGC = '$nombre' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
if($numRows > 0){
        //echo 'funciona';
       // echo '<script language="javascript">alert("El grupo de costo ya existe");
        // window.location.href="../../agregarPresupuestoGestionarGC"</script>';
         ?>
                            <script>
                                    window.onload=function(){
                                        alert("El sub-grupo de gastos ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="subgrupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        //echo 'no sirve';
        $mysqli->query("INSERT INTO presupuestoGruposGastos (nombreSGC,grupo,modulo,idPresupesto) VALUES('$nombre','$grupo','subgrupo','$idPresupuesto') ")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarPresupuestoGestionarGC');
        
        ?>
                            <script>
                                    window.onload=function(){
                                        
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="subgrupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    }

}elseif(isset($_POST['EditarGC'])){

    $nombre = utf8_decode($_POST['nombre']);
    $idPresupuesto = $_POST['idPresupuesto'];
    $idGrupos = $_POST['idGrupos'];
    
    $validacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id='$idGrupos' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        $mysqli->query("UPDATE presupuestoGruposGastos SET  nombreGC='$nombre'  WHERE id = '$idGrupos'")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarProveedoresGrupos
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Grupo de gastos actualizado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
        
    }else{
  
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("El Grupo de gastos ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    
} 

}elseif(isset($_POST['EditarSGC'])){
   
$idSGrupos = $_POST['idSGrupos']; 
$grupo = utf8_decode($_POST['grupo']);    
$nombre = utf8_decode($_POST['nombre']);
$idPresupuesto = $_POST['idPresupuesto'];
   
   
    
    
    $validacion = $mysqli->query("SELECT * FROM presupuestoGruposGastos WHERE id='$idSGrupos' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        $mysqli->query("UPDATE presupuestoGruposGastos SET  nombreSGC='$nombre', grupo='$grupo'  WHERE id = '$idSGrupos'")or die(mysqli_error($mysqli));
        //header ('location: ../../agregarProveedoresGrupos
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Sub-grupo de gastos actualizado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="subgrupo" type="hidden" readonly>
                            </form>
                            
                        <?php
        
    }else{
  
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        alert("El Sub-grupo de gastos ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
    
} 

}elseif(isset($_POST['EliminarGC'])){
    
    $idPresupuesto = $_POST['idPresupuesto'];
    $idGrupos = $_POST['idGrupos'];
    
                      
                        $mysqli->query("DELETE from presupuestoGruposGastos  WHERE id = '$idGrupos'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">alert("El presupuesto fue eliminado");
                        //window.location.href="../../presupuesto"</script>';
                        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Grupo de gastos eliminado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
                    
    
}elseif(isset($_POST['EliminarGrupo'])){
    
    $idPresupuesto = $_POST['idPresupuesto'];
    $idGrupos = $_POST['idGrupos'];
    
                      
                        $mysqli->query("DELETE from presupuestoGruposGastos  WHERE id = '$idGrupos'")or die(mysqli_error($mysqli));
                        $mysqli->query("DELETE from presupuestoGruposGastos  WHERE grupo = '$idGrupos'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">alert("El presupuesto fue eliminado");
                        //window.location.href="../../presupuesto"</script>';
                        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Grupo de gastos y Sub-grupro de gastos eliminado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="grupo" type="hidden" readonly>
                            </form>
                            
                        <?php
                    
    
}elseif(isset($_POST['EliminarSGC'])){
    
    $idPresupuesto = $_POST['idPresupuesto'];
    $idSGrupos = $_POST['idSGrupos'];
    
                      
                        $mysqli->query("DELETE from presupuestoGruposGastos  WHERE id = '$idSGrupos'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">alert("El presupuesto fue eliminado");
                        //window.location.href="../../presupuesto"</script>';
                        ?>
                            <script>
                                    window.onload=function(){
                                        alert("Sub-grupo de gastos eliminado");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../agregarPresupuestoGestionarSGC" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly>
                               <input name="subgrupo" value="subgrupo" type="hidden" readonly>
                            </form>
                            
                        <?php
                    
    
}
?>