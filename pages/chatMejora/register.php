<?php
error_reporting(E_ERROR);
include('database_connection.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
	//header('location:index.php');
}

if(isset($_POST["register"]))
{
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	$cc = trim($_POST["cc"]);
	$check_query = "
	SELECT * FROM login 
	WHERE cc = :cc
	";
	$statement = $connect->prepare($check_query);
	$check_data = array(
		':cc'		=>	$cc //':username'		=>	$username
	);
	if($statement->execute($check_data))	
	{
		if($statement->rowCount() > 0)
		{
			$message .= '<p><label>Nombre de usuario ya tomado</label></p>';
		}
		else
		{
			if(empty($username))
			{
				$message .= '<p><label>Nombre requerido</label></p>';
			}
			if(empty($password))
			{
				$message .= '<p><label>Contraseña requerido</label></p>';
			}
			else
			{
				if($password != $_POST['confirm_password'])
				{
					$message .= '<p><label>La contraseña no coincide</label></p>';
				}
			}
			if($message == '')
			{
				$data = array(
					':username'		=>	$username,
					':password'		=>	password_hash($password, PASSWORD_DEFAULT),
					':cc'		=>	$cc,
					':estado'		=>	'no'
				);

				$query = "
				INSERT INTO login 
				(username, password, cc, estado) 
				VALUES (:username, :password, :cc, :estado)
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data))
				{
					$message = "<label>Registro Completado</label>";
					?>
					        <script>
                                    window.onload=function(){
                                        //alert("El identificador ya existe");
                                        document.forms["miformularioLogin"].submit();
                                        }
                            </script>
                            <form name="miformularioLogin" action="login" method="POST" onsubmit="procesar(this.action);" >
                               <input name="abrirUsuario" value="<?php echo $username; ?>" type="hidden" readonly>
                               <input name="abrirPass" value="<?php echo $password; ?>" type="hidden" readonly>
                            </form>
					<?
				}
			}
		}
	}
}

?>

<html>  
    <head>  
        <title>   </title>  
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
    <!-- 
        <div class="container">
			<br />
			
			<h3 align="center">Chat</a></h3><br />
			<br />
			
			<div class="panel panel-default">
  				<div class="panel-heading">Registro</div>
				<div class="panel-body"> -->
				                
					<form method="post">
						<!--
						<span class="text-danger"><?php //echo $message; ?></span>
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" name="username"  class="form-control" />
							<input type="text" name="cc"  class="form-control" />
						</div>
						-->
						
						
						
							<input type="text" readonly style="visibility:hidden;" name="username" value="<?php echo $_POST['guardarUsuario']; ?>" class="form-control" />
							<input type="text" readonly style="visibility:hidden;" name="cc" value="<?php echo $_POST['guardarcc']; ?>" class="form-control" />
						
							<input type="password" readonly style="visibility:hidden;" name="password" value="<?php echo $_POST['guardarPass']; ?>" class="form-control" />
						
						
							<input type="password" readonly style="visibility:hidden;" name="confirm_password" value="<?php echo $_POST['guardarPass']; ?>" class="form-control" />
					
						    <center>
							    <input type="submit" name="register" class="btn btn-info" value="Habilitar Chat" />
							</center>
					
						<!--
						<div align="center">
							<a href="login.php">Ingreso</a>
						</div> -->
					</form>
			<!--	</div>
			</div>
		</div>  -->
    </body>  
</html>
