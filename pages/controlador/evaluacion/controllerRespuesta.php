<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");

 'Usuario: '.$usuario = $_POST['usuario'];
 '<br>';
 'idEvaluacion: '.$idEvaluacion = $_POST['idEvaluacion'];
 '<br>';
 'id pregunta: '.$idPregunta=$_POST['idPregunta'];
 '<br>';
 'tipo pregunta: '.$tipoPregunta=$_POST['tipoPregunta'];
 '<br>';
 'pregunta abierta: '.$respuesta=$_POST['respuesta'];
 '<br>';
 'Pregunta Si no: '.$SiNo=$_POST['SiNo'];
 '<br>';
 'Pregunta multiple1: '.$correcto1=$_POST['correcto1'];
 '<br>';
 'Pregunta multiple2: '.$correcto2=$_POST['correcto2'];
 '<br>';
 'Pregunta multiple3: '.$correcto3=$_POST['correcto3'];
 '<br>';
 'Pregunta multiple4: '.$correcto4=$_POST['correcto4'];
 '<br>';
 'Pregunta multiple5: '.$correcto5=$_POST['correcto5'];
 '<br>'; 
 'Pregunta única respuesta: '.$correcto=$_POST['correcto'];
 '<br>';
 'Relacionar1: '.$relacionar1=$_POST['relacionar1'];
 '<br>';
 'Relacionar2: '.$relacionar2=$_POST['relacionar2'];
 '<br>';
 'Relacionar3: '.$relacionar3=$_POST['relacionar3'];
 '<br>';
 'Relacionar4: '.$relacionar4=$_POST['relacionar4'];
 '<br>';
 'Relacionar5: '.$relacionar5=$_POST['relacionar5'];
 '<br>';

 '<br>';

for ($i=0,$j=0; $i<count($idPregunta),$j<count($tipoPregunta); $i++,$j++){ 
             'idPregunta: '.$idPregunta[$i]; 
             '<br>';
             'tipo pregunta: '.$tipoPregunta[$j]; 
            if($tipoPregunta[$j] == '1'){
                //echo ' -abierta- ';
                $mysqli->query("INSERT INTO evaluacionRespuesta (idEvaluacion,usuario,idPregunta,tipoPregunta,respuesta1)VALUES('$idEvaluacion','$usuario','$idPregunta[$i]','$tipoPregunta[$j]','$respuesta')")or die(mysqli_error($mysqli));
            }elseif($tipoPregunta[$j] == '2'){
                //echo ' -SiNo- ';
                $mysqli->query("INSERT INTO evaluacionRespuesta (idEvaluacion,usuario,idPregunta,tipoPregunta,respuesta1)VALUES('$idEvaluacion','$usuario','$idPregunta[$i]','$tipoPregunta[$j]','$SiNo')")or die(mysqli_error($mysqli));
            }elseif($tipoPregunta[$j] == '3'){
                //echo ' -checkbox- ';
                $mysqli->query("INSERT INTO evaluacionRespuesta (idEvaluacion,usuario,idPregunta,tipoPregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5)VALUES('$idEvaluacion','$usuario','$idPregunta[$i]','$tipoPregunta[$j]','$correcto1','$correcto2','$correcto3','$correcto4','$correcto5')")or die(mysqli_error($mysqli));
            }elseif($tipoPregunta[$j] == '4'){
                //echo ' -radio- ';
                $mysqli->query("INSERT INTO evaluacionRespuesta (idEvaluacion,usuario,idPregunta,tipoPregunta,respuesta1)VALUES('$idEvaluacion','$usuario','$idPregunta[$i]','$tipoPregunta[$j]','$correcto')")or die(mysqli_error($mysqli));
            }elseif($tipoPregunta[$j] == '5'){
                //echo ' -relacionar- <br>';
                $mysqli->query("INSERT INTO evaluacionRespuesta (idEvaluacion,usuario,idPregunta,tipoPregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5)VALUES('$idEvaluacion','$usuario','$idPregunta[$i]','$tipoPregunta[$j]','$relacionar1','$relacionar2','$relacionar3','$relacionar4','$relacionar5')")or die(mysqli_error($mysqli));
                
            }
            
            
            //echo '<br><br>';
}
?>
 <script> 
                                 window.onload=function(){
                               
                                     document.forms["miformulario"].submit();
                                 }
                            </script>
                             
                            <form name="miformulario" action="../../evaluacionParticipacion" method="POST" onsubmit="procesar(this.action);" >
                                <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                <input type="hidden" name="validacionRealizada" value="1">
                            </form>
