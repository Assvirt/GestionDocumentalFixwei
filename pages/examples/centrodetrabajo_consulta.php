<?php
session_start();
if(!isset($_SESSION["session_username"])){
    header("login");
    echo '<script language="javascript">confirm("Sesion Finalizada por Inactividad");
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
            <div class="modal fade" id="modal-default"><form action="../controlador/centrodetrabajo/controladorcentrodetrabajo" method="POST" >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Editar centro de trabajo</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Prefijo:</p>
                      <input class="form-control" type="hidden" id="id_centrodetrabajo" name="idCentro" required>
                      <input class="form-control" type="text" id="prefijocentrodetrabajo" name="prefijoCentro" required>
                      <p>Nombre:</p>
                      <input class="form-control" type="text" id="nombrecentrodetrabajo" name="nombreCentro" required>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="EditarCentro" value="">Guardar cambios</button>
                      
                      
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --></form>
            </div>
  
      <!-- End se despliega el modal para la edici贸n de los datos  -->


<!-- se despliega el modal para la edici贸n de los datos  -->  
            <div class="modal fade" id="modal-default-ver">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Centro de trabajo</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p><b>Prefijo:</b></p>
                      <span id="prefijocentrodetrabajo3" ></span>
                      <p><b>Nombre:</b></p>
                      <span id="nombrecentrodetrabajo3" ></span>
                      <p><b>Cargos asociados</b></p>
                      <span id="cargosasociados3"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
  
      <!-- End se despliega el modal para la edici贸n de los datos  -->

                
<?php
/////// CONEXIÓN A LA BASE DE DATOS Insert/////////
require_once '../conexion/bd.php';
if ($mysqli -> connect_errno)
{
	die("Fallo la conexion:(".$mysqli -> mysqli_connect_errno().")".$mysqli-> mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla="";
$acentos = $mysqli->query("SET NAMES 'utf8'");
$query="SELECT * FROM centrodetrabajo  order by id_centrodetrabajo ASC LIMIT 0, 50";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$mysqli->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM centrodetrabajo  WHERE 
	id_centrodetrabajo LIKE '%".$q."%' OR
	prefijoCentrodeTrabajo LIKE '%".$q."%' OR
	nombreCentrodeTrabajo LIKE '%".$q."%' ";
}

$buscarAlumnos=$mysqli->query($query);
if ($buscarAlumnos->num_rows > 0)
{
echo "<table class=\"table table-head-fixed\" style=\"background:#f4f6f9;width: 50%; height: 300px;margin: 0 auto;\"  >";
echo "<thead style=\"color:white;\">";
echo "<tr>";
echo "<th style=\"background-color:#17a2b8;\">PREFIJO</th>";
echo "<th style=\"background-color:#17a2b8;\">NOMBRE</th>";
echo "<th style=\"background-color:#17a2b8;\">CARGOS ASOCIADOS</th>";
echo "<th style=\"background-color:#17a2b8;\">VER M&Aacute;S</th>";
echo "<th style=\"background-color:#17a2b8;\">EDITAR</th>";
echo "<th style=\"background-color:#17a2b8;\">ELIMINAR</th>";


echo "</tr>";
echo "</thead>";
		
	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
	    echo "<tbody>";
		echo "<tr>";
		
		echo "<td>" . utf8_decode($filaAlumnos['prefijoCentrodeTrabajo']) . "</td>";
		echo "<td>" . utf8_decode($filaAlumnos['nombreCentrodeTrabajo']) . "</td>";
		echo "<td>" . utf8_decode($filaAlumnos['cargosAsociados']) . "</td>";
		
		
		echo "<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default-ver\"  style=\"background:blue;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_centrodetrabajo'] . " >
		<a id=" . $filaAlumnos['id_centrodetrabajo'] . " onclick='showDeatails3(this);' ><i class=\"fas fa-eye\"></i></a></button> </td>";
		
		echo"<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default\" style=\"background:green;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_centrodetrabajo'] . " >
		<a id=" . $filaAlumnos['id_centrodetrabajo'] . " onclick='showDeatails(this);' ><i class=\"fas fa-edit\"></i></a></button>  </td>";
		
		echo" <td>
		<button data-toggle=\"modal\" data-target=\"#modal-danger\" style=\"background:red;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id_centrodetrabajo'] . " style=\"background:red;color:white;\" >
		<a id=" . $filaAlumnos['id_centrodetrabajo'] . " onclick='showDeatails2(this);' ><i class=\"far fa-trash-alt\"></i></a></button> 
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
    <div class="modal fade" id="modal-danger"><form action="../controlador/centrodetrabajo/controladorcentrodetrabajo" method="POST">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Eliminar datos</h4>
               
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>¿Est&aacute; seguro de eliminar " <b><span  id="nombrecentrodetrabajo2"></span></b> "  del regisro ?</p>
              <input class="form-control" type="hidden" id="id_centrodetrabajo2" name="idCentro" required>
              
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
     
    
    function showDeatails2(button){
        
        var idCentrodetrabajo = button.id;
        
        $.ajax({
            url: "centrodetrabajo_detalle.php",
            method: "GET",
            data: {"idCentrodetrabajo": idCentrodetrabajo},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_centrodetrabajo2").val(datos.id_centrodetrabajo);
                $("#nombrecentrodetrabajo2").text(datos.nombreCentrodeTrabajo);
               
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    
    function showDeatails(button){
        
        var idCentrodetrabajo = button.id;
        
        $.ajax({
            url: "centrodetrabajo_detalle.php",
            method: "GET",
            data: {"idCentrodetrabajo": idCentrodetrabajo},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_centrodetrabajo").val(datos.id_centrodetrabajo);
                $("#nombrecentrodetrabajo").val(datos.nombreCentrodeTrabajo);
                $("#prefijocentrodetrabajo").val(datos.prefijoCentrodeTrabajo);
                
                
                ombre=document.getElementById("nombreCentrodeTrabajo");
                nombre.value=datos.nombreCargos;
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    
    function showDeatails3(button){
        
        var idCentrodetrabajo = button.id;
        
        $.ajax({
            url: "centrodetrabajo_detalle.php",
            method: "GET",
            data: {"idCentrodetrabajo": idCentrodetrabajo},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
               
                $("#nombrecentrodetrabajo3").text(datos.nombreCentrodeTrabajo);
                $("#prefijocentrodetrabajo3").text(datos.prefijoCentrodeTrabajo);
                $("#cargosasociados3").text(datos.cargosAsociados);
                
                ombre=document.getElementById("nombreCentrodeTrabajo3");
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