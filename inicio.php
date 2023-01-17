<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$conexion = $_SESSION['conexion'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/font-awesome.min.css">
    <link rel="stylesheet" href="assets/style/bootstrap3.min.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/styleInicio.css">
    <title>Tienda Virtual de Reparación de Móviles </title>

</head>

<body>
    <!-- NAVEGACION -->
    <div class="countainer">
        <ul class="menu navbar-collapse">
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="crud.php">Gestionar</a></li>
            <li><a href="#!">Acerca de</a></li>
            <li><a onclick=closeSesion() style="cursor: pointer;">Salir</a></li>
        </ul>
        <div class="sesion">
            <p>Hora de conexión: <?php echo $conexion ?></p>
        </div>
        <div class="sesion">
        <p>Bienvenindo: <?php echo $_SESSION['user'] ?></p>
        </div>
        <!-- LOGO -->
        <div class="container-logo">
            <div class="box">
                <div class="title">
                    <span class="block" ></span>
                    <h1 style="cursor: pointer;">Reparación de Móviles<span></span></h1>
                </div>

                <div class="role">
                    <div class="block"></div>
                    <p>Tienda Virtual</p>
                </div>
            </div>
        </div>
    </div>
    </nav>

    <!-- CARDS INSERTAR Y GESTIONAR -->
    <div class="card-category-3">
        <ul>
            <li>
                <div class="ioverlay-card io-card-2">
                    <div class="card-content">
                        <span class="card-title">Insertar</span>
                        <p class="card-text">
                            Inserta la petición de reparación de móvil
                        </p>
                    </div>
                    <span class="card-link">
                        <a href="#insertar" class="edit" data-toggle="modal">
                            <span>INSERTAR</span>
                        </a>
                    </span>
                    <img src="assets/img/insertar.jpg" />
                </div>
            </li>


            <li>
                <div class="ioverlay-card io-card-2">
                    <div class="card-content">
                        <span class="card-title">Gestionar</span>
                        <p class="card-text">
                            Edita o elimina alguna reparación de móvil
                        </p>
                    </div>
                    <span class="card-link">
                        <a href="crud.php">
                            <span>GESTIONAR</span>
                        </a>
                    </span>
                    <img src="assets/img/gestionar.jpg" />
                </div>
            </li>
        </ul>
    </div>


    <!-- FORMULARIO INSERTAR -->
    <div id="insertar" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="formInsert" onsubmit="return false;">
                    <div class="modal-header">
                        <h4 class="modal-title">Insertar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <input type="text" id="nombre_cliente" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email_cliente" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Problema del móvil</label>
                            <textarea class="form-control" id="problema_cliente" style="resize:none;"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Horas estimadas de trabajo</label>
                            <input type="number" id="horas_cliente" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Actual</label>
                            <input type="date" id="fecha_entrega_cliente" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-info" value="Guardar" onclick="insert_request()">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="inicio.php">
                        <img src="assets/img/logo.png" alt="Logo de SLee Dw">
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
    <script src="./assets/js/login.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>