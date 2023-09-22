<?php
error_reporting(E_ERROR);
/*
include('database_connection.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
	//header('location:index.php');
	// echo '<script language="javascript">
      //  window.location.href="index"</script>';
}

if(isset($_POST['login']))
{
	$query = "
		SELECT * FROM login 
  		WHERE username = :username
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':username' => $_POST["username"]
		)
	);	
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if(password_verify($_POST["password"], $row["password"]))
			{
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				
				
				$query = "
				UPDATE login
				SET estado = 'yes' 
				WHERE user_id = '".$row['user_id']."'
				";

				$statement = $connect->prepare($query);

				$statement->execute();
				 
				$sub_query = "
				INSERT INTO login_details 
	     		(user_id,is_type) 
	     		VALUES ('".$row['user_id']."','yes')
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				$_SESSION['login_details_id'] = $connect->lastInsertId();
				//header('location:index.php');
				echo '<script language="javascript">
               window.location.href="index"</script>';
			}
			else
			{
				$message = '<label>Contraseè´–a incorrecta</label>';
			}
		}
	}
	else
	{
		$message = '<label>Usuario incorrecto</labe>';
	}
}

*/
?>

<html>  
    <head>  
        <title></title>  
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
      <!--  <div class="container">
			<br />
			
			<h3 align="center">Chat </h3><br />
			<br />
			<div class="panel panel-default">
  				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<p class="text-danger"><?php // echo $message; ?></p> -->
					       <script>
                                    window.onload=function(){
                                        //alert("El identificador ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
					<form method="post" action="login_chat" name="miformulario"> 
					
							<input type="text"  style="visibility:hidden;" name="username" value="<?php echo $_POST['abrirUsuario']; ?>" class="form-control" required />
					
							<input type="password"  style="visibility:hidden;" name="password" value="<?php echo $_POST['abrirPass']; ?>" class="form-control" required />
					        <input name="entra" type="hidden" value="entra">
						<!--	<input type="submit"  class="btn btn-info" value="Ingresando..." />  -->
					</form>
						<!--
						<div class="form-group">
							<label>Contrase√±a</label>
							<input type="password" name="password" value="<?php //echo $_POST['abrirPass']; ?>" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" class="btn btn-info" value="Ingresar" />
						</div>
						<div align="center">
							<a href="register.php">Registro</a>
						</div> -->
				
					<!--
					<br />
					<br />
					<br />
					<br />
				</div>
			</div>
		</div> -->

    </body>  
</html>