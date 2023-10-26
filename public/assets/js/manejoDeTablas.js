function anadir(boton) {
  var fila = boton.parentNode.parentNode;

  // Copia la fila
  var filaClonada = fila.cloneNode(true);

  // Cambia la función del botón en la fila clonada
  var botonClonado = filaClonada.querySelector('button');
  botonClonado.innerHTML = 'Quitar';
  botonClonado.onclick = function() {
    eliminarFila(this);
  };

  // tabla
  var tabla = document.getElementById('table1');

  // Añadir la fila clonada a la tabla
  tabla.appendChild(filaClonada);

  // Eliminar la fila original
  fila.parentNode.removeChild(fila);
  }

function quitar(boton) {
  // Obtener la fila que contiene el botón
  var fila = boton.parentNode.parentNode;

  // Obtener la tabla que contiene la fila
  var tabla = fila.parentNode;

  // Remover la fila de la tabla
  tabla.removeChild(fila);
  }

function eliminarFila(boton) {
  // Obtener la fila que contiene el botón
  var fila = boton.parentNode.parentNode;

    var filaClonada = fila.cloneNode(true);
    // Cambiar la función del botón en la fila clonada
    var botonClonado = filaClonada.querySelector('button');
    botonClonado.innerHTML = 'añadir';
    botonClonado.onclick = function() {
        anadir(this);
    };
  
    var tabla = document.getElementById('table2');
    tabla.appendChild(filaClonada);
  
    fila.parentNode.removeChild(fila);
  }

 