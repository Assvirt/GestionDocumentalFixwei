<?php
require_once '../../conexion/bd.php';
$radiobtnAut=$_POST['radiobtnAut'];

if($radiobtnAut == 'cargo'){
    $select_encargadoAut=json_encode($_POST['select_encargadoAut']);
}elseif($radiobtnAut == 'usuario'){
    $select_encargadoAut=json_encode($_POST['select_encargadoAutB']);
}elseif($radiobtnAut == 'grupo'){
    $select_encargadoAut=json_encode($_POST['select_encargadoAutC']);
}

$mysqli->query("UPDATE documentoRevision SET quien='$radiobtnAut', responsable='$select_encargadoAut' ")or die(mysqli_error());

        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../revisionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
?>