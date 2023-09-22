<?php error_reporting(E_ERROR);


if(isset($_POST['addPermisosConfig'])){

    //modulo usuarios
    $idGrupo = $_POST['id'];
    
    if($idGrupo == '1'){
        require_once '../conexion/bd.php';
    }elseif($idGrupo == '2'){
        require_once '../../../RMS/pages/conexion/bd.php';    
    }
    
    '<br>permiso 1: '.$permiso1=$_POST['permiso1'];
    '<br>permiso 2: '.$permiso2=$_POST['permiso2'];
    '<br>permiso 3: '.$permiso3=$_POST['permiso3'];
    '<br>permiso 4: '.$permiso4=$_POST['permiso4'];
    '<br>permiso 5: '.$permiso5=$_POST['permiso5'];
    '<br>permiso 6: '.$permiso6=$_POST['permiso6'];
    if($permiso1 == '1'){
        $permiso1='1';
    }else{
        $permiso1='0';
    }
    if($permiso2 == '1'){
        $permiso2='1';
    }else{
        $permiso2='0';
    }
    if($permiso3 == '1'){
        $permiso3='1';
    }else{
        $permiso3='0';
    }
    if($permiso4 == '1'){
        $permiso4='1';
    }else{
        $permiso4='0';
    }
    if($permiso5 == '1'){
        $permiso5='1';
    }else{
        $permiso5='0';
    }
    if($permiso6 == '1'){
        $permiso6='1';
    }else{
        $permiso6='0';
    }
    
    $mysqli->query("UPDATE permisosCliente SET permiso1='$permiso1', permiso2='$permiso2', permiso3='$permiso3', permiso4='$permiso4', permiso5='$permiso5', permiso6='$permiso6' WHERE id='$idGrupo' ");
    
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para configuración
    if($permiso1 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de configuración
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='config'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            if($extraerSubconsultaPermisos['formulario'] == 'comunicaciones'){
            }else{
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            }
        }
    }
    if($permiso1 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de configuración
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='config'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para GD
    if($permiso2 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de GD
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='gestionDoc'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            
        }
    }
    if($permiso2 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de GD
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='gestionDoc'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para repositorio
    if($permiso3 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de Repositorio
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='Repositorio'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            
        }
    }
    if($permiso3 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de Repositorio
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='Repositorio'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para Indicadores
    if($permiso4 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de Indicadores
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='indi'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            
        }
    }
    if($permiso4 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de Indicadores
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='indi'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para actas
    if($permiso5 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de actas
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='actas'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            
        }
    }
    if($permiso5 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de actas
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='actas'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    //// evaluamos que si apagamos el permiso, apagamos los de todos de esta empresa para compras
    if($permiso6 == 0){
        //// consultamos la tabla de permisos para traer todos los permisos activos de compras
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='compras'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            
                $update=$mysqli->query("UPDATE permisos SET listar='0', crear='0', editar='0', eliminar='0' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
            
        }
    }
    if($permiso6 == 1){
        //// consultamos la tabla de permisos para traer todos los permisos activos de compras
        $consultarTablaFormulario=$mysqli->query("SELECT * FROM `formularios` WHERE modulo='compras'");
        while($extraerConsultaTablaFormulario=$consultarTablaFormulario->fetch_array()){
            $subconsultaPermisos=$mysqli->query("SELECT * FROM permisos WHERE formulario='".$extraerConsultaTablaFormulario['idFormulario']."' ");
            $extraerSubconsultaPermisos=$subconsultaPermisos->fetch_array(MYSQLI_ASSOC);
            $update=$mysqli->query("UPDATE permisos SET listar='1' WHERE id='".$extraerSubconsultaPermisos['id']."' ");
        }
    }
    
    
    
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../limistarPermisosVer" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="id" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
        
}

?>