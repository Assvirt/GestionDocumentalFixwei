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
            <div class="modal fade" id="modal-default"><form action="../controlador/definicion/controladordefinicion" method="POST" >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Editar Definici&oacute;n</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body"><input id="id_definicion" name="idDefinicion" type="hidden">
                      <p>Nombre:</p>
                      <input class="form-control" type="text"  name="nombre" id="nombredefinicion" required>
                      <p>Definici&oacute;n:</p>
                      <textarea class="form-control" type="text"  name="definicion" id="definicionD" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="EditarDefinicion" value="">Guardar cambios</button>
                      
                      
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --></form>
            </div>
  
      <!-- End se despliega el modal para la edici贸n de los datos  -->


<!-- la clase de ver el contenido -->
 <div class="modal fade" id="modal-default-ver">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Definici&oacute;n</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p><b>Nombre:</b></p>
                      <span   id="nombredefinicion3"></span>
                      <p><b>Definici&oacute;n:</b></p>
                      <span    id="definicionD3"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                     </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --></form>
            </div>
<!-- End la clase de ver el contenido -->
                
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
$query="SELECT * FROM definicion where not nombre='Nombre' order by id ASC LIMIT 0, 50";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$mysqli->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM definicion  WHERE 
	id LIKE '%".$q."%' OR
	nombre LIKE '%".$q."%' OR
	definicion LIKE '%".$q."%' ";
}

$buscarAlumnos=$mysqli->query($query);
if ($buscarAlumnos->num_rows > 0)
{
echo "<table class=\"table table-head-fixed\" style=\"background:#f4f6f9;width: 50%; height: 300px;margin: 0 auto;\"  >";
echo "<thead style=\"color:white;\">";
echo "<tr>";
echo "<th style=\"background-color:#17a2b8;\" >NOMBRE</th>";
echo "<th style=\"background-color:#17a2b8;\" >VER M&Aacute;S</th>";
echo "<th style=\"background-color:#17a2b8;\" >EDITAR</th>";
echo "<th style=\"background-color:#17a2b8;\" >ELIMINAR</th>";

echo "</tr>";
echo "</thead>";
		
	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
	    echo "<tbody>";
		echo "<tr>";
		
		echo "<td>" . $filaAlumnos['nombre'] . "</td>";
	
		
		
		echo "<td>
	    <button  data-toggle=\"modal\" data-target=\"#modal-default-ver\" style=\"background:blue;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id'] . " >
		<a id=" . $filaAlumnos['id'] . " onclick='showDeatails3(this);' ><i class=\"fas fa-eye\"></i></a></button> </td>  ";
	
	    echo "<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default\" style=\"background:green;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id'] . " >
		<a id=" . $filaAlumnos['id'] . " onclick='showDeatails(this);' ><i class=\"fas fa-edit\"></i></a></button>  
		</td>";
		
		echo " <td>
		<button data-toggle=\"modal\" data-target=\"#modal-danger\" style=\"background:red;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id'] . " style=\"background:red;color:white;\" >
		<a id=" . $filaAlumnos['id'] . " onclick='showDeatails2(this);' ><i class=\"far fa-trash-alt\"></i></a></button> 
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
    <div class="modal fade" id="modal-danger"><form action="../controlador/definicion/controladordefinicion" method="POST">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Eliminar datos</h4>
               
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>¿Est&aacute; seguro de eliminar " <b><span  id="nombredefinicion2"></span></b> "  del regisro ?</p>
              <input class="form-control" type="hidden" id="id_definicion2" name="idDefinicion" required>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-light"  name="EliminarDefinicion">Eliminar</button>
              
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
        
        var idDefinicion = button.id;
        
        $.ajax({
            url: "definicion_detalle.php",
            method: "GET",
            data: {"idDefinicion": idDefinicion},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_definicion2").val(datos.id);
                $("#nombredefinicion2").text(datos.nombre);
               
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    </script>  
    
    <script>
    function showDeatails3(button){
        
        var idDefinicion = button.id;
        
        $.ajax({
            url: "definicion_detalle.php",
            method: "GET",
            data: {"idDefinicion": idDefinicion},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_definicion3").val(datos.id);
                $("#nombredefinicion3").text(datos.nombre);
                $("#definicionD3").text(datos.definicion);
               
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    </script>  
    
    <script>
    function showDeatails(button){
        
        var idDefinicion = button.id;
        
        $.ajax({
            url: "definicion_detalle.php",
            method: "GET",
            data: {"idDefinicion": idDefinicion},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_definicion").val(datos.id);
                $("#nombredefinicion").val(datos.nombre);
                $("#definicionD").val(datos.definicion);
                
                
                ombre=document.getElementById("nombreCentrodeTrabajo");
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