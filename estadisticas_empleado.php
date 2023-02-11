<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$hora_conexion = $_SESSION['conexion'];
$nombre = $_SESSION['user'];
$privilegio = privilegio_usuario($nombre);

if (!isset($_SESSION['user']) || !isset($_COOKIE['adminUser']) || !isset($_GET['id'])) {
    header('Location: inicio.php');
}

if (!isset($_POST['editar'])) {
    $tecnico_data = $_GET['tecnico'];
    $id_data = $_GET['id'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/styleCrud.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Estadisticas de empleado</title>
</head>

<body onload="comprobarLogin()">
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
                <li class="nav-item active efecto">
                    <a href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item active efecto"">
                    <a href=" gestion_moviles.php">Gestionar</a>
                </li>
                <?php
                if ($privilegio == 'admin') {
                    echo '<li class="nav-item active efecto"">
                    <a href="panel_usuario.php">Panel de usuarios</a>
                    </li>';
                }
                ?>
                <li class="nav-item active efecto"">
                    <a href=" acercade.php">Acerca de</a>
                </li>
                <li class="nav-item active efecto"">
                    <a href=" #!" onclick=closeSesion() style="cursor: pointer;">Salir</a>
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

                    <li class="nav-item usuario" style="margin-top: 15px;">
                        Bienvenido <?php echo $_SESSION['user'] ?>
                    </li>
                    <li class="nav-item usuario" style=" margin-top: 15px;">
                        Hora de conexión: <?php echo $hora_conexion ?>
                    </li>
                </ul>
            </span>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="tabla">
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Reparación de móviles</h2>
                        </div>
                    </div>
                </div>
                <table class='table table-striped table-hover' style='width: 100%;'>
                    <?php
                    $file = './csv/moviles.csv';
                    //mostrar todo apartir del 1º row
                    if (!file_exists($file)) {
                        echo "<h2>No hay datos</h2>";
                    } else {
                        $csv = array_map('str_getcsv', file('csv/moviles.csv'));
                        if (countRowsUser($tecnico_data) >= 1) {
                    ?>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Problema del móvil</th>
                                    <th>Fecha</th>
                                    <th>Resuelto</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            foreach ($csv as $row) {
                                $id = $row[0];
                                $nombre = $row[1];
                                $email = $row[2];
                                $problema = $row[3];
                                $fecha_entrega = $row[4];
                                $fecha_terminado = $row[5];
                                $horas_estimadas = $row[6];
                                $horas_reales = $row[7];
                                $resuelto = $row[8];
                                $tecnico = $row[9];
                                $num_factura = $row[10];

                                if ($tecnico_data == $tecnico && $resuelto == 'Si') {
                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$nombre</td>";
                                    echo "<td>$email</td>";
                                    echo "<td>$problema</td>";
                                    echo "<td>$fecha_entrega</td>";
                                    echo "<td>$resuelto</td>";
                                    echo "<td>";
                                    echo "<a href='#editEmployeeModal' class='edit' data-toggle='modal' data-id='$id' data-nombre='$nombre' data-email='$email' data-problema='$problema' data-fecha='$fecha_entrega' data-fecha_terminado='$fecha_terminado' data-horas_estimadas='$horas_estimadas' data-resuelto='$resuelto' data-num_factura='$num_factura' data-tecnico='$tecnico'><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>";
                                    echo "<a href='#deleteEmployeeModal' data-id_delete='$id' class='delete' data-toggle='modal' ><i class='material-icons' data-toggle='tooltip' title='Eliminar'>&#xE872;</i></a>";
                                    //make input submit
                                    echo "<form method='post' action='php/funciones/factura.php'>";
                                    echo "<input type='hidden' name='nombre_cliente_test' id='nombre_cliente_test' value='$nombre'>";
                                    echo "<input type='hidden' name='email_cliente_test' id='email_cliente_test' value='$email'>";
                                    echo "<input type='hidden' name='problema_cliente_test' id='problema_cliente_test' value='$problema'>";
                                    echo "<input type='hidden' name='fecha_cliente_test' id='fecha_cliente_test' value='$fecha_entrega'>";
                                    echo "<input type='hidden' name='fecha_terminado_test' id='fecha_terminado_test' value='$fecha_terminado'>";
                                    echo "<input type='hidden' name='horas_reales_test' id='horas_reales_test' value='$horas_reales'>";
                                    echo "<input type='hidden' name='tecnico_test' id='tecnico_test' value='$tecnico'>";
                                    echo "<input type='hidden' name='numFactura_test' id='numFactura_test' value='$num_factura'>";
                                    echo "<td><button type='submit' class='edit' name='submit' value='submit'>Generar PDF</button></td>";
                                    echo "</form>";
                                    echo "</td>";
                                }
                            }
                            echo "</tr>";
                            echo "</tbody>";
                        } else {
                            echo "<h2>No ha reparado ningun telefono</h2>";
                        }
                    }
                        ?>
                </table>
                <!-- boton volver  -->
                <div class="row">
                    <div class="col-sm-6" style="margin-bottom: 10px;">
                        <a href="panel_usuario.php" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="editForm" onsubmit="return false;">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre_cliente" value="">
                            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id_data ?>">
                            <input type="hidden" class="form-control" name="tecnico_firma" id="tecnico_firma" value="<?php echo $tecnico_data ?>">
                            <input type="hidden" name="num_factura" id="num_factura" value="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="" id="email_cliente">
                        </div>
                        <div class="form-group">
                            <label>Problema del móvil</label>
                            <textarea class="form-control" name="problema" id="problema_cliente"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Fecha de reparación</label>
                            <input type="hidden" class="form-control" name="fecha_entrega" id="fecha_entrega" value="">
                            <input type="date" class="form-control" name="fecha_terminado" id="fecha_terminado" value="">
                        </div>
                        <div class="form-group">
                            <label>Tiempo de trabajo</label>
                            <input type="hidden" class="form-control" name="horas_estimadas" id="horas_estimadas" value="">
                            <input type="number" class="form-control" name="horas_trabajadas" placeholder="Horas de reparacion del telefono" value="" id="horas_trabajadas">
                        </div>
                        <?php
                        echo "<div class='form-group'>
						<label>Resuelto</label>
						<select class='form-control' name='resuelto' id='resuelto'>
						<option value='Si'";
                        if ($resuelto == "Si") {
                            echo " selected";
                        }
                        echo ">Si</option>
						<option value='No'";
                        if ($resuelto == "No") {
                            echo " selected";
                        }
                        echo ">No</option>
						</select>
						</div>";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" name="editar" id="editar" class="btn btn-info" onclick="editCSV()" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" onsubmit="return false;">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro/a que quieres eliminarlo?</p>
                        <p class="text-warning"><small>Esta acción no se puede deshacer</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="id_eliminar" id="id_eliminar" value="">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" value="Eliminar" onclick=delete_slice_CSV()>
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
                    <a href="https://iesplayamar.es/" class="enlace_footer" target="_blank" style="margin-right: 150px;">
                    </a>
                    <a href="inicio.php">
                        <img src="assets/img/logo.png" alt="Logo Tienda reparación de Móviles">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE LA WEB</h2>
                <p>Proyecto de reparación de móviles enfocado para el uso por parte del alumnado de FP Básica del Instituto I.E.S. Playamar. </p>
                <p>Este proyecto forma parte de los módulos Desarrollo Web en Entorno Cliente y Desarrollo Web en Entorno de Servidor.</p>
            </div>
            <div class="box">
                <h2>REDES SOCIALES</h2>
                <div class="red-social">
                    <a href="https://twitter.com/iesplayamar" target="_blank"> <img src="assets/icons/Twitter.svg" alt="Twitter" width="50px"></a>
                    <a href="https://www.facebook.com/profile.php?id=100075955310474" target="_blank"> <img src="assets/icons/Facebook.svg" alt="Facebook" width="50px"></a>
                    <a href="https://www.instagram.com/iesplayamar/" target="_blank"> <img src="assets/icons/Instagram.svg" alt="Instagram" width="50px"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            &copy; 2023 <b>Reparación de Móviles</b> - Tienda Virtual
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        $('#editEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var nombre = button.data('nombre');
            var email = button.data('email');
            var problema = button.data('problema');
            var fecha_entrega = button.data('fecha');
            var fecha_terminado = button.data('fecha_terminado');
            var horas_estimadas = button.data('horas_estimadas');
            var resuelto = button.data('resuelto');
            var num_factura = button.data('num_factura');
            var tecnico = button.data('tecnico');

            populateModalForm(id, nombre, email, problema, fecha_entrega, fecha_terminado, horas_estimadas, resuelto, num_factura, tecnico);
        });

        function populateModalForm(id, nombre, email, problema, fecha_entrega, fecha_terminado, horas_estimadas, resuelto, num_factura, tecnico) {
            $('#editEmployeeModal input[name="id"]').val(id);
            $('#editEmployeeModal input[name="nombre"]').val(nombre);
            $('#editEmployeeModal input[name="email"]').val(email);
            $('#editEmployeeModal textarea[name="problema"]').val(problema);
            $('#editEmployeeModal input[name="fecha_entrega"]').val(fecha_entrega);
            $('#editEmployeeModal input[name="fecha_terminado"]').val(fecha_terminado);
            $('#editEmployeeModal input[name="horas_estimadas"]').val(horas_estimadas);
            $('#editEmployeeModal input[name="resuelto"]').val(resuelto);
            $('#editEmployeeModal input[name="num_factura"]').val(num_factura);
            $('#editEmployeeModal input[name="tecnico_firma"]').val(tecnico);
        }

        $('#deleteEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id_delete');
            deleteModalForm(id);
        });

        function deleteModalForm(id) {
            $('#deleteEmployeeModal input[name="id_eliminar"]').val(id);
        }
    </script>
    <script src="./assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/funciones.js"></script>

</body>

</html>