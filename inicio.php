<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/style/stylePostindex.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <title>Card Hover</title>
</head>
<body onload="comprobarSesion()">
    <section class="hero-section">
        <div class="card-grid">
            <a class="card" href="#">
                <div class="card__background" style="background-image: url('assets/img/insertar.jpg')"></div>
                <div class="card__content">
                    <h3 class="card__heading">Insertar</h3>
                </div>
            </a>
            <a class="card" href="#">
                <div class="card__background" style="background-image: url('assets/img/gestionar.jpg')"></div>
                <div class="card__content">
                    <h3 class="card__heading">Gestionar</h3>
                </div>
            </a>
        </div>
    </section>

    <!-- Formulario de Insertar -->
    <div class="main">
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <form method="POST" id="signup-form" class="signup-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" class="form-input" name="nombre" id="nombre" />
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" class="form-input" name="mail" id="mail" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group form-icon">
                        <label for="date">Fecha actual</label>
                        <input type="date" class="form-input" name="date" id="date" placeholder="MM-DD-YYYY" />
                    </div>
                    <div class="form-radio">
                        <label for="tecnico">Técnico</label>
                        <div class="form-flex">
                            <input type="radio" name="tecnico" value="asignado" id="asignado" checked />
                            <label for="asignado">Asignado</label>
                            <input type="radio" name="tecnico" value="sinasignar" id="sinasignar" />
                            <label for="sinasignar">Sin asignar</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Problema del móvil</label>
                    <textarea id="phone" name="phone" rows="4" cols="50" placeholder="Describa cuál es el problema que tiene el móvil"/></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="form-submit" value="Insertar"/>
                </div>
            </form>
        </div>
    </div>
</section>

</div>
</body>
</html>