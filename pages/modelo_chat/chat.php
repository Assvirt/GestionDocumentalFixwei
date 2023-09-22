<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body style="background:white;">
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: users.php");
        } 
        $update=mysqli_query($conn, "UPDATE messages SET lectura='0' WHERE outgoing_msg_id =  {$user_id} ");
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <?php
        $sacarFotoUsuario = $conn->query("SELECT * FROM usuario WHERE cedula = '".$row['email']."' ");
        $datosDeFotoUsuario = $sacarFotoUsuario->fetch_array(MYSQLI_ASSOC);
        if($datosDeFotoUsuario['foto'] != NULL){
        ?>
        <img src="data:image/jpg;base64,<?php echo base64_encode($datosDeFotoUsuario['foto']); ?>" alt="">
        <?php    
        }else{
        ?>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="">
        <?php
        }
        ?>
        <div class="details">
          <span><?php echo utf8_encode($row['fname']) . " " . utf8_encode($row['lname']) ?></span>
           <p><?php if($row['status'] == 'Offline now'){ echo 'No disponible'; }else{ echo $row['status']; } ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php 
	  echo "<button style=\"background:transparent;border:0px;\" onclick=\"window.open('chatDocumentos?idEnviaObsoleto=\&idEnvia=".$_SESSION['unique_id']."&idRecibe=".$user_id."','New Provider File','width=940,height=820');\">
            Adjuntar <i style='color:red;' class='fas fa-paperclip'></i>
           </button>";
	  ?>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Escribe tu mensaje aquí..." autocomplete="off" >
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>

</html>