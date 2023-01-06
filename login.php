<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tienda virtual</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./assets/style/normalize.min.css">
  <link rel='stylesheet' href='./assets/style/bootstrap.min.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,700,300'>
  <link rel='stylesheet' href='./assets/style/font-awesome.min.css'>
  <link rel="stylesheet" href="./assets/style/styleLogin.css">

</head>

<body onload="comprobarSesion()">
  <div class="signup__container">
    <div class="container__child signup__thumbnail">
      <div class="thumbnail__content text-center">
        <h1 class="heading--primary">Bienvenido a la tienda virtual</h1>
        <h2 class="heading--secondary">Reparación de móviles</h2>
      </div>
      <div class="signup__overlay"></div>
    </div>
    <div class="container__child signup__form">
      <form method="POST" id="formLogin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
          <label for="username">Nombre</label>
          <input class="form-control" type="text" name="username" id="username" placeholder="Ponga su nombre" />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" name="password" id="password" placeholder="********" />
        </div>
        <div class="m-t-lg">
          <input class="btn btn--form" id="submitBtn" type="button" value="Iniciar sesión" onclick="login()" />
        </div>
      </form>
    </div>
  </div>

  <script src="assets/js/sweetalert2.all.min.js"></script>
  <script src="assets/js/login.js"></script>
</body>

</html>