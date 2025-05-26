<form action="editar_usuario.php" method="POST">
  <h2>Editar perfil</h2>

  <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

  <label for="nombre">Nombre:</label><br>
  <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br><br>
  
  <label for="apellidos">Apellidos:</label><br>
  <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required><br><br>
  
  <label for="email">Correo electrónico:</label><br>
  <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" readonly><br><br>
  
  <label for="altura">Altura (cm):</label><br>
  <input type="number" id="altura" name="altura" step="0.01" value="<?= htmlspecialchars($usuario['altura']) ?>"><br><br>
  
  <label for="peso">Peso (kg):</label><br>
  <input type="number" id="peso" name="peso" step="0.01" value="<?= htmlspecialchars($usuario['peso']) ?>"><br><br>
  
  <label for="edad">Edad:</label><br>
  <input type="number" id="edad" name="edad" value="<?= htmlspecialchars($usuario['edad']) ?>"><br><br>
  
  <label for="sexo">Sexo:</label><br>
  <select id="sexo" name="sexo">
    <option value="">--Seleccionar--</option>
    <option value="masculino" <?= $usuario['sexo'] === 'masculino' ? 'selected' : '' ?>>Masculino</option>
    <option value="femenino" <?= $usuario['sexo'] === 'femenino' ? 'selected' : '' ?>>Femenino</option>
    <option value="otro" <?= $usuario['sexo'] === 'otro' ? 'selected' : '' ?>>Otro</option>
  </select><br><br>
  
  <label for="actividad_fisica">Actividad física:</label><br>
  <select id="actividad_fisica" name="actividad_fisica">
    <option value="">--Seleccionar--</option>
    <option value="sedentario" <?= $usuario['actividad_fisica'] === 'sedentario' ? 'selected' : '' ?>>Sedentario</option>
    <option value="ligera" <?= $usuario['actividad_fisica'] === 'ligera' ? 'selected' : '' ?>>Ligera</option>
    <option value="moderada" <?= $usuario['actividad_fisica'] === 'moderada' ? 'selected' : '' ?>>Moderada</option>
    <option value="intensa" <?= $usuario['actividad_fisica'] === 'intensa' ? 'selected' : '' ?>>Intensa</option>
    <option value="muy_intensa" <?= $usuario['actividad_fisica'] === 'muy_intensa' ? 'selected' : '' ?>>Muy intensa</option>
  </select><br><br>
  
  <label for="objetivo">Objetivo:</label><br>
  <input type="text" id="objetivo" name="objetivo" value="<?= htmlspecialchars($usuario['objetivo']) ?>"><br><br>
  
  <input type="submit" value="Guardar cambios">
</form>
