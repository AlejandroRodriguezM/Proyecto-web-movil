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
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="password" placeholder="********" placeholder="***********" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" />
              <button id="toggle-password" type="button" class="d-none"></button>
            </div>
          </div>
        </div>
        <div class="m-t-lg">
          <input class="btn btn--form" id="submitBtn" type="button" value="Iniciar sesión" onclick="login()" />
        </div>
      </form>
    </div>
  </div>
  <script>
    var ShowPasswordToggle = document.querySelector("[type='password']");
    ShowPasswordToggle.onclick = function() {
      document.querySelector("[type='password']").classList.add("input-password");
      document.getElementById("toggle-password").classList.remove("d-none");
      const passwordInput = document.querySelector("[type='password']");
      const togglePasswordButton = document.getElementById("toggle-password");
      togglePasswordButton.addEventListener("click", togglePassword);

      function togglePassword() {
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          togglePasswordButton.setAttribute("aria-label", "Hide password.")
        } else {
          passwordInput.type = "password";
          togglePasswordButton.setAttribute("aria-label", "Show password as plain text. " + "Warning: this will display your password on the screen.")
        }
      }
    };
  </script>
  <script src="assets/js/sweetalert2.all.min.js"></script>
  <script src="assets/js/login.js"></script>
</body>

</html>