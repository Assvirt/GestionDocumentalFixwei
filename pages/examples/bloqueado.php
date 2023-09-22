<?php
session_start();
if(!isset($_SESSION["session_username"])){
    header("login.php");
}else{
    
    
    $usuario = $_SESSION["session_username"];
?>


<html>
					
<!--Aca se encuentra toda la informacion -------------------------------------------------------------------- ---->


<!DOCTYPE html>
<html>






     
 
	
 

<!---- search field ------->



		<!----- close button ----->


    
            
        <head>
    <meta charset="utf-8">
    <title>Cambiar contrase&ntilde;a</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <style>
    body {
  background: #0B2161;
  font-family: 'Lato', sans-serif;
  color: #FDFCFB;
  text-align: center;
}


form {
  width: 450px;
  margin: 17% auto;
}


.header {
  font-size: 35px;
  text-transform: uppercase;
  letter-spacing: 5px;
}


.description {
  font-size: 14px;
  letter-spacing: 1px;
  line-height: 1.3em;
  margin: -2px 0 45px;
}


.input {
  display: flex;
  align-items: center;
}


.button {
   
  height: 44px;
  border: none;
}

  
#newpass {
  width: 20%;
  background: #FDFCFB;
  font-family: inherit;
  color: #737373;
  letter-spacing: 1px;
  text-indent: 5%;
  border-radius: 5px 0 0 5px;
}


#submit {
  width: 25%;
  height: 46px;
  background: #E86C8D;
  font-family: inherit;
  font-weight: bold;
  color: inherit;
  letter-spacing: 1px;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  transition: background .3s ease-in-out;
}
  

#submit:hover {
  background: #d45d7d;
}
  

input:focus {
  outline: none;
  outline: 2px solid #E86C8D;
  box-shadow: 0 0 2px #E86C8D;
}
    </style>
  </head>
 






<!--Aca se encuentra toda la informacion  -------------------------------------------------------------------- ---->
  

<!-- -->



 <body>
    <form action="../controlador/perfil/desbloqueado" method="post" >
      <div class="header">
         <p>Ingrese Nueva Contrase&ntilde;a</p>
      </div>
      <div class="description">
        <p></p>
      </div>
      <div class="input">
      <input type="number" style="visibility:hidden "name="cedula" value="<?php echo $usuario;?>"class="input-field"required><br>

        <input type="password" class="button"required id="newpass" name="newpass" placeholder="PASSWORD">
        <input type="submit" class="button" id="enviar" name="enviar" value="ENVIAR">
      </div>
    </form>
  </body>
 </div>
    </div>
  </div>

    </div>
    </main>
   

</html>



<?php
}
?>