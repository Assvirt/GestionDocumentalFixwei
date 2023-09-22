<?php
require_once("../controlador/sesion/connection.php");

//iniciamos la sesion para la variable que vamos a manejar
// en el siguiente formulario 
session_start();


//traemos los datos del formulario con el boton enviar

if(isset($_POST["enviar"])){
//valida que el campo no este vacio
    if(!empty($_POST['cedula'])) {
  //trae la variable correo del formulario anterior
  // se la asigna a la variable email     
    
    $cedula = $_POST['cedula'].''.$_POST['tipo'];
        
        //hago la consulta

        $consulta="SELECT * FROM usuario WHERE cedula='$cedula'";
        $query = mysqli_query($con, $consulta);
    //traigo el numeor de filas
        $numrows=mysqli_num_rows($query);
        //si es diferente de 0
        if($numrows!=0)
    
        {
        while($row=mysqli_fetch_assoc($query))
        {
           //asignamos lo que devuelve la fila de la bd a la variable dbemail

        $dbemail=$row['correo'];
           //validamos el correo con la CC
           $cc=$row['cedula'];

        $correo = $dbemail;
            //creamos la variable de session correo para usarla en otro formulario
        $_SESSION['correo']=$correo;

        //comparamos si el correo ingresado es != del que esta en la base de datos
        }if($cedula != $cc  ){
            

        
            //si es igual redirige al otro formulario 
        }else{
        ?>
            
           <?php
//funcion que me permite generar un codigo aleatorio entre los numeros del 0-9 y las letras de la A-Z
/*
//la funcion la llamamos generar codigo y le damos un nombre a la variable que nos va a dar el ancho de la clave
function generarCodigo($longitud) {
//key es la variable que vamos a usar para llenar con la cadena de caracteres
//la inicializamos en 0
    $key = '';
//tupla es la lista con los caracteres a usar    
    $tupla = '1234567890abcdefghijklmnopqrstuvwxyz';
 //max es el rango   
    $max = strlen($tupla)-1;
 //usamos un contador   
    for($i=0;$i < $longitud;$i++) $key .= $tupla{mt_rand(0,$max)};
 //retornamos la clave   
    return $key;
    echo generarCodigo(8);
}    */
//imprimimos la clave, los primeros 6 digitos
//ese numero se puede cambiar
//echo generarCodigo(8);
?>


<!DOCTYPE html>
<html>
<head><meta charset="euc-jp">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fixwei</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">

		
<div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">¿Enviar contrase&ntilde;a al correo?</p>

      <form action="login_recuperando" method="post">
        <center>
            <button type="submit" name="reenviar" class="btn btn-primary btn-block">Enviar</button>
         </center>
        <input style=""  type="hidden" name="cc" value="<?php echo $cc;?>" required>
        <?php
        /// código anterior echo generarCodigo(8);
        $tupla = '1234567890abcdefghijklmnopqrstuvwxyz';
        $enviarVariableCaracteres=substr(str_shuffle($tupla), 0, 10);
        ?>
        <input type="hidden"  name="newpass"  value="<?php echo $enviarVariableCaracteres; ?>" required>
      </form> <!-- formtarget='_blank' -->
      

    </div>
    <!-- /.login-card-body -->
  </div>
</div>		
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>		



      <?php  }

//si no, redirige al login y saca mensaje error
}else{
     echo '<script language="javascript">alert("Correo no encontrado verifique de nuevo");
        window.location.href="login"</script>';
    //header("Location: login.php");
   
}
    }
}




?>