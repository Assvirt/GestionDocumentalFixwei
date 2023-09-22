<?php
require_once 'conexion/bd.php';
if($_GET['editable']){
   
    
                    $validandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='".$_GET['editable']."' ");
                    $extrerDocumento=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                    $ruta=utf8_encode($extrerDocumento['nombreOtro']);
?>
<script languaje="JavaScript">
    location = "archivos/documentos/<?php echo $ruta;?>";
    setTimeout(clickbutton, 1000);
    function clickbutton() {
        window.close();
    }
</script>
<?php
}

if($_GET['pdf']){

                    $validandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='".$_GET['pdf']."' ");
                    $extrerDocumento=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                    $ruta=utf8_encode($extrerDocumento['nombrePDF']);
?>
<script languaje="JavaScript">
         location = "archivos/documentos/<?php echo $ruta;?>";
</script>
<?php
}

if($_GET['divulgar']){
                    $validandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='".$_GET['divulgar']."' ");
                    $extrerDocumento=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                    $rutaD=$extrerDocumento['divulgacion'];
                    
                    $explorando=explode(".",$rutaD);
                    $enviarSinExtension= $explorando[0];
                    $enviarConExtension= $explorando[1];
                    
    if($enviarConExtension == 'pdf'){
?>
        <script languaje="JavaScript">
                 location = "<?php echo $rutaD;?>";
        </script>
<?php
    }else{
?>
        <script languaje="JavaScript">
            location = "<?php echo $rutaD;?>";
            setTimeout(clickbutton, 2000);
            function clickbutton() {
                window.close();
            }
        </script>
<?php
    }
}
?>
<noscript>
    <h1>Activar las funciones de script</h1>
</noscript>