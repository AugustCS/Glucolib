<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Acceso a la consola Saweto</title>
  <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

<link href='http://fonts.googleapis.com/css?family=Raleway:300,200' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  <form action="/admin/production/index.php" method="POST" id="login">
    <center class="centrar-logo-login">
      <figure>
        <img src="/img/logo.jpg" alt="">  
      </figure>
    </center>
    <div class="form">
      <div class="forceColor"></div>
      <div class="topbar">
        <div class="spanColor"></div>
        <input type="text" class="input" name="login" id="usuario" placeholder="Usuario"/>
      </div>
      <div class="topbar">
        <div class="spanColor"></div>
        <input type="password" class="input" name="password" id="password" placeholder="Password"/>
      </div>
      <button class="submit" id="submit" >Ingresar</button>
    </div>
    
  </form>  

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
