const formularioDatos = document.getElementById('formulario');
function guardarDatos() {
    //guardo los datos de tabla de ejercicios de mi entrenamiento
    var tabla = document.getElementById('table1');

    var datos = [];
    // guardo solo los ids
    
    for (var i = 1; i < tabla.rows.length; i++) {
      var fila = tabla.rows[i];
      var id = fila.cells[3].innerText;
      datos.push(id);
    }
    
    //envio los ids al controlador por json
    document.getElementById('datosTabla').value =JSON.stringify(datos);
  }

  formularioDatos.addEventListener("submit", function(event) {
    event.preventDefault();
  
    // Ejecutar la función guardarDatos
    guardarDatos(); 
    
      // Establecer el valor del action en un campo oculto
      var actionInput = document.createElement("input");
      actionInput.type = "hidden";
      actionInput.name = "action";
      actionInput.value = "new"; // Valor del action que deseas enviar
      formularioDatos.appendChild(actionInput);
    // Enviar el formulario manualmente
    formularioDatos.submit();
});