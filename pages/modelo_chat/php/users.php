<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    //$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    //echo 'conteo: '.$query = mysqli_query($conn, $sql);
    $query=$conn->query("SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC");
    'conteo: '.mysqli_num_rows($query);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No hay usuarios disponibles para chatear";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
        
    }
    
    echo $output;
    
    $query=$conn->query("SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC");
    'conteo: '.mysqli_num_rows($query);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No hay usuarios disponibles para chatear";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "dataB.php";
    }
    
    echo $output;
?>