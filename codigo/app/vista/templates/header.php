<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutripro</title>
    <link rel="stylesheet" href="./css/styles.css">
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
