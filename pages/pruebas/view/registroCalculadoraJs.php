<?php
require_once '../controllers/bd.php';
?>
                      <table class="table table-head-fixed text-center" >
                         <thead>
                            <tr>
                                <th>Número 1</th>
                                <th>Número 2</th>
                                <th>Operación</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $consulta=$mysqli->query("SELECT * FROM resultados  ORDER BY id ");
                            while($extrae=$consulta->fetch_array()){
                            ?>
                            <tr>
                                <td><?php echo $extrae['numero1']; ?></td>
                                <td><?php echo $extrae['numero2']; ?></td>
                                <td><?php 
                                    if( $extrae['operacion'] == 'sumar'){
                                        echo 'Suma';
                                    }elseif( $extrae['operacion'] == 'restar'){
                                        echo 'Resta';
                                    }elseif( $extrae['operacion'] == 'multiplicar'){
                                        echo 'Multiplicación';
                                    }elseif( $extrae['operacion'] == 'dividir'){
                                        echo 'División';
                                    }  
                                     ?>
                                </td>
                                <td><?php echo $extrae['resultado']; ?></td>
                                
                            </tr>
                            <?php
                             }
                            ?>
                        </tbody>
                     </table>
