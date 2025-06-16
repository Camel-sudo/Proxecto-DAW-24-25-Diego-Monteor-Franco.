loadCSS("vista/css/buscar_dia.css");


function editarAlimento(nombre, id_registro_alimento, cantidadActual, caloriasActual, proteinasActual, carbohidratosActual, grasasActual) {
  Swal.fire({
    title: `Editar ${nombre}`,
    html: `
      <input id="cantidad" class="swal2-input" placeholder="Cantidad (ej: 100g)" value="${cantidadActual}">
      <input id="calorias" class="swal2-input" placeholder="Calorías" value="${caloriasActual}">
      <input id="proteinas" class="swal2-input" placeholder="Proteínas" value="${proteinasActual}">
      <input id="carbohidratos" class="swal2-input" placeholder="Carbohidratos" value="${carbohidratosActual}">
      <input id="grasas" class="swal2-input" placeholder="Grasas" value="${grasasActual}">
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    preConfirm: () => {
      return {
        cantidad: document.getElementById('cantidad').value,
        calorias: document.getElementById('calorias').value,
        proteinas: document.getElementById('proteinas').value,
        carbohidratos: document.getElementById('carbohidratos').value,
        grasas: document.getElementById('grasas').value
      };
    }
  }).then(result => {
    if (result.isConfirmed) {
      fetch("index.php?controller=RegistroAlimentoController&action=modificar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id: id_registro_alimento,
          ...result.value
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire("Guardado", `Cambios guardados para ${nombre}`, "success");
         
          cargarDietas(document.getElementById("fecha").value);
        } else {
          Swal.fire("Error", "No se pudo guardar", "error");
        }
      });
    }
  });
}

function eliminarAlimento(nombre, id_registro_alimento) {
  Swal.fire({
    title: `¿Eliminar ${nombre}?`,
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#aaa",
    confirmButtonText: "Sí, eliminar"
  }).then(result => {
    if (result.isConfirmed) {
      fetch("index.php?controller=RegistroAlimentoController&action=eliminar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id_registro_alimento })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire("Eliminado", `${nombre} ha sido eliminado`, "success");
          cargarDietas(document.getElementById("fecha").value);
        } else {
          Swal.fire("Error", "No se pudo eliminar", "error");
        }
      });
    }
  });
}

function actualizarEnlacesAñadir(fecha) {
  const momentos = ["desayuno", "almuerzo", "cena"];
  momentos.forEach(momento => {
    const tbody = document.getElementById(`alimento-${momento}`);
    if (!tbody) return;
    const ultimaFila = tbody.querySelector("tr:last-child");
    if (!ultimaFila) return;
    const enlace = ultimaFila.querySelector("a");
    if (enlace) {
      enlace.href = `index.php?controller=AlimentoController&action=buscarAlimentoForm&fecha=${fecha}&momento=${momento}`;
    }
  });
}

function cargarDietas(fecha) {
  fetch("index.php?controller=RegistroDiarioController&action=ajaxMisDietas&fecha=" + fecha)
    .then(response => response.json())
    .then(data => {
      if (!data.success) {
        alert("Error: " + data.error);
        return;
      }

      let totalCalorias = 0;
      let totalProteinas = 0;
      let totalCarbohidratos = 0;
      let totalGrasas = 0;
      const momentos = ["desayuno", "almuerzo", "cena"];
      momentos.forEach(m => {
        const tbody = document.getElementById(`alimento-${m}`);
        if (tbody) {
          const ultimaFila = tbody.querySelector("tr:last-child");
          tbody.innerHTML = "";
          if (ultimaFila) tbody.appendChild(ultimaFila);
        }
      });

      data.dietas.forEach(dieta => {
        totalCalorias += parseFloat(dieta.calorias);
        totalProteinas += parseFloat(dieta.proteinas);
        totalCarbohidratos += parseFloat(dieta.carbohidratos);
        totalGrasas += parseFloat(dieta.grasas);

        const tbody = document.getElementById(`alimento-${dieta.momento_dia}`);
        if (!tbody) return;

        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${dieta.descripcion}</td>
          <td>${dieta.cantidad}${dieta.unidad}</td>
          <td>${dieta.calorias}</td>
          <td>${dieta.proteinas}</td>
          <td>${dieta.carbohidratos}</td>
          <td>${dieta.grasas}</td>
          <td><button class="editar-btn" data-id="${dieta.id_registro_alimento}" data-nombre="${dieta.descripcion}" data-cantidad="${dieta.cantidad}" data-calorias="${dieta.calorias}" data-proteinas="${dieta.proteinas}" data-carbohidratos="${dieta.carbohidratos}" data-grasas="${dieta.grasas}">Editar</button></td>
          <td><button class="eliminar-btn" data-id="${dieta.id_registro_alimento}" data-nombre="${dieta.descripcion}">Eliminar</button></td>
        `;

        const ultimaFila = tbody.querySelector("tr:last-child");
        tbody.insertBefore(tr, ultimaFila);
      });

      const macrosSection = document.querySelector(".macros");
      macrosSection.innerHTML = `
        <h3>KCAL: ${totalCalorias.toFixed(2)} / TOTAL PROTEINA: ${totalProteinas.toFixed(2)} / TOTAL GRASAS: ${totalGrasas.toFixed(2)} / TOTAL HIDRATOS: ${totalCarbohidratos.toFixed(2)}</h3>
      `;

      actualizarEnlacesAñadir(fecha);
    })
    .catch(err => {
      alert("Error al cargar las dietas.");
      console.error(err);
    });
}

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("form-fecha");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const fecha = document.getElementById("fecha").value;
    cargarDietas(fecha);
  });

  document.getElementById('contenedor-dietas').addEventListener('click', (e) => {
    if (e.target.classList.contains('editar-btn')) {
      const btn = e.target;
      editarAlimento(
        btn.dataset.nombre,
        btn.dataset.id,
        btn.dataset.cantidad,
        btn.dataset.calorias,
        btn.dataset.proteinas,
        btn.dataset.carbohidratos,
        btn.dataset.grasas
      );
    } else if (e.target.classList.contains('eliminar-btn')) {
      eliminarAlimento(e.target.dataset.nombre, e.target.dataset.id);
    }
  });

  const fechaInicial = document.getElementById("fecha").value;
  cargarDietas(fechaInicial);
});
