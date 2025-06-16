<form action="index.php?controller=UsuarioController&action=registroUsuario" method="POST">
      <h2>Registro de Usuario</h2>

      <section class="form-group">
        <label for="nombre" class="required">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
      </section>

      <section class="form-group">
        <label for="apellidos" class="required">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
      </section>

      <section class="form-group">
        <label for="email" class="required">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
      </section>

      <section class="form-group">
        <label for="contrasena" class="required">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
      </section>

      <input type="submit" class="btn-submit" value="Registrarse">
    </form>
<script src="vista/js/script.js" defer></script>
<script src="vista/js/register.js" defer></script>