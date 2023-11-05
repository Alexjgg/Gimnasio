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
     // Agregar clase CSS al botón clonado
     botonClonado.className = 'btn btn-red';
  
    // tabla
    var tabla = document.getElementById('table1');
  
    // Añadir la fila clonada a la tabla
    tabla.appendChild(filaClonada);
  
    // Eliminar la fila original
    fila.parentNode.removeChild(fila);
  }
  //Misma funcion que la anterior pero hacia la otra tabla
  function eliminarFila(boton) {
    var fila = boton.parentNode.parentNode;

    var filaClonada = fila.cloneNode(true);
  
    var botonClonado = filaClonada.querySelector('button');
    botonClonado.innerHTML = 'Añadir';
    botonClonado.onclick = function() {
        anadir(this);
    };
    
    // Agregar clase CSS al botón clonado
    botonClonado.className = 'btn btn-green';
  
    var tabla = document.getElementById('table2');
    tabla.appendChild(filaClonada);
  
    fila.parentNode.removeChild(fila);
  }