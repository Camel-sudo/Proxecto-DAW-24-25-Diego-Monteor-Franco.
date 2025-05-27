<form action="index.php?controller=AuthController&action=LoginUsuario" method="POST">
  <h2>Iniciar sesión</h2>
  
  <label for="email">Correo electrónico:</label><br>
  <input type="email" id="email" name="email" required><br><br>
  
  <label for="contrasena">Contraseña:</label><br>
  <input type="password" id="contrasena" name="contrasena" required><br><br>
  
  <input type="submit" value="Entrar">
</form>
