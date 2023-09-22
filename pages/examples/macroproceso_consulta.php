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
            <div class="modal fade" id="modal-default"><form action="../controlador/macroproceso/controladormacroproceso" method="POST" >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"> Editar Procesos</h4>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <input name="idMacroproceso" type="hidden" id="id_macroproceso">
                      <p>Nombre:</p>
                      <input class="form-control" type="text"  name="nombre" id="nombremacroproceso" required>
                      <p>Orden:</p>
                      <input class="form-control" type="number"  name="orden" id="ordenmacroproceso" required>
                      <p>Misional ?:</p>
                      <input class="form-control" type="checkbox"  name="misional" id="misionalmacroproceso" required>
                      <p>Estilo:</p>
                      <select class="form-control" type="text"  name="estilo" id="estilomacroproceso" required>
                        <option value=" ">Seleccionar..</option>
                        <option value="dato2">dato2.2..</option>
                      </select>
                      <p>Descripci&oacute;n:</p>
                      <textarea class="form-control" type="checkbox"  name="descripcion" id="descripcionmacroproceso" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary toastrDefaultSuccess" name="EditarMacroproceso" value="">Guardar cambios</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog --></form>
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
$query="SELECT * FROM macroproceso where not nombre='Nombre' order by id ASC LIMIT 0, 50";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$mysqli->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM macroproceso  WHERE 
	id LIKE '%".$q."%' OR
	nombre LIKE '%".$q."%' OR
	orden LIKE '%".$q."%' OR
	misional LIKE '%".$q."%' OR
	estilo LIKE '%".$q."%' OR
	descripcion LIKE '%".$q."%' ";
}

$buscarAlumnos=$mysqli->query($query);
if ($buscarAlumnos->num_rows > 0)
{
echo "<table class=\"table table-head-fixed\"  style=\"background:#f4f6f9;width: 50%; height: 300px;margin: 0 auto;\" >";
echo "<thead style=\"color:white;\">";
echo "<tr>";
echo "<th style=\"background-color:#17a2b8;\">NOMBRE</th>";
echo "<th style=\"background-color:#17a2b8;\">ORDEN</th>";
echo "<th style=\"background-color:#17a2b8;\">MISIONAL</th>";
echo "<th style=\"background-color:#17a2b8;\">ESTILO</th>";
echo "<th style=\"background-color:#17a2b8;\">DESCRIPCI&Oacute;N</th>";
echo "<th style=\"background-color:#17a2b8;\">VER M&Aacute;S</th>";
echo "<th style=\"background-color:#17a2b8;\">ELIMINAR</th>";


echo "</tr>";
echo "</thead>";
		
	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
	    echo "<tbody>";
		echo "<tr>";
		
		echo "<td>" . $filaAlumnos['nombre'] . "</td>";
		echo "<td>" . $filaAlumnos['orden'] . "</td>";
		echo "<td>" . $filaAlumnos['misional'] . "</td>";
		echo "<td>" . $filaAlumnos['estilo'] . "</td>";
		echo "<td>" . $filaAlumnos['descripcion'] . "</td>";
	
		
		
		echo "<td>
		<button  data-toggle=\"modal\" data-target=\"#modal-default\" style=\"background:green;color:white;width:70px;height:25px;border-width: 0px;\" id=" . $filaAlumnos['id'] . " >
		<a id=" . $filaAlumnos['id'] . " onclick='showDeatails(this);' ><i class=\"fas fa-edit\"></i></a></button></td> "; 
		
		echo"<td>
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
    <div class="modal fade" id="modal-danger"><form action="../controlador/macroproceso/controladormacroproceso" method="POST">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Eliminar datos</h4>
               
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>¿Est&aacute; seguro de eliminar " <b><span  id="nombreMacroproceso2"></span></b> "  del regisro ?</p>
              <input class="form-control" type="hidden" name="idMacroproceso" id="idMacroproceso2" required>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-light"  name="EliminarMacroproceso">Eliminar</button>
              
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
        
        var idMacroproceso = button.id;
        
        $.ajax({
            url: "macroproceso_detalle.php",
            method: "GET",
            data: {"idMacroproceso": idMacroproceso},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                $("#idMacroproceso2").val(datos.id);
                $("#nombreMacroproceso2").text(datos.nombre);
                
                //let idProceso = datos.id;
                //document.getElementById("idProceso").value = idProceso;
                
                //imagen = document.getElementById("fotoJava");
                //imagen.src = "WMS/"+datos.foto;
                
            }
        });
		    
	}
    </script>    
  
  
  
  
    <script>
    function showDeatails(button){
        
        var idMacroproceso = button.id;
        
        $.ajax({
            url: "macroproceso_detalle.php",
            method: "GET",
            data: {"idMacroproceso": idMacroproceso},
            success: function(response){
                //alert(response);
                //Parseo de Json a objeto de javascript
                var datos = JSON.parse(response);
                
                //$("#fotoJava").text(datos.foto);
               // $("#codBarras").text(datos.codbarras);
                $("#id_macroproceso").val(datos.id);
                $("#nombremacroproceso").val(datos.nombre);
                $("#ordenmacroproceso").val(datos.orden);
                $("#misionalmacroproceso").val(datos.misional);
                $("#estilomacroproceso").val(datos.estilo);
                $("#descripcionmacroproceso").val(datos.descripcion);
                
                
                
                
                
                
                ombre=document.getElementById("nombre");
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