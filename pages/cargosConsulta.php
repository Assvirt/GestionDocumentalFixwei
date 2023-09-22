<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'cargos'; //Se cambia el nombre del formulario

$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
        $permisoEliminar = $permisos['eliminar'];    
    }
    
}


if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
} 
//////////////////////PERMISOS////////////////////////

?>
<?php
/////// CONEXIÓN A LA BASE DE DATOS Insert/////////
error_reporting(E_ERROR);
require_once'conexion/bd.php';


//$mysqli = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($mysqli -> connect_errno)
{
	die("Fallo la conexion:(".$mysqli -> mysqli_connect_errno().")".$mysqli-> mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla="";
$acentos = $mysqli->query("SET NAMES 'utf8'");
$query="SELECT * FROM cargos";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$mysqli->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM cargos  WHERE 
	id_cargos LIKE '%".$q."%' OR
	nombreCargos LIKE '%".$q."%' OR
	descripcionCargos LIKE '%".$q."%' 
           
            
			";
}

$buscarAlumnos=$mysqli->query($query);
if ($buscarAlumnos->num_rows > 0)
{
echo "<table class='table table-head-fixed text-center'   >";
echo "<thead>";
echo "<tr>";


echo "<th class='text-center'>Nombre</th>";
echo "<th class='text-center'>Descripci&oacute;n</th>";
echo "<th class='text-center'>Jefe inmediato</th>";
echo "<th class='text-center'>Nivel cargo</th>";
echo "<th style='display:$visibleE'>Editar</th>";
echo "<th style='display:$visibleD'>Eliminar</th>";


echo "</tr>";
echo "</thead>";
		
	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
		echo "<tr>";
		
		echo "<td>" . utf8_decode($filaAlumnos['nombreCargos']) . "</td>";
		echo "<td>" . utf8_decode($filaAlumnos['descripcionCargos']) . "</td>";
		$id = $filaAlumnos['id_cargos'];
    		$idJefeInmediato=$filaAlumnos['jefeInmediatoCargos'];
            $queryJefeInmediato=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idJefeInmediato' ");
    	    $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
    	    $nombreJefeInmediato=$rowDatos['nombreCargos'];
    	if($nombreJefeInmediato != NULL){
            		echo "<td>" . $nombreJefeInmediato . "</td>";
            		}else{
            		echo "<td><b>" . 'No aplica' . "</b></td>";    
            		}
                    $idNivelCargo=$filaAlumnos['nivelCargo'];
            	    $queryCargo=$mysqli->query("SELECT * FROM nivelcargo WHERE id='$idNivelCargo' ");
            	    $rowDatos=$queryCargo->fetch_array(MYSQLI_ASSOC);
            	    $NombreCargo=$rowDatos['nivelCargo'];
            	    
            	    if($NombreCargo != NULL){
            	        echo "<td>" . utf8_decode($NombreCargo) . "</td>";
            	    }else{
            	        echo "<td><b>" .  'No aplica' . "</b></td>";
            	    }
                    echo"<form action='cargosEditar' method='POST'>";
                    echo"<input type='hidden' name='idCargos' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    echo"<form action='controlador/cargos/controladorCargos' method='POST'>";
                    echo"<input type='hidden' name='idCargos' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button type='submit' name='EliminarCargos' class='btn btn-block btn-danger btn-sm' onclick='return ConfirmDelete()' ><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    echo "</tr>";
} 
echo "</table>";
mysqli_close( $mysqli );

}
else
	{
		$tabla="No se encontraron coincidencias con sus criterios de búsqueda.";
	}
echo $tabla;
?>
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>

 <?php
}
 ?>     