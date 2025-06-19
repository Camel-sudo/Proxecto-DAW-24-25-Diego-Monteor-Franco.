<h2>Buscar Alimento</h2>

<form id="form-busqueda" method="GET">
  
<label for="input-busqueda" class="visually-hidden">Buscar alimento</label>
<input type="text" id="input-busqueda" name="busqueda" placeholder="Buscar alimento..." aria-label="Buscar alimento">

  <input type="hidden" name="fecha" value="<?= $_GET['fecha'] ?? date('Y-m-d') ?>">
  <input type="hidden" name="momento_dia" value="<?= $_GET['momento'] ?? 'desayuno' ?>">

  <button type="submit">Buscar</button>
  <button type="button" class="crear">Crear alimento</button>
</form>

<div id="resultados">

</div>
<script src="vista/js/script.js" defer></script>
<script src="vista/js/buscarAlimentos.js" defer></script>
