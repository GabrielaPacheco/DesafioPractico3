<?php
// inicializar sesion
session_start();
 
// compruebe si el usuario ha iniciado sesion, de lo contrario, redirija a la pagina de inicio de sesion
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// incluir archivo de conexion
require_once "conexion.php";
 
// definir variables e inicializar con valores vacios
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// procesamiento de datos del formulario cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // validar nueva contraseña
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // validar confirmar contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme la contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
        
    // verificar los errores de entrada antes de actualizar la base de datos
    if(empty($new_password_err) && empty($confirm_password_err)){
        // prepare una declaracion de actualizacion
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //vincular variables a la declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // establecer parametros
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // intente ejecutar la declaracion preparada
            if(mysqli_stmt_execute($stmt)){
                // contraseña actualizada exitosamente. Destruye la sesión y redirige a la pagina de inicio de sesion
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Algo salió mal, por favor vuelva a intentarlo.";
            }
        }
        
        // declaracion de cierre
        mysqli_stmt_close($stmt);
    }
    
    // cierre de conexion
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia tu contraseña acá</title>
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
    <h1>Cambiar Contraseña</h1>
    </div>
    <div class="login-form">
    <div class="control-group">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" placeholder="Nueva Contraseña" name="new_password" class="form-control" value="<?php echo $new_password; ?>"><br>
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" placeholder="Confirmar Contraseña" name="confirm_password" class="form-control"><br>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Guardar Cambios"><br>
                <a href="paginaprincipal.php">Cancelar</a>
            </div>
        </form>
        </div>
    </div>
    </div>    
    </div>
    </div>    
</body>
</html>