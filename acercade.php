<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$hora_conexion = $_SESSION['conexion'];
$nombre = $_SESSION['user'];
$privilegio = privilegio_usuario($nombre);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/style/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/styleCrud.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Acerca de</title>
    <style>
        .enlace_git {
            color: blue;
            animation: colorchange 5s infinite;
        }

        @keyframes colorchange {
            0% {
                color: blue;
            }

            50% {
                color: red;
            }

            100% {
                color: blue;
            }
        }
    </style>
</head>

<body>
    <!-- NAVEGACION -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="background-color: #333 !important;">
        <div class="container-logo">
            <div class="box">
                <div class="title">
                    <span class="block"></span>
                    <a href="inicio.php">
                        <h1 style="cursor: pointer;">Reparación de Móviles<span></span></h1>
                    </a>
                </div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a href="gestion_moviles.php">Gestionar</a>
                </li>
                <?php
                if ($privilegio == 'admin') {
                    echo '<li class="nav-item active">
                    <a href="panel_usuario.php">Panel de usuarios</a>
                    </li>';
                }
                ?>
                <li class="nav-item active">
                    <a href="acercade.php">Acerca de</a>
                </li>
                <li class="nav-item active">
                    <a href="#!" onclick=closeSesion() style="cursor: pointer;">Salir</a>
                </li>
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <?php
                    $file = './csv/usuarios.csv';
                    $login = $_SESSION['user'];
                    $picture = pictureProfile($file, $login);
                    echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()'>";
                    ?>

                    <div id="myModal" class="modal_picture" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <span class="close"></span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal_picture-content" id="img01">
                    </div>

                    <li class="nav-item active" style="margin-top: 15px;">
                        <a href="#!" style="color: white;">Bienvenido <?php echo $_SESSION['user'] ?></a>
                    </li>
                    <li class="nav-item active" style="margin-top: 15px;">
                        <a href="#!" style="color: white;">Hora de conexión: <?php echo $hora_conexion ?></a>
                    </li>
                </ul>
            </span>
        </div>
    </nav>

    <div class="tabla">
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Acerca de <span>página</span></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Nombre de la página</td>
                            <td>Pagina Web moviles</td>
                        </tr>
                        <tr>
                            <td>Objetivo</td>
                            <td>Proyecto para instituto para control de usuarios y arreglo de telefonos</td>
                        </tr>
                        <tr>
                            <td>Fecha de lanzamiento</td>
                            <td>01/02/2023</td>
                        </tr>
                        <tr>
                            <td>Curso</td>
                            <td>Desarollo de aplicaciones Web (DAW)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Acerca del <span>creador</span></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Nombre</td>
                            <td>Alejandro Rodriguez Mena</td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td>Información a completar</td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td>Información a completar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Redes sociales <span>creador</span></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Alejandro Rodriguez</td>
                            <td>
                            <a href="https://github.com/AlejandroRodriguezM" class="enlace_git" target="_blank">GitHub</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Alejandro Rodriguez</td>
                            <td>
                            <a href="https://www.infojobs.net/candidate/cv/view/index.xhtml?dgv=5797560250733159980" class="enlace_git" target="_blank">InfoJobs</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nombre del creador</td>
                            <td>GitHub</td>
                        </tr>
                        <tr>
                            <td>Nombre del creador</td>
                            <td>GitHub</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="inicio.php">
                        <img src="assets/img/logo.png" alt="Logo Tienda reparación de Móviles">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ipsa?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ipsa?</p>
            </div>
            <div class="box">
                <h2>SIGUENOS</h2>
                <div class="red-social">
                    <a href="#">link 1</a>
                    <a href="#">link 2</a>
                    <a href="#">link 3</a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            &copy; 2022 <b>Reparación de Móviles</b> - Tienda Virtual
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        const link = document.querySelector('a[href="https://github.com/AlejandroRodriguezM"]');
        link.classList.add('blink');
    </script>
    <script src="./assets/js/login.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/funciones.js"></script>

</body>

</html>