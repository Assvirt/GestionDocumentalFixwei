<?php
error_reporting(E_ERROR);
include('database_connection.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
	//header('location:index.php');
	// echo '<script language="javascript">
      //  window.location.href="index"</script>';
}
$loginIngreso=$_POST['entra'];
if($loginIngreso =='entra') 
{  
    // isset($_POST['login'])
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
				$message = '<label>Contraseña incorrecta</label>';
			}
		}
	}
	else
	{
		$message = '<label>Usuario incorrecto</labe>';
	}
}


?>