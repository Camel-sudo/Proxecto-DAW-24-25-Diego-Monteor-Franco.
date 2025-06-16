<main>
  <section class="grid">
    <section class="momento">
      <h2>Mis Dietas</h2>

      <form id="form-fecha">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>">
        <button type="submit">Ver</button>
      </form>

      <section class="macros">
        <h3>KCAL: 33 / TOTAL PROTEINA: 33 / TOTAL GRASAS: 33 / TOTAL HIDRATOS: 33</h3>
      </section>

      <section id="contenedor-dietas">

        <section>
          <h3>Desayuno</h3>
          <table border="1" cellpadding="8" cellspacing="0">
            <thead>
              <tr>
                <th>Alimento</th>
                <th>Cantidad</th>
                <th>Calorías</th>
                <th>Proteínas</th>
                <th>Carbohidratos</th>
                <th>Grasas</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="alimento-desayuno">
              <tr>
                <td colspan="9" style="text-align: center;">
                  <a href="index.php?controller=AlimentoController&action=buscarAlimentoForm&fecha=2025-06-14&momento=almuerzo">
                    ➕ Añadir alimento
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </section>

        <section class="momento">
          <h3>Almuerzo</h3>
          <table border="1" cellpadding="8" cellspacing="0">
            <thead>
              <tr>
                <th>Alimento</th>
                <th>Cantidad</th>
                <th>Calorías</th>
                <th>Proteínas</th>
                <th>Carbohidratos</th>
                <th>Grasas</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="alimento-almuerzo">

              <tr>
                <td colspan="9" style="text-align: center;">
                <a href="index.php?controller=AlimentoController&action=buscarAlimentoForm&fecha=2025-06-14&momento=almuerzo">
                    ➕ Añadir alimento
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </section>

        <section class="momento">
          <h3>Cena</h3>
          <table border="1" cellpadding="8" cellspacing="0">
            <thead>
              <tr>
                <th>Alimento</th>
                <th>Cantidad</th>
                <th>Calorías</th>
                <th>Proteínas</th>
                <th>Carbohidratos</th>
                <th>Grasas</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="alimento-cena">
              <tr>
                <td colspan="9" style="text-align: center;">
                <a href="index.php?controller=AlimentoController&action=buscarAlimentoForm&fecha=2025-06-14&momento=almuerzo">
                    ➕ Añadir alimento
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </section>

      </section>
    </section>
  </section>
</main>

<script src="vista/js/script.js" defer></script>
<script src="vista/js/misDietas.js" defer></script>