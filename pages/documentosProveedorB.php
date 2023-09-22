<?php
require_once 'conexion/bd.php';


//echo $rutaNombreArchivo=$_POST['rutaNombreArchivo'];
$idDocumento = $_POST['rutaNombreArchivo'];

$consultaDocumentos = $mysqli->query("SELECT * FROM proveedordocumentos WHERE id='$idDocumento'");
$extraerConsultaDocumentos = $consultaDocumentos->fetch_array(MYSQLI_ASSOC);
$rutaNombreArchivo = utf8_encode($extraerConsultaDocumentos['soporte']);

?>

<script languaje="javascript">

    location = "<?php  echo $rutaNombreArchivo; ?>";
    setTimeout(clickbutton, 1000);
    function clickbutton() {
        window.close();
    }
    
</script>