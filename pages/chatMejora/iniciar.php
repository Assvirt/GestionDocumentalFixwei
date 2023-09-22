<?php
session_start();
if(!isset($_SESSION["session_username"])){
    //header("login");
    echo '<script language="javascript">confirm("Sesión Finalizada por Inactividad");
    window.location.href="../examples/login"</script>';
}else{
//require_once 'inactividad.php';

     $celdulaUser = $_SESSION['session_username']; 
                    

                        require_once'../conexion/bd.php';
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$celdulaUser'");
                        $row = $query->fetch_array(MYSQLI_ASSOC);
                        $nombreUsuarioValidado= $row['nombres'];
                        
                        
                        
                        
                          $usuario=$celdulaUser;
                         '<br>'.$pass=$celdulaUser;
                         '<br>'.$nombreUsuario=$nombreUsuarioValidado;
                            
                         
                        if($usuario != NULL){  
                            
                            $validarExistenciaUsuario=$mysqli->query("SELECT * FROM login WHERE cc='$usuario' ");
                            $confirmaUsuario=$validarExistenciaUsuario->fetch_array(MYSQLI_ASSOC);
                            $usuarioExiste=$confirmaUsuario['cc'];
                            $estadoExiste=$confirmaUsuario['estado'];
                            
                                    $validarUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula='$usuario' ");
                                    $confirmaUsuarioLogin=$validarUsuario->fetch_array(MYSQLI_ASSOC);
                                    $usuarioLogin=$confirmaUsuarioLogin['nombres'];
                            
                            if($usuario == $usuarioExiste){
                               
                              
                                if($estadoExiste == 'yes' ){ ////// usamos esta validación para iniciar nuevamente después de cerrar
                                
                                
                               ?>
                                                    <script>
                                                            window.onload=function(){
                                                                //alert("El identificador ya existe");
                                                               document.forms["miformularioIndex"].submit();
                                                                }
                                                    </script>
                                                    <form name="miformularioIndex" action="index" method="POST" onsubmit="procesar(this.action);" >
                                                       <!-- <input value="Confirma ingreso" type="submit"> -->
                                                    </form>
                                                    
                                <?php
                                }
                                
                                
                                
                                if($estadoExiste == 'no' ){
                                    
                                 ?>
                                                    <script>
                                                            window.onload=function(){
                                                                //alert("El identificador ya existe");
                                                               document.forms["miformularioLogin"].submit();
                                                                }
                                                    </script>
                                                    <form name="miformularioLogin" action="login.php" method="POST" onsubmit="procesar(this.action);" >
                                                       <input name="abrirUsuario" value="<?php echo $usuarioLogin; ?>" type="hidden" readonly>
                                                       <input name="abrirPass" value="<?php echo $usuarioExiste; ?>" type="hidden" readonly>
                                                       <!-- <input value="Confirma ingreso" type="submit"> -->
                                                    </form>
                                                    
                                <?php   
                                    
                                    
                                    
                                    
                                    
                                }
                                
                                
                                
                                
                                
                            }
                        }
                        
                        
                        
                        
}                     
                        ?>
                  
                 
                   
                   
                   
         