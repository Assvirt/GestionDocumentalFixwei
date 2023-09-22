<?php 
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'../cierreSesion.php';
}else{

        session_start();
        include('header.php');
        $loginError = '';
        if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
        	include ('Chat.php');
        	$chat = new Chat();
        	$user = $chat->loginUsers($_POST['username'], $_POST['pwd']);	
        	if(!empty($user)) {
        		$_SESSION['username'] = $user[0]['username'];
        		$_SESSION['userid'] = $user[0]['userid'];
        		$chat->updateUserOnline($user[0]['userid'], 1);
        		$lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
        		$_SESSION['login_details_id'] = $lastInsertId;
        		//header("Location:index.php");
        		echo '<script language="javascript">
                window.location.href="index"</script>';
        	} else {
        		$loginError = "Usuario y Contraseña invalida";
        	}
        }
        
        require_once'../conexion/bd.php';
        $consultandoDatos=$mysqli->query("SELECT * FROM usuario WHERE cedula='".$_SESSION["session_username"]."' ");
        $datos=$consultandoDatos->fetch_array(MYSQLI_ASSOC);
        
        ?>
        
        <?php //include('container.php');?>
        
        			<script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                             //alert("Compromiso actualizado.");
                         }
                    </script>
        			<form method="post" name="miformulario">
        				
        				<?php/* if ($loginError ) { ?>
        					<div class="alert alert-warning"><?php echo $loginError; ?></div>
        				<?php }*/ ?>
        				
        				
        					<input type="hidden" class="form-control" value="<?php echo $datos['nombres']; ?>" name="username" required>
        				
        					<input type="hidden" class="form-control" value="<?php echo $datos['cedula']; ?>" name="pwd" required>
        				
        				<button type="submit" style="display:none;" name="login" >Cargando...</button>
        			</form>
        			<center>
                    <style>
                        .preloader {
                              width: 70px;
                              height: 70px;
                              border: 10px solid #eee;
                              border-top: 10px solid #666;
                              border-radius: 50%;
                              animation-name: girar;
                              animation-duration: 2s;
                              animation-iteration-count: infinite;
                              animation-timing-function: linear;
                            }
                            @keyframes girar {
                              from {
                                transform: rotate(0deg);
                              }
                              to {
                                transform: rotate(360deg);
                              }
                            }
                    </style> 
                    <div class="preloader"></div> Cargando
                </center>
<?php } //include('footer.php');?>






