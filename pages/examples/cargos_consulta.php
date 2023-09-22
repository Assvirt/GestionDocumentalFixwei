<?php
session_start();
if(!isset($_SESSION["session_username"])){
    header("login");
    echo '<script language="javascript">confirm("Sesi贸n Finalizada por Inactividad");
    window.location.href="login"</script>';
}else{
require_once 'inactividad.php';
?>
  <div class="row">
          <div class="col-12">
            <div class="" style="background:#f4f6f9;"> <!-- class="card" -->
              <div class=""><!-- class="card-header" -->
                <h3 class="card-title"> </h3>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                


 <!-- se despliega el modal para la edici贸n de los datos  -->  
            <div class="modal fade" id="modal-default"><form action="../controlador/cargos/controladorCargos" method="POST" >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Editar cargo</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Nombre:</p>
                      <input class="form-control" type="hidden" id="id_cargos" name="idCargos" required>
                      <input class="form-control" type="text" id="nombreCargos" name="nombreCargo" required>
                      <p>Descripci&oacute;n:</p>
                      <textarea type="text" name="descripcionCargo" id="descripcionCargos" class="form-control"></textarea>
                     
                       <?php 
                        error_reporting(E_ERROR);
                        require_once '../conexion/bd.php'; 
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $query = "SELECT * FROM cargos ";
						$resultado=$mysqli->query($query);
					
                      ?>
                      <p>Jefe inmediato:</p>
                      <select class="form-control" type="text"  name="jefeInmediatoCargo" id="jefeInmediatoCargo" required>
                          <?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                          <option value="<?php echo $columna['id_cargos']; ?>"><?php echo utf8_decode($columna['nombreCargos']); ?> </option>
                         
                          <?php } ?>
                          <option value="No aplica">No aplica</option>
                      </select>
                      <?php
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $query = "SELECT * FROM nivelcargo ";
						$resultado=$mysqli->query($query);
					
                      ?>
                      <p>Nivel de Cargo:</p>
                      <select class="form-control" type="text"  name="nivelCargo" id="nivelCargo" required>
                          <?php while ($columna = mysqli_fetch_array( $resultado )) { ?>
                          <option value="<?php echo $columna['id_nivelCargo']; ?>"><?php echo utf8_decode($columna['nivelCargo']); ?> </option>
                          
                          <?php } ?>
                          <option value="No aplica">No aplica</option>
                      </select>  
                      
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="EditarCargos" value="">Guardar cambios</button>
                      
                      
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --></form>
            </div>
  
      <!-- End se despliega el modal para la edici贸n de los datos  -->


 <div class="modal fade" id="modal-default-ver">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Cargo</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p><b>Nombre:</b></p>
                      <span   id="nombreCargos3"   ></span>
                      <p><b>Descripci&oacute;n:</b></p>
                      <span   id="descripcionCargos3"  ></span>
                      <p><b>Jefe inmediato:</b></p>
                      <span   id="jefeInmediatoCargos3"   ></span>
                      <p><b>Nivel:</b></p>
                      <span   id="nivelCargos3"   ></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


                
<?php
/////// CONEXIÓN A LA BASE DE DATOS Insert/////////

if ($mysqli -> connect_errno)
{
	die("Fallo la conexion:(".$mysqli -> mysqli_connect_errno().")".$mysqli-> mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla="";
$acentos = $mysqli->query("SET NAMES 'utf8'");
$query="SELECT *  FROM cargos  order by id_cargos ASC ";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$mysqli->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM cargos  WHERE 
	id_cargos LIKE '%".$q."%' OR
	nombreCargos LIKE '%".$q."%' OR
	descripcionCargos LIKE '%".$q."%' OR
	jefeInmediatoCargos LIKE '%".$q."%' ";
}

$buscarAlumnos=$mysqli->query($query);
if ($buscarAlumnos->num_rows > 0)
{
echo "<table class=\"table table-head-fixed\"  style=\"background:#f4f6f9;width: 80%; height: 300px;margin: 0 auto;\" >";
echo "<thead style=\"color:white;\">";
echo "<tr>";
echo "<th style=\"background-color:#17a2b8;\">NOMBRE</th>";
echo "<th style=\"background-color:#17a2b8;\">DESCRIPCI&Oacute;N</th>";
echo "<th style=\"background-color:#17a2b8;\">JEFE INMEDIATO</th>";
echo "<th style=\"background-color:#17a2b8;\">NIVEL CARGO</th>";
echo "<th style=\"background-color:#17a2b8;\">VER M&Aacute;S</th>";
echo "<th style=\"background-color:#17a2b8;\">EDITAR</th>";
echo "<th style=\"background-color:#17a2b8;\">ELIMINAR</th>";


echo "</tr>";
echo "</thead>";
		
	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
	    echo "<tbody>";
		echo "<tr>";
		
		echo "<td>" . utf8_decode($filaAlumnos['nombreCargos']) . "</td>";
		echo "<td>" . utf8_decode($filaAlumnos['descripcionCargos']) . "</td>";
		$filaAlumnos['jefeInmediatoCargos'];
		
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
	    $queryCargo=$mysqli->query("SELECT * FROM nivelcargo WHERE id_nivelCargo='$idNivelCargo' ");
	    $rowDatos=$queryCargo->fetch_array(MYSQLI_ASSOC);
	    $NombreCargo=$rowDatos['nivelCargo'];
	    
	    if($NombreCargo != NULL){
	        echo "<td>" . utf8_decode($NombreCargo) . "</td>";
	    }else{
	        echo "<td>" .  'No aplica' . "</td>";
	    }
	    
	
		
		echo "<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default-ver\"  style=\"background:blue;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_cargos'] . " >
		<a id=" . $filaAlumnos['id_cargos'] . " onclick='showDeatails3(this);' ><i class=\"fas fa-eye\"></i></a></button>  </td>";
		
		echo "<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default\"  style=\"background:green;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_cargos'] . " >
		<a id=" . $filaAlumnos['id_cargos'] . " onclick='showDeatails(this);' ><i class=\"fas fa-edit\"></i></a></button> </td>";  
		
		echo " <td>
		<button data-toggle=\"modal\" data-target=\"#modal-danger\" style=\"background:red;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_cargos'] . "  >
		<a id=" . $filaAlumnos['id_cargos'] . " onclick='showDeatails2(this);' ><i class=\"far fa-trash-alt\"></i></a></button> 
		</td>";
	
	   
		echo "</tr>";
		echo "</tbody>";
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
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        
   
                
                
       
    
    
    
    
                
   
      
      
      
      
      
       <!-- se despliega el modal eliminar -->  
    <div class="modal fade" id="modal-danger"><form action="../controlador/cargos/controladorCargos" method="POST">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Eliminar datos</h4>
               
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>¿Est&aacute; seguro de eliminar " <b><span  id="nombreCargos2"></span></b> "  del regisro ?</p>
              <input class="form-control" type="hidden" id="id_cargos2" name="idCargos" required>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-light"  name="EliminarCargos">Eliminar</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog --></form>
      </div>
      <!-- End se despliega el modal para eliminar  -->
      
      
      
    <!-- accion de la notificacion de editar -->
  
    <script type="text/javascript">
    
        $('.toastrDefaultSuccess').click(function() {
            
          toastr.success('Registro actualizado con éxito.')
        });
     
    </script>
    <!-- End accion de la notificacion de editar -->
    <script>
    function showDeatails2(button){
        
        var idCargos = button.id;
        
        $.ajax({
            url: "cargos_detalle.php",
            method: "GET",
            data: {"idCargos": idCargos},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                $("#nombreCargos2").text(datos.nombreCargos);
                $("#id_cargos2").val(datos.id_cargos);
               
            }
        });
		    
	}
    </script>    
    
    <script>
    function showDeatails(button){
        
        var idCargos = button.id;
        
        $.ajax({
            url: "cargos_detalle.php",
            method: "GET",
            data: {"idCargos": idCargos},
            success: function(response){
                alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_cargos").val(datos.id_cargos);
                $("#nombreCargos").val(datos.nombreCargos);
                $("#descripcionCargos").text(datos.descripcionCargos);
                $("#jefeInmediatoCargos").text(datos.jefeInmediatoCargos);
                $("#nivelCargo").text(datos.nivelCargo);
                
                nombre=document.getElementById("nombreCargos");
                nombre.value=datos.nombreCargos;
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    </script>
    
    <script>
    function showDeatails3(button){
        
        var idCargos = button.id;
        
        $.ajax({
            url: "cargos_detalle.php",
            method: "GET",
            data: {"idCargos": idCargos},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_cargos3").val(datos.id);
                $("#nombreCargos3").text(datos.nombreCargos);
                $("#descripcionCargos3").text(datos.descripcionCargos);
                $("#jefeInmediatoCargos3").text(datos.jefeInmediatoCargos);
                $("#nivelCargos3").text(datos.nivelCargo);
                
                nombre=document.getElementById("nombreCargos");
                nombre.value=datos.nombreCargos;
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    </script>
   <!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->

       
    
    
    
           
<?php
}
?>