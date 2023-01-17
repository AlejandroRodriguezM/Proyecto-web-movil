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
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tienda Virtual de Reparación de Móviles - Averiados</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="assets/style/font-awesome.min.css">
	<link rel="stylesheet" href="assets/style/bootstrap3.min.css">
	<link rel="stylesheet" href="assets/style/styleCrud.css">
	<link rel="stylesheet" href="assets/style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body onload="comprobarLogin()">
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
					<span class="block"></span>
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
	<!-- center the nav  -->
	<nav class="center">
		<div class="countainer">
			<ul class="menu">
				<li><a href="CRUD.php">Todos</a></li>
				<li><a href="averiados.php">Averiados</a></li>
				<li><a href="reparados.php">Arreglados</a></li>
			</ul>
	</nav>
	<div class="tabla">
		<div class="container">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2>Moviles averiados</h2>
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover" style="width: 78%;">
					<?php
					$file = './csv/moviles.csv';
					//mostrar todo apartir del 1º row
					if (!file_exists($file)) {
						echo "<h2>No hay datos</h2>";
					} else {
						$csv = array_map('str_getcsv', file('csv/moviles.csv'));
						if (countRowsCSVAveriados($file) >= 1) {
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
								$fecha = $row[4];
								$resuelto = $row[7];
								if ($resuelto == 'No') {
									echo "<tr>";
									echo "<td>$id</td>";
									echo "<td>$nombre</td>";
									echo "<td>$email</td>";
									echo "<td>$problema</td>";
									echo "<td>$fecha</td>";
									echo "<td>$resuelto</td>";
									echo "<td>";
									echo "<a href='#editEmployeeModal' class='edit' data-toggle='modal' data-id='$id' data-nombre='$nombre' data-email='$email' data-problema='$problema' data-fecha='$fecha' data-resuelto='$resuelto'  ><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>";
									echo "<a class='delete' data-toggle='modal' style='cursor: not-allowed'><i class='material-icons' data-toggle='tooltip' title='Eliminar'>&#xE872;</i></a>";
									echo "</td>";
									echo "</tr>";
								}
							}
							echo "</tbody>";
						} else {
							echo "<h2>No hay ningun movil averiado</h2>";
						}
					}
						?>
				</table>
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
							<input type="hidden" class="form-control" name="id" id="id" value="">
							<input type="hidden" class="form-control" name="tecnico" id="tecnico" value="<?php echo $_SESSION['user']; ?>">
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
							<label>Fecha</label>
							<input type="date" class="form-control" name="fecha" value="" id="fecha_entrega_cliente">
						</div>
						<div class="form-group">
							<label>Coste</label>
							<input type="number" class="form-control" name="coste" placeholder="Precio de reparacion del telefono" value="" id="coste_entrega_cliente">
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
						<input type="submit" class="btn btn-info" onclick="updateCSV()" value="Guardar">
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
	<script>
		$('#editEmployeeModal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var id = button.data('id');
			var nombre = button.data('nombre');
			var email = button.data('email');
			var problema = button.data('problema');
			var fecha = button.data('fecha');
			var resuelto = button.data('resuelto');

			populateModalForm(id, nombre, email, problema, fecha, resuelto);
		});

		function populateModalForm(id, nombre, email, problema, fecha, resuelto) {
			$('#editEmployeeModal input[name="id"]').val(id);
			$('#editEmployeeModal input[name="nombre"]').val(nombre);
			$('#editEmployeeModal input[name="email"]').val(email);
			$('#editEmployeeModal textarea[name="problema"]').val(problema);
			$('#editEmployeeModal input[name="fecha"]').val(fecha);
			$('#editEmployeeModal input[name="resuelto"]').val(resuelto);
		}
	</script>
	<script src="./assets/js/login.js"></script>
	<script src="./assets/js/bootstrap.min.js"></script>
	<script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>