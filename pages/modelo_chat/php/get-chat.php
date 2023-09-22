<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                
                if($row['documento'] != NULL){ //$_SESSION['unique_id']
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p><a style="color:white;" href="documentos/uploads/'.utf8_encode($row['documento']).'" onClick="javascript:document["ver-form"].submit();" target="_blank">'.$row['nombreDocumento'].' <i class="fas fa-download"></i></a>
                                ';    
                
                $output.="<button style=\"background:transparent;color:white;border:0px;\" onclick=\"window.open('eliminar_documento?idEnviaObsoleto=\&idEnvia=".$row['msg_id']."','New Provider File','width=340,height=220');\">
             <i class='fas fa-trash-alt'></i>
           </button>";
                
                                    
                $output .='</p>
                                </div>
                                </div>';    
                }else{
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
                }
            } else {
                $sacarFotoUsuario = $conn->query("SELECT * FROM usuario WHERE cedula = '".$row['email']."' ");
                $datosDeFotoUsuario = $sacarFotoUsuario->fetch_array(MYSQLI_ASSOC);
                if($datosDeFotoUsuario['foto'] != NULL){
                    if($row['documento'] != NULL){
                        $output .= '<div class="chat incoming">
                                <img src="data:image/jpg;base64,' . base64_encode($datosDeFotoUsuario['foto']).'" alt="">
                                <div class="details">
                                    <p><a style="color:black;" href="documentos/uploads/'.utf8_encode($row['documento']).'" onClick="javascript:document["ver-form"].submit();" target="_blank">'.$row['nombreDocumento'].' <i class="fas fa-download"></i></a></p>
                                </div>
                                </div>';
                    }else{
                        $output .= '<div class="chat incoming">
                                <img src="data:image/jpg;base64,' . base64_encode($datosDeFotoUsuario['foto']).'" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
                    }
                    
                }else{
                    if($row['documento'] != NULL){
                        $output .= '<div class="chat incoming">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="">
                                <div class="details">
                                    <p><a style="color:black;" href="documentos/uploads/'.utf8_encode($row['documento']).'" onClick="javascript:document["ver-form"].submit();" target="_blank">'.$row['nombreDocumento'].' <i class="fas fa-download"></i></a></p>
                                </div>
                                </div>';
                    }else{
                    $output .= '<div class="chat incoming">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>'; 
                    }
                }
                
            }
        }
    } else {
        $output .= '<div class="text">No hay mensajes disponibles. Una vez que envíe el mensaje, aparecerán aquí.</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}
