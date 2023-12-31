<?php 
session_start();
include('header.php');
?>
<title>Chat</title>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<link href="css/style.css" rel="stylesheet" id="bootstrap-css">
<script src="js/chat.js"></script>
<style>
.modal-dialog {
    width: 400px;
    margin: 30px auto;	
}
</style>
<?php //include('container.php');?>
<div class="container">		
	<!--<h1>Sistema de chat en vivo con Ajax, PHP y MySQL</h1>		
	<br>-->		
	<?php if(isset($_SESSION['userid']) && $_SESSION['userid']) { ?> 	
		<div class="">	<!-- chat -->
			<div id="frame">		
				<div id="sidepanel">
					<div id="profile">
					<?php
					include ('Chat.php');
					$chat = new Chat();
					$loggedUser = $chat->getUserDetails($_SESSION['userid']);
					echo '<div class="wrap">';
					$currentSession = '';
					foreach ($loggedUser as $user) {
						$currentSession = $user['current_session'];
						
						///// tratamos de traer la foto del perfil
						$consultaPerfil=$user['password'];
						require_once'../conexion/bd.php';
						$acentos2 = $mysqli->query("SET NAMES 'utf8'");
						$consultandoDAtos=$mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaPerfil' ");
						$extraerDAtos=$consultandoDAtos->fetch_Array(MYSQLI_ASSOC);
						$nombreCompleto=$extraerDAtos['nombres'].' '.$extraerDAtos['apellidos'];
						$enviarFotoPerfil=$extraerDAtos['foto'];
						$UserEnviar=$extraerDAtos['id'];
						/// end
					
						///echo '<img id="profile-img" src="userpics/'.$user['avatar'].'" class="online" alt="" />';
						if($enviarFotoPerfil != NULL){
						    	echo '<img id="profile-img" src="data:image/jpg;base64, '.base64_encode($enviarFotoPerfil).'" class="online" alt="" />';
						}else{ 
						    	echo '<img id="profile-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" class="online" alt="" />';
						}
					
						echo  '<p>'.$nombreCompleto.'</p>'; // 	echo  '<p>'.$user['username'].'</p>';
							echo '<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>';
							//echo '<div id="status-options">';
							//echo '<ul>';
							///	echo '<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>';
							///	echo '<li id="status-away"><span class="status-circle"></span> <p>Ausente</p></li>';
							///	echo '<li id="status-busy"><span class="status-circle"></span> <p>Ocupado</p></li>';
							///	echo '<li id="status-offline"><span class="status-circle"></span> <p>Desconectado</p></li>';
							//echo '</ul>';
							//echo '</div>';
							echo '<div id="expanded">';			
							echo '<a href="logout.php">Salir</a>';
							echo '</div>';
					}
					echo '</div>';
					?>
					</div>
					<!--
					<div id="search">
						<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
						<input type="text" placeholder="Buscar Contactos..." />					
					</div>
					-->
					<div id="contacts">	
					<?php
					echo '<ul>';
					$chatUsers = $chat->chatUsers($_SESSION['userid']);
					foreach ($chatUsers as $user) {
						$status = 'offline';						
						if($user['online']) {
							$status = 'online';
						}
						$activeUser = '';
						if($user['userid'] == $currentSession) {
							$activeUser = "active";
						}
						echo '<li id="'.$user['userid'].'" class="contact '.$activeUser.'" data-touserid="'.$user['userid'].'" data-tousername="'.$user['username'].'">';
						echo '<div class="wrap">';
						echo '<span id="status_'.$user['userid'].'" class="contact-status '.$status.'"></span>';
						
						///// tratamos de traer la foto del perfil
						$consultaPerfil=$user['password'];
						require_once'../conexion/bd.php';
						$acentos2 = $mysqli->query("SET NAMES 'utf8'");
						$consultandoDAtos=$mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaPerfil' ");
						$extraerDAtos=$consultandoDAtos->fetch_Array(MYSQLI_ASSOC);
						$nombreCompleto=$extraerDAtos['nombres'].' '.$extraerDAtos['apellidos'];
						$enviarFotoPerfil=$extraerDAtos['foto'];
						/// end
						if($enviarFotoPerfil != NULL){
						    	echo '<img id="profile-img" src="data:image/jpg;base64, '.base64_encode($enviarFotoPerfil).'" alt="" />';
						}else{ 
						    	echo '<img id="profile-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="" />';
						}
						//echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
						
						echo '<div class="meta">';
						//echo '<p class="name">'.$user['username'].'<span id="unread_'.$user['userid'].'" class="unread">'.$chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']).'</span></p>';
						echo '<p class="name">'.$nombreCompleto.'<span id="unread_'.$user['userid'].'" class="unread">'.$chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']).'</span></p>';
						echo '<p class="preview"><span id="isTyping_'.$user['userid'].'" class="isTyping"></span></p>';
						echo '</div>';
						echo '</div>';
						echo '</li>'; 
					}
					echo '</ul>';
					?>
					</div>
					<!--
					<div id="bottom-bar">	
						<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Agregar Contactos</span></button>
						<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Configuracion</span></button>					
					</div>-->
				</div>			
				<div class="content" id="content"> 
					<div class="contact-profile" id="userSection">	
    					<?php
    					$userDetails = $chat->getUserDetails($currentSession);
    					foreach ($userDetails as $user) {										
    						
    						
    						
    						///// tratamos de traer la foto del perfil
    						$consultaPerfil=$user['password'];
    						require_once'../conexion/bd.php';
    						$acentos2 = $mysqli->query("SET NAMES 'utf8'");
    						$consultandoDAtos=$mysqli->query("SELECT * FROM usuario WHERE cedula='$consultaPerfil' ");
    						$extraerDAtos=$consultandoDAtos->fetch_Array(MYSQLI_ASSOC);
    						$nombreCompleto=$extraerDAtos['nombres'];
    						//$enviarFotoPerfil=$extraerDAtos['foto'];
    						/// end
    						/*
    						if($enviarFotoPerfil != NULL){
						    	echo '<img src="data:image/jpg;base64, '.base64_encode($enviarFotoPerfil).'" alt="" />';
						    }else{ 
						    	echo '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="" />';
						    }
    						*/
						    
    						//echo '<img src="userpics/'.$user['avatar'].'" alt="" />';
    						//echo '<p>'.$user['username'].'</p>';
    						echo '&nbsp;&nbsp;<label>'.$nombreCompleto.'</label>';
    						
    							//echo '<div class="social-media">';
    							//echo '<i class="fa fa-facebook" aria-hidden="true"></i>';
    							//echo '<i class="fa fa-twitter" aria-hidden="true"></i>';
    							//echo '<i class="fa fa-instagram" aria-hidden="true"></i>';
    							//echo '</div>';
    					}	
    					?>						
					</div>
					<div class="messages" id="conversation">		
    					<?php
    					echo $chat->getUserChat($_SESSION['userid'], $currentSession);						
    					?>
					</div>
					<div class="message-input" id="replySection">				
						<div class="message-input" id="replyContainer">
						    <?php 
								'id enviar: '.$UserEnviar;
								'<br> id recibe: '.$currentSession;
							    echo "<button class=\"btn btn-success btn-raised btn-sm\" style=\"color:white;\" onclick=\"window.open('chatDocumentos?idEnvia=\ ".$UserEnviar."&idRecibe=".$currentSession."','New Provider File','width=940,height=820');\">
                                        Adjuntar
                                      </button>";
								?>
							<div class="wrap">
								<!--<input type="file" class="archivo" id="archivo<?php //echo $currentSession; ?>"  />-->
								<input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." />
								<button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>	
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<!--<strong><a href="login.php"><h3>Acceder al Chat</h3></a></strong>-->		
	<?php } ?>
	<!--
	<br>
	<br>	
	<div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.baulphp.com/sistema-de-chat-en-vivo-con-ajax-php-y-mysql">Volver al Tutorial</a>		
	</div>	-->
</div>	
<?php //include('footer.php');?>