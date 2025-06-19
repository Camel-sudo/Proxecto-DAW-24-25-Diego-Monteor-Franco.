loadCSS("vista/css/pacientes.css");
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


  function fetchPacientes() {
    ajax({
      url: 'index.php?controller=ClienteController&action=obtenerClientes',
      fExito: data => {
        const lista = document.getElementById('lista-pacientes');
        lista.innerHTML = '';
  
        if (data.success && data.clientes.length) {
          data.clientes.forEach(c => {
            const article = document.createElement('article');
            article.classList.add('paciente');
            article.setAttribute('role', 'article');
            article.setAttribute('tabindex', '0');
  
            const icono = document.createElement('p');
            icono.textContent = '👤';
  
            const btnEditar = document.createElement('button');
            btnEditar.textContent = 'Editar';
            btnEditar.title = 'Editar paciente';
            btnEditar.classList.add('btn-editar');
            btnEditar.addEventListener('click', () => {
              editarPaciente(c.id_cliente, c.nombre, c.apellidos, c.id_usuario);
            });
  
            const btnVerDieta = document.createElement('button');
            btnVerDieta.textContent = 'Ver dieta';
            btnVerDieta.title = 'Ver o modificar dieta';
            btnVerDieta.classList.add('btn-ver-dieta');
            btnVerDieta.addEventListener('click', () => {
              seleccionarPaciente(c.id_cliente);
            });
  
            const btnEliminar = document.createElement('button');
            btnEliminar.textContent = 'Eliminar';
            btnEliminar.title = 'Eliminar paciente';
            btnEliminar.classList.add('btn-eliminar');
            btnEliminar.addEventListener('click', () => {
              eliminarPaciente(c.id_cliente);
            });
  
            const baseInfo = document.createElement('div');
            baseInfo.classList.add('paciente-item');
            baseInfo.innerHTML = `<span>${c.nombre} ${c.apellidos}</span>`;
  
            article.appendChild(icono);
            article.appendChild(btnEditar);
            article.appendChild(btnVerDieta);
            article.appendChild(btnEliminar);
            article.appendChild(baseInfo);
  
            lista.appendChild(article);
          });
        } else {
          lista.innerHTML = '<p>No tienes pacientes asignados.</p>';
        }
      },
      fError: () => Swal.fire("Error", "No se pudieron cargar los pacientes", "error")
    });
  }
  
  
  

  fetchPacientes();


  document.getElementById('btn-nuevo-paciente').addEventListener('click', () => {
    ajax({
      url: 'index.php?controller=ClienteController&action=clientesDisponibles',
      fExito: async data => {
        if (!data.success || !data.usuarios.length) {
          return Swal.fire("Sin usuarios", "No hay usuarios base disponibles", "info");
        }

        const inputOptions = {};
        data.usuarios.forEach(u => {
          inputOptions[u.id_usuario] = `${u.nombre} ${u.apellidos}`;
        });

        const { value: id_usuario } = await Swal.fire({
          title: 'Seleccionar paciente',
          input: 'select',
          inputOptions,
          inputPlaceholder: 'Seleccione un usuario base',
          showCancelButton: true
        });

        if (id_usuario) {
          ajax({
            url: 'index.php?controller=ClienteController&action=altaClienteNutricionista',
            method: 'POST',
            data: { id_usuario: parseInt(id_usuario) },
            fExito: result => {
              if (result.success) {
                Swal.fire("Paciente añadido", "Se añadió correctamente", "success");
                fetchPacientes();
              } else {
                Swal.fire("Error", result.error || "No se pudo añadir", "error");
              }
            },
            fError: () => Swal.fire("Error", "Error en la solicitud", "error")
          });
        }
      },
      fError: () => Swal.fire("Error", "No se pudieron obtener usuarios disponibles", "error")
    });
  });

  async function editarPaciente(id_cliente, nombreActual, apellidosActuales, id_usuario) {
    const { value: formValues } = await Swal.fire({
      title: 'Editar datos del paciente',
      html: `
        <input id="swal-nombre" class="swal2-input" placeholder="Nombre" value="${nombreActual}">
        <input id="swal-apellidos" class="swal2-input" placeholder="Apellidos" value="${apellidosActuales}">
        <input id="swal-altura" class="swal2-input" placeholder="Altura (cm)" type="number">
        <input id="swal-peso" class="swal2-input" placeholder="Peso (kg)" type="number">
        <input id="swal-edad" class="swal2-input" placeholder="Edad" type="number">
        <select id="swal-sexo" class="swal2-input">
          <option value="">Sexo</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>
        <select id="swal-actividad" class="swal2-input">
          <option value="null">Actividad física</option>
          <option value="sedentario">Sedentario</option>
          <option value="ligera">Ligera</option>
          <option value="moderada">Moderada</option>
          <option value="intensa">Intensa</option>
          <option value="muy_intensa">muy_intensa</option>
        </select>
        <input id="swal-objetivo" class="swal2-input" placeholder="Objetivo">
        <input id="swal-metabolismo" class="swal2-input" placeholder="Metabolismo basal (kcal)" type="number">
      `,
      focusConfirm: false,
      showCancelButton: true,
      preConfirm: () => {
        return {
          nombre: document.getElementById('swal-nombre').value.trim(),
          apellidos: document.getElementById('swal-apellidos').value.trim(),
          altura: parseInt(document.getElementById('swal-altura').value),
          peso: parseFloat(document.getElementById('swal-peso').value),
          edad: parseInt(document.getElementById('swal-edad').value),
          sexo: document.getElementById('swal-sexo').value,
          actividad_fisica: document.getElementById('swal-actividad').value,
          objetivo: document.getElementById('swal-objetivo').value.trim(),
          metabolismo_basal: parseInt(document.getElementById('swal-metabolismo').value)
        };
      }
    });

    if (formValues && formValues.nombre && formValues.apellidos && formValues.sexo && formValues.actividad_fisica) {
      ajax({
        url: 'index.php?controller=ClienteController&action=editarCliente',
        method: 'POST',
        data: {
          id_cliente,
          id_usuario,
          datos: formValues
        },
        fExito: data => {
          if (data.success) {
            Swal.fire("Paciente actualizado", "", "success");
            fetchPacientes();
          } else {
            Swal.fire("Error", data.error || "No se pudo actualizar", "error");
          }
        },
        fError: () => Swal.fire("Error", "Error en la solicitud", "error")
      });
    } else {
      Swal.fire("Error", "Por favor completa todos los campos obligatorios.", "warning");
    }
  }

  async function eliminarPaciente(id_cliente) {
    const confirm = await Swal.fire({
      title: '¿Eliminar paciente?',
      text: 'Esto desvinculará al paciente de tu lista.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    });

    if (confirm.isConfirmed) {
      ajax({
        url: 'index.php?controller=ClienteController&action=eliminarCliente',
        method: 'POST',
        data: { id_cliente },
        fExito: data => {
          if (data.success) {
            Swal.fire("Paciente eliminado", "", "success");
            fetchPacientes();
          } else {
            Swal.fire("Error", data.error || "No se pudo eliminar", "error");
          }
        },
        fError: () => Swal.fire("Error", "Error al eliminar", "error")
      });
    }
  }

  function seleccionarPaciente(id_cliente) {
    ajax({
      url: 'index.php?controller=ClienteController&action=seleccionarPaciente',
      method: 'POST',
      data: { id_cliente },
      fExito: data => {
        if (data.success) {
          window.location.href = 'index.php?controller=RegistroDiarioController&action=misDietas';
        } else {
          Swal.fire("Error", data.error || "No se pudo seleccionar al paciente", "error");
        }
      },
      fError: () => Swal.fire("Error", "Error en la solicitud", "error")
    });
  }