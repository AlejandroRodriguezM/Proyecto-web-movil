<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tienda virtual</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style/normalize.min.css">
  <link rel='stylesheet' href='style/bootstrap.min.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,700,300'>
  <link rel='stylesheet' href='style/font-awesome.min.css'>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <div class="signup__container">
    <div class="container__child signup__thumbnail">
      <div class="thumbnail__content text-center">
        <h1 class="heading--primary">Bienvenido a la tienda virtual</h1>
        <h2 class="heading--secondary">Reparación de móviles</h2>
      </div>
      <div class="signup__overlay"></div>
    </div>
    <div class="container__child signup__form">
      <form action="#">
        <div class="form-group">
          <label for="username">Nombre</label>
          <input class="form-control" type="text" name="username" id="username" placeholder="Ponga su nombre" required />
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input class="form-control" type="text" name="email" id="email" placeholder="correo@tuemail.com" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" name="password" id="password" placeholder="********" required />
        </div>
        <div class="form-group">
          <label for="passwordRepeat">Repita su Password</label>
          <input class="form-control" type="password" name="passwordRepeat" id="passwordRepeat" placeholder="********" required />
        </div>
        <div class="m-t-lg">
          <ul class="list-inline">
            <li>
              <input class="btn btn--form" type="submit" value="Iniciar sesión" />
            </li>
            <li>
              <a class="signup__link" href="#">Crear cuenta</a>
            </li>
          </ul>
        </div>
      </form>
    </div>
  </div>

</body>

</html>