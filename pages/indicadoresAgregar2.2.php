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
<body class="hold-transition sidebar-mini">
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
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
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
        <div class="row">
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
                  <? /* ?>
                        <form action="indicadoresAgregarTipoVariable" method="POST">
                            <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                            <button type="submit" style="color:white;" class="btn btn-success float-let" name="AgregarVariables">Regresar</button>
                        </form>    
                        <?php
                        */
                            //// debemos mantener la variable viajando en el archivo para que no se cierre esta opción
                            $variablesSM=$_POST['variablesSU'];
                            if($variablesSM == 'Serie única'){
                                $checkedMulti='checked';
                            }
                            ///// END
                        ?>
                            <form role="form" action="controlador/indicadores/controllerM" method="POST" enctype="multipart/form-data">
                      
                     
                            <div class="card-body">
                                
                                <!-- parametros para la activacion de correo y plataforma -->
                                   
                                            
                                            
                                          <input name="usuarioActividad" value="<?php echo $ultimoIndicadorSaleQuienCrea;?>" type="hidden" readonly>
                                          <input name="idContinuaIndicador" value="<?php echo $ultimoIndicadorSale;?>" type="hidden" readonly>
                                          
                                          
                                          
                                        
                                              <?php if($visibleP != 'none'){ ?>
                                              
                                               
                                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                                <?php }else{  }
                                          
                                              if($visibleP != 'none' && $visibleC != 'none'){
                                                  //echo '-';
                                              }
                                          
                                                    if($visibleC != 'none'){ ?>
                                               
                                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                                <?php }else{  } ?>
                                       
                                <!-- Fin parametros para la activacion de correo y plataforma -->
                                   
                                  <div class="row">
                                      <div class="form-group col-sm-6">
                                            <label>Tipo de variable a usar en el indicador</label><br>
                                            Serie única
                                            <input type="radio" class=""  name="variables" value="Serie única" <?php //echo $checkedMulti; ?>checked required>
                                            <br><br>
                                            
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="nombre2" placeholder="Nombre" required>
                                            <br>
                                            <label>Descripción:</label>
                                            <textarea type="text" class="form-control" name="descripcion2" placeholder="Descripción" required></textarea>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label><font color="white">color</font></label><br>
                                            
                                            <input type="radio" style="visibility:hidden;" >
                                           
                                            <input type="radio" style="visibility:hidden;" >
                                             <br><br>
                                            <label>Símbolo:</label>
                                            <input type="text" class="form-control" name="simbolo" placeholder="Símbolo" required>
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
                                                        <font color="white">espacio</font>
                                                    </td>
                                                    <td>
                                                        <button type="submit" style="color:white;" class="btn btn-warning float-right" name="AgregarVariables">Guardar</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                  </div>
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
                                                          <form role="form" action="controlador/indicadores/controllerM" method="POST">
                                                            <div class="card-body">
                                                              <div class="form-group">
                                                                <label>Nombre:</label>
                                                                <input type="text" class="form-control"  name="nombre2" value="<?php echo $nombreVariable; ?>" placeholder="Tipo" required>
                                                                <br>
                                                                <label>Símbolo:</label>
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
                    <div name="ocultarMostrar" id="ocultarMostrar">
                        <input type="button" class="btn btn-primary" value="Variable" id="rad_mostrar" name="radiobtn" value="mostrar">
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
                                                                <table class="table table-head-fixed text-center" id="example">
                                                                  <thead>
                                                                    <tr>
                                                                      <th>N°2</th>
                                                                      <th>Nombre</th>
                                                                      <th>Editar</th>
                                                                      <th>Eliminar</th>
                                                                      <th>Aplicar símbolo</th>
                                                                    </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                     <?php
                                                                     require 'conexion/bd.php';
                                                                     $acentos = $mysqli->query("SET NAMES 'utf8'"); ///usuario='$ultimoIndicadorSaleQuienCrea' AND
                                                                     $data = $mysqli->query("SELECT * FROM indicadoresVariables WHERE  idIndicador='$ultimoIndicadorSale' ORDER BY nombreVariable")or die(mysqli_error());
                                                                     $conteo=1;
                                                                     $conteoEnviar=1;
                                                                     while($row = $data->fetch_assoc()){
                                                                 
                                                                    echo"<tr>";
                                                                    echo" <td>".$conteo++."</td>";
                                                                    $enviarSimbolo=$row['simbolo'];
                                                                    echo" <td>".$row['nombreVariable']."</td>";
                                                                    $id=$row['id'];
                                                                    echo"<form action='indicadoresAgregar2.2' method='POST'>";
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                                                    echo"<input type='hidden' name='calculadoraMostrar' value= 'TRUE' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$ultimoIndicadorSale' >";
                                                                    echo" <td><button type='submit' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                                                    echo"</form>";
                                                                    echo"<form action='controlador/indicadores/controllerM' method='POST'>";
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='quienCrea' value= '$quienCrea' >";
                                                                    echo"<input type='hidden' name='calculadoraMostrar' value= 'TRUE' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$ultimoIndicadorSale' >";
                                                                    echo" <td><button  onclick='return ConfirmDelete()' type='submit' name='AgregarVariablesEliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                                                                    echo"</form>";
                                                                    /*
                                                                    echo"<form action='controlador/indicadores/controllerM' method='POST'>";
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
                   <section>   
                           <!-- Calculadora -->
                                <center><h4>Calculadora</h4></center>
                                    <style>
                                    *{
                                        padding: 0px;
                                        margin: 0px;
                                        /*font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;*/
                                    }
                                    
                                    .contenidoCalculadora{
                                        background-color: #ededed;
                                        width: fit-content;
                                        margin: auto;
                                        margin-top: 30px;
                                    }
                                    
                                    .teclas{
                                        display: flex;
                                    }
                                    
                                    .pantalla{
                                        padding: 18px 18px 0px 18px;
                                    }
                                    
                                    #resultado{
                                        background-color: #666;
                                        padding: 9px;
                                        color: white;
                                    }
                                    
                                    .operaciones{
                                        padding: 18px; 18px 18px 9px;
                                    }
                                    .operaciones button{
                                        display: block;
                                        width: 54px;
                                        height: 54px;
                                        padding: 9px 15px;
                                        background-color: #000;/*rgba(30,60,160,0.12);*/
                                        color: #fff;
                                        border: none;
                                    }
                                    
                                    .numeros {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .numeros div{
                                        text-align: center;
                                    }
                                    .numeros button{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                    }
                                    .numeros button:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    .variables {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .variables div{
                                        text-align: center;
                                    }
                                    .variables a{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                        /*height: 15px;*/
                                        width: 70px;
                                        font-size: 10px;
                                    }
                                    .variables a:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    
                                    button{
                                        margin: 2px 0px;
                                        padding: 15px;
                                        font-size: 19px;
                                    }
                                    
                                    .sr{
                                        padding: 0px 18px; 18px; 18px;
                                    }
                                    
                                    .sr button{
                                        width: 100%;
                                        background-color: #48c;
                                        color: white;
                                        columns: #fff;
                                        border: none;
                                        font-size: 50px;
                                        padding: 0px;
                                        
                                    }
                                    
                                </style>
                                <div class="contenidoCalculadora">
                                    <div class="pantalla">
                                        <div id="resultado"></div>
                                        <div>
                                            <?php
                                                if(isset($_POST['aplicarVariable'])){
                                                    $ecuacion=$_POST['ecuacion'];
                                                }
                                            ?>
                                            <!-- 
                                            <form action="" method="POST">
                                                <input type='hidden' name='quienCrea' value="<?php //echo $quienCrea; ?>" >
                                                <input type='hidden' name='calculadoraMostrar' value="TRUE" >
                                                <input type='hidden' name='variablesIdPrincipal' value="<?php //echo $variablesIdPrincipal; ?>" >
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <button type="submit" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Aceptar</button>
                                            </form>
                                            -->
                                            
                                              
                                                <!-- enviamos por javascript al input por el boton aceptar o submit-->
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <button onclick="funcionFormula()" type="submit" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Aceptar</button>
                                            
                                        </div>
                                    </div>
                                    <div class="teclas">
                                       
                                       <!--     <div class="">
                                                <?php /*
                                                //// se agrega tabla para las variables asociadas al indicador
                                                $variables=$mysqli->query("SELECT * FROM indicadoresVariablesAsociadas WHERE idIndicador='$variablesIdPrincipal' ORDER BY id ");
                                                $contador=1;
                                                while($extraerVariable= $variables->fetch_array()){
                                                    ////// se realiza subconsulta para traer el nombre del IdVariable
                                                    $nombreVariable=$extraerVariable['idVariable'];
                                                    $idVariable=$mysqli->query("SELECT * FROM indicadoresVariables WHERE id='$nombreVariable' ");
                                                    $extraerIdVariable=$idVariable->fetch_array(MYSQLI_ASSOC);
                                                    
                                                ?>
                                                    <button id="v<?php echo $contador++; ?>"><?php echo $extraerIdVariable['simbolo']; ?></button><br>
                                                        <form action="controlador/indicadores/controllerM" method="POST">
                                                            <input type="hidden" name='quienCrea' value="<?php echo $quienCrea; ?>" >
                                                            <input type="hidden" name='calculadoraMostrar' value="TRUE" >
                                                            <input type="hidden" name='variablesIdPrincipal' value="<?php echo $variablesIdPrincipal; ?>" >
                                                            <input value="<?php echo $extraerVariable['id']; ?>" name="desaplicar" type="hidden" readonly>  
                                                            <td><button   type='submit' name='AgregarVariablesDesaplicar'style='color:white;background:#ffc107;' class='btn btn-block btn-warning btn-sm'><i class=''></i> Desaplicar</button></td>
                                                        </form>
                                                <?php 
                                                } */
                                                //// END
                                                ?>
                                            </div> -->
                                       
                                        <div class="numeros">
                                            <div>
                                                <button id="n1">1</button>
                                                <button id="n2">2</button>
                                                <button id="n3">3</button>
                                                <button id="nCa">^</button>
                                                
                                            </div>
                                            <div>
                                                <button id="n4">4</button>
                                                <button id="n5">5</button>
                                                <button id="n6">6</button>
                                                <button id="nP1">(</button>
                                                
                                            </div>
                                            <div>
                                                <button id="n7">7</button>
                                                <button id="n8">8</button>
                                                <button id="n9">9</button>
                                                <button id="nP2">)</button>
                                            </div>
                                            <div>
                                                <button id="nC">,</button>
                                                <button id="n0">0</button>
                                                <button id="nP">.</button>
                                                <button id="nMYMN">+/-</button>
                                            </div>
                                            
                                        </div>
                                        <div class="operaciones">
                                            <button id="s">+</button>
                                            <button id="r">-</button>
                                            <button id="d">/</button>
                                            <button id="m">x</button>
                                            <button id="BT">C</button>
                                        </div>
                                    </div>
                                    <div class="variables">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v1" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v2" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v3" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v4" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v5" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v6" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v7" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v8" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v9" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v10" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v11" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v12" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v13" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v14" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v15" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                   
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v16" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v17" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v18" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v19" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v20" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v21" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v22" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v23" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v24" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v25" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v26" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v27" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v28" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v29" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v30" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="sr">
                                            <button id="sr"></button>
                                    </div>
                                </div>
                            
                                <script>
                                
                                 /*función para retroceso*/
                                    document.getElementById("BT").addEventListener("click",borradoTotal);
                                 
                                    function borradoTotal() {
                                     document.getElementById("resultado").value= resultado.innerHTML=0; //poner pantalla a 0
                                     document.getElementById("capturaVariable").value= resultado.innerHTML=''; //poner pantalla a 0
                                    }
                                
                                
                                 /*Operaciones*/
                                    document.getElementById("s").addEventListener("click",operaciones1);
                                    document.getElementById("r").addEventListener("click",operaciones2);
                                    document.getElementById("d").addEventListener("click",operaciones3);
                                    document.getElementById("m").addEventListener("click",operaciones4);
                                    document.getElementById("sr").addEventListener("click",showResult);
                                   
                                    function operaciones1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("s").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("r").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("d").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("m").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function showResult(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let suma = actual.indexOf("+");
                                        let resta = actual.indexOf("-");
                                        let div = actual.indexOf("/");
                                        let mult = actual.indexOf("x");
                                        if(suma !== -1){
                                            arr = actual.split("+",2);
                                            res = parseInt(arr[0]) + parseInt(arr[1]);
                                            document.getElementById("resultado").innerHTML = res;
                                            /* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (resta !== -1){
                                            arr = actual.split("-",2);
                                            res = arr[0] - arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (div !== -1){
                                            arr = actual.split("/",2);
                                            res = arr[0] / arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (mult !== -1){
                                            arr = actual.split("x",2);
                                            res = arr[0] * arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }
                                    }
                                    
                                
                                
                                /* script para los numeros*/
                                    document.getElementById("n1").addEventListener("click",n1);
                                    document.getElementById("n2").addEventListener("click",n2);
                                    document.getElementById("n3").addEventListener("click",n3);
                                    document.getElementById("n4").addEventListener("click",n4);
                                    document.getElementById("n5").addEventListener("click",n5);
                                    document.getElementById("n6").addEventListener("click",n6);
                                    document.getElementById("n7").addEventListener("click",n7);
                                    document.getElementById("n8").addEventListener("click",n8);
                                    document.getElementById("n9").addEventListener("click",n9);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("nP1").addEventListener("click",nP1);
                                    document.getElementById("nP2").addEventListener("click",nP2);
                                    document.getElementById("nCa").addEventListener("click",nCa);
                                    document.getElementById("nMYMN").addEventListener("click",nMYMN);
                                    
                                    
                                    
                                    
                                    function n1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n0(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n0").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nCa(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nCa").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nMYMN(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nMYMN").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    /*script para el (.) y la (,)*/
                                    
                                    document.getElementById("nC").addEventListener("click",nC);
                                    document.getElementById("nP").addEventListener("click",nP);
                                    function nC(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nC").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /*script para las variables que se elistan al costado izquierda de la calculadora*/
                                    
                                    document.getElementById("v1").addEventListener("click",v1);
                                    document.getElementById("v2").addEventListener("click",v2);
                                    document.getElementById("v3").addEventListener("click",v3);
                                    document.getElementById("v4").addEventListener("click",v4);
                                    document.getElementById("v5").addEventListener("click",v5);
                                    document.getElementById("v6").addEventListener("click",v6);
                                    document.getElementById("v7").addEventListener("click",v7);
                                    document.getElementById("v8").addEventListener("click",v8);
                                    document.getElementById("v9").addEventListener("click",v9);
                                    document.getElementById("v10").addEventListener("click",v10);
                                    
                                    document.getElementById("v11").addEventListener("click",v11);
                                    document.getElementById("v12").addEventListener("click",v12);
                                    document.getElementById("v13").addEventListener("click",v13);
                                    document.getElementById("v14").addEventListener("click",v14);
                                    document.getElementById("v15").addEventListener("click",v15);
                                    document.getElementById("v16").addEventListener("click",v16);
                                    document.getElementById("v17").addEventListener("click",v17);
                                    document.getElementById("v18").addEventListener("click",v18);
                                    document.getElementById("v19").addEventListener("click",v19);
                                    document.getElementById("v20").addEventListener("click",v20);
                                    
                                    document.getElementById("v21").addEventListener("click",v21);
                                    document.getElementById("v22").addEventListener("click",v22);
                                    document.getElementById("v23").addEventListener("click",v23);
                                    document.getElementById("v24").addEventListener("click",v24);
                                    document.getElementById("v25").addEventListener("click",v25);
                                    document.getElementById("v26").addEventListener("click",v26);
                                    document.getElementById("v27").addEventListener("click",v27);
                                    document.getElementById("v28").addEventListener("click",v28);
                                    document.getElementById("v29").addEventListener("click",v29);
                                    document.getElementById("v30").addEventListener("click",v30);
                                     
                                     function v1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v10(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v10").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    function v11(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v11").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v12(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v12").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v13(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v13").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v14(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v14").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v15(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v15").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v16(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v16").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v17(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v17").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v18(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v18").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v19(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v19").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v20(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v20").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v21(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v21").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v22(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v22").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v23(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v23").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v24(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v24").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v25(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v25").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v26(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v26").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v27(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v27").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v28(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v28").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v29(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v29").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v30(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v30").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     /* envia los simbolos creados para aplicarlos en la calculadora*/
                                     document.getElementById("enviarVariable1").addEventListener("click",enviarVariable1);
                                     document.getElementById("enviarVariable2").addEventListener("click",enviarVariable2);
                                     document.getElementById("enviarVariable3").addEventListener("click",enviarVariable3);
                                     document.getElementById("enviarVariable4").addEventListener("click",enviarVariable4);
                                     document.getElementById("enviarVariable5").addEventListener("click",enviarVariable5);
                                     document.getElementById("enviarVariable6").addEventListener("click",enviarVariable6);
                                     document.getElementById("enviarVariable7").addEventListener("click",enviarVariable7);
                                     document.getElementById("enviarVariable8").addEventListener("click",enviarVariable8);
                                     document.getElementById("enviarVariable9").addEventListener("click",enviarVariable9);
                                     document.getElementById("enviarVariable10").addEventListener("click",enviarVariable10);
                                    
                                     document.getElementById("enviarVariable11").addEventListener("click",enviarVariable11);
                                     document.getElementById("enviarVariable12").addEventListener("click",enviarVariable12);
                                     document.getElementById("enviarVariable13").addEventListener("click",enviarVariable13);
                                     document.getElementById("enviarVariable14").addEventListener("click",enviarVariable14);
                                     document.getElementById("enviarVariable15").addEventListener("click",enviarVariable15);
                                     document.getElementById("enviarVariable16").addEventListener("click",enviarVariable16);
                                     document.getElementById("enviarVariable17").addEventListener("click",enviarVariable17);
                                     document.getElementById("enviarVariable18").addEventListener("click",enviarVariable18);
                                     document.getElementById("enviarVariable19").addEventListener("click",enviarVariable19);
                                     document.getElementById("enviarVariable20").addEventListener("click",enviarVariable20);
                                     
                                     document.getElementById("enviarVariable21").addEventListener("click",enviarVariable21);
                                     document.getElementById("enviarVariable22").addEventListener("click",enviarVariable22);
                                     document.getElementById("enviarVariable23").addEventListener("click",enviarVariable23);
                                     document.getElementById("enviarVariable24").addEventListener("click",enviarVariable24);
                                     document.getElementById("enviarVariable25").addEventListener("click",enviarVariable25);
                                     document.getElementById("enviarVariable26").addEventListener("click",enviarVariable26);
                                     document.getElementById("enviarVariable27").addEventListener("click",enviarVariable27);
                                     document.getElementById("enviarVariable28").addEventListener("click",enviarVariable28);
                                     document.getElementById("enviarVariable29").addEventListener("click",enviarVariable29);
                                     document.getElementById("enviarVariable30").addEventListener("click",enviarVariable30);
                                     
                                    function enviarVariable1(){
                                        
                                        let enviar = document.getElementById("enviarVariable1").innerHTML;
                                        document.getElementById('v1').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable2(){
                                        
                                        let enviar = document.getElementById("enviarVariable2").innerHTML;
                                        document.getElementById('v2').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable3(){
                                        
                                        let enviar = document.getElementById("enviarVariable3").innerHTML;
                                        document.getElementById('v3').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable4(){
                                        
                                        let enviar = document.getElementById("enviarVariable4").innerHTML;
                                        document.getElementById('v4').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable5(){
                                        
                                        let enviar = document.getElementById("enviarVariable5").innerHTML;
                                        document.getElementById('v5').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable6(){
                                        
                                        let enviar = document.getElementById("enviarVariable6").innerHTML;
                                        document.getElementById('v6').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable7(){
                                        
                                        let enviar = document.getElementById("enviarVariable7").innerHTML;
                                        document.getElementById('v7').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable8(){
                                        
                                        let enviar = document.getElementById("enviarVariable8").innerHTML;
                                        document.getElementById('v8').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable9(){
                                        
                                        let enviar = document.getElementById("enviarVariable9").innerHTML;
                                        document.getElementById('v9').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable10(){
                                        
                                        let enviar = document.getElementById("enviarVariable10").innerHTML;
                                        document.getElementById('v10').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable11(){
                                        
                                        let enviar = document.getElementById("enviarVariable11").innerHTML;
                                        document.getElementById('v11').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable12(){
                                        
                                        let enviar = document.getElementById("enviarVariable12").innerHTML;
                                        document.getElementById('v12').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable13(){
                                        
                                        let enviar = document.getElementById("enviarVariable13").innerHTML;
                                        document.getElementById('v13').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable14(){
                                        
                                        let enviar = document.getElementById("enviarVariable14").innerHTML;
                                        document.getElementById('v14').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable15(){
                                        
                                        let enviar = document.getElementById("enviarVariable15").innerHTML;
                                        document.getElementById('v15').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable16(){
                                        
                                        let enviar = document.getElementById("enviarVariable16").innerHTML;
                                        document.getElementById('v16').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable17(){
                                        
                                        let enviar = document.getElementById("enviarVariable17").innerHTML;
                                        document.getElementById('v17').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable18(){
                                        
                                        let enviar = document.getElementById("enviarVariable18").innerHTML;
                                        document.getElementById('v18').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable19(){
                                        
                                        let enviar = document.getElementById("enviarVariable19").innerHTML;
                                        document.getElementById('v19').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable20(){
                                        
                                        let enviar = document.getElementById("enviarVariable20").innerHTML;
                                        document.getElementById('v20').innerHTML = enviar
                                        
                                    }
                                    
                                    function enviarVariable21(){
                                        
                                        let enviar = document.getElementById("enviarVariable21").innerHTML;
                                        document.getElementById('v21').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable22(){
                                        
                                        let enviar = document.getElementById("enviarVariable22").innerHTML;
                                        document.getElementById('v22').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable23(){
                                        
                                        let enviar = document.getElementById("enviarVariable23").innerHTML;
                                        document.getElementById('v23').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable24(){
                                        
                                        let enviar = document.getElementById("enviarVariable24").innerHTML;
                                        document.getElementById('v24').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable25(){
                                        
                                        let enviar = document.getElementById("enviarVariable25").innerHTML;
                                        document.getElementById('v25').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable26(){
                                        
                                        let enviar = document.getElementById("enviarVariable26").innerHTML;
                                        document.getElementById('v26').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable27(){
                                        
                                        let enviar = document.getElementById("enviarVariable27").innerHTML;
                                        document.getElementById('v27').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable28(){
                                        
                                        let enviar = document.getElementById("enviarVariable28").innerHTML;
                                        document.getElementById('v28').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable29(){
                                        
                                        let enviar = document.getElementById("enviarVariable29").innerHTML;
                                        document.getElementById('v29').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable30(){
                                        
                                        let enviar = document.getElementById("enviarVariable30").innerHTML;
                                        document.getElementById('v30').innerHTML = enviar
                                        
                                    }
                                    
                                    /* end envia los simbolos creados para aplicarlos en la calculadora*/
                                /* 303 líneas de código para la calculadora, atrapar la variable al aplicar y desaplicar y eviarla a una variable*/
                                </script>
                            <!-- END calculadora -->
                            
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                        <table>
                                            <tr>
                                                <td>
                                                    <form action="controlador/indicadores/controllerM" method="POST">
                                                        <label>Fórmula</label>
                                                        <input type="hidden" name='quienCrea' value="<?php echo $quienCrea; ?>" required>
                                                        <input type="hidden" name='variablesIdPrincipal' value="<?php echo $ultimoIndicadorSale; ?>"required>
                                                        <input style="background:#666;color:white;padding:9px;width:100%;color:white;" id="capturarFormula" name="formula" type="" value="<?php echo $ecuacion; ?>"  size="36px" required>
                                                        <button type="submit" style="color:white;" class="btn btn-warning" name="AgregarFormula">Siguiente</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
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
</body>
</html>
<?php
}
?>