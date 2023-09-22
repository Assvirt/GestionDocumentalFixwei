<head><meta http-equiv="Content-Type" content="text/html;" charset="utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
  <title>Cargos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- evento para el actualizar o eliminar  -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
<!-- finaliza el evento  --> 
</head>


<form action="../controlador/cargos/controladorNivelCargo" method="POST">
                    <div class="modal-body">
                      <p>Ingresar nivel:</p>
                      <input class="form-control" type="text"  name="nivelCargo" required>
                        <div class="modal-footer justify-content-between">
                          <input type="submit" name="AgregarNivelCargo" class="btn btn-primary" value="Guardar">
                          </form>
                        </div>
                      <p>Niveles existentes</p>
                      <table class="table table-head-fixed" >
                          <tr>
                              <th>Niveles</th>
                          </tr>
                          <?php         require_once'../conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = "SELECT * FROM nivelcargo ORDER BY id_nivelcargo";
                						$resultado=$mysqli->query($query);
                                        while ($columna = mysqli_fetch_array( $resultado )) {
                          ?>
                        <tbody>
                              <tr>
                                  <form action="../controlador/cargos/controladorNivelCargo" method="POST">
                                    <input readonly value="<?php echo  $columna['id_nivelCargo']; ?>" type="hidden" name="idNivelCargo">
                                      <td>
                                          <input  value="<?php echo utf8_decode($columna['nivelCargo']); ?>" type="text" name="nivelCargo">
                                      </td>
                                      <td>
                                          <button type="submit" name="AgregarNivelCargoEditar"><i class="fas fa-edit"></i></button>
                                      </td>
                                  </form>
                                  
                                  <form action="../controlador/cargos/controladorNivelCargo" method="POST">
                                    <input readonly value="<?php echo $columna['id_nivelCargo']; ?>" type="hidden" name="idNivelCargo">
                                      <td>
                                          <button type="submit" name="AgregarNivelCargoEliminar" ><i class="far fa-trash-alt"></i></button>
                                      </td>
                                  </form>
                              </tr>
                        </tbody><?php } ?>
                      </table>
                    </div>