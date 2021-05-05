$(document).ready(function () {
  // Global Settings
  let edit = false;

  // Testing Jquery
  console.log('jquery is working!');
  fetchTasks();
  $('#task-result').hide();

  // search key type event
  $('#search').keyup(function () {
    if ($('#search').val()) {
      let search = $('#search').val();
      $.ajax({
        url: 'task-search.php',
        data: { search },
        type: 'POST',
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = '';
            tasks.forEach(task => {
              template += `
              <tr taskId="${task.id}">
              <td><a href="#" class="task-item">${task.nombre}</a></td>
              </tr>
              <tr taskId="${task.id}">
              <td><a href="#" class="task-item2">${task.tipo}</a></td>
              </tr>
                    `
            });
            $('#task-result').show();
            $('#container').html(template);
          }
        }
      })
    }
  });

  $('#task-form').submit(function (e) {
    e.preventDefault();
    if (edit == false) {
      var imagen = $('#imagen').prop('files')[0];
      var nombre = $('#nombre').val();
      var tipo = $('#tipo').val();
      var ingredientes = $('#ingredientes').val();
      var preparacion = $('#preparacion').val();
      var id = $('#taskId').val();
      var formData = new FormData();
      formData.append('imagen', imagen);
      formData.append('nombre', nombre);
      formData.append('tipo', tipo);
      formData.append('ingredientes', ingredientes);
      formData.append('preparacion', preparacion);
      formData.append('id', id);
      $.ajax({
        type: 'POST',
        url: 'task-add.php',
        dataType: 'text',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
          if (response != 0) {
            $('#task-form').trigger('reset');
            fetchTasks();
          } else {
            alert('Formato de imagen incorrecto.');
          }
        }
      });
    }
    else {
      var imagen = $('#imagenActual').val();
      var nombre = $('#nombre').val();
      var tipo = $('#tipo').val();
      var ingredientes = $('#ingredientes').val();
      var preparacion = $('#preparacion').val();
      var id = $('#taskId').val();
      var formData = new FormData();
      formData.append('imagen', imagen);
      formData.append('nombre', nombre);
      formData.append('tipo', tipo);
      formData.append('ingredientes', ingredientes);
      formData.append('preparacion', preparacion);
      formData.append('id', id);;
      $.ajax({
        type: 'POST',
        url: 'task-edit.php',
        dataType: 'text',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
          if (response != 0) {
            $('#task-form').trigger('reset');
            fetchTasks();
          } else {
            alert('Formato de imagen incorrecto.');
          }
        }
      });
    }
  });

  // Fetching Recipes
  function fetchTasks() {
    $.ajax({
      url: 'tasks-list.php',
      type: 'GET',
      success: function (response) {
        const tasks = JSON.parse(response);
        let template = '';
        tasks.forEach(task => {
          template += `
                  <tr taskId="${task.id}">
                  <td>${task.id}</td>
                  <td>
                  <a href="#" class="task-item">
                    ${task.nombre} 
                  </a>
                  </td>
                  <td>${task.tipo}</td>
                  <td>${task.ingredientes}</td>
                  <td>${task.preparacion}</td>
                  <td>
                  <a href="#" class="task-item2">
                  <img src='${task.imagen}'width="100px" height="80px">
                  </a>
                  </td>
                  <td>
                    <button class="task-delete btn btn-danger">
                     Eliminar 
                    </button>
                  </td>
                  </tr>
                `
        });
        $('#tasks').html(template);
      }
    });
  }

  // Get a Single Task by Id 
  $(document).on('click', '.task-item', (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr('taskId');
    $.post('task-single.php', { id }, (response) => {
      const task = JSON.parse(response);
      $('#nombre').val(task.nombre);
      $('#tipo').val(task.tipo);
      $('#ingredientes').val(task.ingredientes);
      $('#preparacion').val(task.preparacion);
      $('#taskId').val(task.id);
      $('#imagenActual').val(task.imagen);
      edit = true;
    });
    // e.preventDefault();
  });
  $(document).on('click', '.task-item2', (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const id = $(element).attr('taskId');
    $.post('task-single.php', { id }, (response) => {
      const task = JSON.parse(response);
      $('#nombre').val(task.nombre);
      $('#tipo').val(task.tipo);
      $('#ingredientes').val(task.ingredientes);
      $('#preparacion').val(task.preparacion);
      $('#taskId').val(task.id);
      $('#imagenActual').val(task.imagen);
      edit = true;
    });
    // e.preventDefault();
  });

  // Delete a Single Task
  $(document).on('click', '.task-delete', (e) => {
    if (confirm('Esta seguro de eliminar esta informacion?')) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskId');
      $.post('task-delete.php', { id }, (response) => {
        fetchTasks();
      });
    }
  });
});
