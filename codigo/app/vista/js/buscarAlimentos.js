function ajax(options) {
  const { url, method, fExito, fError, data } = options;
  const fetchOptions = {
    method: method || 'GET',
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

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-busqueda');
  const input = document.getElementById('input-busqueda');
  const resultadosDiv = document.getElementById('resultados');

  // BÚSQUEDA 
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

  // GUARDADO
  resultadosDiv.addEventListener('submit', (e) => {
    if (e.target.matches('.form-seleccion')) {
      e.preventDefault();
  
      const formData = new FormData(e.target);
      const data = Object.fromEntries(formData.entries());
  
      const alimentoDiv = e.target.closest('.alimento');
      const nombre = alimentoDiv.querySelector('strong')?.textContent ?? '';
      const texto = alimentoDiv.textContent;
  
      const calorias = parseFloat(texto.match(/Calorías: (\d+\.?\d*)/)?.[1] ?? 0);
      const proteinas = parseFloat(texto.match(/Proteínas: (\d+\.?\d*)/)?.[1] ?? 0);
      const carbohidratos = parseFloat(texto.match(/Carbs: (\d+\.?\d*)/)?.[1] ?? 0);
      const grasas = parseFloat(texto.match(/Grasas: (\d+\.?\d*)/)?.[1] ?? 0);
  
      const alimento = {
        id_alimento: data.idAlimento,
        nombre: nombre,
        marca: null,
        calorieking_id: null,
        porcion_estandar: 100,
        calorias: calorias,
        proteinas: proteinas,
        carbohidratos: carbohidratos,
        grasas: grasas,
        fibra: 0,
        sodio: 0,
        ultima_actualizacion: new Date().toISOString().split('T')[0]
      };
  
      const payload = {
        idAlimento: data.idAlimento,
        cantidad: data.cantidad,
        alimento: alimento
      };
  
      ajax({
        url: e.target.getAttribute('data-action'),
        method: 'POST',
        data: payload,
        fExito: (res) => {
          if (res.success) {
            alert(' Alimento guardado con éxito.');
          } else {
            alert(` Error: ${res.error}`);
          }
        },
        fError: (err) => {
          console.error('Error al guardar alimento:', err);
          alert(' Error al guardar alimento.');
        }
      });
    }
  });
  
  
});
