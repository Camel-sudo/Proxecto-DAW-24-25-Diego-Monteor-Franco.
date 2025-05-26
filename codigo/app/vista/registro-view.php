<form action="index.php?controller=UsuarioController&action=registroUsuario" method="POST">
  <h2>Registro de Usuario</h2>
  
  <label for="nombre">Nombre:</label><br>
  <input type="text" id="nombre" name="nombre" required><br><br>
  
  <label for="apellidos">Apellidos:</label><br>
  <input type="text" id="apellidos" name="apellidos" required><br><br>
  
  <label for="email">Correo electrónico:</label><br>
  <input type="email" id="email" name="email" required><br><br>
  
  <label for="contrasena">Contraseña:</label><br>
  <input type="password" id="contrasena" name="contrasena" required><br><br>
  <input type="submit" value="Registrarse">
</form>
