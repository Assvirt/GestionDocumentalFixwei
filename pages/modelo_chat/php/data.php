<?php
while ($row = mysqli_fetch_assoc($query)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "No hay mensajes disponibles";
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
    if (isset($row2['outgoing_msg_id'])) {
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Tu: " : $you = "";
    } else {
        $you = "";
    }
    ($row['status'] == "Fuera de Línea") ? $offline = "offline" : $offline = "";
    ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";
    
    
    $sacarFotoUsuario = $conn->query("SELECT * FROM usuario WHERE cedula = '".$row['email']."' ");
    $datosDeFotoUsuario = $sacarFotoUsuario->fetch_array(MYSQLI_ASSOC);
    
    
    if($row2['lectura'] == 0){
        continue;
    }
    
    if($datosDeFotoUsuario['foto'] != NULL){
        
        /// condicional del color, disponible o ocupado del usuario
        if($row['status'] == 'Disponible'){
            $colorUsuarios='green';
        }else{
            $colorUsuarios='red';
        }
        /// end
        
        //// color negrilla de la lectura del mensaje
        if($row2['lectura'] == '1' && $outgoing_id == $row2['incoming_msg_id'] ){
            $colorNegrilla='<b>';
            $colorNegrillaC='</b>';
        }else{
            $colorNegrilla='';
            $colorNegrillaC='';
        }
        //// end
        
        $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="data:image/jpg;base64,' . base64_encode($datosDeFotoUsuario['foto']) . '" alt="">
                    <div class="details">
                        <span>' . utf8_encode($row['fname']) . " " . utf8_encode($row['lname']) . '</span>
                        '.$colorNegrilla.'<p>' . $you . $msg . '</p> '.$colorNegrillaC.'
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i style="color:'.$colorUsuarios.';" class="fas fa-circle"></i></div>
                </a>';
    }else{
        
        /// condicional del color, disponible o ocupado del usuario
        if($row['status'] == 'Disponible'){
            $colorUsuarios='green';
        }else{
            $colorUsuarios='red';
        }
        /// end
        
        //// color negrilla de la lectura del mensaje
        if($row2['lectura'] == '1' && $outgoing_id == $row2['incoming_msg_id'] ){
            $colorNegrilla='<b>';
            $colorNegrillaC='</b>';
            $mostrarMensajePrimero='1';
        }else{
            $colorNegrilla='';
            $colorNegrillaC='';
            $mostrarMensajePrimero='';
        }
        //// end
        
        $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="">
                    <div class="details">
                        <span>' . utf8_encode($row['fname']) . " " . utf8_encode($row['lname']) . '</span>
                        '.$colorNegrilla.'<p>' . $you . $msg . '</p> '.$colorNegrillaC.'
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i style="color:'.$colorUsuarios.';" class="fas fa-circle"></i></div>
                </a>';  
    }
    
}
