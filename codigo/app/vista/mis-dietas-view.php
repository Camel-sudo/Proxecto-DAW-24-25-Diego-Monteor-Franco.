<div class="grid">
    <div class="card">
        <h2>Mis Dietas</h2>

        <!-- Formulario para seleccionar fecha -->
        <form id="form-fecha" style="margin-bottom: 20px;">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>">
            <button type="submit">Ver</button>
        </form>

        <!-- Contenedor donde se cargará el contenido con AJAX -->
        <div id="contenedor-dietas">
            <p>Cargando...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-fecha");
    const contenedor = document.getElementById("contenedor-dietas");

    function cargarDietas(fecha) {
        fetch("index.php?controller=RegistroDiarioController&action=ajaxMisDietas&fecha=" + fecha)
            .then(response => response.json())
            .then(data => {
                contenedor.innerHTML = "";
                if (!data.success) {
                    contenedor.innerHTML = "<p>Error: " + data.error + "</p>";
                    return;
                }

                const dietas = data.dietas;

                // Agrupar por momento_dia
                const agrupadas = {};
                dietas.forEach(d => {
                    if (!agrupadas[d.momento_dia]) agrupadas[d.momento_dia] = [];
                    agrupadas[d.momento_dia].push(d);
                });

                for (const momento in agrupadas) {
                    const grupo = agrupadas[momento];
                    const div = document.createElement("div");
                    div.classList.add("card");
                    div.innerHTML = `<h3>${momento.charAt(0).toUpperCase() + momento.slice(1)}</h3>
                                     <a href="index.php?controller=AlimentoController&action=buscarAlimentoForm">Añadir alimento</a>`;
                    
                    grupo.forEach(dieta => {
                        div.innerHTML += `
                            <div style="margin-bottom: 20px;">
                                <strong>${dieta.fecha}</strong><br>
                                <em>${dieta.descripcion} (${dieta.cantidad}${dieta.unidad})</em><br>
                                Calorías: ${dieta.calorias} |
                                Proteínas: ${dieta.proteinas} |
                                Carbos: ${dieta.carbohidratos} |
                                Grasas: ${dieta.grasas}<br>
                                ${dieta.consumido ? '✅ Consumido' : '📌 Recomendación'}
                            </div>`;
                    });

                    contenedor.appendChild(div);
                }
            })
            .catch(err => {
                contenedor.innerHTML = "<p>Error al cargar las dietas.</p>";
                console.error(err);
            });
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const fecha = document.getElementById("fecha").value;
        cargarDietas(fecha);
    });

    // Cargar dietas al cargar la página
    cargarDietas(document.getElementById("fecha").value);
});
</script>
