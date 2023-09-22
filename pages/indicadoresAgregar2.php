<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Indicadores</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agregar Fórmulas y Variables <?php $quienCrea=$_POST['quienCrea'];?></h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agregar Formulas y Variables </li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Listar indicadores</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row" style="display:none;">
            <div class="col">
                    
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
                  <div class="card-header">
                    <?php
                    $muestraCalculadora=$_POST['calculadoraMostrar'];
                    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
                   
                                /// se trae el último indicador que realizo el usuario
                                $quienCrea;
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicado=$mysqli->query("SELECT * FROM `indicadores` WHERE quienCrea='$quienCrea' ORDER BY id DESC LIMIT 0,1 ");
                                $extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                $ultimoIndicadorSale=$extraeDatoIndicador['id'];
                                $ultimoIndicadorSaleQuienCrea=$extraeDatoIndicador['quienCrea'];
                                $nombreIndicador=$extraeDatoIndicador['nombre'];
                                ?>
                    <h3 class="card-title"></h3>
                  </div>
                        <!--
                        <form action="indicadoresAgregarTipoVariable" method="POST">
                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                            <input name="variablesIdPrincipal" value="<?php echo $ultimoIndicadorSale; ?>" type="hidden" readonly> 
                            <button type="submit" style="color:white;" class="btn btn-success float-let" name="AgregarVariables">Regresar</button>
                        </form>
                        -->
                        <?php
                            //// debemos mantener la variable viajando en el archivo para que no se cierre esta opción
                            $variablesSM=$_POST['variablesMS'];
                            if($variablesSM == 'Multiserie'){
                                $checkedMulti='checked';
                            }
                            ///// END
                        ?>
                            <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                      
                     
                            <div class="card-body">
                                
                                <!-- parametros para la activacion de correo y plataforma -->
                                    <div class="row"> 
                                        <div class="form-group col-sm-6">
                                            
                                            
                                          <input name="usuarioActividad" value="<?php echo $ultimoIndicadorSaleQuienCrea;?>" type="hidden" readonly>
                                          <input name="idContinuaIndicador" value="<?php echo $ultimoIndicadorSale;?>" type="hidden" readonly>
                                          
                                          
                                          
                                          <label><!-- Notificaciones por: --> </label>&nbsp;&nbsp;
                                              <?php if($visibleP != 'none'){ ?>
                                              
                                                <label><!-- Plataforma --></label>
                                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                                <?php }else{  }
                                          
                                              if($visibleP != 'none' && $visibleC != 'none'){
                                                  //echo '-';
                                              }
                                          
                                                    if($visibleC != 'none'){ ?>
                                                <label><!-- Correo --></label>
                                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                                <?php }else{  } ?>
                                        </div>
                                    </div>
                                <!-- Fin parametros para la activacion de correo y plataforma -->
                                    <?php
                                    $consultandoVariables=$mysqli->query("SELECT COUNT(*) FROM indicadoresVariables ");
                                    $exxtraerConsultaVariablesConteo=$consultandoVariables->fetch_array(MYSQLI_ASSOC);
                                    if($exxtraerConsultaVariablesConteo['COUNT(*)'] == '30'){
                                        //echo '<br><br><font color="red">Llegó al límite de registros permitidos que son 30 variables</font>';
                                    }else{ /*
                                    ?>   
                                  <div class="row">
                                      <input type="radio" style="visibility:hidden;"  name="variables" value="Multiserie" <?php// echo $checkedMulti; ?>checked required>
                                      <div class="form-group col-sm-5">
                                            <!--<label>Seleccione el tipo de variable a usar en el indicador</label><br>
                                            Multiserie
                                            -->
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="nombre2" placeholder="Nombre" required>
                                            <br>
                                            <label>Descripción:</label>
                                            <textarea type="text" class="form-control" name="descripcion2" placeholder="Descripción" required></textarea>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label>Variable:</label>
                                            <input type="text" class="form-control" name="simbolo" placeholder="Variable" required>
                                            <br>
                                            <label>Unidad de medida:</label>
                                             <select type="text" class="form-control" name="unidad" placeholder="Unidad de medida" required>
                                                 <option value="">Seleccionar unidad...</option>
                                                 <?php
                                                 $unidadMedida=$mysqli->query("SELECT * FROM indicadoresUnidad ORDER BY unidad");
                                                 while($datoUnidad=$unidadMedida->fetch_array()){
                                                 ?>
                                                 <option value="<?php echo $datoUnidad['unidad']; ?>"><?php echo $datoUnidad['unidad']; ?></option>
                                                <?php
                                                 }
                                                ?>
                                             </select>
                                            <br>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <font color="white">--------------------------------------------</font>
                                                    </td>
                                                    <td>
                                                        <button type="submit" style="color:white;" class="btn btn-warning float-right" name="AgregarVariables">Guardar</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                  </div>
                                  <?php
                                    */} 
                                  ?>
                                </form>  
                                
                                
                                <section class="content">
                                                  <div class="container-fluid">
                                                    <!-- /.row -->
                                                    <div class="row">
                                                        <div class="col">
                                                        </div>
                                                        <div class="col-9">
                                                      
                                                      <?php
                                                      /////////////// se valida que botón entra para el formulario de editar o de agregar-....
                                                      $id=$_POST['id'];
                                                      
                                                      
                                                      if(isset($_POST['botonValidarEditar'])){
                                                      ?>
                                                           
                                                        <div class="card card-primary">
                                                          <div class="card-header">
                                                            <h3 class="card-title">Editar variable del Indicadores</h3>
                                                          </div>
                                                          <!-- /.card-header -->
                                                          <!-- form start -->
                                                          <?php 
                                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                $query = $mysqli->query("SELECT * FROM indicadoresVariables WHERE id = '$id' ");
                                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                                $nombreVariable = $row['nombreVariable'];
                                                                $simbolo = $row['simbolo'];
                                                                $idDatos = $row['id'];
                                                                
                                                            ?>
                                                          <form role="form" action="controlador/indicadores/controller" method="POST">
                                                            <div class="card-body">
                                                              <div class="form-group">
                                                                <label>Nombre:</label>
                                                                <input type="text" class="form-control"  name="nombre2" value="<?php echo $nombreVariable; ?>" placeholder="Tipo" required>
                                                                <br>
                                                                <label>Variable:</label>
                                                                <input type="text" class="form-control"  name="simbolo" value="<?php echo $simbolo; ?>" placeholder="Descripción" required>
                                                                <input type="hidden" name="id" value="<?php echo $idDatos; ?>">
                                                                <input type="hidden" name='quienCrea' value="<?php echo $quienCrea;?>" >
                                                                <input type="hidden" name='calculadoraMostrar' value="<?php echo $muestraCalculadora; ?>" >
                                                                <input type="hidden" name='variablesIdPrincipal' value="<?php echo $variablesIdPrincipal; ?>" >
                                                                
                                                              </div>
                                                            
                                                            </div>
                                                            <!-- /.card-body -->
                                            
                                                            <div class="card-footer" >
                                                              <button type="submit" class="btn btn-primary float-right" name="AgregarVariablesActualizar">Actualizar</button>
                                                            </div>
                                                          </form>
                                                         
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        
                                                        
                                                        
                                                        </div>    
                                            
                                                    <div class="col">
                                                        </div>
                                                        
                                                       
                                                    </div>
                                                    <!-- /.row -->
                                                  </div><!-- /.container-fluid -->
                                                  
                                                </section>  
                                            
                                    
                             
                            </div>
                    
                </div>
            </div>    
            <div class="col">
                    
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                </div>
                <div class="col-9">
                    <?php
                    //if($muestraCalculadora != NULL){
                    ?>
                    <!--<form action="" method="POST">
                        <input name="calculadoraMostrar" type="hidden" readonly value="TRUE">
                        <input type="hidden" name="quienCrea" value= "<?php echo $quienCrea; ?>" >
                        <input name="variablesIdPrincipal" type="hidden" readonly value="<?php echo $ultimoIndicadorSale; ?>">
                        <input value="Calculadora" class="btn btn-primary" type="submit">
                    </form>-->
                    <?php
                    //}else{
                    ?>
                    <div name="ocultarMostrar" style="display:none;" id="ocultarMostrar">
                        <input type="button" class="btn btn-primary" value="Variables" id="rad_mostrar" name="radiobtn" value="mostrar">
                    </div>      
                    
                    <div name="ocultar" id="ocultar" style="display:none;">
                        <input type="button" class="btn btn-success" value="Ocultar" id="rad_ocultar" name="radiobtn" value="ocultar">
                    </div>
                    <br>
                    <?php
                    //}
                    ?>
                    
                </div>
                <div class="col">
                </div>
            </div>
        </div>
    </section>
   
  
    <div name="mostrar" id="mostrar" style="display:none;"> <!-- muestra el historial con el script  -->
        <section class="content">
                                              <div class="container-fluid">
                                                <!-- /.row -->
                                                <div class="row">
                                                   <div class="col">
                        
                                                    </div>
                                                  <div class="col-9">
                                                    <div class="card">    
                                                        <div class="card-body table-responsive p-0" style="">
                                                            <!--
                                                            <form action="" method="POST">
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" name="filtroSimbolo" placeholder="Símbolo" class="form-control">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="filtroNombre" placeholder="Nombre" class="form-control">
                                                                        </td>
                                                                        <td>
                                                                            <button type="submit" style="color:white;" class="btn btn-info" name="AgregarVariables">Buscar</button>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                                <input type='hidden' name='calculadoraMostrar' value= '<?php echo $muestraCalculadora; ?>' >
                                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $ultimoIndicadorSale; ?>' >
                                                            </form>
                                                            
                                                             <form action="" method="POST">
                                                                <button type="submit" style="color:white;" class="btn btn-success" name="AgregarVariables">Limpiar Busqueda</button>
                                                                <input type='hidden' name='quienCrea' value= '<?php  $quienCrea; ?>' >
                                                                <input type='hidden' name='calculadoraMostrar' value= '<?php  $muestraCalculadora; ?>' >
                                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php  $ultimoIndicadorSale; ?>' >
                                                            </form>-->
                                                                <table class="table table-head-fixed text-center" id="example">
                                                                  <thead>
                                                                    <tr>
                                                                      <th>N°</th>
                                                                      <th>Nombre</th>
                                                                      <th>Editar</th>
                                                                      <th>Eliminar</th>
                                                                      <th>Aplicar Variable</th>
                                                                    </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                     <?php
                                                                     require 'conexion/bd.php';
                                                                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                     //$data = $mysqli->query("SELECT * FROM indicadoresVariables  ORDER BY nombreVariable")or die(mysqli_error());
                                                                     //$filtroNombre=$_POST['filtroNombre'];
                                                                     //$filtroSimbolo=$_POST['filtroSimbolo'];
                                                                     //if($filtroNombre != NULL || $filtroSimbolo != NULL){
                                                                    //    $data = $mysqli->query("SELECT * FROM indicadoresVariables WHERE idIndicador IS NULL AND nombreVariable LIKE '%$filtroNombre%' ORDER BY simbolo")or die(mysqli_error());
                                                                     
                                                                     //   if($filtroSimbolo != NULL){
                                                                      //       $data = $mysqli->query("SELECT * FROM indicadoresVariables WHERE idIndicador IS NULL AND simbolo LIKE '%$filtroSimbolo%' ORDER BY simbolo")or die(mysqli_error());
                                                                     //   }    
                                                                     //}else{
                                                                     $data = $mysqli->query("SELECT * FROM indicadoresVariables  ORDER BY simbolo ASC")or die(mysqli_error());
                                                                     //}
                                                                     $conteo=1;
                                                                     $conteoEnviar=1;
                                                                     while($row = $data->fetch_assoc()){
                                                                 
                                                                    echo"<tr>";
                                                                    echo" <td>".$conteo++."</td>";
                                                                    $enviarSimbolo=$row['simbolo'];
                                                                    echo" <td>".$row['nombreVariable']."</td>";
                                                                    $id=$row['id'];
                                                                    echo"<form action='indicadoresAgregar2' method='POST'>";
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                                                    echo"<input type='hidden' name='calculadoraMostrar' value= 'TRUE' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$ultimoIndicadorSale' >";
                                                                    echo" <td><button type='submit' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                                                    echo"</form>";
                                                                     ?>
                                                                    
                                                                    <input type='hidden' id='capturaVariableEliminacion<?php echo $contadoEliminacionr++;?>'  value= '<?php echo $id;?>' >
                                                                    <td><a onclick='funcionFormula<?php echo $contadorEliminacion1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                                                    <script>
                                                                        function funcionFormula<?php echo $contadorEliminacion2++;?>() {
                                                                            /*alert("entre");*/
                                                                          document.getElementById("capturarFormulaEliminacion").value = document.getElementById("capturaVariableEliminacion<?php echo $contadorEliminacion3++;?>").value;
                                                                        }
                                                                   </script>
                                                                    <?php
                                                                    /*
                                                                    echo"<form action='controlador/indicadores/controller' method='POST'>";
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                                                    echo"<input type='hidden' name='calculadoraMostrar' value= 'TRUE' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$ultimoIndicadorSale' >";
                                                                    echo" <td><button  onclick='return ConfirmDelete()' type='submit' name='AgregarVariablesEliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                                                                    echo"</form>";
                                                                    */
                                                                    /*
                                                                    echo"<form action='controlador/indicadores/controller' method='POST'>";
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                                                    echo"<input type='hidden' name='calculadoraMostrar' value= 'TRUE' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$ultimoIndicadorSale' >";
                                                                    echo" <td><button   type='submit' name='AgregarVariablesAplicar'style='color:white;' class='btn btn-block btn-warning btn-sm'><i class=''></i> Aplicar</button></td>"; //fas fa-trash-alt
                                                                    echo"</form>";*/
                                                                    ?>
                                                                    <td><a   id='enviarVariable<? echo $conteoEnviar++;?>' style='color:white;' class='btn btn-block btn-warning btn-sm'><? echo $enviarSimbolo;?></a></td>
                                                                    <?
                                                                    echo"</tr>";
                                                                    }
                                                                    ?> 
                                                                    <div class="modal fade" id="modal-danger">
                                                                        <div class="modal-dialog">
                                                                          <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                              <h4 class="modal-title">Alerta</h4>
                                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                              </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                              <p>¿Est&aacute; seguro que desea eliminar?</p>
                                                                            </div>
                                                                             <!-- formulario para eliminar por el id -->
                                                                            <form action='controlador/indicadores/controller' method='POST'>
                                                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                                                <input type='hidden' name='calculadoraMostrar' value= 'TRUE' >
                                                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $ultimoIndicadorSale; ?>' >
                                                                            <div class="modal-footer justify-content-between">
                                                                              <input type="hidden" id="capturarFormulaEliminacion" name='id' readonly>
                                                                              <button type="submit" name='AgregarVariablesEliminar' class="btn btn-outline-light">Si</button>
                                                                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                                                            </div>
                                                                             </form>
                                                                             <!-- END formulario para eliminar por el id -->
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                  </tbody>
                                                                </table>
                                                              </div>
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                  </div>
                                              </div>
                                              </div>
                        </section>
    </div>
  
    <section class="content">
          <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col">
                        
                </div>
                <div class="col-9">
                   
                    <div class="card card-primary">
                   
                  
                   <section class="content"><br>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                        <table>
                                            <tr>
                                                <td>
                                                    <form action="controlador/indicadores/controller" method="POST">
                                                        <label>Fórmula</label>
                                                        <input type="hidden" name='quienCrea' value="<?php echo $quienCrea; ?>" required>
                                                        <input type="hidden" name='variablesIdPrincipal' value="<?php echo $ultimoIndicadorSale; ?>"required>
                                                        <input style="background:#666;color:white;padding:9px;width:100%;color:white;" size="36px" name="formula" id="capturarFormula" type="" value="<?php echo $ecuacion; ?>"   onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 33 || event.charCode == 35 || event.charCode == 36 || event.charCode == 37 || event.charCode == 38 || event.charCode == 47 || event.charCode == 40 || event.charCode == 41 || event.charCode == 61 || event.charCode == 63 || event.charCode == 161 || event.charCode == 191 || event.charCode == 43 || event.charCode == 42 || event.charCode == 45)" required>
                                                        <br><br>
                                                        <button type="submit" style="color:white;" class="btn btn-warning" name="AgregarFormula">Siguiente</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </section>
                      
    
                   
                
                    </div>
                </div>    
                <div class="col">
                        
                </div>
            </div>
           
          </div>
        </section>
                   
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoC').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
        $('#rad_usuarioC').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
    });
</script>
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Está seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<script>
        $(document).ready(function(){
            $('#rad_mostrar').click(function(){
                document.getElementById('ocultarMostrar').style.display = 'none';
                document.getElementById('ocultar').style.display = '';
                document.getElementById('mostrar').style.display = '';
            });

            $('#rad_ocultar').click(function(){
                document.getElementById('ocultarMostrar').style.display = '';
                document.getElementById('mostrar').style.display = 'none';
                document.getElementById('ocultar').style.display = 'none';
            });
        });
    </script>
     <!-- se usa esta función para el resultado de la calculadora y capturarlo en el input de formula -->
    <script>
        function funcionFormula() {
            /*alert("entre");*/
          document.getElementById("capturarFormula").value = document.getElementById("capturaVariable").value;
        }
    </script>
    <!-- END -->
    <!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    
    <?php
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La variable ya existe.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
        })
    <?php
    }
    
    if($validacionActualizar == 1){
    ?>
        Toast.fire({
            type: 'info',
            title: 'Registro actualizado.'
        })
    <?php
    }
    
    if($validacionEliminar == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Registro eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
  <script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
</body>
</html>
<?php
}
?>