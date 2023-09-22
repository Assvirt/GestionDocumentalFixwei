<!DOCTYPE html>
<html>
  
<head>
    <title>
        Download File Using 
        JavaScript/jQuery
    </title>
</head>
  
<body>
    <h1>
        Download File Using 
        JavaScript/jQuery
    </h1>
  
    <a id="link" href="#">
        Download this file
    </a>
</body>
  
</html>

<script>
    $(document).ready(function () {
      $("#link").click(function (e) {
          e.preventDefault();
          window.location.href = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJE7ccp7YzvCfMd3D0hb_l0ieaJzeVxFY3fg&usqp=CAU";
      });
});

// Note: url= your file path
</script>