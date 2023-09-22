<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");
error_reporting(E_ERROR);

if(isset($_POST['Agregar'])){
    
$color = $_POST['color'];    
$minimo = $_POST['minimo'];
$maximo = $_POST['maximo'];
$radiobtn = $_POST['radiobtn'];//quien cita
//$select2 = json_encode($_POST['select_encargadoE']);
'<br>';
 $select = $_POST['select_encargadoE'];
$select= json_encode($select);    
    

    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM politicas WHERE aprobador = '$select' AND tipoAprobador='$radiobtn' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
        if($numRows > 0){ 
                
                //echo '<script language="javascript">alert("El aprobador ya existe");
                //window.location.href="../../politicas"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../politicas" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }else{
                $select2 = json_encode($_POST['select_encargadoE']);
                $mysqli->query("INSERT INTO politicas (tipoAProbador, aprobador, minimo, maximo, color, plataformaH) VALUES('$radiobtn','$select2','$minimo','$maximo','$color','1') ")or die(mysqli_error($mysqli));
                //header ('location: ../../politicas');
                //echo '<script language="javascript">alert("Politica Registrada");
                //window.location.href="../../politicas"</script>';
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../politicas" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php
            }
    

}elseif(isset($_POST['Editar'])){

    $id= $_POST['idPoliticas'];
    $minimo = $_POST['minimo'];
    $maximo = $_POST['maximo'];
    $radiobtn = $_POST['radiobtn'];//quien cita
    $select = json_encode($_POST['select_encargadoE']);
    
    $validacion = $mysqli->query("SELECT * FROM politicas WHERE aprobador='$select' AND tipoAprobador='$radiobtn' AND id !='$id' ");
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../politicas" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
  
        //echo '<script language="javascript">alert("La politica ya existe");
        //window.location.href="../../politicas"</script>';
       
    }else{
                
        $mysqli->query("UPDATE politicas SET  tipoAprobador='$radiobtn', aprobador='$select', minimo='$minimo', maximo='$maximo'  WHERE id = '$id'")or die(mysqli_error($mysqli));
        //header ('location: ../../politicas');
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../politicas" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionActualizar" value="1">
                    </form> 
                <?php
    } 

}elseif(isset($_POST['Eliminar'])){
    
                        $id = $_POST['idPoliticas'];
                        $mysqli->query("DELETE from politicas  WHERE id = '$id'")or die(mysqli_error($mysqli));
                        //echo '<script language="javascript">alert("La politica fue eliminada");
                        //window.location.href="../../politicas"</script>';
                        ?>
                            <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../politicas" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionEliminar" value="1">
                            </form> 
                        <?php
                    
    
}
?>