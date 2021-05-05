<?php
// Inicializar la sesión
session_start();
 
// Compruebe si el usuario ya ha iniciado sesión, en caso afirmativo, rediríjalo a la página de bienvenida
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: paginaprincipal.php");
  exit;
}
 
// Incluir el archivo de conexion
require_once "conexion.php";
 
//Definir variables e inicializar con valores vacíos
$username = $password = "";
$username_err = $password_err = "";
 
// Procesando los datos del formulario cuando se envia el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Comprobar si el nombre del usuario esta vacío
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // comprobar si la contraseña esta vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Verifica el usuario
    if(empty($username_err) && empty($password_err)){
        // Preparar una declaración de selección
        $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // vincular variables a la declarción preparada como parametros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // establecer parametros
            $param_username = $username;
            
            // intente ejecutar la declaracion preparada
            if(mysqli_stmt_execute($stmt)){
                // resultado de la petición
                mysqli_stmt_store_result($stmt);
                
                // verifique si existe el nombre de usuario, si es asi, verifique la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Vincular variables de resultados
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // la contraseña es correcta, asi que inicie una nueva sesión
                            session_start();
                            
                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirigir al usuario a la pagina principal
                            header("location: paginaprincipal.php");
                        } else{
                            // Muestra un error si la contraseña no es valida
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    // muestra un mensaje de error si el nombre de un usuario no existe
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else{
                echo "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }
        
        // declaracion de cierre
        mysqli_stmt_close($stmt);
    }
    
    // cerrar conexion
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: pink;">
    <div class="container">
    <div class='login'>
    <div class="login-screen">
    <div class="app-title">
    <h1>Iniciar Sesión</h1>
    </div>
    <div class="login-form">
    <div class="control-group">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input placeholder="Usuario" type="text" name="username" class="form-control" value="<?php echo $username; ?>"><br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="form-control" placeholder="Contraseña"><br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
            <br><p>¿No tienes una cuenta? <br><a href="register.php">Regístrate ahora.</a></p>
        </form>
    </div>
    </div>
    </div>    
    </div>
    </div>
</body>
</html>