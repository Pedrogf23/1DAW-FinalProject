<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once '../includes/conexion.php';
    require_once '../includes/helpers.php';
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcun icon" href="../img/logo.png">
</head>
<?php if($_SESSION['idUser'] == null){
    header("Location: ../index.php");
}
if(isset($_POST['nombreV'])) {
    $nombreV = $_POST['nombreV'];
} else {
    $nombreV = "";
}
if(isset($_POST['desarrollador'])) {
    $desarrollador = $_POST['desarrollador'];
} else {
    $desarrollador = "";
}
?>
<body>
    <div class="pagina">
        <div class="header">
        <h1>Bienvenido <?php echo $_SESSION['nombreUsuario']; ?></h1>
        </div> <!--header-->
        <div class="navegacion">
            <nav id="menu">
				<ul>
					<li>
						<a href="inicio.php">Mi lista</a>
					</li>
				
					<li>
						<a href="#">Juegos disponibles</a>
					</li>
                    <li>
						<a href="editarPerfil.php">Editar perfil</a>
					</li>
                    <li>
						<a href="../php/cerrarSesion.php">Cerrar sesión</a>
					</li>
				</ul>
			</nav>
        </div> <!--navegacion-->
        <div class="contenido">
            <h1>Juegos disponibles:</h1>	
            <table>
                <tr>
                    <th>Videojuego</th>
                    <th>Desarrollador</th>
                    <th>Añadir a tu lista</th>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php echo isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'alreadyAdded') : ''; ?>
                        <?php echo isset($_SESSION['correcto']) ? $_SESSION['correcto'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <form action="listaJuegos.php" method="POST">
                        <td><input type="text" placeholder="Nombre" name="nombreV" maxlength="50" pattern="[A-Za-z0-9ÑñÁÉÍÓÚáéíóúÇç_.\-: ]+"/></td>
                        <td><input type="text" placeholder="Desarrollador" name="desarrollador" maxlength="50" pattern="[A-Za-z0-9ÑñÁÉÍÓÚáéíóúÇç_.\-: ]+"/></td>
                        <td><input type="submit" value="Buscar">
                        </td>
                    </form>
                </tr>
                <?php 
                    $sql = "SELECT nombre, desarrollador FROM videojuego WHERE nombre LIKE '%$nombreV%' AND desarrollador LIKE '%$desarrollador%' ORDER BY nombre ASC;";
                    $juegos = mysqli_query($db, $sql);
                    
                    $resultado = [];
                    
                    if($juegos && mysqli_num_rows($juegos) >= 1){
                        $resultado = $juegos;
                    }

                    if(!empty($resultado)){
                        while($juego = mysqli_fetch_assoc($resultado)){
                ?>
                <tr>
                    <td><?=$juego['nombre']?></td>
                    <td><?=$juego['desarrollador']?></td>
                    <td id="add">
                        <form action="../php/guardarJuegoToLista.php" method="POST">
                            <input type="hidden" value="<?=$juego['nombre']?>" name="nombreV">
                            <input type="submit" value="+">
                        </form>
                    </td>
                </tr>
            
                <?php
                        } //Fin while
                    } //Fin if
                ?>
            </table>
            <h3>¿Falta algún juego? <a href="addJuego.php">Añádelo</a></h3>
        </div> <!--contenido-->
    </div> <!--pagina-->
    <?php
    borrarErrores();
    $_SESSION['correcto'] = "";
    ?>
</body>
</html>