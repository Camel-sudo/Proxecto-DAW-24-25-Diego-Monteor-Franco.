loadCSS("vista/css/buscar_alimentos.css");

const fecha = document.querySelector('input[name="fecha"]')?.value || '';
const momento = document.querySelector('input[name="momento_dia"]')?.value || '';

function ajax(options) {
  const { url, method = 'GET', fExito, fError, data } = options;
  const fetchOptions = {
    method,
    headers: {}
  };

  if (method !== 'GET') {
    fetchOptions.headers['Content-Type'] = 'application/json; charset=utf-8';
    fetchOptions.body = JSON.stringify(data);
  }

  fetch(url, fetchOptions)
    .then(resp => resp.ok ? resp.json() : Promise.reject(resp))
    .then(json => fExito(json))
    .catch(error => fError(error));
}

function crearAlimentoDesdeTexto(nombre, texto, idAlimento = null) {
  const calorias = parseFloat(texto.match(/Calorías: (\d+\.?\d*)/)?.[1] ?? 0);
  const proteinas = parseFloat(texto.match(/Proteínas: (\d+\.?\d*)/)?.[1] ?? 0);
  const carbohidratos = parseFloat(texto.match(/Carbs: (\d+\.?\d*)/)?.[1] ?? 0);
  const grasas = parseFloat(texto.match(/Grasas: (\d+\.?\d*)/)?.[1] ?? 0);

  return {
    id_alimento: idAlimento,
    nombre,
    marca: null,
    calorieking_id: null,
    porcion_estandar: 100,
    calorias,
    proteinas,
    carbohidratos,
    grasas,
    fibra: 0,
    sodio: 0,
    ultima_actualizacion: new Date().toISOString().split('T')[0]
  };
}

function construirPayload({ id_alimento, cantidad, alimento }) {
  return {
    id_alimento,
    cantidad: parseFloat(cantidad) || 0,
    fecha,
    momento_dia: momento,
    alimento
  };
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-busqueda');
  const input = document.getElementById('input-busqueda');
  const resultadosDiv = document.getElementById('resultados');
  const btnCrear = document.querySelector('button.crear');
  btnCrear.onclick = mostrarFormularioAgregarAlimento;
  
  // Búsqueda
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const query = input.value.trim();
    if (!query) {
      resultadosDiv.innerHTML = '<p>Por favor ingresa un término de búsqueda.</p>';
      return;
    }

    resultadosDiv.innerHTML = '<p>Cargando resultados...</p>';

    ajax({
      url: `index.php?controller=AlimentoController&action=buscar&q=${encodeURIComponent(query)}`,
      method: 'GET',
      fExito: (data) => {
        resultadosDiv.innerHTML = '';
        if (data.error) {
          resultadosDiv.innerHTML = `<p>${data.error}</p>`;
        } else if (data.length === 0) {
          resultadosDiv.innerHTML = '<p>No se encontraron resultados.</p>';
        } else {
          data.forEach((item) => {
            resultadosDiv.innerHTML += `
              <div class="alimento">
                <strong>${item.descripcion}</strong><br>
                Calorías: ${item.calorias ?? 'N/A'}, Proteínas: ${item.proteinas ?? 'N/A'}, Carbs: ${item.carbohidratos ?? 'N/A'}, Grasas: ${item.grasas ?? 'N/A'}
                <form class="form-seleccion" data-action="index.php?controller=AlimentoController&action=guardarSeleccion">
                  <input type="hidden" name="fecha" value="${fecha}">
                  <input type="hidden" name="momento_dia" value="${momento}">
                  <input type="hidden" name="idAlimento" value="${item.id_alimento}">
                  <label for="cantidad">Cantidad (g):</label>
                  <input type="number" name="cantidad" min="1" required>
                  <button type="submit">Seleccionar</button>
                </form>
                <hr>
              </div>
            `;
          });
        }
      },
      fError: (error) => {
        resultadosDiv.innerHTML = '<p>Error al buscar alimento. Intenta de nuevo.</p>';
        console.error('Fetch error:', error);
      }
    });
  });

  // Guardar alimentos
  resultadosDiv.addEventListener('submit', (e) => {
    if (e.target.matches('.form-seleccion')) {
      e.preventDefault();

      const formData = new FormData(e.target);
      const data = Object.fromEntries(formData.entries());

      const alimentoDiv = e.target.closest('.alimento');
      const nombre = alimentoDiv.querySelector('strong')?.textContent ?? '';
      const texto = alimentoDiv.textContent;

      const alimento = crearAlimentoDesdeTexto(nombre, texto, data.idAlimento);
      const payload = construirPayload({
        idAlimento: data.idAlimento,
        cantidad: data.cantidad,
        alimento
      });

      ajax({
        url: e.target.getAttribute('data-action'),
        method: 'POST',
        data: payload,
        fExito: (res) => {
          if (res.success) {
            alert('Alimento guardado con éxito.');
          } else {
            alert(`Error: ${res.error}`);
          }
        },
        fError: (err) => {
          console.error('Error al guardar alimento:', err);
          alert('Error al guardar alimento.');
        }
      });
    }
  });
});

// Modal 
function mostrarFormularioAgregarAlimento() {
  Swal.fire({
    title: 'Añadir alimento',
    html: `
      <input id="nombre" class="swal2-input" placeholder="Nombre">
      <input id="porcion" class="swal2-input" placeholder="Porción estándar (g)" type="number" min="1" value="100">
      <input id="cantidad" class="swal2-input" placeholder="Cantidad consumida (g)" type="number" min="1" value="100">
      <input id="calorias" class="swal2-input" placeholder="Calorías" type="number" min="0" value="0">
      <input id="proteinas" class="swal2-input" placeholder="Proteínas (g)" type="number" min="0" value="0">
      <input id="carbohidratos" class="swal2-input" placeholder="Carbohidratos (g)" type="number" min="0" value="0">
      <input id="grasas" class="swal2-input" placeholder="Grasas (g)" type="number" min="0" value="0">
    `,
    confirmButtonText: 'Guardar',
    focusConfirm: false,
    preConfirm: () => {
      const nombre = document.getElementById('nombre').value.trim();
      const porcion = parseFloat(document.getElementById('porcion').value || 100);
      const cantidad = parseFloat(document.getElementById('cantidad').value || porcion);
      const calorias = parseFloat(document.getElementById('calorias').value || 0);
      const proteinas = parseFloat(document.getElementById('proteinas').value || 0);
      const carbohidratos = parseFloat(document.getElementById('carbohidratos').value || 0);
      const grasas = parseFloat(document.getElementById('grasas').value || 0);

      if (!nombre) {
        Swal.showValidationMessage('El nombre es obligatorio');
        return false;
      }

      return {
        alimento: {
          id_alimento: null,
          nombre,
          marca: null,
          calorieking_id: null,
          porcion_estandar: porcion,
          calorias,
          proteinas,
          carbohidratos,
          grasas,
          fibra: 0,
          sodio: 0,
          ultima_actualizacion: new Date().toISOString().split('T')[0]
        },
        cantidad
      };
    }
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      const { alimento, cantidad } = result.value;

      const payload = construirPayload({
        idAlimento: null,
        cantidad,
        alimento
      });

      guardarAlimentoEnServidor(payload);
    }
  });
}

function guardarAlimentoEnServidor(payload) {
  console.log('Payload a enviar:', payload);
  ajax({
    url: 'index.php?controller=AlimentoController&action=guardarSeleccion',
    method: 'POST',
    data: payload,
    fExito: (data) => {
      if (data.success) {
        Swal.fire('¡Guardado!', 'El alimento ha sido añadido correctamente.', 'success');
      } else {
        Swal.fire('Error', data.error || 'Ocurrió un error al guardar.', 'error');
      }
    },
    fError: (err) => {
      Swal.fire('Error', 'Fallo al conectar con el servidor.', 'error');
      console.error(err);
    }
  });
}
