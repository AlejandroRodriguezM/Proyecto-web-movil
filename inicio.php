<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$hora_conexion = $_SESSION['conexion'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/styleInicio.css">
    <title>Tienda Virtual de Reparación de Móviles </title>

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
                    <a href="crud.php">Gestionar</a>
                </li>
                <?php
                if ($_SESSION['user'] == 'admin') {
                    echo '<li class="nav-item active">
                    <a href="panel_usuario.php">Panel de usuarios</a>
                    </li>';
                }
                ?>
                <li class="nav-item active">
                    <a href="#!">Acerca de</a>
                </li>
                <li class="nav-item active">
                    <a href="#!" onclick=closeSesion() style="cursor: pointer;">Salir</a>
                </li>
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a href="#!" style="color: white;">Bienvenido <?php echo $_SESSION['user'] ?></a>
                    </li>
                    <li class="nav-item active">
                        <a href="#!" style="color: white;">Hora de conexión: <?php echo $hora_conexion ?></a>
                    </li>
                </ul>
            </span>
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
                            <!-- /$date with year month and day  -->
                            <?php
                            $fecha_entrega = date('Y-m-d');
                            ?>
                            <input type="hidden" id="fecha_entrega_cliente" class="form-control" value="<?php echo $fecha_entrega ?>">
                            <input type="hidden" id="num_factura" value="<?php echo createInvocieNumer() ?>">
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
    <script src="./assets/js/login.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>