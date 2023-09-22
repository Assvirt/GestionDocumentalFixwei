<?php
session_start();
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
?>

<?php include_once "header.php"; ?>
<script src="javascript/jquery.min.js"></script>
<body style="background:white;display:none;">
  <div class="wrapper">
    <section class="form login">
      <header></header>
        <script> 
                 window.onload=function(){
               
                     document.forms["chatEntrando"].submit();
                 }
                setTimeout(clickbuttonformario, 2000);
                function clickbuttonformario() { 
                         document.forms["chatEntrando"].submit();
                }
        </script>
      <form action="" method="POST" enctype="multipart/form-data" autocomplete="off" name="chatEntrando">
        <div class="error-text"></div>
        <div class="field input">
        
          <input type="" name="email" value="<?php echo $_SESSION["session_username"];?>" required>
        </div>
        <div class="field input">
          <input type="" name="password" value="<?php echo $_SESSION["session_username"];?>" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" id="captura_boton" value="Chatear">
        </div>
      </form>
      <!--<div class="link">Aún no te has registrado? <a href="index.php">Regístrate acá</a></div>-->
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script> 
  <script>
      //// agregamos un click automatico para después refrescar la página y entrar al chat
    $(document).ready(function() {
      // indicamos que se ejecuta la funcion en 1 segundo de haberse
      // cargado la pagina
      setTimeout(clickbutton, 1000);
                            
      function clickbutton() { 
          
          
                if (window.localStorage) { 
                    // recargamos la página una sola vez
                    if (!localStorage.getItem('reload')) {
                        localStorage['reload'] = true;
                        window.location.reload(); 
                    } else {
                        localStorage.removeItem('reload');
                    }
                }
          
          
        // simulamos el click del mouse en el boton del formulario
        $("#captura_boton").click();
        //después de capturar el botón, recargamos la vista
            // JavaScript function
            setTimeout(clickbuttonformario, 2000);
                function clickbuttonformario() { 
                         document.forms["chatEntrando"].submit();
                }
            (() => { 
                
                if (window.localStorage) { 
                    // recargamos la página una sola vez
                    if (!localStorage.getItem('reload')) {
                        localStorage['reload'] = true;
                        window.location.reload(); 
                    } else {
                        localStorage.removeItem('reload');
                    }
                }
            })(); // Calling anonymous function here only
        
      }
      $('#captura_boton').on('click',function() {
       // console.log('action');
      });
    });
  </script>
</body>

</html>