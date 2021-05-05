<?php
// inicialice la sesion
session_start();
 
// verifique si el usuario ha iniciado sesion, sino redirijalo a la pagina de inicio de sesion
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas de cocina</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
        integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="app.js"></script>

</head>

<body style="background: pink;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand">Bienvenid@ <?php echo htmlspecialchars($_SESSION["username"]); ?> a recetas de
            cocina.</a><br>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <br>
    <p align="right">
        <a href="reset-password.php" class="btn btn-success">Cambiar Contraseña</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </p>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Filtro de búsqueda Comida Salvadoreña</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <form class="form-inline my-2 my-lg-0">
                    <input name="search" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar"
                        aria-label="Buscar">
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
        </div>
    </nav>
    <div class="container">
        <div class="row p-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">

                        <!-- FORM QUE AÑADE RECETAS -->
                        <form id="task-form" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                                <input type="text" id="nombre" placeholder="Nombre de Receta" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" id="tipo" placeholder="Tipo de Comida" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea id="ingredientes" cols="20" rows="10" class="form-control"
                                    placeholder="Ingredientes de la Receta"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea id="preparacion" cols="20" rows="10" class="form-control"
                                    placeholder="Pasos de Preparacion de la Receta"></textarea>
                            </div>

                            <div class="form-group">
                                <br>
                                <label>Subir Imagen</label>
                                <img src="imagenes/comida.jpg" class="img-thumbnail previsualizar" width="100px"><br>
                                <input type="file" class="imagen" id="imagen" name="imagen" class="form-control">
                                <input type="hidden" name="imagenActual" id="imagenActual">
                            </div>

                            <input type="hidden" id="taskId"><br>
                            <button type="submit" class="btn btn-success btn-block text-center">
                                Crear nueva Receta
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLA  -->
            <div class="col-md-7">
                <div class="card my-4" id="task-result">
                    <div class="card-body">
                        <!-- BUSCAR -->
                        <ul id="container"></ul>
                    </div>
                </div>

                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre Receta</th>
                            <th scope="col">Tipo de comida</th>
                            <th scope="col">Ingredientes</th>
                            <th scope="col">Preparacion</th>
                            <th scope="col">Imagen</th>
                        </tr>
                    </thead>
                    <tbody id="tasks"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>