<?php
	session_start();
	include_once "defines.php";
	require_once('classes/BD.class.php');
	BD::conn();

	if(!isset($_SESSION['email_logado'], $_SESSION['id_user'])){
		header("Location: index.php");
	}

	$pegaUser = BD::conn()->prepare("SELECT * FROM `usuarios` WHERE `email` = ?");
	$pegaUser->execute(array($_SESSION['email_logado']));
	$dadosUser = $pegaUser->fetch();

	if(isset($_GET['acao']) && $_GET['acao'] == 'sair'){
		unset($_SESSION['email_logado']);
		unset($_SESSION['id_user']);
		session_destroy();
		header("Location: index.php");
	}
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
	  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  
  
  
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/responsive.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery_play.js"></script>
		<script type="text/javascript">
			$.noConflict();
		</script>
		
	</head>

	<body>
		<span class="user_online" id="<?php echo $dadosUser['id'];?>"></span>
		<h2><!--Bienvenido--> <?php
                    		$pegaUserNombres = BD::conn()->prepare("SELECT * FROM `usuario` WHERE `cedula` = ?");
                    	    $pegaUserNombres->execute(array($_SESSION['email_logado']));
                    	    $dadosUserNombres = $pegaUserNombres->fetch();
		                    $dadosUserNombres['nombres'];
		               ?>
		</h2>
		<a href="?acao=sair"></a> <!-- Salir -->
		<aside id="users_online">
			<ul>
			<?php
			//SELECT * FROM `usuarios` WHERE `id` != ?
				$pegaUsuarios = BD::conn()->prepare("SELECT * FROM `usuarios` WHERE `id` != ?");
				$pegaUsuarios->execute(array($_SESSION['id_user']));
				while($row = $pegaUsuarios->fetch()){
				    
				            $documento = $row['email'];
				            $pegaUserNombres = BD::conn()->prepare("SELECT * FROM `usuario` WHERE `cedula` = '$documento'");
                    	    $pegaUserNombres->execute(array());
                    	    $dadosUserNombres = $pegaUserNombres->fetch();
		                    $dadosUserNombres['foto'];
		                    
					$foto = ($row['foto'] == '') ? 'default.jpg' : $row['foto'];
					$blocks = explode(',', $row['blocks']);
					$agora = date('Y-m-d H:i:s');
					if(!in_array($_SESSION['id_user'], $blocks)){
						$status = 'on';
						if($agora >= $row['limite']){
							$status = 'off';
						}
			?>
				<li id="<?php echo $row['id'];?>">
				    <div class="imgSmall">
				        <img src="fotos/<?php echo $foto;?>" border="0" />
				    </div>
					<a href="#" id="<?php echo $_SESSION['id_user'].':'.$row['id'];?>" class="comecar"><?php echo utf8_encode($row['nome']);?></a>
					<span id="<?php echo $row['id'];?>" class="status <?php echo $status;?>"></span>
				</li>
			<?php 
					}
			}
			?>
			</ul>
		</aside>
				
		<!--Agregado x Abisai Ramos
				botton para mostrar un modal de las chats minimizados, que no entran en la pantalla
	    -->

		<aside id="chats">
		</aside>
		<script type="text/javascript" src="js/functions.js"></script>
	</body>
</html>
 <!--          
<div class="card window" id="janela_x">
    <div class="header_window card-header">
        <h3 class="card-title">
         <span class="name"> Fulano de tal</span>
        </h3>
        <button type="button" class="btn btn-tool" ><i class="fas fa-minus"></i></button>
        <button type="button"  href="#" class="close" class="btn btn-tool" ><i class="fas fa-times"></i></button>
        <span id="5" style="float:left;" class="status on"></span>
    </div>
	<div class="body">
		<div class="mensagens">
			<ul>
				
			</ul>
		</div>
		<div class="send_message card-footer" id="3:5">
			<input placeholder="Escribir mensaje..." type="text" name="mensagem" class="msg form-control" id="3:5" />
			
		</div>
		
	</div>
</div> -->