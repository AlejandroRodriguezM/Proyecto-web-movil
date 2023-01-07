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
	<title>Tienda Virtual de Reparación de Móviles - Gestionar</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="assets/style/font-awesome.min.css">
	<link rel="stylesheet" href="assets/style/bootstrap3.min.css">
	<link rel="stylesheet" href="assets/style/styleCrud.css">
	<link rel="stylesheet" href="assets/style/style.css">

<body onload="comprobarLogin()">
	<!-- NAVEGACION -->
	<nav>
		<div class="countainer">
			<ul class="menu">
				<li><a href="inicio.php">Inicio</a></li>
				<li><a href="crud.php">Gestionar</a></li>
				<li><a href="#!">Acerca de</a></li>
			</ul>
			<div class="sesion border-right">
				<p>Hora de conexión: <?php $conexion ?></p>

			</div>
            <div class="sesion">
            Bienvenido<p id="user"></p>
            </div>

			<!-- LOGO -->
			<div class="container-logo">
				<div class="box">

					<div class="title">
						<span class="block"></span>
						<h1>Reparación de Móviles<span></span></h1>
					</div>

					<div class="role">
						<div class="block"></div>
						<p>Tienda Virtual</p>
					</div>

				</div>
			</div>
		</div>
	</nav>
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
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Fecha</th>
							<th>Resuelto</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Antonio</td>
							<td>antonioruiz@mail.com</td>
							<td>No conecta internet</td>
							<td>12/12/2022</td>
							<td>Sí</td>
							<td>
								<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
								<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
							</td>
						</tr>
						<tr>
							<td>María Soler</td>
							<td>mariasoler@mail.com</td>
							<td>Bloqueo de pantalla</td>
							<td>30/12/2022</td>
							<td>No</td>
							<td>
								<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
								<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Editar</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control">
						</div>
						<div class="form-group">
							<label>Problema del móvil</label>
							<textarea class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>Fecha</label>
							<input type="date" class="form-control">
						</div>
						<div class="form-group">
							<label>Resuelto</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
						<input type="submit" class="btn btn-info" value="Guardar">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Eliminar</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>¿Estás seguro/a que quieres eliminarlo?</p>
						<p class="text-warning"><small>Esta acción no se puede deshacer</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
						<input type="submit" class="btn btn-danger" value="Eliminar">
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
	<script src="./assets/js/jquery.min.js"></script>
	<script src="./assets/js/bootstrap.min.js"></script>
</body>

</html>