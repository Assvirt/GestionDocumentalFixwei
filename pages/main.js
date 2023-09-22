$(document).ready(function() {
    $('#example').DataTable({
        "language": {
            "lengthMenu": "<font color='white'>---</font>Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "<font color='white'>Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros</font>",
            "infoEmpty": "<font color='white'>Mostrando registros del 0 al 0 de un total de 0 registros</font>",
            "infoFiltered": "<font color='white'>(filtrado de un total de _MAX_ registros)</font>",
            "sSearch": "<i class='fas fa-search' style='color:#17a2b8;' ></i>         <font color='#17a2b8'>Buscar</font>",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
                },
                "sProcessing":"Procesando...",
                }
    }); // para inicar la datatable de manera más simple
});