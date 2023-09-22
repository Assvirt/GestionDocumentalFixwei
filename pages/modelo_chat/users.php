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
    <section class="users">
      <header>
        <div class="content">
          <?php 
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          //// consultamos el usuario principal y traemos la foto
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
        </div>
        <!--<a href="php/logout.php?logout_id=<?php //echo $row['unique_id']; ?>" class="logout">Cerrar Sesión</a>-->
      </header>
      <div class="search">
        <span class="text">Selecciona un usuario </span>
        <input type="text" placeholder="Buscar nombre...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">

      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>

</html>