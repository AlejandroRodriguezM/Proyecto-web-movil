<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tienda virtual</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/style/normalize.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
  <link rel='stylesheet' href='./assets/style/font-awesome.min.css'>
  <link rel="stylesheet" href="./assets/style/styleLogin.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>

<body onload="comprobarSesion()">
  <div class="signup__container">
    <div class="container__child signup__thumbnail">
      <div class="thumbnail__content text-center">
        <h1 id="saludo" class="heading--primary">Bienvenido a la tienda virtual</h1>
        <h2 id="lema" class="heading--secondary">Reparación de móviles</h2>
      </div>
      <div class="signup__overlay"></div>
    </div>
    <div class="container__child signup__form">
      <form method="POST" id="formLogin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
          <label id="username_label" for="username">Nombre</label>
          <input class="form-control" type="text" name="username" id="username" placeholder="Ponga su nombre" />
        </div>
        <div class="form-group">
          <div class="mb-3">
            <label id="password_label" for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="password" placeholder="********" placeholder="***********" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" />
              <div class="input-group-append">
                <span class="input-group-text" onclick="password_show_hide();">
                  <i class="fas fa-eye" id="show_eye"></i>
                  <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="m-t-lg">
          <input class="btn btn--form" id="submitBtn" type="button" value="Iniciar sesión" onclick="login()" />
        </div>
      </form>
      <br>
      <div class="mobile-phone">
        <img src="assets/img/logo-playamar.png" alt="Mobile Phone" style="width: 150px; height: 150px; display: block; margin: 0 auto;">
      </div>
      <div id="text" style="color: black; margin-top: 150px;font-size: 20px">Bienvenido trabajador, logueate para empezar</div>
    </div>
  </div>
</body>
<script>
  var text = document.getElementById("text");
  var saludo = document.getElementById("saludo");
  var lema = document.getElementById("lema");
  var boton_validar = document.getElementById("submitBtn");
  var password_label = document.getElementById("password_label");
  var username_label = document.getElementById("username_label");
  var username = document.getElementById("username");
  var password = document.getElementById("password");

  text.addEventListener("click", function() {
    saludo.style.color = getRandomColor();
    lema.style.color = getRandomColor();
    boton_validar.style.color = getRandomColor();
    password_label.style.color = getRandomColor();
    username_label.style.color = getRandomColor();
    username.style.color = getRandomColor();
    password.style.color = getRandomColor();
    this.style.color = getRandomColor();
  });

  text.addEventListener("mouseover", function() {
    this.style.color = getRandomColor();
  });


  function getRandomColor() {
    const letters = "0123456789ABCDEF";
    let color = "#";
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  function password_show_hide() {
    var x = document.getElementById("password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    } else {
      x.type = "password";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    }
  }
</script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>


</html>