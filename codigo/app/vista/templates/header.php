<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de administración de Nutripro">
    <title>Nutripro</title>
    <link rel="stylesheet" href="../vista/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <h1>NutriPro</h1>
        <nav>
            <button class="hamburger-btn" id="hamburger-btn" aria-label="Abrir menú">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <section class="nav-left" id="nav-menu">
            <?php
        echo(AuthModel::cargarMenu());
      ?>
            </section>
            <section class="nav-right">
                <a href="index.php?controller=userController&action=perfil">PERFIL</a>
            </section>
    </nav>
    </header>
<main>
