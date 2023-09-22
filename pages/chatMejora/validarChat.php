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
                            echo $usuarioExiste=$confirmaUsuario['cc'];
                            
                                    $validarUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula='$usuario' ");
                                    $confirmaUsuarioLogin=$validarUsuario->fetch_array(MYSQLI_ASSOC);
                                    $usuarioLogin=$confirmaUsuarioLogin['nombres'];
                            
                            if($usuario == $usuarioExiste){
                               
                              ?>
                                                    <script>
                                                            window.onload=function(){
                                                                //alert("El identificador ya existe");
                                                               document.forms["miformulario"].submit();
                                                                }
                                                    </script>
                                                    <form name="miformulario" action="index" method="POST" onsubmit="procesar(this.action);" >
                                                       <input name="abrirUsuario" value="<?php echo $nombreUsuario; ?>" type="hidden" readonly>
                                                       <input name="abrirPass" value="<?php echo $pass; ?>" type="hidden" readonly>
                                                    </form>
                                                    
                                                <?php
                                
                            
                            
                            }else{
                                
                                
                               ?>
                                                    <script>
                                                            window.onload=function(){
                                                                //alert("El identificador ya existe");
                                                               document.forms["miformulario"].submit();
                                                                }
                                                    </script>
                                                    <form name="miformulario" action="register" method="POST" onsubmit="procesar(this.action);" >
                                                       <input name="guardarUsuario" value="<?php echo $nombreUsuario; ?>" type="hidden" readonly>
                                                       <input name="guardarcc" value="<?php echo $usuario; ?>" type="hidden" readonly>
                                                       <input name="guardarPass" value="<?php echo $pass; ?>" type="hidden" readonly>
                                                    </form>
                                                    
                                                <?php
                           }
                        }
                        
                        
                        
                        
}                     
                        ?>
                  
                 
                   
                   
                   
         