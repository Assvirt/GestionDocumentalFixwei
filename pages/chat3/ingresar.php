<?php
session_start();
if(!isset($_SESSION["session_username"])){
    //header("login");
    echo '<script language="javascript">
    window.location.href="../examples/login"</script>';
}else{
//require_once 'inactividad.php';

     $celdulaUser = $_SESSION['session_username']; 
                  
                        
        ?>
                                                    <script>
                                                            window.onload=function(){
                                                               
                                                               document.forms["miformularioIndex"].submit();
                                                                }
                                                    </script>
                                                    <form name="miformularioIndex" action="index" method="POST" onsubmit="procesar(this.action);" >
                                                       <input value="<?php echo $celdulaUser?>" name="iniciarSesion" type="hidden"> 
                                                    </form>
                                                    
        <?php                
                        
} 
?>