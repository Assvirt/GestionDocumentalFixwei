<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
  
}else{
    include 'conexion/bd.php';
    
    $sesion=$_SESSION["session_username"];
                    /*
                      $consultaUsuarioChat=$mysqli->query("SELECT * FROM chat_users WHERE password='$sesion' ");
                      $extrarerUsuarioChat=$consultaUsuarioChat->fetch_array(MYSQLI_ASSOC);
                      $verificarUsuarioChat=$extrarerUsuarioChat['userid'];
                      
                      $consultaUsuarioChat2=$mysqli->query("SELECT count(*) FROM chat WHERE reciever_userid='$verificarUsuarioChat' AND status='1' ");
                      $extrarerUsuarioChat2=$consultaUsuarioChat2->fetch_array(MYSQLI_ASSOC);
                      $notificacionChat=$extrarerUsuarioChat2['count(*)'];
                    */  
                      $consultaUsuarioChat=$mysqli->query("SELECT * FROM users WHERE email='$sesion' ");
                      $extrarerUsuarioChat=$consultaUsuarioChat->fetch_array(MYSQLI_ASSOC);
                      $verificarUsuarioChat=$extrarerUsuarioChat['unique_id'];
                      
                      $consultaUsuarioChat2=$mysqli->query("SELECT count(*) FROM messages WHERE incoming_msg_id='$verificarUsuarioChat' AND lectura='1' ");
                      $extrarerUsuarioChat2=$consultaUsuarioChat2->fetch_array(MYSQLI_ASSOC);
                      $notificacionChat=$extrarerUsuarioChat2['count(*)'];
                      if($notificacionChat > 0){
                          echo '<span class="right badge badge-danger">Nuevo!</span>';
                      }
             
}
?>
