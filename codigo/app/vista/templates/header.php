<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutripro</title>
    <link rel="stylesheet" href="../vista/css/styles.css">
</head>
<body>
    <div class="container">
    <header>
    <h1>Nutripro</h1>
    <nav>
      <?php
        echo(AuthModel::cargarMenu());
      ?>
    </nav>

  </header> 
        <main>
        <!-- <nav>
                <div class="nav-left">
                    <a href="index.php?controller=adminController&action=panel">PANEL ADMIN</a>
                    <a href="index.php?controller=userController&action=perfil">MI PERFIL</a>
                    <a href="index.php?controller=logout&action=cerrarSesion">CERRA SESION</a>
                </div>
                <div class="nav-right">
                    <a href="index.php?controller=logout&action=cerrarSesion">PERFIL</a>
                </div>
            </nav> -->