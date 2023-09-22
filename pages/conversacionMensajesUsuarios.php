<?php
session_start();
if(!isset($_SESSION["session_username"])){
  
}else{
    include 'conexion/bd.php';
    
    $_SESSION["session_username"];
    ?>
    <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-center" id="example">
          <tbody>
            <?php
                $acentos = $mysqli->query("SET NAMES 'utf8'");
                $consultarNombre=$mysqli->query("SELECT * FROM usuario WHERE estadoUsuario='Conectado'  "); //AND NOT cedula='".$_SESSION["session_username"]."'
                while($traerNombre=$consultarNombre->fetch_array()){
                ?>    
                    
                            <tr>
                              <td>
                                  <form action="" method="POST">
                                      <input name="solicitarChat" id="solicitarChat" value="<?php echo $traerNombre['cedula']; ?>" type="" readonly>
                                      <button type="submit" class="btn btn-primary">Iniciar</button>
                                  </form>
                              </td>
                              <td><?php echo $traerNombre['nombres'].' '.$traerNombre['apellidos'];?></td>
                              <td><?php 
                                    if($traerNombre['mensaje'] > 0){
                                        echo '<font color="red">'.$traerNombre['mensaje'].'</font>';
                                    }else{
                                        echo '<font color="blue">0</font>';
                                    }
                                   ?>
                              </td>
                            </tr>
                <?php    
                }
                ?>
          </tbody>
        </table>
    </div>
    <?php
             
}
?>
