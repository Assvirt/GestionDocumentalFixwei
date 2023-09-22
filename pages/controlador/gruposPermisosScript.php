<?php
require_once '../conexion/bd.php';

$grupos = $mysqli->query("SELECT idFormulario FROM formularios");
$idGrupos = $grupos->fetch_array(MYSQLI_ASSOC);

foreach($grupos as $idGrupo){
    $idForm = $idGrupo['idFormulario'];
    
    $mysqli->query("INSERT INTO permisos(idGrupo,formulario,listar,crear,editar,eliminar) VALUES(1, '$idForm', FALSE, FALSE, FALSE, FALSE)")or die(mysqli_error($mysqli));
    
    
}





?>