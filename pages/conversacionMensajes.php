<?php
session_start();
if(!isset($_SESSION["session_username"])){
  
}else{
    include 'conexion/bd.php';
    
    $_SESSION["session_username"];
    
    
    include'pruebasRecibir.php';
    
   
    
  
    $traerMensajes=$mysqli->query("SELECT * FROM mensajes   ORDER BY id ASC"); //WHERE para='$quienEscribo'
    while($extraeDatos=$traerMensajes->fetch_array()){
        
        // traemos los datos de mi perfil
        $consultandoDatosPerfil=$mysqli->query("SELECT * FROM usuario WHERE cedula='".$extraeDatos['user']."' ");
        $exatreDatosPerfil=$consultandoDatosPerfil->fetch_array(MYSQLI_ASSOC);
        $fotoPerfilU=$exatreDatosPerfil['foto'];
        // end
        // validamos que la conversación propia que se nos posiciona a la deecha es nuestra y la de la otra persona se nos ubique al costado izquierdo
        if($extraeDatos['user'] == $_SESSION["session_username"]){
            echo '<div class="direct-chat-msg right">';
                echo '<div class="direct-chat-infos clearfix" >
                        <span class="direct-chat-name float-right">'.$exatreDatosPerfil['nombres'].'</span>
                        <span class="direct-chat-timestamp float-left">'.$extraeDatos['fecha'].'</span>
                      </div>';
        
                if($fotoPerfilU != NULL){
                ?>
                    <img class="direct-chat-img" src="data:image/jpg;base64,<? echo base64_encode($fotoPerfilU);?>" alt="Message User Image">
                <?php
                }else{
                    echo '<img class="direct-chat-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="Message User Image">';
                }
        
                echo '<div class="direct-chat-text" style="background:#007bff;border-color: #007bff;color:white;">';
                    
                    echo $extraeDatos['mensaje']; echo '<br>';
                    
                echo '</div>';
            echo '</div>';
        }else{
            
        
            echo '<div class="direct-chat-msg">';
                echo '<div class="direct-chat-infos clearfix" >
                        <span class="direct-chat-name float-left">'.$exatreDatosPerfil['nombres'].'</span>
                        <span class="direct-chat-timestamp float-right">'.$extraeDatos['fecha'].'</span>
                      </div>';
            
                if($fotoPerfilU != NULL){
                ?>
                    <img class="direct-chat-img" src="data:image/jpg;base64,<? echo base64_encode($fotoPerfilU);?>" alt="Message User Image">
                <?php
                }else{
                    echo '<img class="direct-chat-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="Message User Image">';
                }
            
                echo '<div class="direct-chat-text" style="background:#d2d6de;border-color: #d2d6de;color:#444;">';
                        
                        echo $extraeDatos['mensaje']; echo '<br>';
                        
                echo '</div>';
            echo '</div>';
        }
    }

}


?>
