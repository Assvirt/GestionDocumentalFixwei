	<!-- Inicializa script para la inactividad -->
<?php // include 'administrador/tiempo.php'; ?>
<?php // $time; $tiempo= $time * 60000;?>
<script>
function redireccion() {
 //   window.location = "../controlador/sesion/logout2";
}

// se llamará a la función que redirecciona después de 10 minutos (600.000 segundos)
// var variable='<?php // echo $tiempo; ?>';

var temp = setTimeout(redireccion,  variable);

// cuando se pulse en cualquier parte del documento
document.addEventListener("click", function() {
    // borrar el temporizador que redireccionaba
    clearTimeout(temp);
    // y volver a iniciarlo
    temp = setTimeout(redireccion,  variable );
})
</script>
<!-- Finaliza Inicializa script para la inactividad -->